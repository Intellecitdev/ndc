{{-- Shared by the receive details page and its PDF. --}}
@php
    $pdf ??= false;
    $order = $receive->purchaseOrder;
    $left = [
        'Invoice No' => $receive->invoice_no, 'Invoice Date' => $receive->date->format('d M Y'), 'Unit Name' => $receive->unit?->name,
        'Supplier Name' => $receive->supplier?->name, 'Received Qty' => $receive->received_qty,
    ];
    $right = [
        'PO No' => $order?->po_no, 'PO Date' => $order?->date->format('d M Y'), 'Financial Year' => $receive->financialYear?->name,
        'Received By' => $receive->creator ? $receive->creator->full_name.($pdf ? '' : ' ('.$receive->creator->name.')') : '',
        'Received At' => $receive->created_at->format('d M Y, h:i A'),
    ];
@endphp
@if ($pdf)
<table style="width:100%;margin-bottom:10px;{{ $pdf ? 'border-bottom:1px solid #000;padding-bottom:6px;' : '' }}" class="mb-3 w-full">
    <tr>
        @foreach ([$left, $right] as $col)
            <td style="width:{{ $loop->first ? '62%' : '38%' }};vertical-align:top;" class="align-top">
                <table>
                    @foreach ($col as $k => $v)
                        <tr><td style="padding:1px 6px 1px 0;white-space:nowrap;" class="pr-2 whitespace-nowrap">{{ $k }}</td><td style="padding:1px 0;">: {{ $v }}</td></tr>
                    @endforeach
                </table>
            </td>
        @endforeach
    </tr>
</table>
@else
    <x-info-columns :columns="[$left, $right]" />
@endif
<table class="{{ $pdf ? 'grid' : 'table table-bordered table-striped [&_td]:text-center [&_th]:text-center' }}">
    <thead><tr><th>Sl.</th><th>Item Code</th><th>Item Name</th><th>Category</th><th>Description</th><th>Quantity</th><th>Serial No</th></tr></thead>
    <tbody>
    @foreach ($receive->stocks->whereNull('parent_id') as $s)
        <tr>
            <td class="center">{{ $loop->iteration }}</td>
            <td class="center">{{ $s->item->code }}</td>
            <td class="center">{{ $s->item->name }}</td>
            <td class="center">{{ $s->item->category?->name }}</td>
            <td class="center">{{ $s->item->brand?->name }}, {{ $s->item->productModel?->name }},</td>
            <td class="center">{{ $s->purchaseReceiveItem?->quantity && ! $s->serial_no ? $s->purchaseReceiveItem->quantity : 1 }}</td>
            <td class="center">{{ $s->serial_no }}</td>
        </tr>
        @if ($s->coverage_type)
            <tr>
                <td colspan="7" style="text-align:right;" class="!text-right">
                    <b>Type:</b> {{ $s->coverage_type }} | <b>Start Date:</b> {{ $s->coverage_start?->format('d M Y') }} | <b>End Date:</b> {{ $s->coverage_end?->format('d M Y') }} | <b>Duration:</b> {{ $s->duration }} {{ $s->duration_type }}
                </td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
