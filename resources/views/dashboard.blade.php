@extends('layouts.wallet')

@section('content')
    <div class="container">
        <dashboard-component :received="{{ $received }}" :sent="{{ $sent }}" :transactions="{{ $transactions }}"/>
    </div>
@endsection
