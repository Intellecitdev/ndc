<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Concerns\JsonResponses;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use App\Support\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class ChatController extends Controller
{
    use JsonResponses;

    public function index(Request $request): View
    {
        return view('admin.messaging.chats', $this->conversation($request) + [
            'users' => User::orderBy('full_name')->pluck('full_name', 'id'),
        ]);
    }

    public function pdf(Request $request): Response
    {
        $data = $this->conversation($request);
        abort_unless($data['chats'], 404);

        return Pdf::stream('pdf.chats', $data, 'Chats Details', 'chats');
    }

    public function destroy(Chat $chat): JsonResponse
    {
        $chat->delete();

        return $this->ok('Message deleted successfully.', ['id' => $chat->id]);
    }

    private function conversation(Request $request): array
    {
        $sender = $request->filled('senderid') ? User::find($request->senderid) : null;
        $receiver = $request->filled('receiverid') ? User::find($request->receiverid) : null;

        return [
            'sender' => $sender,
            'receiver' => $receiver,
            'chats' => $sender && $receiver
                ? Chat::with('sender')->between($sender->id, $receiver->id)->oldest('id')->get()
                : null,
        ];
    }
}
