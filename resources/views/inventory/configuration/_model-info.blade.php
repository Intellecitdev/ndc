{{-- "Brands, Models, Ports, Layers and Capacity Information" rows; $models, $showBrand --}}
<table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
    <thead>
    <tr>
        <th>SL</th>
        @if ($showBrand)<th>Brand</th>@endif
        <th>Model</th><th>Ports</th><th>Layers</th><th>Capacity</th><th>Status</th>
    </tr>
    </thead>
    <tbody>
    @forelse ($models as $m)
        <tr>
            <td>{{ $loop->iteration }}</td>
            @if ($showBrand)<td>{{ $m->brand?->name }}</td>@endif
            <td><a href="{{ url('inventory/configuration/models/'.$m->id) }}">{{ $m->name }}</a></td>
            <td>{{ $m->ports->pluck('name')->implode(', ') }}</td>
            <td>{{ $m->layers->pluck('name')->implode(', ') }}</td>
            <td>{{ $m->capacities->pluck('name')->implode(', ') }}</td>
            <td>{{ $m->status ? 'Active' : 'InActive' }}</td>
        </tr>
    @empty
        <tr><td colspan="{{ $showBrand ? 7 : 6 }}">No items found</td></tr>
    @endforelse
    </tbody>
</table>
