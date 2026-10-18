@php $p = 'inventory/configuration/suppliers'; $status = ['Y' => 'Yes', 'N' => 'No']; @endphp
<x-layouts.app title="Suppliers" module="inventory">
    <div x-data="{ edit: {}, deleteUrl: '' }">
        <x-card title="Suppliers" :back="route('inventory.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <button class="btn btn-success" @click="$dispatch('open-modal', 'addModal')"><i class="fa-solid fa-plus"></i>&nbsp; Add Supplier</button>
                @endcanmenu
            </x-slot:actions>
            <x-search-form :action="url($p)" />
            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>Code</th><th>Supplier</th><th>Contact Person</th><th>Contact No</th><th>Email</th><th>Address</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                    @forelse ($records as $r)
                        <tr>
                            <td>{{ $r->code }}</td><td>{{ $r->name }}</td><td>{{ $r->contact_person }}</td><td>{{ $r->contact_no }}</td>
                            <td>{{ $r->email }}</td><td>{{ $r->address }}</td><td>{{ $r->status ? 'Active' : 'InActive' }}</td>
                            <td><x-row-actions :p="$p" :update="url($p.'/'.$r->id)" :edit="['Code' => $r->code, 'Supplier' => $r->name, 'ContactPerson' => $r->contact_person, 'ContactNo' => $r->contact_no, 'Email' => $r->email, 'Address' => $r->address, 'C4S' => $r->status ? 'Y' : 'N']" /></td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot:footer>{{ $records->links() }}</x-slot:footer>
        </x-card>

        @foreach (['add' => null, 'edit' => 'edit'] as $mode => $bind)
            <x-modal-form :name="$mode.'Modal'" :title="($bind ? 'Edit' : 'Add').' Supplier'" :action="$bind ? null : url($p)" :bind-action="$bind ? 'edit.url' : null"
                          :method="$bind ? 'PATCH' : 'POST'" :icon="$bind ? 'fa-solid fa-pen-to-square' : 'fa-solid fa-plus'"
                          :submit="$bind ? 'Update' : 'Save'" :submit-class="$bind ? 'btn-warning' : 'btn-success'" size="max-w-[800px]">
                <div class="grid grid-cols-1 gap-x-4 md:grid-cols-2">
                    <x-form.input label="Code" name="Code" maxlength="50" required :x-model="$bind ? 'edit.Code' : null" />
                    <x-form.input label="Supplier Name" name="Supplier" maxlength="50" required :x-model="$bind ? 'edit.Supplier' : null" />
                    <x-form.input label="Contact Person" name="ContactPerson" maxlength="50" required :x-model="$bind ? 'edit.ContactPerson' : null" />
                    <x-form.input label="Contact No" name="ContactNo" pattern="(01)[0-9]{9}" minlength="11" maxlength="11" required :x-model="$bind ? 'edit.ContactNo' : null" />
                    <x-form.input label="Email" name="Email" type="email" required :x-model="$bind ? 'edit.Email' : null" />
                    <x-form.select label="Is Active?" name="C4S" :options="$status" selected="Y" required :x-model="$bind ? 'edit.C4S' : null" />
                </div>
                <x-form.input label="Address" name="Address" type="textarea" maxlength="250" rows="3" :x-model="$bind ? 'edit.Address' : null" />
            </x-modal-form>
        @endforeach
        <x-delete-modal entity="Supplier" />
    </div>
</x-layouts.app>
