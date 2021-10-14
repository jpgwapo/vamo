@extends('layouts.wallet')

@section('content')
    <div class="container">
        <wallet-component :transactions="{{ $transactions }}" :amount="{{ $amount }}" :wallet="{{ $wallet }}"/>
    </div>
@endsection
