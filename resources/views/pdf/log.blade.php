@extends('pdf.layout')

@section('content')
    <table class="grid kv">
        <tr><th>Log ID</th><td>{{ $log->id }}</td></tr>
        <tr><th>Method</th><td>{{ $log->method }}</td></tr>
        <tr><th>Subject</th><td>{{ $log->subject }}</td></tr>
        <tr><th>URL</th><td>{{ $log->url }}</td></tr>
        <tr><th>IP Address</th><td>{{ $log->ip }}</td></tr>
        <tr><th>User Agent</th><td>{{ $log->agent }}</td></tr>
        <tr><th>User Name</th><td>{{ $log->user?->name }}</td></tr>
        <tr><th>Created At</th><td>{{ $log->created_at }}</td></tr>
    </table>
    @if ($log->old_data || $log->new_data)
        <br>
        <table class="grid">
            <tr><th class="center" style="width:50%">Old Data</th><th class="center">New Data</th></tr>
            <tr>
                <td>@foreach ((array) $log->old_data as $k => $v) <b>{{ $k }}</b>: {{ is_scalar($v) ? $v : json_encode($v) }}<br> @endforeach</td>
                <td>@foreach ((array) $log->new_data as $k => $v) <b>{{ $k }}</b>: {{ is_scalar($v) ? $v : json_encode($v) }}<br> @endforeach</td>
            </tr>
        </table>
    @endif
@endsection
