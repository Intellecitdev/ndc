<?php

/*
|--------------------------------------------------------------------------
| Sidebar menus
|--------------------------------------------------------------------------
| Mirrors the sidebar of the reference system, module by module.
| "path" is relative to the app root; a menu item is active when the
| current URL starts with its path.
| "abilities" defaults to view/create/edit/delete when omitted; these are
| the permissions a role can be granted on that page (Admin > Roles).
| "icon" (Bootstrap Icons) is optional on child pages; it defaults to an arrow.
*/

return [

    'inventory' => [
        'title' => 'Inventory',
        'path' => 'inventory',
        'image' => 'images/module-inventory.png',
        'items' => [
            ['title' => 'Dashboard', 'icon' => 'bi bi-speedometer', 'path' => 'inventory', 'exact' => true],
            // QM queue: "view" sees it, "edit" approves/rejects. Roles without "edit" here
            // (Storeman) have their new records wait for approval.
            ['title' => 'Approvals', 'icon' => 'bi bi-clipboard-check', 'path' => 'inventory/approvals', 'abilities' => ['view', 'edit']],
            ['title' => 'Configuration', 'icon' => 'bi bi-gear-wide-connected', 'children' => [
                ['title' => 'Wings', 'icon' => 'bi bi-diagram-3', 'path' => 'inventory/configuration/units'],
                ['title' => 'Ranks', 'icon' => 'bi bi-award', 'path' => 'inventory/configuration/ranks'],
                ['title' => 'Suppliers', 'icon' => 'bi bi-truck', 'path' => 'inventory/configuration/suppliers'],
                ['title' => 'Parent Categories', 'icon' => 'bi bi-diagram-2', 'path' => 'inventory/configuration/parentcategories'],
                ['title' => 'Categories', 'icon' => 'bi bi-tags', 'path' => 'inventory/configuration/categories'],
                ['title' => 'Brands', 'icon' => 'bi bi-patch-check', 'path' => 'inventory/configuration/brands'],
                ['title' => 'Models', 'icon' => 'bi bi-box', 'path' => 'inventory/configuration/models'],
                ['title' => 'Item Units', 'icon' => 'bi bi-rulers', 'path' => 'inventory/configuration/itemunits'],
                ['title' => 'Financial Years', 'icon' => 'bi bi-calendar3', 'path' => 'inventory/configuration/financialyears'],
                ['title' => 'Items', 'icon' => 'bi bi-box-seam', 'path' => 'inventory/configuration/items'],
            ]],
            ['title' => 'Purchase', 'icon' => 'bi bi-cart3', 'children' => [
                ['title' => 'Purchase Orders', 'icon' => 'bi bi-receipt', 'path' => 'inventory/purchase/purchaseorders'],
                ['title' => 'Pur Order Receive', 'icon' => 'bi bi-cart-check', 'path' => 'inventory/purchase/purchaseorderreceive'],
            ]],
            ['title' => 'Transaction', 'icon' => 'bi bi-arrow-left-right', 'children' => [
                ['title' => 'Stock Position', 'icon' => 'bi bi-boxes', 'path' => 'inventory/transaction/stockposition'],
                ['title' => 'Stock Receive', 'icon' => 'bi bi-box-arrow-in-down', 'path' => 'inventory/transaction/stockreceive'],
                ['title' => 'Damages', 'icon' => 'bi bi-exclamation-triangle', 'path' => 'inventory/transaction/damages'],
                ['title' => 'Issue Vouchers', 'icon' => 'bi bi-send', 'path' => 'inventory/transaction/issuevouchers'],
                ['title' => 'Warranty And Service', 'icon' => 'bi bi-shield-check', 'path' => 'inventory/transaction/warrantyandservice'],
                ['title' => 'Licenses', 'icon' => 'bi bi-key', 'path' => 'inventory/transaction/licenses'],
                ['title' => 'Bar Codes', 'icon' => 'bi bi-upc-scan', 'path' => 'inventory/transaction/barcodes'],
            ]],
            ['title' => 'Reports', 'icon' => 'bi bi-bar-chart-line', 'children' => [
                ['title' => 'Item Search', 'icon' => 'bi bi-search', 'path' => 'inventory/reports/itemsearch', 'abilities' => ['view']],
                ['title' => 'Purchase Report', 'icon' => 'bi bi-bag-check', 'path' => 'inventory/reports/purchasereport', 'abilities' => ['view']],
                ['title' => 'Issue Report', 'icon' => 'bi bi-file-earmark-bar-graph', 'path' => 'inventory/reports/issuereport', 'abilities' => ['view']],
                ['title' => 'Damage Report', 'icon' => 'bi bi-x-octagon', 'path' => 'inventory/reports/damagereport', 'abilities' => ['view']],
                ['title' => 'Stock Balance Report', 'icon' => 'bi bi-clipboard-data', 'path' => 'inventory/reports/stockbalancereport', 'abilities' => ['view']],
                ['title' => 'Warranty Information', 'icon' => 'bi bi-shield-lock', 'path' => 'inventory/reports/warrantyinformation', 'abilities' => ['view']],
                ['title' => 'Licenses Information', 'icon' => 'bi bi-card-checklist', 'path' => 'inventory/reports/licensesinformation', 'abilities' => ['view']],
                ['title' => 'Stock Checking', 'icon' => 'bi bi-graph-up', 'path' => 'inventory/reports/stockchecking', 'abilities' => ['view']],
                ['title' => 'Stock Summary', 'icon' => 'bi bi-pie-chart', 'path' => 'inventory/reports/stocksummary', 'abilities' => ['view']],
            ]],
        ],
    ],

    'admin' => [
        'title' => 'Admin',
        'path' => 'admin',
        'image' => 'images/module-admin.png',
        'items' => [
            ['title' => 'Dashboard', 'icon' => 'bi bi-speedometer', 'path' => 'admin', 'exact' => true],
            ['title' => 'IP Filtering', 'icon' => 'bi bi-funnel', 'path' => 'admin/ipfiltering'],
            ['title' => 'IP Auditing', 'icon' => 'bi bi-eye', 'path' => 'admin/ipauditing'],
            ['title' => 'Roles', 'icon' => 'bi bi-person-badge', 'path' => 'admin/roles'],
            ['title' => 'Users', 'icon' => 'bi bi-people', 'path' => 'admin/users'],
            ['title' => 'Messaging', 'icon' => 'bi bi-chat-dots', 'children' => [
                ['title' => 'Chats', 'icon' => 'bi bi-chat-square-text', 'path' => 'admin/messaging/chats'],
                ['title' => 'Tickets', 'icon' => 'bi bi-ticket-perforated', 'path' => 'admin/messaging/tickets'],
                ['title' => 'Notifications', 'icon' => 'bi bi-bell', 'path' => 'admin/messaging/notifications'],
            ]],
            ['title' => 'Log Activity', 'icon' => 'bi bi-journal-text', 'path' => 'admin/logs', 'abilities' => ['view']],
        ],
    ],

];
