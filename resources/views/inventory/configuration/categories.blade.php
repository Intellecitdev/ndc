@php $p = 'inventory/configuration/categories'; $status = ['Y' => 'Active', 'N' => 'In Active']; @endphp
<x-layouts.app title="Categories" module="inventory">
    <div x-data="{ edit: {}, deleteUrl: '' }">
        <x-card title="Categories" :back="route('inventory.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <button class="btn btn-success" @click="$dispatch('open-modal', 'addModal')"><i class="fa-solid fa-plus"></i>&nbsp; Add Category</button>
                @endcanmenu
            </x-slot:actions>
            <x-filter-form :action="url($p)" :fields="['Category' => 'Category...', 'Parent' => 'Parent...']" />
            <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                <thead><tr><th>ID</th><th>Category</th><th>Description</th><th>Parent Category</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                @forelse ($records as $r)
                    <tr>
                        <td>{{ $r->id }}</td><td>{{ $r->name }}</td><td>{{ $r->description }}</td><td>{{ $r->parent?->name }}</td><td>{{ $r->status ? 'Active' : 'InActive' }} <x-approval-badge :record="$r" /></td>
                        <td><x-row-actions :p="$p" :update="url($p.'/'.$r->id)" :view="url($p.'/'.$r->id)"
                                           :edit="['ParentCatID' => (string) $r->parent_category_id, 'Category' => $r->name, 'Description' => $r->description, 'C4S' => $r->status ? 'Y' : 'N']" /></td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
            <x-slot:footer>{{ $records->links() }}</x-slot:footer>
        </x-card>

        @foreach (['add' => null, 'edit' => 'edit'] as $mode => $bind)
            <x-modal-form :name="$mode.'Modal'" :title="($bind ? 'Edit' : 'Add').' Category'" :action="$bind ? null : url($p)" :bind-action="$bind ? 'edit.url' : null"
                          :method="$bind ? 'PATCH' : 'POST'" :icon="$bind ? 'fa-solid fa-pen-to-square' : 'fa-solid fa-plus'"
                          :submit="$bind ? 'Update' : 'Save'" :submit-class="$bind ? 'btn-warning' : 'btn-success'">
                <x-form.select label="Parent Category" name="ParentCatID" :options="$parents" placeholder="Select One" required :x-model="$bind ? 'edit.ParentCatID' : null" />
                <x-form.input label="Category" name="Category" maxlength="50" required :x-model="$bind ? 'edit.Category' : null" />
                <x-form.input label="Description" name="Description" type="textarea" maxlength="250" rows="3" :x-model="$bind ? 'edit.Description' : null" />
                <x-form.select label="Status" name="C4S" :options="$status" selected="Y" required :x-model="$bind ? 'edit.C4S' : null" />
            </x-modal-form>
        @endforeach
        <x-delete-modal entity="Category" />
    </div>
</x-layouts.app>
