@extends('pdf.layout')

@section('content')
    @php $c = $voucher->creator; @endphp
    <table style="margin-bottom:10px;border-bottom:1px solid #000;">
        <tr>
            <td style="width:62%;vertical-align:top;padding-bottom:8px;">
                <table>
                    <tr><td style="width:80px;">Invoice No</td><td>: {{ $voucher->iv_no }}</td></tr>
                    <tr><td>Invoice Date</td><td>: {{ $voucher->date->format('d M Y') }}</td></tr>
                    <tr><td>From (WH)</td><td>: {{ $voucher->fromUnit?->name }}</td></tr>
                    <tr><td>Address</td><td>: {{ $voucher->fromUnit?->address }}</td></tr>
                </table>
            </td>
            <td style="vertical-align:top;padding-bottom:8px;">
                <table>
                    <tr><td colspan="2"><u>Created By:</u></td></tr>
                    <tr><td style="width:70px;">Rank</td><td>: {{ $c?->rank?->name }}</td></tr>
                    <tr><td>Name</td><td>: {{ $c?->full_name }}</td></tr>
                    <tr><td>Mobile No</td><td>: {{ $c?->mobile_no }}</td></tr>
                    <tr><td>Created At</td><td>: {{ $voucher->created_at->format('d M Y, h:i A') }}</td></tr>
                </table>
            </td>
        </tr>
    </table>
    <table class="grid">
        <tr><th>Sl.</th><th>Serial No</th><th>Item Name</th><th>Category</th><th>Quantity</th><th>To (WH)</th><th>Status</th></tr>
        @foreach ($voucher->items as $line)
            <tr>
                <td class="center">{{ $loop->iteration }}</td>
                <td class="center">{{ $line->stock->label() }}</td>
                <td class="center">{{ $line->stock->item->name }}</td>
                <td class="center">{{ $line->stock->item->category?->name }}</td>
                <td class="center">{{ $line->quantity }} {{ $line->stock->item->unit?->name }}</td>
                <td class="center">{{ $line->toUnit?->name }}</td>
                <td class="center">{{ $line->status }}</td>
            </tr>
        @endforeach
    </table>
    <div style="position: fixed; bottom: -55px; left: 60%; font-size: 10px; border-top: 1px solid #000; padding-top: 2px; width: 120px;">
        <b>Received By</b><br>Rank:<br>Name:<br>Mobile No:
    </div>
@endsection
