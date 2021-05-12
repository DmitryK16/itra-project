@extends('layouts.admin')

@section('content')

    <div class="form-group">
        <a href="{{route('admin_news_create')}}" class="btn btn-primary">Добавить</a>
    </div>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <h1>Ваши Новости</h1>

    <?= $grid ?>

@endsection
