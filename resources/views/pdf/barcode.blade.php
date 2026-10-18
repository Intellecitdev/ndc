@extends('pdf.layout')

@section('content')
    @php $sup = $stock->supplier; @endphp
    <table>
        <tr>
            <td style="width:60%;vertical-align:top;">
                <table>
                    @foreach ([
                        'Serial No/Code' => $stock->label(), 'Product Name' => $stock->item->name, 'Category' => $stock->item->category?->name,
                        'Coverage' => $stock->coverage_type, 'Date(From)' => $stock->coverage_start?->format('d-m-Y'), 'Date(To)' => $stock->coverage_end?->format('d-m-Y'),
                        'Supplier' => $sup?->name, 'Contact Person' => $sup?->contact_person, 'Contact No' => $sup?->contact_no,
                        'Email' => $sup?->email, 'Address' => $sup?->address,
                    ] as $k => $v)
                        <tr><td style="width:95px;font-weight:bold;padding:1px 0;">{{ $k }}</td><td style="padding:1px 0;"><b>:</b> {{ $v }}</td></tr>
                    @endforeach
                </table>
            </td>
            <td style="vertical-align:top;text-align:center;">
                <img src="{{ $stock->barcodeDataUri() }}" style="height:35px;width:190px;"><br>{{ $stock->label() }}
            </td>
        </tr>
    </table>
@endsection
