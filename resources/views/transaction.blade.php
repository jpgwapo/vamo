@extends('layouts.wallet')

@section('content')
    <div class="container">
        <transaction-component :transactions="{{ $transactions }}" :amount="{{ $amount }}"/>
    </div>
@endsection
