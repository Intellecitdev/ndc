<x-layouts.app title="Issue Vouchers" module="inventory">
    <x-card title="Issue Vouchers" :back="route('inventory.dashboard')">
        <x-filter-form :action="url('inventory/transaction/issuevouchers')" :fields="['Code' => 'Invoice No']" />
        <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
            <thead><tr><th>#</th><th>Invoice No</th><th>Date</th><th>Issued By</th><th>Action</th></tr></thead>
            <tbody>
            @forelse ($vouchers as $v)
                <tr>
                    <td>{{ $v->id }}</td><td>{{ $v->iv_no }} <x-approval-badge :record="$v" /></td><td>{{ $v->date->format('d-m-Y') }}</td><td>{{ $v->creator?->full_name }}</td>
                    <td><a href="{{ route('inventory.transaction.stockposition.pdf', $v) }}" title="Delivery Challan" class="btn btn-sm btn-secondary" target="_blank"><i class="fa-solid fa-file-pdf"></i></a></td>
                </tr>
            @empty
            @endforelse
            </tbody>
        </table>
        <x-slot:footer>{{ $vouchers->links() }}</x-slot:footer>
    </x-card>
</x-layouts.app>
