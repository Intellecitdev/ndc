<?php

namespace App\Http\Controllers\Inventory\Transaction;

use App\Http\Controllers\Concerns\ScopesUnit;
use App\Http\Controllers\Controller;
use App\Models\IssueVoucher;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IssueVoucherController extends Controller
{
    use ScopesUnit;

    public function index(Request $request): View
    {
        $vouchers = $this->scopeUnit(IssueVoucher::query()->with(['creator', 'approvalRequests']), $request, 'from_unit_id')
            ->when($request->filled('Code'), fn ($q) => $q->where('iv_no', 'like', "%{$request->Code}%"))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('inventory.transaction.issuevouchers', compact('vouchers'));
    }
}
