{{-- Parent category request. --}}
<x-card title="Parent Category Details" class="mb-2">
    <table class="table table-bordered [&_td]:text-center [&_th]:text-center">
        <thead><tr><th>ID</th><th>Parent Category</th><th>Status</th><th>Approval Status</th><th>Created At</th></tr></thead>
        <tbody><tr>
            <td>{{ $record->id }}</td><td>{{ $record->name }}</td><td>{{ $record->status ? 'Active' : 'InActive' }}</td>
            <td>{{ $record->approval_status }}</td><td>{{ $record->created_at?->format('d M Y, h:i A') }}</td>
        </tr></tbody>
    </table>
</x-card>
<x-card title="Categories">
    <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
        <thead><tr><th>SL</th><th>Category</th><th>Description</th><th>Status</th></tr></thead>
        <tbody>
        @forelse ($record->categories as $c)
            <tr><td>{{ $loop->iteration }}</td><td>{{ $c->name }}</td><td>{{ $c->description }}</td><td>{{ $c->status ? 'Active' : 'InActive' }}</td></tr>
        @empty
            <tr><td colspan="4">No items found</td></tr>
        @endforelse
        </tbody>
    </table>
</x-card>
