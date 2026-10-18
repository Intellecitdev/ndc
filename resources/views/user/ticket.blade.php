<x-layouts.app title="Ticket">
    <x-card :title="'Ticket >> Unread: '.$unread" :back="route('welcome')">
        <x-slot:actions>
            <button class="btn btn-success" @click="$dispatch('open-modal', 'addModal')"><i class="fa-solid fa-plus"></i>&nbsp; Create Ticket</button>
        </x-slot:actions>
        <x-search-form :action="route('user.ticket.index')" />
        @include('partials.tickets-table', ['updateRoute' => 'user.ticket.update', 'isAdmin' => false, 'canDelete' => false])
    </x-card>

    <x-modal-form name="addModal" title="Create New Ticket" :action="route('user.ticket.store')" files>
        <x-form.input label="Subject" name="Subject" maxlength="250" required />
        <x-form.input label="Details" name="Details" type="textarea" rows="5" required />
        <x-form.input label="Attachments (Max. 5MB)" name="attchfile" type="file" accept="image/*,application/pdf" />
    </x-modal-form>
</x-layouts.app>
