@extends('layouts.wallet')

@section('content')
    <div class="container">
        <transfer-component :wallets="{{ $wallets }}" :users="{{ $users }}" :history="{{ $history }}" />
    </div>
@endsection
