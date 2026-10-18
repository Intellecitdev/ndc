<x-layouts.app title="Brands" module="inventory">
    <x-card title="Brands Details" :back="url('inventory/configuration/brands')" class="mb-2">
        <table class="table table-bordered [&_td]:text-center [&_th]:text-center">
            <thead><tr><th>ID</th><th>Brand</th><th>Description</th><th>Category</th><th>Status</th></tr></thead>
            <tbody><tr>
                <td>{{ $brand->id }}</td><td>{{ $brand->name }}</td><td>{{ $brand->description }}</td>
                <td>{{ $brand->category?->name }}</td><td>{{ $brand->status ? 'Active' : 'InActive' }}</td>
            </tr></tbody>
        </table>
    </x-card>
    <x-card title="Models, Ports, Layers and Capacity Information">
        @include('inventory.configuration._model-info', ['models' => $brand->models, 'showBrand' => false])
    </x-card>
</x-layouts.app>
