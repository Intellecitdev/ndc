<x-layouts.app title="Licenses" module="inventory">
    <x-card title="Licenses" :back="route('inventory.dashboard')">
        <x-filter-form :action="url('inventory/transaction/licenses')" :fields="['Code' => 'Search']" />
        <div class="table-responsive">
            <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                <thead><tr><th>#</th><th>Item Name</th><th>Product Key</th><th>Manufacturer</th><th>Licensed To Name</th><th>Licensed To Email</th><th>Purchase Date</th><th>Expiration Date</th><th>Deployed</th><th>Supplier</th><th>Action</th></tr></thead>
                <tbody>
                @forelse ($licenses as $l)
                    <tr @class(['!bg-[#f8d7da]' => $l->expiration_date->isPast()])>
                        <td>{{ $l->id }}</td><td>{{ $l->stock->item->name }}</td><td>{{ $l->product_key }}</td><td>{{ $l->manufacturer }}</td>
                        <td>{{ $l->licensed_to_name }}</td><td>{{ $l->licensed_to_email }}</td><td>{{ $l->purchase_date->format('d-m-Y') }}</td>
                        <td class="{{ $l->expiration_date->isPast() ? 'text-bs-danger font-bold' : '' }}">{{ $l->expiration_date->format('d-m-Y') }}</td>
                        <td>{{ $l->deployment?->personnel }} ({{ $l->deployment?->unit?->name }}, {{ $l->deployment?->deploy_date->format('d-m-Y') }})</td>
                        <td>{{ $l->stock->supplier?->name }}</td>
                        <td><span class="badge {{ $l->re_assignable ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $l->re_assignable ? 'Renewable' : 'Not Renewable' }}</span></td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
        </div>
        <x-slot:footer>{{ $licenses->links() }}</x-slot:footer>
    </x-card>
</x-layouts.app>
