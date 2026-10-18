<x-layouts.app title="Tickets" module="admin">
    <x-card title="Tickets" :back="route('admin.dashboard')">
        <x-search-form :action="route('admin.messaging.tickets.index')" />
        @include('partials.tickets-table', [
            'updateRoute' => 'admin.messaging.tickets.update',
            'isAdmin' => true,
            'canDelete' => auth()->user()->canMenu('admin/messaging/tickets', 'delete'),
        ])
    </x-card>
</x-layouts.app>
