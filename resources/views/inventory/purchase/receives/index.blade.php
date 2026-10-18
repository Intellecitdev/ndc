@php $p = 'inventory/purchase/purchaseorderreceive'; @endphp
<x-layouts.app title="Purchase Order Receive" module="inventory">
    <div x-data="{ deleteUrl: '' }">
        <x-card title="Purchase Order Receive" :back="route('inventory.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <a href="{{ route('inventory.purchase.purchaseorderreceive.create') }}" class="btn btn-success"><i class="fa-solid fa-cart-flatbed"></i>&nbsp; Receive</a>
                @endcanmenu
            </x-slot:actions>
            <x-filter-form :action="url($p)" :fields="['InvoiceNo' => 'Invoice No']">
                <input type="text" name="Date" class="form-control" placeholder="Date" value="{{ request('Date') }}" x-datepicker>
                <select class="form-select" name="Supplier">
                    <option value="">Select One</option>
                    @foreach ($suppliers as $id => $name)<option value="{{ $id }}" @selected(request('Supplier') == $id)>{{ $name }}</option>@endforeach
                </select>
                <input type="text" name="PONo" class="form-control" placeholder="PO No" value="{{ request('PONo') }}">
            </x-filter-form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>#</th><th>Invoice No</th><th>Invoice Date</th><th>Unit</th><th>Supplier</th><th>PO No</th><th>Received Qty</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse ($receives as $r)
                        <tr>
                            <td>{{ $r->id }}</td><td>{{ $r->invoice_no }}</td><td>{{ $r->date->format('d-m-Y') }}</td><td>{{ $r->unit?->name }}</td>
                            <td>{{ $r->supplier?->name }}</td><td>{{ $r->purchaseOrder?->po_no }}</td><td>{{ $r->received_qty }}</td><td>{{ $r->status ? 'Active' : 'Inactive' }} <x-approval-badge :record="$r" /></td>
                            <td>
                                <div class="flex justify-center gap-1">
                                    <a href="{{ route('inventory.purchase.purchaseorderreceive.show', $r) }}" title="View" class="btn btn-sm btn-info"><i class="fa-regular fa-eye"></i></a>
                                    <a href="{{ route('inventory.purchase.purchaseorderreceive.pdf', $r) }}" title="PDF" class="btn btn-sm btn-secondary" target="_blank"><i class="fa-solid fa-file-pdf"></i></a>
                                    @canmenu($p, 'edit')
                                        <a href="{{ route('inventory.purchase.purchaseorderreceive.edit', $r) }}" title="Edit" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                    @endcanmenu
                                    @canmenu($p, 'delete')
                                        <button title="Delete" class="btn btn-sm btn-danger" @click="deleteUrl = @js(route('inventory.purchase.purchaseorderreceive.destroy', $r)); $dispatch('open-modal', 'deleteModal')"><i class="fa-solid fa-trash"></i></button>
                                    @endcanmenu
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot:footer>{{ $receives->links() }}</x-slot:footer>
        </x-card>
        <x-delete-modal entity="Purchase Order Receive" />
    </div>
</x-layouts.app>
