@php $p = 'inventory/purchase/purchaseorders'; @endphp
<x-layouts.app title="Purchase Orders" module="inventory">
    <div x-data="{ deleteUrl: '' }">
        <x-card title="Purchase Orders" :back="route('inventory.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <a href="{{ route('inventory.purchase.purchaseorders.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i>&nbsp; Add Purchase Order</a>
                @endcanmenu
            </x-slot:actions>
            <x-filter-form :action="url($p)" :fields="['PONo' => 'PO No']">
                <input type="text" name="Date" class="form-control" placeholder="Date" value="{{ request('Date') }}" x-datepicker>
                <select class="form-select" name="Supplier">
                    <option value="">Select Category</option>
                    @foreach ($suppliers as $id => $name)<option value="{{ $id }}" @selected(request('Supplier') == $id)>{{ $name }}</option>@endforeach
                </select>
                <select class="form-select" name="FinYear">
                    <option value="">Select Category</option>
                    @foreach ($finYears as $id => $name)<option value="{{ $id }}" @selected(request('FinYear') == $id)>{{ $name }}</option>@endforeach
                </select>
            </x-filter-form>
            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>#</th><th>PO NO</th><th>PO Date</th><th>Purchase Unit</th><th>Fin. Year</th><th>Supplier</th><th>Comments</th><th>#of Item</th><th>Quantity</th><th>Due Qty</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse ($orders as $o)
                        <tr>
                            <td>{{ $o->id }}</td><td>{{ $o->po_no }}</td><td>{{ $o->date->format('d-m-Y') }}</td><td>{{ $o->unit?->name }}</td>
                            <td>{{ $o->financialYear?->name }}</td><td>{{ $o->supplier?->name }}</td><td>{{ $o->comments }}</td>
                            <td>{{ $o->items->count() }}</td><td>{{ $o->orderQty() }}</td><td>{{ $o->dueQty() }}</td><td>{{ $o->status ? 'Active' : 'Inactive' }} <x-approval-badge :record="$o" /></td>
                            <td>
                                <div class="flex justify-center gap-1">
                                    <a href="{{ route('inventory.purchase.purchaseorders.show', $o) }}" title="View" class="btn btn-sm btn-info"><i class="fa-regular fa-eye"></i></a>
                                    <a href="{{ route('inventory.purchase.purchaseorders.pdf', $o) }}" title="PDF" class="btn btn-sm btn-secondary" target="_blank"><i class="fa-solid fa-file-pdf"></i></a>
                                    @canmenu($p, 'edit')
                                        <a href="{{ route('inventory.purchase.purchaseorders.edit', $o) }}" title="Edit" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                    @endcanmenu
                                    @canmenu($p, 'delete')
                                        <button title="Delete" class="btn btn-sm btn-danger" @click="deleteUrl = @js(route('inventory.purchase.purchaseorders.destroy', $o)); $dispatch('open-modal', 'deleteModal')"><i class="fa-solid fa-trash"></i></button>
                                    @endcanmenu
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot:footer>{{ $orders->links() }}</x-slot:footer>
        </x-card>
        <x-delete-modal entity="Purchase Order" />
    </div>
</x-layouts.app>
