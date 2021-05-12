@if (count($errors) > 0)
    <div class="alert alert-danger text-left">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@if (session('succsess'))
    <div class="text-left">
        <div class="alert alert-success">
            {{ session('succsess') }}
        </div>
    </div>
@endif


@if (session('error'))
    <div class="text-left">
        <div class="alert alert-danger ">
            {{ session('error') }}
        </div>
    </div>
@endif

@if (session('warning'))
    <div class="text-left">
        <div class="alert alert-warning">
            {{ session('warning') }}
        </div>
    </div>
@endif
