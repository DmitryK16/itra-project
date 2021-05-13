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


@section('js')
    <script>
        $("a[data-form-delete]").click(function (e) {
            e.preventDefault();

            var elementId = $(this).data('element-id');
            console.log(elementId);
            $.ajax({
                url: "/admin/news/delete/" + elementId,
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                   window.location.reload();
                },
            });
        })
    </script>
@stop
