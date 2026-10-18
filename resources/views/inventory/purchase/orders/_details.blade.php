{{-- Shared by the details page and the PDF ($pdf = true uses plain table styling). --}}
@php
    $pdf ??= false;
    $left = [
        'PO No' => $order->po_no, 'PO Date' => $order->date->format('d M Y'), 'Supplier Name' => $order->supplier?->name,
        'Contact No' => $order->supplier?->contact_no, 'Contact Person' => $order->supplier?->contact_person, 'Address' => $order->supplier?->address,
    ];
    $right = [
        'Financial Year' => $order->financialYear?->name, 'Order Ref. No' => $order->reference_no, 'Purchase Unit' => $order->unit?->name,
        'Created By' => $order->creator ? $order->creator->full_name.($pdf ? '' : ' ('.$order->creator->name.')') : '',
        'Created At' => $order->created_at->format('d M Y, h:i A'), 'Comments' => $order->comments,
    ];
@endphp
@if ($pdf)
<table class="{{ $pdf ? 'info' : 'mb-3 w-full' }}" style="{{ $pdf ? 'width:100%;margin-bottom:10px;border-bottom:1px solid #000;padding-bottom:6px;' : '' }}">
    <tr>
        @foreach ([$left, $right] as $col)
            <td class="align-top" style="width:{{ $loop->first ? '62%' : '38%' }};vertical-align:top;">
                <table>
                    @foreach ($col as $k => $v)
                        <tr><td class="pr-2 whitespace-nowrap" style="padding:1px 6px 1px 0;white-space:nowrap;">{{ $k }}</td><td style="padding:1px 0;">: {{ $v }}</td></tr>
                    @endforeach
                </table>
            </td>
        @endforeach
    </tr>
</table>
@else
    <x-info-columns :columns="[$left, $right]" />
@endif
@if (! $pdf && $order->attachment)
    <p class="mb-2"><a href="{{ route('attachments.purchaseorder', $order) }}" target="_blank"><i class="fa-solid fa-paperclip"></i> Scan Copy</a></p>
@endif
<table class="{{ $pdf ? 'grid' : 'table table-bordered table-striped [&_td]:text-center [&_th]:text-center' }}">
    <thead><tr><th>Sl.</th><th>Item Code</th><th>Item Name</th><th>Category</th><th>Description</th><th>Order Qty</th><th>Unit</th></tr></thead>
    <tbody>
    @foreach ($order->items as $line)
        <tr>
            <td class="center">{{ $loop->iteration }}</td>
            <td class="center">{{ $line->item->code }}</td>
            <td class="center">{{ $line->item->name }}</td>
            <td class="center">{{ $line->item->category?->name }}</td>
            <td class="center">{{ $line->item->brand?->name }}, {{ $line->item->productModel?->name }},</td>
            <td class="center">{{ $line->order_qty }}</td>
            <td class="center">{{ $line->item->unit?->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
