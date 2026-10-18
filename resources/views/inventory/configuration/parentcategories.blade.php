@php $p = 'inventory/configuration/parentcategories'; $status = ['Y' => 'Active', 'N' => 'In Active']; @endphp
<x-layouts.app title="Parent Categories" module="inventory">
    <div x-data="{ edit: {}, deleteUrl: '' }">
        <x-card title="Parent Categories" :back="route('inventory.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <button class="btn btn-success" @click="$dispatch('open-modal', 'addModal')"><i class="fa-solid fa-plus"></i>&nbsp; Add Parent Category</button>
                @endcanmenu
            </x-slot:actions>
            <x-search-form :action="url($p)" />
            <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                <thead><tr><th>ID</th><th>Parent Category</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                @forelse ($records as $r)
                    <tr>
                        <td>{{ $r->id }}</td><td>{{ $r->name }}</td><td>{{ $r->status ? 'Active' : 'InActive' }} <x-approval-badge :record="$r" /></td>
                        <td><x-row-actions :p="$p" :update="url($p.'/'.$r->id)" :edit="['PCategory' => $r->name, 'C4S' => $r->status ? 'Y' : 'N']" /></td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
            <x-slot:footer>{{ $records->links() }}</x-slot:footer>
        </x-card>

        @foreach (['add' => null, 'edit' => 'edit'] as $mode => $bind)
            <x-modal-form :name="$mode.'Modal'" :title="($bind ? 'Edit' : 'Add').' Parent Category'" :action="$bind ? null : url($p)" :bind-action="$bind ? 'edit.url' : null"
                          :method="$bind ? 'PATCH' : 'POST'" :icon="$bind ? 'fa-solid fa-pen-to-square' : 'fa-solid fa-plus'"
                          :submit="$bind ? 'Update' : 'Save'" :submit-class="$bind ? 'btn-warning' : 'btn-success'">
                <x-form.input label="Parent Category" name="PCategory" maxlength="50" required :x-model="$bind ? 'edit.PCategory' : null" />
                <x-form.select label="Status" name="C4S" :options="$status" selected="Y" required :x-model="$bind ? 'edit.C4S' : null" />
            </x-modal-form>
        @endforeach
        <x-delete-modal entity="Parent Category" />
    </div>
</x-layouts.app>
