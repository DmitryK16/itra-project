@extends('layouts.admin')

@section('title', 'Добавление')

@section('content_header')
    <h1>Добавление Новости</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="form-group">
            <a href="{{route('admin_news')}}" class="btn btn-default">Список</a>
        </div>

        @include('admin.inc.message')

        {{ Form::open(['url' => route('admin_news_store'),'class'=>'form form-horizontal', 'files'=>'true']) }}


        <div class="form-group">
            {{ Form::label('','Компания') }}
            {{ Form::select('company_id', $companiesMapped, 1, [
          'class' => 'form-control',
          'required',
        ]) }}

            <div class="form-group">
                {{ Form::label('','Название') }}
                {{ Form::text('name', '',[
                'class' => 'form-control',
                'placeholder' =>'Название',
                 'required',
                ]) }}
            </div>
            <div class="form-group">
                {{ Form::label('','Картинка') }}<br>
                {{ Form::file('img', [
                     'required',
                ]) }}
            </div>

            <div class="form-group">
                {{ Form::label('','Полное описание') }}
                {{ Form::textArea('descriptions', '',[
                'class' => 'form-control',
                'id' => 'descriptions',
                'rows' => 5,
                'placeholder' =>'Полное описание',
                 'required',
                ]) }}
            </div>

            <div class="form-group">
                {{ Form::submit('Сохранить', [
              'class' => 'btn btn-primary',
              ]) }}
            </div>

            {{ Form::close() }}

        </div>
        @stop

        @section('js')
            <script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
            <script>
                CKEDITOR.replace(document.querySelector('#descriptions'),
                    {
                        filebrowserUploadMethod: 'form'
                    });
            </script>

@stop
