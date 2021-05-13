@extends('layouts.app')

@section('content')
    <div class="container-fluid my-container">
        <div class="row">

            @foreach($companies as $company)
                @php
                    /** @var \App\Models\Company $company */
                @endphp
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $company->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $company->amount }}</h6>
                            <p class="card-text">{{ $company->small_descriptions }}</p>
                            <a href="{{ route('view_company', (int)$company->id) }}" class="card-link">View</a>
                        </div>
                    </div>
                </div>
            @endforeach
                <div class="d-flex news-pagination">
                    {!! $companies->links() !!}
                </div>
        </div>
    </div>
@endsection
