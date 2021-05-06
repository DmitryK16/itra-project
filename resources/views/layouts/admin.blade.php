@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <title>{{ config('app.name', 'Laravel') }}</title>
@stop

@section('content')
    @yield('content')
@stop

@section('css')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@stop

@section('js')
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
@stop
