@php $p = 'admin/ipfiltering'; $yn = ['Y' => 'Yes', 'N' => 'No']; $types = ['whitelist' => 'whitelist', 'blacklist' => 'blacklist']; @endphp
<x-layouts.app title="IP Filtering" module="admin">
    <div x-data="{ edit: {}, deleteUrl: '' }">
        <x-card title="IP Filtering" :back="route('admin.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <button class="btn btn-success" @click="$dispatch('open-modal', 'addModal')"><i class="fa-solid fa-plus"></i>&nbsp; Add New IP</button>
                @endcanmenu
            </x-slot:actions>
            <x-search-form :action="route('admin.ipfiltering.index')" />
            <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                <thead><tr><th>ID</th><th>IP Address</th><th>Type</th><th>Reason</th><th>Time</th><th>Active?</th><th>Action</th></tr></thead>
                <tbody>
                @forelse ($filters as $f)
                    <tr>
                        <td>{{ $f->id }}</td>
                        <td>{{ $f->ip_address }}</td>
                        <td>{{ $f->type }}</td>
                        <td>{{ $f->reason }}</td>
                        <td>{{ $f->created_at }}</td>
                        <td>{{ $f->is_active ? 'Y' : 'N' }}</td>
                        <td>
                            <div class="flex justify-center gap-2">
                                @canmenu($p, 'edit')
                                    <button title="Edit" class="btn btn-sm btn-warning"
                                            @click="edit = @js(['url' => route('admin.ipfiltering.update', $f), 'ip_address' => $f->ip_address, 'type' => $f->type, 'C4S' => $f->is_active ? 'Y' : 'N']); $dispatch('open-modal', 'editModal')"><i class="fa-solid fa-pen-to-square"></i></button>
                                @endcanmenu
                                @canmenu($p, 'delete')
                                    <button title="Delete" class="btn btn-sm btn-danger" @click="deleteUrl = @js(route('admin.ipfiltering.destroy', $f)); $dispatch('open-modal', 'deleteModal')"><i class="fa-solid fa-trash"></i></button>
                                @endcanmenu
                            </div>
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
            <x-slot:footer>{{ $filters->links() }}</x-slot:footer>
        </x-card>

        <x-modal-form name="addModal" title="Add New IP" :action="route('admin.ipfiltering.store')">
            <x-form.input label="IP Address" name="ip_address" maxlength="45" required />
            <x-form.select label="Type" name="type" :options="$types" selected="blacklist" required />
            <x-form.select label="Is Active?" name="C4S" :options="$yn" selected="Y" required />
        </x-modal-form>

        <x-modal-form name="editModal" title="Edit IP Address" icon="fa-solid fa-pen-to-square" bind-action="edit.url" method="PUT"
                      submit="Update" submit-class="btn-warning" submit-icon="fa-regular fa-floppy-disk">
            <x-form.input label="IP Address" name="ip_address" maxlength="45" x-model="edit.ip_address" required />
            <x-form.select label="Type" name="type" :options="$types" x-model="edit.type" required />
            <x-form.select label="Is Active?" name="C4S" :options="$yn" x-model="edit.C4S" required />
        </x-modal-form>

        <x-delete-modal entity="IP address" />
    </div>
</x-layouts.app>
