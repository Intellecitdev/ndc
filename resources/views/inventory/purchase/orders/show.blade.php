@php $p = 'inventory/purchase/purchaseorders'; @endphp
<x-layouts.app title="Purchase Orders" module="inventory">
    <x-card title="Purchase Order Details" :back="route('inventory.purchase.purchaseorders.index')">
        <x-slot:actions>
            @canmenu($p, 'edit')
                <a href="{{ route('inventory.purchase.purchaseorders.edit', $order) }}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i>&nbsp; Edit</a>
            @endcanmenu
            <a href="{{ route('inventory.purchase.purchaseorders.pdf', $order) }}" class="btn btn-secondary" target="_blank"><i class="fa-solid fa-file-pdf"></i> PDF</a>
        </x-slot:actions>
        @include('inventory.purchase.orders._details', ['order' => $order])
    </x-card>
</x-layouts.app>
