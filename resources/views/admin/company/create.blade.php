@extends('layouts.admin')

@section('title', 'Добавление')

@section('content_header')
    <h1>Добавление</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="form-group">
            <a href="{{route('admin_companies')}}" class="btn btn-default">Список</a>
        </div>

        @include('admin.inc.message')

        {{ Form::open(['url' => route('admin_company_store'),'class'=>'form form-horizontal']) }}

        <div class="form-group">
            {{ Form::label('','Название') }}
            {{ Form::text('name', '',[
            'class' => 'form-control',
            'placeholder' =>'Название',
             'required',
            ]) }}
        </div>
        <div class="form-group">
            {{ Form::label('','Описание') }}
            {{ Form::textArea('small_descriptions', '',[
            'class' => 'form-control',
            'id' => 'small_descriptions',
            'rows' => 5,
            'placeholder' =>'описание',
             'required',
            ]) }}
        </div>
        <div class="form-group">
            {{ Form::label('','Link to video') }}
            {{ Form::text('video', '',[
            'class' => 'form-control',
            'placeholder' =>'link',
            ]) }}
        </div>
        <div class="form-group">
            {{ Form::label('','Запрашиваемая сумма') }}
            {{ Form::text('required_amount', '',[
            'class' => 'form-control',
            'placeholder' =>'сумма',
            ]) }}
        </div>
        <div class="form-group">
            {{ Form::label('','Тематика') }}
            {{ Form::select('subject_id', $subjects, 1, [
          'class' => 'form-control',
          'required',
        ]) }}

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
                CKEDITOR.replace(document.querySelector('#small_descriptions'),
                    {
                        filebrowserUploadMethod: 'form'
                    });
            </script>
@stop
