{{-- Stock entry request: the receive with its lines and serial numbers. --}}
<x-card title="Receive Purchase Order Details">
    <x-slot:actions>
        <a href="{{ route('inventory.purchase.purchaseorderreceive.pdf', $record) }}" class="btn btn-secondary" target="_blank"><i class="fa-solid fa-file-pdf"></i> PDF</a>
    </x-slot:actions>
    @include('inventory.purchase.receives._details', ['receive' => $record])
    {{-- A rejected entry has no stock rows left: show the received lines instead. --}}
    @if ($record->stocks->isEmpty() && $record->items->isNotEmpty())
        <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
            <thead><tr><th>Sl.</th><th>Item Code</th><th>Item Name</th><th>Category</th><th>Description</th><th>Quantity</th></tr></thead>
            <tbody>
            @foreach ($record->items as $line)
                <tr>
                    <td>{{ $loop->iteration }}</td><td>{{ $line->item?->code }}</td><td>{{ $line->item?->name }}</td>
                    <td>{{ $line->item?->category?->name }}</td><td>{{ $line->item?->brand?->name }}, {{ $line->item?->productModel?->name }}</td>
                    <td>{{ $line->quantity }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</x-card>
