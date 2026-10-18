@extends('pdf.layout')

@section('content')
    <p>Between <b>{{ $sender->full_name }}</b> and <b>{{ $receiver->full_name }}</b></p>
    <table class="grid">
        <tr><th style="width:19%">From</th><th style="width:7%" class="center">Priority</th><th>Message</th><th style="width:20%">Created At</th><th style="width:12%">Seen At</th></tr>
        @foreach ($chats as $chat)
            <tr>
                <td>{{ $chat->sender?->full_name }}</td>
                <td class="center">{{ $chat->priority }}</td>
                <td>{{ $chat->message }}</td>
                <td>{{ $chat->created_at }}</td>
                <td>{{ $chat->read_at ?? '--' }}</td>
            </tr>
        @endforeach
    </table>
@endsection
