@php $p = 'inventory/configuration/items'; @endphp
<x-layouts.app title="Items" module="inventory">
    <div x-data="{ deleteUrl: '' }">
        <x-card title="Items" :back="route('inventory.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <a href="{{ route('inventory.configuration.items.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i>&nbsp; Add Item</a>
                @endcanmenu
            </x-slot:actions>
            <x-filter-form :action="url($p)" :fields="['code' => 'Item Code', 'name' => 'Item Name', 'category' => 'Category', 'parent' => 'Parent Category', 'brand' => 'Brand', 'model' => 'Model']" />
            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>#</th><th>Item Code</th><th>Item Name</th><th>Category</th><th>Parent Category</th><th>Brand</th><th>Model</th><th>Unit</th><th>Port</th><th>Wrnt.</th><th>Cons.</th><th>Status</th><th>Stock</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse ($items as $i)
                        <tr>
                            <td>{{ $i->id }}</td><td>{{ $i->code }}</td><td>{{ $i->name }}</td><td>{{ $i->category?->name }}</td><td>{{ $i->parentCategory?->name }}</td>
                            <td>{{ $i->brand?->name }}</td><td>{{ $i->productModel?->name }}</td><td>{{ $i->unit?->name }}</td><td>{{ $i->port?->name }}</td>
                            <td>{{ $i->has_warranty ? 'Yes' : 'No' }}</td><td>{{ $i->is_consumable ? 'Yes' : 'No' }}</td><td>{{ $i->status ? 'Active' : 'Inactive' }} <x-approval-badge :record="$i" /></td>
                            <td>{{ $stock[$i->id] ?? 0 }}</td>
                            <td>
                                <div class="flex justify-center gap-1">
                                    <a href="{{ route('inventory.configuration.items.show', $i) }}" title="View" class="btn btn-sm btn-info"><i class="fa-regular fa-eye"></i></a>
                                    @canmenu($p, 'edit')
                                        <a href="{{ route('inventory.configuration.items.edit', $i) }}" title="Edit" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                    @endcanmenu
                                    @canmenu($p, 'delete')
                                        <button title="Delete" class="btn btn-sm btn-danger" @click="deleteUrl = @js(route('inventory.configuration.items.destroy', $i)); $dispatch('open-modal', 'deleteModal')"><i class="fa-solid fa-trash"></i></button>
                                    @endcanmenu
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot:footer>{{ $items->links() }}</x-slot:footer>
        </x-card>
        <x-delete-modal entity="Item" />
    </div>
</x-layouts.app>
