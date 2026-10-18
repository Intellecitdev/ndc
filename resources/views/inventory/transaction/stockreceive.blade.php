@php $p = 'inventory/transaction/stockreceive'; @endphp
<x-layouts.app title="Stock Receive" module="inventory">
    <div x-data="{ url: '' }">
        <x-card title="Stock Receive" :back="route('inventory.dashboard')">
            <x-filter-form :action="url($p)" :fields="['Serial' => 'Product Serial', 'Name' => 'Product Name']">
                <select class="form-select" name="CategoryID">
                    <option value="">Select Category</option>
                    @foreach ($categories as $id => $name)<option value="{{ $id }}" @selected(request('CategoryID') == $id)>{{ $name }}</option>@endforeach
                </select>
                <select class="form-select" name="TypeID">
                    <option value="">Select Type </option>
                    @foreach (\App\Models\IssueVoucherItem::FILTERS as $id => $name)<option value="{{ $id }}" @selected(request()->filled('TypeID') && $type === (string) $id)>{{ $name }}</option>@endforeach
                </select>
            </x-filter-form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>#</th><th>IV No</th><th>Serial No</th><th>Item Name</th><th>Item Category</th><th>Quantity</th><th>Unit</th><th>Transfer Type</th><th>Transfer From</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse ($rows as $r)
                        <tr>
                            <td>{{ $r->id }}</td><td>{{ $r->voucher->iv_no }}</td><td>{{ $r->stock->label() }}</td><td>{{ $r->stock->item->name }}</td>
                            <td>{{ $r->stock->item->category?->name }}</td><td>{{ $r->quantity }}</td><td>{{ $r->stock->item->unit?->name }}</td>
                            <td>Issue Voucher</td><td>{{ $r->voucher->fromUnit?->name }}</td>
                            <td><span class="badge {{ ['Pending' => 'text-bg-warning', 'Received' => 'text-bg-success', 'Returned' => 'text-bg-secondary'][$r->status] }}">{{ $r->status }}</span></td>
                            <td>
                                @if ($r->status === 'Pending')
                                    @canmenu($p, 'edit')
                                        <div class="flex justify-center gap-1">
                                            <button title="Receive" class="btn btn-sm btn-success" @click="url = @js(route('inventory.transaction.stockreceive.update', $r)); $dispatch('open-modal', 'receiveModal')"><i class="fa-solid fa-check"></i></button>
                                            <button title="Return" class="btn btn-sm btn-danger" @click="url = @js(route('inventory.transaction.stockreceive.update', $r)); $dispatch('open-modal', 'returnModal')"><i class="fa-solid fa-rotate-left"></i></button>
                                        </div>
                                    @endcanmenu
                                @endif
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot:footer>{{ $rows->links() }}</x-slot:footer>
        </x-card>
        <x-confirm-modal name="receiveModal" bind-action="url" method="PATCH" message="Are you sure you want to Receive this Stock?" submit="Receive" submit-class="btn-success">
            <input type="hidden" name="formNo" value="1">
        </x-confirm-modal>
        <x-confirm-modal name="returnModal" bind-action="url" method="PATCH" message="Are you sure you want to Return this Stock?" submit="Return" submit-class="btn-danger" submit-icon="fa-solid fa-rotate-left">
            <input type="hidden" name="formNo" value="2">
        </x-confirm-modal>
    </div>
</x-layouts.app>
