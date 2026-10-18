@php $p = 'inventory/configuration/financialyears'; $status = ['Y' => 'Active', 'N' => 'In Active']; $yn = ['Y' => 'Yes', 'N' => 'No']; @endphp
<x-layouts.app title="Financial Years" module="inventory">
    <div x-data="{ edit: {}, deleteUrl: '' }">
        {{-- The reference shows "Item Units" as this card's title. --}}
        <x-card title="Financial Years" :back="route('inventory.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <button class="btn btn-success" @click="$dispatch('open-modal', 'addModal')"><i class="fa-solid fa-plus"></i>&nbsp; Add Fin. Year</button>
                @endcanmenu
            </x-slot:actions>
            <x-search-form :action="url($p)" />
            <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                <thead><tr><th>ID</th><th>Year</th><th>Current</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                @forelse ($records as $r)
                    <tr>
                        <td>{{ $r->id }}</td><td>{{ $r->name }}</td>
                        <td>@if ($r->is_current)<span class="badge text-bg-success">Yes</span>@else No @endif</td>
                        <td>{{ $r->status ? 'Active' : 'InActive' }}</td>
                        <td><x-row-actions :p="$p" :update="url($p.'/'.$r->id)" :edit="['Name' => $r->name, 'Current' => $r->is_current ? 'Y' : 'N', 'C4S' => $r->status ? 'Y' : 'N']" /></td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
            <x-slot:footer>{{ $records->links() }}</x-slot:footer>
        </x-card>

        @foreach (['add' => null, 'edit' => 'edit'] as $mode => $bind)
            <x-modal-form :name="$mode.'Modal'" :title="($bind ? 'Edit' : 'Add').' Fin. Year'" :action="$bind ? null : url($p)" :bind-action="$bind ? 'edit.url' : null"
                          :method="$bind ? 'PATCH' : 'POST'" :icon="$bind ? 'fa-solid fa-pen-to-square' : 'fa-solid fa-plus'"
                          :submit="$bind ? 'Update' : 'Save'" :submit-class="$bind ? 'btn-warning' : 'btn-success'">
                <x-form.input label="Financial Year" name="Name" maxlength="50" placeholder="Name" required :x-model="$bind ? 'edit.Name' : null" />
                <x-form.select label="Current?" name="Current" :options="$yn" selected="N" required :x-model="$bind ? 'edit.Current' : null" />
                <x-form.select label="Status" name="C4S" :options="$status" selected="Y" required :x-model="$bind ? 'edit.C4S' : null" />
            </x-modal-form>
        @endforeach
        <x-delete-modal entity="Fin. Year" />
    </div>
</x-layouts.app>
