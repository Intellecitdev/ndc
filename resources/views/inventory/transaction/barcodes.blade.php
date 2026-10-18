<x-layouts.app title="Bar Codes" module="inventory">
    <div x-data="{ view: {} }">
        <x-card title="Bar Codes" :back="route('inventory.dashboard')">
            <x-slot:actions>
                <a href="{{ route('inventory.transaction.barcodes.bulk') }}" class="btn btn-primary"><i class="fa-solid fa-print"></i>&nbsp; Bulk Print</a>
            </x-slot:actions>
            <x-filter-form :action="url('inventory/transaction/barcodes')" :fields="['Serial' => 'Product Serial No', 'Name' => 'Product Name']" />
            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>#</th><th>Product Serial</th><th>Product Name</th><th>Product Category</th><th>Coverage</th><th>Date(From)</th><th>Date(To)</th><th>Supplier</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse ($stocks as $s)
                        <tr>
                            <td>{{ $s->id }}</td><td>{{ $s->label() }}</td><td>{{ $s->item->name }}</td><td>{{ $s->item->category?->name }}</td>
                            <td>{{ $s->coverage_type }}</td><td>{{ $s->coverage_start?->format('d-m-Y') }}</td><td>{{ $s->coverage_end?->format('d-m-Y') }}</td><td>{{ $s->supplier?->name }}</td>
                            <td>
                                <div class="flex justify-center gap-1">
                                    <button title="Item Details" class="btn btn-sm btn-info" @click="view = @js($s->details()); $dispatch('open-modal', 'viewModal')"><i class="fa-solid fa-eye"></i></button>
                                    <a href="{{ route('inventory.transaction.barcodes.pdf', $s) }}" title="Barcode Print" class="btn btn-sm btn-secondary" target="_blank"><i class="fa-solid fa-barcode"></i></a>
                                    <button type="button" title="Print Barcode" class="btn btn-sm btn-primary" @click="printBarcodes([{{ $s->id }}])"><i class="fa-solid fa-print"></i></button>
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot:footer>{{ $stocks->links() }}</x-slot:footer>
        </x-card>
        @include('inventory.transaction._stock-details-modal')
        @include('inventory.transaction._barcode-print-frame')
    </div>
</x-layouts.app>
