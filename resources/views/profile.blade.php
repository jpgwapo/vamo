@extends('layouts.wallet')

@section('content')
    <div class="container">
        <profile-component :user="{{ $user }}"/>
    </div>
@endsection
