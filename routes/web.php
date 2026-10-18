<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Inventory;
use App\Http\Controllers\PendingPageController;
use App\Http\Controllers\User;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

/*
| Every route below is guarded by the "menu" middleware: pages listed in
| config/menu.php need the matching role permission (view/create/edit/delete).
| Non-standard actions declare their ability with ->defaults('ability', ...).
*/
Route::middleware(['auth', 'menu'])->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout'); // POST only: a link or image can't log users out (CSRF)
    Route::get('welcome', WelcomeController::class)->name('welcome');

    // Private uploads, served with permission checks (not through public /storage URLs).
    Route::get('attachments/purchaseorder/{purchaseorder}', [AttachmentController::class, 'purchaseOrder'])->name('attachments.purchaseorder');
    Route::get('attachments/ticket/{ticket}', [AttachmentController::class, 'ticket'])->name('attachments.ticket');

    // ---------------- Inventory ----------------
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', Inventory\DashboardController::class)->name('dashboard');

        // QM approval queue.
        Route::prefix('approvals')->name('approvals.')->controller(Inventory\ApprovalController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('read/{notification?}', 'read')->name('read');
            Route::get('{approval}', 'show')->whereNumber('approval')->name('show');
            Route::post('{approval}/approve', 'approve')->name('approve')->defaults('ability', 'edit');
            Route::post('{approval}/reject', 'reject')->name('reject')->defaults('ability', 'edit');
        });

        // Breadcrumb group links (e.g. /inventory/configuration) go back to the module dashboard.
        foreach (['configuration', 'purchase', 'transaction', 'reports'] as $group) {
            // Named route, so the redirect keeps the app's sub-folder (/ndcitinv).
            Route::get($group, fn () => redirect()->route('inventory.dashboard'));
        }

        // Cascading dropdown / item lookups (same URLs as the reference).
        Route::controller(Inventory\LookupController::class)->group(function () {
            Route::get('getcategorylist/{parent}', 'categories');
            Route::get('getbrandlist/{category}', 'brands');
            Route::get('getmodellist/{brand}', 'models');
            Route::get('getmodeldetails/{model}', 'modelDetails');
            Route::get('getitemlist', 'items');
            Route::get('getitemdetails/{item}', 'itemDetails');
        });

        Route::prefix('configuration')->name('configuration.')->group(function () {
            $simple = [
                'units' => Inventory\Configuration\UnitController::class,
                'ranks' => Inventory\Configuration\RankController::class,
                'suppliers' => Inventory\Configuration\SupplierController::class,
                'parentcategories' => Inventory\Configuration\ParentCategoryController::class,
                'itemunits' => Inventory\Configuration\ItemUnitController::class,
                'financialyears' => Inventory\Configuration\FinancialYearController::class,
            ];
            foreach ($simple as $uri => $controller) {
                Route::resource($uri, $controller)->only(['index', 'store', 'update', 'destroy'])->parameters([$uri => 'id']);
            }
            Route::resource('categories', Inventory\Configuration\CategoryController::class)->only(['index', 'store', 'show', 'update', 'destroy'])->parameters(['categories' => 'id']);
            Route::resource('brands', Inventory\Configuration\BrandController::class)->only(['index', 'store', 'show', 'update', 'destroy'])->parameters(['brands' => 'id']);
            Route::resource('models', Inventory\Configuration\ProductModelController::class)->only(['index', 'store', 'show', 'update', 'destroy'])->parameters(['models' => 'id']);
            Route::post('models/{model}/{type}', [Inventory\Configuration\ProductModelController::class, 'storeAttribute'])->whereIn('type', ['port', 'layer', 'capacity'])->name('models.attribute.store')->defaults('ability', 'edit');
            Route::patch('models/{type}/{attribute}', [Inventory\Configuration\ProductModelController::class, 'updateAttribute'])->whereIn('type', ['port', 'layer', 'capacity'])->name('models.attribute.update')->defaults('ability', 'edit');
            Route::delete('models/{type}/{attribute}', [Inventory\Configuration\ProductModelController::class, 'destroyAttribute'])->whereIn('type', ['port', 'layer', 'capacity'])->name('models.attribute.destroy')->defaults('ability', 'edit');
            Route::resource('items', Inventory\Configuration\ItemController::class);
        });

        // ---- Purchase ----
        Route::get('getpurchasedetails/{order}', [Inventory\Purchase\PurchaseReceiveController::class, 'details']);
        Route::get('serialnochecking', [Inventory\Purchase\PurchaseReceiveController::class, 'serialCheck']);

        Route::prefix('purchase')->name('purchase.')->group(function () {
            Route::get('purchaseorders/pdf/{purchaseorder}', [Inventory\Purchase\PurchaseOrderController::class, 'pdf'])->name('purchaseorders.pdf');
            Route::resource('purchaseorders', Inventory\Purchase\PurchaseOrderController::class);
            Route::get('purchaseorderreceive/pdf/{purchaseorderreceive}', [Inventory\Purchase\PurchaseReceiveController::class, 'pdf'])->name('purchaseorderreceive.pdf');
            Route::resource('purchaseorderreceive', Inventory\Purchase\PurchaseReceiveController::class);
        });

        // ---- Transaction ----
        Route::prefix('transaction')->name('transaction.')->group(function () {
            Route::get('stockposition/pdf/{voucher}', [Inventory\Transaction\StockPositionController::class, 'pdf'])->name('stockposition.pdf');
            Route::get('stockposition/scan', [Inventory\Transaction\StockPositionController::class, 'scan'])->name('stockposition.scan')->defaults('ability', 'create');
            Route::resource('stockposition', Inventory\Transaction\StockPositionController::class)->only(['index', 'create', 'store', 'update', 'destroy']);
            Route::resource('stockreceive', Inventory\Transaction\StockReceiveController::class)->only(['index', 'update']);
            Route::resource('damages', Inventory\Transaction\DamageController::class)->only(['index', 'store', 'update']);
            Route::get('issuevouchers', [Inventory\Transaction\IssueVoucherController::class, 'index'])->name('issuevouchers.index');
            Route::resource('warrantyandservice', Inventory\Transaction\WarrantyServiceController::class)->only(['index', 'update']);
            Route::get('licenses', [Inventory\Transaction\LicenseController::class, 'index'])->name('licenses.index');
            Route::get('barcodes', [Inventory\Transaction\BarcodeController::class, 'index'])->name('barcodes.index');
            Route::get('barcodes/bulk', [Inventory\Transaction\BarcodeController::class, 'bulk'])->name('barcodes.bulk');
            Route::get('barcodes/search', [Inventory\Transaction\BarcodeController::class, 'search'])->name('barcodes.search');
            Route::get('barcodes/print', [Inventory\Transaction\BarcodeController::class, 'print'])->name('barcodes.print');
            Route::get('barcodes/pdf/{stock}', [Inventory\Transaction\BarcodeController::class, 'pdf'])->name('barcodes.pdf');
        });

        // ---- Reports ----
        Route::prefix('reports')->name('reports.')->controller(Inventory\ReportController::class)->group(function () {
            foreach (['itemsearch', 'purchasereport', 'issuereport', 'damagereport', 'stockbalancereport', 'warrantyinformation', 'licensesinformation', 'stockchecking', 'stocksummary'] as $report) {
                Route::get($report, $report)->name($report);
            }
        });
    });

    // ---------------- Admin ----------------
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', Admin\DashboardController::class)->name('dashboard');

        Route::resource('users', Admin\UserController::class)->except(['create', 'edit']);
        Route::patch('users/{user}/password', [Admin\UserController::class, 'resetPassword'])->name('users.password')->defaults('ability', 'edit');
        Route::post('users/{user}/toggleactivating', [Admin\UserController::class, 'toggleActivating'])->name('users.toggle')->defaults('ability', 'edit');
        Route::post('users/{user}/logout', [Admin\UserController::class, 'logout'])->name('users.logout')->defaults('ability', 'edit');

        Route::resource('roles', Admin\RoleController::class);

        Route::resource('ipfiltering', Admin\IpFilterController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::resource('ipauditing', Admin\IpAuditController::class)->only(['index', 'update', 'destroy']);

        Route::get('logs', [Admin\LogController::class, 'index'])->name('logs.index');
        Route::get('logs/pdf/{log}', [Admin\LogController::class, 'pdf'])->name('logs.pdf');

        // Breadcrumb group link goes back to the module dashboard.
        Route::get('messaging', fn () => redirect()->route('admin.dashboard'));

        Route::prefix('messaging')->name('messaging.')->group(function () {
            Route::get('chats', [Admin\ChatController::class, 'index'])->name('chats.index');
            Route::get('chats/pdf', [Admin\ChatController::class, 'pdf'])->name('chats.pdf');
            Route::delete('chats/{chat}', [Admin\ChatController::class, 'destroy'])->name('chats.destroy');

            Route::resource('tickets', Admin\TicketController::class)->only(['index', 'update', 'destroy']);
            Route::resource('notifications', Admin\NotificationController::class)->only(['index', 'store', 'destroy']);
        });
    });

    // ---------------- User (every logged-in user) ----------------
    Route::prefix('user')->name('user.')->group(function () {
        // Breadcrumb "User" link: the signed-in user's own profile.
        Route::get('/', fn () => redirect()->route('user.profile.show', auth()->user()));
        Route::get('quicklink', [User\QuickLinkController::class, 'index'])->name('quicklink.index');
        Route::post('quicklink', [User\QuickLinkController::class, 'store'])->name('quicklink.store');
        Route::put('quicklink/{quicklink}', [User\QuickLinkController::class, 'update'])->name('quicklink.update');
        Route::delete('quicklink/{quicklink}', [User\QuickLinkController::class, 'destroy'])->name('quicklink.destroy');

        Route::get('profile/{user}', [User\ProfileController::class, 'show'])->name('profile.show');
        Route::patch('profile/{user}', [User\ProfileController::class, 'update'])->name('profile.update');

        Route::resource('ticket', User\TicketController::class)->only(['index', 'store', 'update']);

        Route::get('chat', [User\ChatController::class, 'index'])->name('chat.index');
        Route::get('chat/{user}', [User\ChatController::class, 'show'])->name('chat.show');
        Route::post('chat/{user}', [User\ChatController::class, 'store'])->name('chat.store');

        Route::get('live', User\LiveController::class)->name('live');

        Route::get('notification', [User\NotificationController::class, 'index'])->name('notification.index');
        Route::patch('notification/{notification}', [User\NotificationController::class, 'update'])->name('notification.update');
    });

    // ---------------- Not yet ported ----------------
    // Sidebar pages without a real route yet show a placeholder.
    $registered = collect(Route::getRoutes()->getRoutes())->map->uri()->all();
    foreach (\App\Support\Menu::pages() as $menuPage) {
        if (! in_array($menuPage['path'], $registered, true)) {
            Route::get($menuPage['path'], PendingPageController::class);
        }
    }
});
