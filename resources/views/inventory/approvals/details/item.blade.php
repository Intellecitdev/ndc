{{-- Item request: every field of the item. --}}
<x-card title="Item Details">
    <table class="table table-bordered table-striped [&_th]:w-[30%] [&_th]:text-left">
        <thead><tr><th>Title</th><th>Value</th></tr></thead>
        <tbody>
        @foreach ([
            '#' => $record->id, 'Item Code' => $record->code, 'Item Name' => $record->name, 'Description' => $record->description,
            'Unit' => $record->unit?->name, 'Parent Category' => $record->parentCategory?->name, 'Category' => $record->category?->name,
            'Brand' => $record->brand?->name, 'Model' => $record->productModel?->name, 'Port' => $record->port?->name,
            'Layer' => $record->layer?->name, 'Capacity' => $record->capacity?->name,
            'Warranty?' => $record->has_warranty ? 'Yes' : 'No', 'Consumable?' => $record->is_consumable ? 'Yes' : 'No',
            'License?' => $record->is_license ? 'Yes' : 'No', 'Status' => $record->status ? 'Active' : 'Inactive',
            'Approval Status' => $record->approval_status, 'Created At' => $record->created_at?->format('d M Y, h:i A'),
        ] as $k => $v)
            @continue(in_array($k, ['Port', 'Layer', 'Capacity']) && ! $v)
            <tr><th>{{ $k }}</th><td>{{ $v }}</td></tr>
        @endforeach
        </tbody>
    </table>
</x-card>
