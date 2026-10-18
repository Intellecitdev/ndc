<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ChatController extends Controller
{
    use JsonResponses;

    /** Messages shown before "Full Chat" is clicked. */
    private const RECENT = 15;

    public function index(Request $request): View
    {
        return view('user.chat', ['contacts' => $this->contacts($request), 'partner' => null, 'chats' => collect()]);
    }

    public function show(Request $request, User $user): View|JsonResponse
    {
        $me = $request->user();
        abort_if($user->is($me), 404);

        // Opening a conversation marks the partner's messages as read.
        Chat::where('sender_id', $user->id)->where('receiver_id', $me->id)->whereNull('read_at')->update(['read_at' => now()]);

        $query = Chat::between($me->id, $user->id)->latest('id');
        $chats = ($request->boolean('fullchat') ? $query->get() : $query->limit(self::RECENT)->get())->reverse()->values();

        if ($request->boolean('partial')) {
            return response()->json(['html' => view('user._chat_rows', ['chats' => $chats, 'me' => $me])->render()]);
        }

        return view('user.chat', ['contacts' => $this->contacts($request), 'partner' => $user, 'chats' => $chats]);
    }

    public function store(Request $request, User $user): JsonResponse
    {
        abort_if($user->is($request->user()), 422);
        $data = $this->check($request, [
            'priority' => ['required', Rule::in(array_keys(Chat::PRIORITIES))],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        Chat::create($data + ['sender_id' => $request->user()->id, 'receiver_id' => $user->id]);

        return $this->ok('Message sent.', ['redirect' => route('user.chat.show', $user)]);
    }

    private function contacts(Request $request)
    {
        $me = $request->user();
        $unread = Chat::where('receiver_id', $me->id)->whereNull('read_at')->selectRaw('sender_id, count(*) c')->groupBy('sender_id')->pluck('c', 'sender_id');

        return User::where('id', '!=', $me->id)
            ->where('status', true)
            ->when($request->filled('search'), fn ($q) => $q->where('full_name', 'like', "%{$request->search}%"))
            ->orderByDesc('id')
            ->get(['id', 'full_name'])
            ->each(fn ($u) => $u->unread = $unread[$u->id] ?? 0);
    }
}
