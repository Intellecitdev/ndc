@php $p = 'admin/users'; @endphp
<x-layouts.app title="Users" module="admin">
    <div x-data="{ edit: {}, deleteUrl: '', resetUrl: '', logoutUrl: '' }">
        <x-card title="User List" :back="route('admin.dashboard')">
            <x-slot:actions>
                @canmenu($p, 'create')
                    <button class="btn btn-success" @click="$dispatch('open-modal', 'addModal')"><i class="fa-solid fa-plus"></i>&nbsp; Add User</button>
                @endcanmenu
            </x-slot:actions>

            <x-search-form :action="route('admin.users.index')" />

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-center [&_td]:text-center [&_th]:text-center">
                    <thead>
                    <tr>
                        <th>ID</th><th>Login</th><th>Email</th><th>Full Name</th><th>Mobile No</th><th>Role</th>
                        <th>Unit</th><th>Rank</th><th>Join Date</th><th>Last Login</th><th>Online?</th><th>Status</th><th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($users as $user)
                        @php
                            $online = in_array($user->id, $onlineIds);
                            $locked = $user->isSuperAdmin() || $user->is(auth()->user());
                        @endphp
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->mobile_no }}</td>
                            <td>{{ $user->role?->name }}</td>
                            <td>{{ $user->unit?->name }}</td>
                            <td>{{ $user->rank?->name }}</td>
                            <td>{{ $user->join_date?->format('d M Y') }}</td>
                            <td>{{ $user->last_login_at?->format('d-m-y H:i') }}</td>
                            <td>
                                @if ($online && ! $locked)
                                    <button type="button" class="btn btn-default btn-sm text-bs-success" title="OnLine"
                                            @click="logoutUrl = @js(route('admin.users.logout', $user)); $dispatch('open-modal', 'logOutModal')">
                                        <i class="fa-solid fa-user-check"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-default btn-sm {{ $online ? 'text-bs-success' : 'text-bs-danger' }}" title="{{ $online ? 'OnLine' : 'OffLine' }}">
                                        <i class="fa-solid {{ $online ? 'fa-user-check' : 'fa-user-xmark' }}"></i>
                                    </button>
                                @endif
                            </td>
                            <td>
                                @if ($locked || ! auth()->user()->canMenu($p, 'edit'))
                                    <button type="button" class="btn btn-default btn-sm {{ $user->status ? 'text-bs-success' : 'text-bs-danger' }}" title="{{ $user->status ? 'Active' : 'Inactive' }}">
                                        <i class="fa-solid {{ $user->status ? 'fa-user-shield' : 'fa-user-slash' }}"></i>
                                    </button>
                                @else
                                    <form x-data="ajaxForm" action="{{ route('admin.users.toggle', $user) }}" @submit.prevent="submit" class="inline">
                                        <button type="submit" class="btn btn-default btn-sm {{ $user->status ? 'text-bs-success' : 'text-bs-danger' }}" title="{{ $user->status ? 'Active' : 'Inactive' }}" :disabled="busy">
                                            <i class="fa-solid {{ $user->status ? 'fa-user-shield' : 'fa-user-slash' }}"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                <div class="flex justify-center gap-1">
                                    @if (! $user->isSuperAdmin() || auth()->user()->isSuperAdmin())
                                        @canmenu($p, 'edit')
                                            <button title="Reset Password" class="btn btn-sm btn-warning"
                                                    @click="resetUrl = @js(route('admin.users.password', $user)); $dispatch('open-modal', 'resetPassModal')"><i class="fa-solid fa-key"></i></button>
                                        @endcanmenu
                                    @endif
                                    <a href="{{ route('admin.users.show', $user) }}" title="View" class="btn btn-sm btn-info"><i class="fa-regular fa-eye"></i></a>
                                    @unless ($locked)
                                        @canmenu($p, 'edit')
                                            <button title="Edit" class="btn btn-sm btn-warning"
                                                    @click="edit = @js(['url' => route('admin.users.update', $user), 'roleid' => (string) $user->role_id, 'name' => $user->name, 'email' => $user->email, 'MobileNo' => $user->mobile_no, 'fullName' => $user->full_name, 'unitID' => (string) $user->unit_id, 'rankID' => (string) $user->rank_id, 'Address' => $user->address]); $dispatch('open-modal', 'editModal')">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                        @endcanmenu
                                        @canmenu($p, 'delete')
                                            <button title="Delete" class="btn btn-sm btn-danger"
                                                    @click="deleteUrl = @js(route('admin.users.destroy', $user)); $dispatch('open-modal', 'deleteModal')"><i class="fa-solid fa-trash"></i></button>
                                        @endcanmenu
                                    @endunless
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
            <x-slot:footer>
                {{ $users->links() }}
            </x-slot:footer>
            <x-slot:after>
                <div class="card-header"><h3 class="card-title text-bs-success">Total Online User: {{ count($onlineIds) }}</h3></div>
            </x-slot:after>
        </x-card>

        @php
            $roleOptions = $roles->pluck('name', 'id');
            $unitOptions = $units->pluck('name', 'id');
            $rankOptions = $ranks->pluck('name', 'id');
        @endphp

        {{-- Add --}}
        <x-modal-form name="addModal" title="Add New User" :action="route('admin.users.store')" size="max-w-[800px]">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-[5px]">
                    <x-form.select label="Role" name="roleid" :options="$roleOptions" placeholder="Select One" required />
                    <x-form.input label="Login Name" name="name" maxlength="50" required />
                    <x-form.input label="Email Address" name="email" type="email" required />
                    <x-form.input label="Mobile No" name="MobileNo" pattern="(01)[0-9]{9}" minlength="11" maxlength="11" required />
                    <x-form.input label="User Full Name" name="fullName" maxlength="150" required />
                </div>
                <div class="p-[5px]">
                    <x-form.select label="Unit" name="unitID" :options="$unitOptions" required />
                    <x-form.select label="Rank" name="rankID" :options="$rankOptions" placeholder="Select One" required />
                    <x-form.input label="Address" name="Address" maxlength="250" />
                    <x-form.input label="Password" name="password" type="password" required />
                    <x-form.input label="Confirm Password" name="confirm_password" type="password" required />
                </div>
            </div>
        </x-modal-form>

        {{-- Edit --}}
        <x-modal-form name="editModal" title="Edit User" icon="fa-solid fa-pen-to-square" bind-action="edit.url" method="PUT"
                      submit="Update" submit-class="btn-warning" submit-icon="fa-regular fa-floppy-disk" size="max-w-[800px]">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-[5px]">
                    <x-form.select label="Role" name="roleid" :options="$roleOptions" placeholder="Select One" x-model="edit.roleid" required />
                    <x-form.input label="Login Name" name="name" maxlength="50" x-model="edit.name" required />
                    <x-form.input label="Email Address" name="email" type="email" x-model="edit.email" required />
                    <x-form.input label="Mobile No" name="MobileNo" pattern="(01)[0-9]{9}" minlength="11" maxlength="11" x-model="edit.MobileNo" required />
                </div>
                <div class="p-[5px]">
                    <x-form.input label="User Full Name" name="fullName" maxlength="150" x-model="edit.fullName" required />
                    <x-form.select label="Unit" name="unitID" :options="$unitOptions" x-model="edit.unitID" required />
                    <x-form.select label="Rank" name="rankID" :options="$rankOptions" placeholder="Select One" x-model="edit.rankID" required />
                    <x-form.input label="Address" name="Address" type="textarea" maxlength="250" x-model="edit.Address" />
                </div>
            </div>
        </x-modal-form>

        {{-- Reset password --}}
        <x-modal-form name="resetPassModal" title="Password Reset Form" icon="fa-solid fa-key" bind-action="resetUrl" method="PATCH"
                      submit="Reset" submit-class="btn-warning" submit-icon="fa-regular fa-floppy-disk">
            <x-form.input label="Password" name="password" type="password" required />
            <x-form.input label="Confirm Password" name="confirm_password" type="password" required />
        </x-modal-form>

        <x-confirm-modal name="logOutModal" bind-action="logoutUrl" message="Are you sure you want to Log Out this user?"
                         submit="Log Out" submit-icon="fa-solid fa-right-from-bracket" />

        <x-delete-modal entity="user" />
    </div>
</x-layouts.app>
