@php $p = 'inventory/configuration/itemunits'; $status = ['Y' => 'Active', 'N' => 'In Active']; @endphp
<x-layouts.app title="Item Unit" module="inventory">
    <div x-data="{ edit: {}, deleteUrl: '' }">
        <x-card title="Item Units" :back="route('inventory.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <button class="btn btn-success" @click="$dispatch('open-modal', 'addModal')"><i class="fa-solid fa-plus"></i>&nbsp; Add Unit</button>
                @endcanmenu
            </x-slot:actions>
            <x-search-form :action="url($p)" />
            <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                <thead><tr><th>ID</th><th>Code</th><th>Unit</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                @forelse ($records as $r)
                    <tr>
                        <td>{{ $r->id }}</td><td>{{ $r->code }}</td><td>{{ $r->name }}</td><td>{{ $r->status ? 'Active' : 'InActive' }}</td>
                        <td><x-row-actions :p="$p" :update="url($p.'/'.$r->id)" :edit="['Code' => $r->code, 'Unit' => $r->name, 'C4S' => $r->status ? 'Y' : 'N']" /></td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
            <x-slot:footer>{{ $records->links() }}</x-slot:footer>
        </x-card>

        @foreach (['add' => null, 'edit' => 'edit'] as $mode => $bind)
            <x-modal-form :name="$mode.'Modal'" :title="($bind ? 'Edit' : 'Add').' Unit'" :action="$bind ? null : url($p)" :bind-action="$bind ? 'edit.url' : null"
                          :method="$bind ? 'PATCH' : 'POST'" :icon="$bind ? 'fa-solid fa-pen-to-square' : 'fa-solid fa-plus'"
                          :submit="$bind ? 'Update' : 'Save'" :submit-class="$bind ? 'btn-warning' : 'btn-success'">
                <x-form.input label="Code" name="Code" maxlength="10" required :x-model="$bind ? 'edit.Code' : null" />
                <x-form.input label="Unit" name="Unit" maxlength="50" required :x-model="$bind ? 'edit.Unit' : null" />
                <x-form.select label="Status" name="C4S" :options="$status" selected="Y" required :x-model="$bind ? 'edit.C4S' : null" />
            </x-modal-form>
        @endforeach
        <x-delete-modal entity="Unit" />
    </div>
</x-layouts.app>
