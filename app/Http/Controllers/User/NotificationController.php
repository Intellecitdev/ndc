<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    use JsonResponses;

    public function index(Request $request): View
    {
        $notifications = $request->user()->notifications()
            ->when($request->filled('search'), fn ($q) => $q->where('data', 'like', "%{$request->search}%"))
            ->paginate(15)
            ->withQueryString();

        return view('user.notification', compact('notifications'));
    }

    public function update(Request $request, string $notification): JsonResponse
    {
        $request->user()->notifications()->findOrFail($notification)->markAsRead();

        return $this->ok('Notification marked as read.');
    }
}
