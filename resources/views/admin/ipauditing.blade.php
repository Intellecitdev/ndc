@php $p = 'admin/ipauditing'; @endphp
<x-layouts.app title="IP Auditing" module="admin">
    <div x-data="{ edit: {}, deleteUrl: '' }">
        <x-card title="IP Auditing" :back="route('admin.dashboard')">
            <x-search-form :action="route('admin.ipauditing.index')" />
            <div class="table-responsive">
                <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                    <thead><tr><th>ID</th><th>IP</th><th>URL</th><th>User Agent</th><th>Blocked?</th><th>Reason</th><th>Time</th><th>Active</th></tr></thead>
                    <tbody>
                    @forelse ($audits as $a)
                        <tr>
                            <td>{{ $a->id }}</td>
                            <td>{{ $a->ip }}</td>
                            <td class="break-all">{{ $a->url }}</td>
                            <td class="break-all">{{ $a->user_agent }}</td>
                            <td>{{ $a->blocked ? 'Yes' : 'No' }}</td>
                            <td>{{ $a->reason }}</td>
                            <td>{{ $a->created_at }}</td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    @canmenu($p, 'edit')
                                        <button title="Edit" class="btn btn-sm btn-warning"
                                                @click="edit = @js(['url' => route('admin.ipauditing.update', $a), 'ip' => $a->ip, 'page' => $a->url, 'user_agent' => $a->user_agent, 'blocked' => $a->blocked ? '1' : '0', 'reason' => $a->reason]); $dispatch('open-modal', 'editModal')"><i class="fa-solid fa-pen-to-square"></i></button>
                                    @endcanmenu
                                    @canmenu($p, 'delete')
                                        <button title="Delete" class="btn btn-sm btn-danger" @click="deleteUrl = @js(route('admin.ipauditing.destroy', $a)); $dispatch('open-modal', 'deleteModal')"><i class="fa-solid fa-trash"></i></button>
                                    @endcanmenu
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot:footer>{{ $audits->links() }}</x-slot:footer>
        </x-card>

        <x-modal-form name="editModal" title="Edit IP Auditing Info" icon="fa-solid fa-pen-to-square" bind-action="edit.url" method="PUT"
                      submit="Update" submit-class="btn-warning" submit-icon="fa-regular fa-floppy-disk">
            <x-form.input label="IP" name="ip" x-model="edit.ip" required />
            <x-form.input label="URL" name="url" x-model="edit.page" required />
            <x-form.input label="User Agent" name="user_agent" x-model="edit.user_agent" required />
            <x-form.select label="Is Blocked?" name="blocked" :options="['1' => 'Yes', '0' => 'No']" x-model="edit.blocked" required />
            <x-form.select label="Reason" name="reason" :options="array_combine(\App\Models\IpAudit::REASONS, \App\Models\IpAudit::REASONS)" x-model="edit.reason" required />
        </x-modal-form>

        <x-delete-modal entity="IP auditing info" />
    </div>
</x-layouts.app>
