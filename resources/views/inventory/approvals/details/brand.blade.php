{{-- Brand request. --}}
<x-card title="Brand Details" class="mb-2">
    <table class="table table-bordered [&_td]:text-center [&_th]:text-center">
        <thead><tr><th>ID</th><th>Brand</th><th>Description</th><th>Category</th><th>Status</th><th>Approval Status</th></tr></thead>
        <tbody><tr>
            <td>{{ $record->id }}</td><td>{{ $record->name }}</td><td>{{ $record->description }}</td>
            <td>{{ $record->category?->name }}</td><td>{{ $record->status ? 'Active' : 'InActive' }}</td><td>{{ $record->approval_status }}</td>
        </tr></tbody>
    </table>
</x-card>
<x-card title="Models, Ports, Layers and Capacity Information">
    @include('inventory.configuration._model-info', ['models' => $record->models, 'showBrand' => false])
</x-card>
