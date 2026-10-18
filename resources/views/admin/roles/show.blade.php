<x-layouts.app title="Roles" module="admin">
    <x-card title="Role Details" :back="route('admin.roles.index')">
        <x-slot:actions>
            @canmenu('admin/roles', 'edit')
                <a href="{{ route('admin.roles.edit', $role) }}" title="Edit" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i>&nbsp; Edit Role</a>
            @endcanmenu
        </x-slot:actions>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead><tr><th>Name</th><th>Slug</th><th>Assigned Users</th></tr></thead>
                <tbody>
                <tr>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->slug }}</td>
                    <td>{{ $role->users->pluck('full_name')->implode(', ') }}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <br>
        @include('admin.roles._access', ['map' => $role->permissionMap()])
    </x-card>
</x-layouts.app>
