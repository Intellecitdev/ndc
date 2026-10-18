@php $p = 'inventory/configuration/ranks'; $status = ['Y' => 'Active', 'N' => 'In Active']; @endphp
<x-layouts.app title="Ranks" module="inventory">
    <div x-data="{ edit: {}, deleteUrl: '' }">
        <x-card title="Ranks" :back="route('inventory.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <button class="btn btn-success" @click="$dispatch('open-modal', 'addModal')"><i class="fa-solid fa-plus"></i>&nbsp; Add Rank</button>
                @endcanmenu
            </x-slot:actions>
            <x-search-form :action="url($p)" />
            <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                <thead><tr><th>ID</th><th>Short</th><th>Rank</th><th>Order</th><th>Status</th><th>Action</th></tr></thead>
                <tbody>
                @forelse ($records as $r)
                    <tr>
                        <td>{{ $r->id }}</td><td>{{ $r->short }}</td><td>{{ $r->name }}</td><td>{{ $r->order }}</td><td>{{ $r->status ? 'Active' : 'InActive' }}</td>
                        <td><x-row-actions :p="$p" :update="url($p.'/'.$r->id)" :edit="['Code' => $r->short, 'Rank' => $r->name, 'RankOrder' => (string) $r->order, 'C4S' => $r->status ? 'Y' : 'N']" /></td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
            <x-slot:footer>{{ $records->links() }}</x-slot:footer>
        </x-card>

        @foreach (['add' => null, 'edit' => 'edit'] as $mode => $bind)
            <x-modal-form :name="$mode.'Modal'" :title="($bind ? 'Edit' : 'Add').' Rank'" :action="$bind ? null : url($p)" :bind-action="$bind ? 'edit.url' : null"
                          :method="$bind ? 'PATCH' : 'POST'" :icon="$bind ? 'fa-solid fa-pen-to-square' : 'fa-solid fa-plus'"
                          :submit="$bind ? 'Update' : 'Save'" :submit-class="$bind ? 'btn-warning' : 'btn-success'">
                <x-form.input label="Short" name="Code" maxlength="50" required :x-model="$bind ? 'edit.Code' : null" />
                <x-form.input label="Rank" name="Rank" maxlength="150" required :x-model="$bind ? 'edit.Rank' : null" />
                <x-form.input label="Rank Order" name="RankOrder" type="number" min="0" required :x-model="$bind ? 'edit.RankOrder' : null" />
                <x-form.select label="Status" name="C4S" :options="$status" selected="Y" required :x-model="$bind ? 'edit.C4S' : null" />
            </x-modal-form>
        @endforeach
        <x-delete-modal entity="Rank" />
    </div>
</x-layouts.app>
