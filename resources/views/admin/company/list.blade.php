@extends('layouts.admin')

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <h1>Ваши кампании</h1>

    <?= $grid ?>

@endsection
