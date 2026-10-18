<x-layouts.app title="Categories" module="inventory">
    <x-card title="Category Details" :back="url('inventory/configuration/categories')" class="mb-2">
        <table class="table table-bordered [&_td]:text-center [&_th]:text-center">
            <thead><tr><th>ID</th><th>Category</th><th>Description</th><th>Parent Category</th><th>Status</th></tr></thead>
            <tbody><tr>
                <td>{{ $category->id }}</td><td>{{ $category->name }}</td><td>{{ $category->description }}</td>
                <td>{{ $category->parent?->name }}</td><td>{{ $category->status ? 'Active' : 'InActive' }}</td>
            </tr></tbody>
        </table>
    </x-card>
    <x-card title="Brands, Models, Ports, Layers and Capacity Information">
        @include('inventory.configuration._model-info', ['models' => $category->models, 'showBrand' => true])
        @if ($category->brands->whereNotIn('id', $category->models->pluck('brand_id'))->isNotEmpty())
            <p class="mt-2 text-sm text-bs-secondary">Brands without models: {{ $category->brands->whereNotIn('id', $category->models->pluck('brand_id'))->pluck('name')->implode(', ') }}</p>
        @endif
    </x-card>
</x-layouts.app>
