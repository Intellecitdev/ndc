<x-layouts.app title="User Profile">
    <x-card title="User Details" :back="route('welcome')">
        <x-slot:actions>
            @if ($user->is(auth()->user()))
                <button type="button" class="btn btn-warning" @click="$dispatch('open-modal', 'passwordResetModal')"><i class="fa-solid fa-key"></i>&nbsp; Reset Password</button>
                <button type="button" class="btn btn-primary" @click="$dispatch('open-modal', 'uploadImageModal')"><i class="fa-solid fa-image"></i>&nbsp; Upload Photo</button>
            @endif
        </x-slot:actions>

        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <td class="w-[20%] !text-center align-top">
                        <img src="{{ $user->avatarUrl() }}" class="mx-auto w-[180px] p-[5px] shadow" alt="User Image">
                    </td>
                    <td class="w-[40%] align-top">
                        <table class="table table-bordered [&_th]:w-[120px] [&_th]:text-left">
                            <tr><th>Login</th><td>{{ $user->name }}</td></tr>
                            <tr><th>Full Name</th><td>{{ $user->full_name }}</td></tr>
                            <tr><th>Mobile No.</th><td>{{ $user->mobile_no }}</td></tr>
                            <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                            <tr><th>Address</th><td>{{ $user->address }}</td></tr>
                        </table>
                    </td>
                    <td class="w-[40%] align-top">
                        <table class="table table-bordered [&_th]:w-[120px] [&_th]:text-left">
                            <tr><th>Role</th><td>{{ $user->role?->name }}</td></tr>
                            <tr><th>Unit</th><td>{{ $user->unit?->name }}</td></tr>
                            <tr><th>Rank</th><td>{{ $user->rank?->name }}</td></tr>
                            <tr><th>Created At</th><td>{{ $user->created_at?->format('d M Y h:i A') }}</td></tr>
                            <tr><th>Last Login</th><td>{{ $user->last_login_at?->format('d M Y h:i A') }}</td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        @include('admin.roles._access', ['map' => $user->role?->permissionMap() ?? [], 'all' => $user->isSuperAdmin()])
    </x-card>

    <x-modal-form name="passwordResetModal" title="Password Reset Form" icon="fas fa-key" :action="route('user.profile.update', $user)" method="PATCH"
                  submit="Save" submit-class="btn-warning" submit-icon="fa-regular fa-floppy-disk" size="max-w-[800px]">
        <input type="hidden" name="_form" value="1">
        <x-form.input label="Current Password" name="current_password" type="password" autocomplete="current-password" required />
        <div class="grid grid-cols-1 gap-x-4 md:grid-cols-2">
            <x-form.input label="New Password" name="password" type="password" autocomplete="new-password" required />
            <x-form.input label="Confirm Password" name="confirm_password" type="password" required />
        </div>
    </x-modal-form>

    <x-modal-form name="uploadImageModal" title="Upload Photo" icon="fa-solid fa-image" :action="route('user.profile.update', $user)" method="PATCH"
                  submit="Upload" submit-class="btn-primary" submit-icon="fa-solid fa-upload" files>
        <input type="hidden" name="_form" value="2">
        <x-form.input label="User Photo" name="image" type="file" accept="image/*" required />
    </x-modal-form>
</x-layouts.app>
