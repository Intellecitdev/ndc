<x-layouts.app title="Items" module="inventory">
    <div class="grid grid-cols-1 gap-x-6 md:grid-cols-12">
        <div class="md:col-span-8">
            <x-card title="Item Details" :back="route('inventory.configuration.items.index')">
                <x-slot:actions>
                    @canmenu('inventory/configuration/items', 'edit')
                        <a href="{{ route('inventory.configuration.items.edit', $item) }}" title="Edit" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i>&nbsp; Edit Item</a>
                    @endcanmenu
                </x-slot:actions>
                <table class="table table-bordered table-striped [&_th]:w-[30%] [&_th]:text-left">
                    <thead><tr><th>Title</th><th>Value</th></tr></thead>
                    <tbody>
                    @foreach ([
                        '#' => $item->id, 'Item Code' => $item->code, 'Item Name' => $item->name, 'Description' => $item->description,
                        'Unit' => $item->unit?->name, 'Category' => $item->category?->name, 'Parent Category' => $item->parentCategory?->name,
                        'Brand' => $item->brand?->name, 'Model' => $item->productModel?->name, 'Port' => $item->port?->name,
                        'Layer' => $item->layer?->name, 'Capacity' => $item->capacity?->name,
                        'Warranty?' => $item->has_warranty ? 'Yes' : 'No', 'Consumable?' => $item->is_consumable ? 'Yes' : 'No',
                        'License?' => $item->is_license ? 'Yes' : 'No', 'Status' => $item->status ? 'Active' : 'Inactive',
                    ] as $k => $v)
                        @continue(in_array($k, ['Port', 'Layer', 'Capacity']) && ! $v)
                        <tr><th>{{ $k }}</th><td>{{ $v }}</td></tr>
                    @endforeach
                    </tbody>
                </table>
            </x-card>
        </div>
        <div class="md:col-span-4">
            <x-card title="Item Statistics..">
                <table class="table table-bordered table-striped [&_td:last-child]:text-center">
                    <thead><tr><th>Title</th><th>Value</th></tr></thead>
                    <tbody>
                    @foreach ($stats as $k => $v)
                        <tr><th class="!text-left font-normal">{{ $k }}</th><td>{{ $v }}</td></tr>
                    @endforeach
                    </tbody>
                </table>
            </x-card>
        </div>
    </div>
</x-layouts.app>
