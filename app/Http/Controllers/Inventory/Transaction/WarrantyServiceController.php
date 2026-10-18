<?php

namespace App\Http\Controllers\Inventory\Transaction;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Concerns\ScopesUnit;
use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\WarrantyClaim;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Warranty And Service: send a damaged item for claim, then receive it back.
 */
class WarrantyServiceController extends Controller
{
    use JsonResponses, ScopesUnit;

    public function index(Request $request): View
    {
        $claims = $this->scopeUnit(WarrantyClaim::query()->with(['stock.item.category', 'stock.supplier', 'unit', 'claimer', 'damage']), $request)
            ->when($request->filled('Serial'), fn ($q) => $q->whereHas('stock', fn ($q) => $q->where('serial_no', 'like', "%{$request->Serial}%")))
            ->when($request->filled('Name'), fn ($q) => $q->whereHas('stock.item', fn ($q) => $q->where('name', 'like', "%{$request->Name}%")))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('inventory.transaction.warrantyandservice', compact('claims'));
    }

    /** formNo 1 = claim, 2 = edit claim, 3 = receive back. */
    public function update(Request $request, WarrantyClaim $warrantyandservice): JsonResponse
    {
        $claim = $warrantyandservice->load('stock');
        abort_unless($this->ownsUnit($request, $claim->unit_id), 404);
        $form = (int) $request->input('formNo');

        if ($form === 1 || $form === 2) {
            if (! in_array($claim->status, $form === 1 ? ['For Claim'] : ['Claimed'], true)) {
                return $this->fail('This claim can not be changed now.');
            }
            $data = $this->check($request, [
                'Comments' => ['required', 'string', 'max:2000'],
                'ExpReturnDate' => [$form === 2 ? 'required' : 'nullable', 'date'],
                'C4S' => ['required', 'in:Y'],
            ], ['ExpReturnDate' => 'Expected Return Date', 'C4S' => 'Claim Status']);
            $claim->update([
                'status' => 'Claimed', 'comments' => $data['Comments'], 'expected_return_date' => $data['ExpReturnDate'] ?? null,
                'claim_date' => $claim->claim_date ?? now(), 'claimed_by' => $claim->claimed_by ?? $request->user()->id,
            ]);

            return $this->ok($form === 1 ? 'Claimed successfully.' : 'Claim updated successfully.');
        }

        if ($form === 3) {
            if ($claim->status !== 'Claimed') {
                return $this->fail('Only claimed items can be received.');
            }
            $data = $this->check($request, ['Status' => ['required', Rule::in(array_keys(WarrantyClaim::RECEIVE_STATUSES))]], ['Status' => 'Warranty/Service Status']);
            DB::transaction(function () use ($claim, $data, $request) {
                $claim->update(['status' => $data['Status'], 'received_by' => $request->user()->id, 'received_at' => now()]);
                // Repaired/replaced items return to stock; uncovered ones stay damaged.
                $claim->stock->update(['status' => $data['Status'] === 'Received' ? Stock::IN_STOCK : Stock::DAMAGE]);
            });

            return $this->ok('Warranty/Service received successfully.');
        }

        return $this->fail('Unknown action.');
    }
}
