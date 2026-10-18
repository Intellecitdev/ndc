<?php

namespace App\Http\Controllers\Inventory\Transaction;

use App\Http\Controllers\Concerns\ScopesUnit;
use App\Http\Controllers\Controller;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LicenseController extends Controller
{
    use ScopesUnit;

    public function index(Request $request): View
    {
        $licenses = License::with(['stock.item', 'stock.supplier', 'deployment.unit'])
            ->whereHas('stock', fn ($q) => $this->scopeUnit($q, $request))
            ->when($request->filled('Code'), fn ($q) => $q->where(fn ($q) => $q
                ->where('product_key', 'like', "%{$request->Code}%")
                ->orWhere('licensed_to_name', 'like', "%{$request->Code}%")
                ->orWhereHas('stock.item', fn ($q) => $q->where('name', 'like', "%{$request->Code}%"))))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('inventory.transaction.licenses', compact('licenses'));
    }
}
