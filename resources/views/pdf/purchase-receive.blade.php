@extends('pdf.layout')

@section('content')
    @include('inventory.purchase.receives._details', ['receive' => $receive, 'pdf' => true])
@endsection
