{{-- Model request: the model with its ports, layers and capacities. --}}
<x-card title="Model Details" class="mb-2">
    <table class="table table-bordered [&_td]:text-center [&_th]:text-center">
        <thead><tr><th>ID</th><th>Model</th><th>Brand</th><th>Category</th><th>Status</th><th>Approval Status</th></tr></thead>
        <tbody><tr>
            <td>{{ $record->id }}</td><td>{{ $record->name }}</td><td>{{ $record->brand?->name }}</td>
            <td>{{ $record->category?->name }}</td><td>{{ $record->status ? 'Active' : 'InActive' }}</td><td>{{ $record->approval_status }}</td>
        </tr></tbody>
    </table>
</x-card>
<div class="grid grid-cols-1 gap-x-6 md:grid-cols-3">
    @foreach (['Ports' => $record->ports, 'Layers' => $record->layers, 'Capacities' => $record->capacities] as $title => $rows)
        <x-card :title="$title" class="mb-2">
            <table class="table table-bordered [&_td]:text-center [&_th]:text-center">
                <thead><tr><th>SL</th><th>Name</th><th>Status</th></tr></thead>
                <tbody>
                @forelse ($rows as $row)
                    <tr><td>{{ $loop->iteration }}</td><td>{{ $row->name }}</td><td>{{ $row->status ? 'Active' : 'InActive' }}</td></tr>
                @empty
                    <tr><td colspan="3">No items found</td></tr>
                @endforelse
                </tbody>
            </table>
        </x-card>
    @endforeach
</div>
