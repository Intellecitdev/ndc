<?php

namespace App\Http\Controllers\Inventory\Transaction;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Concerns\ScopesUnit;
use App\Http\Controllers\Controller;
use App\Models\Damage;
use App\Models\Stock;
use App\Models\WarrantyClaim;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Damage declaration -> approval -> (warranty/service claim).
 */
class DamageController extends Controller
{
    use JsonResponses, ScopesUnit;

    public function index(Request $request): View
    {
        $damages = $this->scopeUnit(Damage::query()->with(['stock.item', 'creator', 'claim']), $request)
            ->when($request->filled('Serial'), fn ($q) => $q->whereHas('stock', fn ($q) => $q->where('serial_no', 'like', "%{$request->Serial}%")))
            ->when($request->filled('Name'), fn ($q) => $q->whereHas('stock.item', fn ($q) => $q->where('name', 'like', "%{$request->Name}%")))
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        $stocks = $this->scopeUnit(Stock::query()->with('item'), $request)->inStock()->orderBy('serial_no')->get()
            ->mapWithKeys(fn ($s) => [$s->id => ['label' => $s->label().' | '.$s->item->name, 'qty' => $s->quantity, 'unit' => $s->item->unit?->name]]);

        return view('inventory.transaction.damages', compact('damages', 'stocks'));
    }

    public function store(Request $request): JsonResponse
    {
        $stock = Stock::find($request->input('RegLogID'));
        $data = $this->check($request, [
            'RegLogID' => ['required', 'exists:stocks,id'],
            'Quantity' => ['nullable', 'integer', 'min:1', 'max:'.($stock?->quantity ?? 1)],
            'Reason' => ['required', 'string', 'max:2000'],
            'Actions' => ['required', 'string', 'max:2000'],
            'Remarks' => ['nullable', 'string', 'max:2000'],
        ], ['RegLogID' => 'Item', 'Quantity' => 'Damage Quantity', 'Actions' => 'Taken Actions']);

        if ($stock->status !== Stock::IN_STOCK || ! $this->ownsUnit($request, $stock->unit_id)) {
            return $this->fail('This item is not in your stock.');
        }

        DB::transaction(function () use ($stock, $data) {
            $qty = (int) ($data['Quantity'] ?? $stock->quantity);
            $damaged = $stock->take($qty, Stock::DAMAGE);
            Damage::create([
                'stock_id' => $damaged->id, 'unit_id' => $damaged->unit_id, 'quantity' => $qty, 'date' => now(),
                'reason' => $data['Reason'], 'actions' => $data['Actions'], 'remarks' => $data['Remarks'] ?? null,
            ]);
        });

        return $this->ok('Damage added successfully.');
    }

    /**
     * formNo 1 = edit, 2 = approval (Approved/Declined), 3 = claim warranty, 4 = claim service.
     */
    public function update(Request $request, Damage $damage): JsonResponse
    {
        abort_unless($this->ownsUnit($request, $damage->unit_id), 404);
        $damage->load('stock');

        switch ((int) $request->input('formNo')) {
            case 1:
                if ($damage->status !== 'Pending') {
                    return $this->fail('Only pending damages can be edited.');
                }
                $data = $this->check($request, [
                    'Date' => ['required', 'date'], 'Reason' => ['required', 'string', 'max:2000'],
                    'Actions' => ['required', 'string', 'max:2000'], 'Remarks' => ['nullable', 'string', 'max:2000'],
                ], ['Actions' => 'Taken Actions']);
                $damage->update(['date' => $data['Date'], 'reason' => $data['Reason'], 'actions' => $data['Actions'], 'remarks' => $data['Remarks'] ?? null]);

                return $this->ok('Damage updated successfully.');

            case 2:
                if ($damage->status !== 'Pending') {
                    return $this->fail('This damage has already been '.strtolower($damage->status).'.');
                }
                $data = $this->check($request, ['Approve' => ['required', Rule::in(['Approved', 'Declined'])]], ['Approve' => 'Action']);
                DB::transaction(function () use ($damage, $data, $request) {
                    $damage->update(['status' => $data['Approve'], 'approved_by' => $request->user()->id, 'approved_at' => now()]);
                    if ($data['Approve'] === 'Declined') {
                        $damage->stock->update(['status' => Stock::IN_STOCK]); // not damaged after all
                    }
                });

                return $this->ok('Damage '.strtolower($data['Approve']).' successfully.');

            case 3:
            case 4:
                $type = (int) $request->input('formNo') === 3 ? 'Warranty' : 'Service';
                if ($damage->status !== 'Approved' || $damage->claim()->exists()) {
                    return $this->fail('Only approved damages without a claim can be sent for '.strtolower($type).'.');
                }
                DB::transaction(function () use ($damage, $type) {
                    WarrantyClaim::create(['damage_id' => $damage->id, 'stock_id' => $damage->stock_id, 'unit_id' => $damage->unit_id, 'type' => $type]);
                    $damage->stock->update(['status' => $type === 'Warranty' ? Stock::UNDER_WARRANTY : Stock::UNDER_SERVICE]);
                });

                return $this->ok("$type claim created successfully.", ['redirect' => route('inventory.transaction.warrantyandservice.index')]);
        }

        return $this->fail('Unknown action.');
    }
}
