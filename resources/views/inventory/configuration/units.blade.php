@php
    $p = 'inventory/configuration/units';
    $status = ['Y' => 'Active', 'N' => 'In Active'];
    $types = ['Wing' => 'Wing', 'Unit' => 'Unit', 'Division' => 'Division'];
@endphp
<x-layouts.app title="Wings" module="inventory">
    <div x-data="{ edit: {}, deleteUrl: '' }">
        <x-card title="Wings" :back="route('inventory.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <button class="btn btn-success" @click="$dispatch('open-modal', 'addModal')"><i class="fa-solid fa-plus"></i>&nbsp; Add Wing</button>
                @endcanmenu
            </x-slot:actions>
            <x-search-form :action="url($p)" />
            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>ID</th><th>Code</th><th>Wing</th><th>Address</th><th>Type</th><th>Order</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse ($records as $r)
                        <tr>
                            <td>{{ $r->id }}</td><td>{{ $r->code }}</td><td>{{ $r->name }}</td><td>{{ $r->address }}</td>
                            <td>{{ $r->type }}</td><td>{{ $r->order }}</td><td>{{ $r->status ? 'Active' : 'InActive' }}</td>
                            <td>
                                <x-row-actions :p="$p" :update="url($p.'/'.$r->id)"
                                               :edit="['Code' => $r->code, 'Unit' => $r->name, 'Address' => $r->address, 'Type' => $r->type, 'Order' => (string) $r->order, 'C4S' => $r->status ? 'Y' : 'N']" />
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot:footer>{{ $records->links() }}</x-slot:footer>
        </x-card>

        @foreach (['add' => null, 'edit' => 'edit'] as $mode => $bind)
            <x-modal-form :name="$mode.'Modal'" :title="($bind ? 'Edit' : 'Add').' Wing'" :action="$bind ? null : url($p)" :bind-action="$bind ? 'edit.url' : null"
                          :method="$bind ? 'PATCH' : 'POST'" :icon="$bind ? 'fa-solid fa-pen-to-square' : 'fa-solid fa-plus'"
                          :submit="$bind ? 'Update' : 'Save'" :submit-class="$bind ? 'btn-warning' : 'btn-success'">
                <x-form.input label="Code" name="Code" maxlength="50" required :x-model="$bind ? 'edit.Code' : null" />
                <x-form.input label="Unit Name" name="Unit" maxlength="250" required :x-model="$bind ? 'edit.Unit' : null" />
                <x-form.input label="Address" name="Address" type="textarea" maxlength="250" rows="3" :x-model="$bind ? 'edit.Address' : null" />
                <x-form.select label="Type" name="Type" :options="$types" selected="Wing" required :x-model="$bind ? 'edit.Type' : null" />
                <x-form.input label="Order" name="Order" maxlength="100" required :x-model="$bind ? 'edit.Order' : null" />
                <x-form.select label="Status" name="C4S" :options="$status" selected="Y" required :x-model="$bind ? 'edit.C4S' : null" />
            </x-modal-form>
        @endforeach
        <x-delete-modal entity="Wing" />
    </div>
</x-layouts.app>
