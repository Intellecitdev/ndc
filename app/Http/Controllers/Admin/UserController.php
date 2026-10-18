<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\Rank;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    use JsonResponses;

    public function index(Request $request): View
    {
        $users = User::with(['role', 'unit', 'rank'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $s = $request->search;
                $q->where(fn ($q) => $q->where('name', 'like', "%$s%")
                    ->orWhere('email', 'like', "%$s%")
                    ->orWhere('full_name', 'like', "%$s%")
                    ->orWhere('mobile_no', 'like', "%$s%"));
            })
            ->orderBy('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'onlineIds' => User::onlineIds(),
            'roles' => Role::where('slug', '!=', 'superadmin')->orderBy('id')->get(),
            'units' => $this->unitOptions($request->user()),
            'ranks' => Rank::where('status', true)->orderBy('order')->get(),
        ]);
    }

    public function show(User $user): View
    {
        $user->load(['role.permissions', 'unit', 'rank']);

        return view('admin.users.show', compact('user'));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->check($request, $this->rules($request) + [
            'password' => ['required', 'string', Password::defaults(), 'same:confirm_password'],
            'confirm_password' => ['required'],
        ], $this->attributes());

        $user = User::create($this->payload($data) + ['password' => $data['password'], 'join_date' => now()]);

        return $this->ok('User created successfully.', ['id' => $user->id]);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $this->guardEditable($request, $user);
        $data = $this->check($request, $this->rules($request, $user), $this->attributes());
        $user->update($this->payload($data));

        return $this->ok('User updated successfully.');
    }

    public function destroy(Request $request, User $user): JsonResponse
    {
        $this->guardEditable($request, $user);
        $user->delete();

        return $this->ok('User deleted successfully.', ['id' => $user->id]);
    }

    public function resetPassword(Request $request, User $user): JsonResponse
    {
        // Nobody may take over an account whose role has more rights than their own (Super Admin included).
        abort_unless($request->user()->canGrantRole($user->role), 403);
        $data = $this->check($request, [
            'password' => ['required', 'string', Password::defaults(), 'same:confirm_password'],
            'confirm_password' => ['required'],
        ]);
        $user->update(['password' => $data['password']]);
        // A reset password ends every open session of that account (except the admin's own, if it is theirs).
        $user->is($request->user()) ? $user->logoutOtherSessions($request->session()->getId()) : $user->logoutEverywhere();

        return $this->ok('Password reset successfully.');
    }

    public function toggleActivating(Request $request, User $user): JsonResponse
    {
        $this->guardEditable($request, $user);
        $user->update(['status' => ! $user->status]);
        if (! $user->status) {
            $user->logoutEverywhere();
        }

        return $this->ok($user->status ? 'User activated successfully.' : 'User deactivated successfully.', ['status' => $user->status]);
    }

    public function logout(Request $request, User $user): JsonResponse
    {
        $this->guardEditable($request, $user);
        $user->logoutEverywhere();

        return $this->ok('User logged out successfully.');
    }

    /**
     * Super Admin and one's own account can't be edited from this list (as in the reference),
     * nor can accounts whose role has more rights than the editor's.
     */
    private function guardEditable(Request $request, User $user): void
    {
        abort_if($user->isSuperAdmin() || $user->is($request->user()), 403);
        abort_unless($request->user()->canGrantRole($user->role), 403);
    }

    private function unitOptions(User $user)
    {
        return Unit::where('status', true)
            ->when(! $user->isSuperAdmin(), fn ($q) => $q->where('id', $user->unit_id))
            ->orderBy('order')
            ->get();
    }

    private function rules(Request $request, ?User $user = null): array
    {
        $actor = $request->user();

        return [
            'roleid' => ['required', Rule::exists('roles', 'id')->where(fn ($q) => $q->where('slug', '!=', 'superadmin')),
                function ($attribute, $value, $fail) use ($actor) {
                    if (! $actor->canGrantRole(Role::with('permissions')->find($value))) {
                        $fail('You can not assign a role that has more permissions than your own.');
                    }
                }],
            'name' => ['required', 'string', 'max:50', Rule::unique('users', 'name')->ignore($user)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'MobileNo' => ['required', 'regex:/^01[0-9]{9}$/'],
            'fullName' => ['required', 'string', 'max:150'],
            'unitID' => ['required', 'exists:units,id',
                // Only Super Admin places users in other wings (the form only offers one's own wing).
                function ($attribute, $value, $fail) use ($actor, $user) {
                    if (! $actor->isSuperAdmin() && (int) $value !== (int) $actor->unit_id && (int) $value !== (int) $user?->unit_id) {
                        $fail('You can only add users to your own wing.');
                    }
                }],
            'rankID' => ['required', 'exists:ranks,id'],
            'Address' => ['nullable', 'string', 'max:250'],
        ];
    }

    private function attributes(): array
    {
        return [
            'roleid' => 'Role', 'name' => 'Login Name', 'email' => 'Email Address', 'MobileNo' => 'Mobile No',
            'fullName' => 'User Full Name', 'unitID' => 'Unit', 'rankID' => 'Rank', 'Address' => 'Address',
        ];
    }

    private function payload(array $data): array
    {
        return [
            'role_id' => $data['roleid'],
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_no' => $data['MobileNo'],
            'full_name' => $data['fullName'],
            'unit_id' => $data['unitID'],
            'rank_id' => $data['rankID'],
            'address' => $data['Address'] ?? null,
        ];
    }
}
