@extends('pdf.layout')

@section('content')
    @if (! empty($extra['register']))
        <p style="margin:0 0 3px;font-weight:bold;">Store Register Information:</p>
        <table class="grid" style="margin-bottom:10px;">
            <tr>@foreach ($extra['register'][0] as $c)<th>{{ $c }}</th>@endforeach</tr>
            <tr>@foreach ($extra['register'][1] as $c)<td class="center">{{ $c }}</td>@endforeach</tr>
        </table>
        <p style="margin:0 0 3px;font-weight:bold;">Store Log Records:</p>
        <table class="grid" style="margin-bottom:10px;">
            <tr>@foreach ($extra['summary'][0] as $c)<th>{{ $c }}</th>@endforeach</tr>
            <tr>@foreach ($extra['summary'][1] as $c)<td class="center">{{ $c }}</td>@endforeach</tr>
        </table>
        <p style="margin:0 0 3px;font-weight:bold;">Transaction Records:</p>
    @endif
    <table class="grid">
        <tr>@foreach ($columns as $c)<th>{{ $c }}</th>@endforeach</tr>
        @forelse ($rows as $row)
            <tr>
                @foreach ($row as $cell)
                    <td class="center" style="{{ $cell === 'In Stock' ? 'color:#198754;' : '' }}">{{ $cell }}</td>
                @endforeach
            </tr>
        @empty
        @endforelse
    </table>
@endsection
