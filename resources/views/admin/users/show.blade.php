<x-layouts.app title="Users" module="admin">
    <x-card title="User Details" :back="route('admin.users.index')">
        <div class="table-responsive">
            <table class="table table-bordered [&_th]:w-[200px] [&_th]:text-left">
                <tbody>
                <tr><th>Login</th><td>{{ $user->name }}</td></tr>
                <tr><th>Full Name</th><td>{{ $user->full_name }}</td></tr>
                <tr><th>Mobile No.</th><td>{{ $user->mobile_no }}</td></tr>
                <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                <tr><th>Address</th><td>{{ $user->address }}</td></tr>
                <tr><th>Role</th><td>{{ $user->role?->name }}</td></tr>
                <tr><th>Unit</th><td>{{ $user->unit?->name }}</td></tr>
                <tr><th>Rank</th><td>{{ $user->rank?->name }}</td></tr>
                <tr><th>Created At</th><td>{{ $user->created_at?->format('d M Y h:i A') }}</td></tr>
                <tr><th>Last Login</th><td>{{ $user->last_login_at?->format('d M Y h:i A') }}</td></tr>
                </tbody>
            </table>
        </div>
        <br>
        @include('admin.roles._access', ['map' => $user->role?->permissionMap() ?? [], 'all' => $user->isSuperAdmin()])
    </x-card>
</x-layouts.app>
