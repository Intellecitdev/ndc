<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use JsonResponses;

    public function show(Request $request, User $user): View
    {
        // Own profile, or anyone's for those who may view Admin > Users.
        abort_unless($user->is($request->user()) || $request->user()->canMenu('admin/users'), 403);
        $user->load(['role.permissions', 'unit', 'rank']);

        return view('user.profile', compact('user'));
    }

    /**
     * _form 1 = password reset, 2 = photo upload (as in the reference).
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $this->authorizeSelf($request, $user);

        if ((int) $request->input('_form') === 2) {
            $this->check($request, ['image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048']], ['image' => 'Photo']);
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->update(['photo' => $request->file('image')->store('users', 'public')]);

            return $this->ok('Photo uploaded successfully.');
        }

        $data = $this->check($request, [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', Password::defaults(), 'different:current_password', 'same:confirm_password'],
            'confirm_password' => ['required'],
        ], ['current_password' => 'Current Password']);
        $user->update(['password' => $data['password']]);
        // Anyone still signed in with the old password (another browser or device) is signed out.
        $user->logoutOtherSessions($request->session()->getId());

        return $this->ok('Password changed successfully.');
    }

    private function authorizeSelf(Request $request, User $user): void
    {
        abort_unless($user->is($request->user()), 403);
    }
}
