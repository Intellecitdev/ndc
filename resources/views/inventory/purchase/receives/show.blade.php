<x-layouts.app title="Purchase Order Receive" module="inventory">
    <x-card title="Receive Purchase Order Details" :back="route('inventory.purchase.purchaseorderreceive.index')">
        <x-slot:actions>
            @canmenu('inventory/purchase/purchaseorderreceive', 'edit')
                <a href="{{ route('inventory.purchase.purchaseorderreceive.edit', $receive) }}" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i>&nbsp; Edit</a>
            @endcanmenu
            <a href="{{ route('inventory.purchase.purchaseorderreceive.pdf', $receive) }}" class="btn btn-secondary" target="_blank"><i class="fa-solid fa-file-pdf"></i> PDF</a>
        </x-slot:actions>
        @include('inventory.purchase.receives._details')
    </x-card>
</x-layouts.app>
