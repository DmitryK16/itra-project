@extends('layouts.app')

@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <h1>Ваши компании</h1>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Descriptions</th>
            <th scope="col">Amount</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>

        @foreach($companies as $company)
            @php
                /** @var \App\Models\Company $company */
            @endphp
            <tr>
                <th scope="row">{{ $company->id }}</th>
                <td>{{ $company->name }}</td>
                <td>{{ $company->small_descriptions }}</td>
                <td>{{ $company->amount }}</td>
                <td>Edit / Delete</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection
