@php $p = 'inventory/configuration/brands'; $status = ['Y' => 'Active', 'N' => 'In Active']; @endphp
<x-layouts.app title="Brands" module="inventory">
    <div x-data="{ edit: {}, deleteUrl: '' }">
        <x-card title="Brands" :back="route('inventory.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <button class="btn btn-success" @click="$dispatch('open-modal', 'addModal')"><i class="fa-solid fa-plus"></i>&nbsp; Add Brand</button>
                @endcanmenu
            </x-slot:actions>
            <x-filter-form :action="url($p)" :fields="['Brand' => 'Brand...', 'Category' => 'Category...']" />
            <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                <thead><tr><th>ID</th><th>Brand</th><th>Description</th><th>Category</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                @forelse ($records as $r)
                    <tr>
                        <td>{{ $r->id }}</td><td>{{ $r->name }}</td><td>{{ $r->description }}</td><td>{{ $r->category?->name }}</td><td>{{ $r->status ? 'Active' : 'InActive' }} <x-approval-badge :record="$r" /></td>
                        <td><x-row-actions :p="$p" :update="url($p.'/'.$r->id)" :view="url($p.'/'.$r->id)"
                                           :edit="['CategoryID' => (string) $r->category_id, 'Brand' => $r->name, 'Description' => $r->description, 'C4S' => $r->status ? 'Y' : 'N']" /></td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
            <x-slot:footer>{{ $records->links() }}</x-slot:footer>
        </x-card>

        @foreach (['add' => null, 'edit' => 'edit'] as $mode => $bind)
            <x-modal-form :name="$mode.'Modal'" :title="($bind ? 'Edit' : 'Add').' Brand'" :action="$bind ? null : url($p)" :bind-action="$bind ? 'edit.url' : null"
                          :method="$bind ? 'PATCH' : 'POST'" :icon="$bind ? 'fa-solid fa-pen-to-square' : 'fa-solid fa-plus'"
                          :submit="$bind ? 'Update' : 'Save'" :submit-class="$bind ? 'btn-warning' : 'btn-success'">
                <x-form.select label="Category" name="CategoryID" :options="$categories" placeholder="Select One" required :x-model="$bind ? 'edit.CategoryID' : null" />
                <x-form.input label="Brand" name="Brand" maxlength="20" required :x-model="$bind ? 'edit.Brand' : null" />
                <x-form.input label="Description" name="Description" type="textarea" maxlength="250" rows="3" :x-model="$bind ? 'edit.Description' : null" />
                <x-form.select label="Status" name="C4S" :options="$status" selected="Y" required :x-model="$bind ? 'edit.C4S' : null" />
            </x-modal-form>
        @endforeach
        <x-delete-modal entity="Brand" />
    </div>
</x-layouts.app>
