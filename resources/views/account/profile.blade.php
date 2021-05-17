@extends('layouts.admin')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <h1>{{ $user->name }}</h1>
    <div>
        Email: {{$user->email}}
    </div>
@endsection

@section('js')
@endsection
