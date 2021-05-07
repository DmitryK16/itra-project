@extends('layouts.app')

@section('content')
    @php
        /** @var \App\Models\Company $company */
    @endphp
    <div class="card-company">
        <div class="container-fliud">
            <div class="wrapper row">
                <div class="preview col-md-6">

                    <div class="preview-pic tab-content">
                        <div class="tab-pane active" id="pic-1"><img src="http://placekitten.com/400/252"/></div>
                        <div class="tab-pane" id="pic-2"><img src="http://placekitten.com/400/252"/></div>
                        <div class="tab-pane" id="pic-3"><img src="http://placekitten.com/400/252"/></div>
                        <div class="tab-pane" id="pic-4"><img src="http://placekitten.com/400/252"/></div>
                        <div class="tab-pane" id="pic-5"><img src="http://placekitten.com/400/252"/></div>
                    </div>
                    <ul class="preview-thumbnail nav nav-tabs">
                        <li class="active"><a data-target="#pic-1" data-toggle="tab"><img
                                    src="http://placekitten.com/200/126"/></a></li>
                        <li><a data-target="#pic-2" data-toggle="tab"><img src="http://placekitten.com/200/126"/></a>
                        </li>
                        <li><a data-target="#pic-3" data-toggle="tab"><img src="http://placekitten.com/200/126"/></a>
                        </li>
                        <li><a data-target="#pic-4" data-toggle="tab"><img src="http://placekitten.com/200/126"/></a>
                        </li>
                        <li><a data-target="#pic-5" data-toggle="tab"><img src="http://placekitten.com/200/126"/></a>
                        </li>
                    </ul>
                </div>
                <div class="details col-md-6">
                    <h3 class="product-title">{{ $company->name }}</h3>
                    <p class="product-description">{{$company->small_descriptions}}</p>
                    <h4 class="price">Целевая сумма денег: <span>{{$company->required_amount}}</span></h4>
                    <h4 class="price">Собранная сумма денег: <span>{{$company->deposited_amount}}</span></h4>
                    <div class="action">
                        @if(\Illuminate\Support\Facades\Auth::check())
                            <button class="add-to-cart btn btn-default" type="button">Donate</button>
                        @else
                            <span>Для доната пожалуйста авторизуйтесь</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="owl-carousel owl-theme">
        <div class="item"><h4>1</h4></div>
        <div class="item"><h4>2</h4></div>
        <div class="item"><h4>3</h4></div>
        <div class="item"><h4>4</h4></div>
        <div class="item"><h4>5</h4></div>
        <div class="item"><h4>6</h4></div>
        <div class="item"><h4>7</h4></div>
        <div class="item"><h4>8</h4></div>
        <div class="item"><h4>9</h4></div>
        <div class="item"><h4>10</h4></div>
        <div class="item"><h4>11</h4></div>
        <div class="item"><h4>12</h4></div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="news-slider" class="owl-carousel">
                    @foreach($company->news as $news)
                        @php
                            /** @var \App\Models\News $news */
                        @endphp
                        <div class="post-slide ">
                            <div class="post-img">
                                <img src="{{ $news->img }}" />
                            </div>
                            <div class="post-review">
                                <h3 class="post-title">
                                    {{ $news->name }}
                                </h3>
                                <p class="post-description">
                                    {{ \Illuminate\Support\Str::limit($news->descriptions, 150, $end='...') }}
                                </p>
                                <div class="post-bar">
{{--                                    <span><i class="fa fa-user"></i> <a href="#">BootstrapTema</a></span>--}}

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div><!-- ./col-md-12 -->
            </div><!-- ./row -->
        </div><!-- ./container -->
    </div>
@endsection

@section('js-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#news-slider").owlCarousel({
                items:3,
                itemsDesktop:[1199,3],
                itemsDesktopSmall:[1000,2],
                itemsMobile:[650,1],
                pagination:false,
                navigationText:false,
                autoPlay:true
            });
        });
    </script>
@endsection


