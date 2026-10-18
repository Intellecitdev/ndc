@extends('pdf.layout')

@section('content')
    @include('inventory.purchase.orders._details', ['order' => $order, 'pdf' => true])
@endsection
