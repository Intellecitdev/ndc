@php $p = 'admin/roles'; @endphp
<x-layouts.app title="Roles" module="admin">
    <div x-data="{ deleteUrl: '' }">
        <x-card title="Role List" :back="route('admin.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i>&nbsp; Add Role</a>
                @endcanmenu
            </x-slot:actions>

            <x-search-form :action="route('admin.roles.index')" />

            <table class="table table-bordered table-striped [&_td]:text-center [&_th]:text-center">
                <thead>
                <tr><th>ID</th><th>Name</th><th>Slug</th><th>#of Users</th><th>Action</th></tr>
                </thead>
                <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->slug }}</td>
                        <td>{{ $role->users_count }}</td>
                        <td>
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.roles.show', $role) }}" title="View" class="btn btn-sm btn-info"><i class="fa-regular fa-eye"></i></a>
                                @canmenu($p, 'edit')
                                    <a href="{{ route('admin.roles.edit', $role) }}" title="Edit" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                                @endcanmenu
                                @if (! in_array($role->slug, \App\Models\Role::PROTECTED, true))
                                    @canmenu($p, 'delete')
                                        <button title="Delete" class="btn btn-sm btn-danger"
                                                @click="deleteUrl = @js(route('admin.roles.destroy', $role)); $dispatch('open-modal', 'deleteModal')"><i class="fa-solid fa-trash"></i></button>
                                    @endcanmenu
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                @endforelse
                </tbody>
            </table>
            <x-slot:footer>{{ $roles->links() }}</x-slot:footer>
        </x-card>
        <x-delete-modal entity="role" />
    </div>
</x-layouts.app>
