<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class NotificationController extends Controller
{
    use JsonResponses;

    public function index(Request $request): View
    {
        $notifications = DatabaseNotification::with('notifiable')
            ->when($request->filled('search'), fn ($q) => $q->where('data', 'like', "%{$request->search}%"))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.messaging.notifications', [
            'notifications' => $notifications,
            'users' => User::orderBy('id')->get(['id', 'name', 'full_name']),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $this->check($request, [
            'Subject' => ['required', 'string', 'max:250'],
            'Message' => ['required', 'string', 'max:5000'],
            'subscribers' => ['required', 'array', 'min:1'],
            'subscribers.*' => ['exists:users,id'],
        ], ['subscribers' => 'Receivers']);

        Notification::send(
            User::whereIn('id', $data['subscribers'])->get(),
            new SystemNotification($data['Subject'], $data['Message'], $request->user())
        );

        return $this->ok('Notification sent successfully.');
    }

    public function destroy(string $notification): JsonResponse
    {
        DatabaseNotification::findOrFail($notification)->delete();

        return $this->ok('Notification deleted successfully.');
    }
}
