@extends('website.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection
<style>#sort_by_orderby {
        width: auto !important;
    }</style>
@section('content-page')
    @include('website.partals.header')
    @include('website.partals.nav')

    <div class="slider">
        <img class="lazyload" data-src="{{$category_image}}" alt="" style="width: 100%;
height: 400px;">
    </div>

    <div class="category-page">

        <div class="boys-clothes">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$category_name_title}}</li>
                </ol>
            </nav>

            @include('website.shop.partals.mobile_filter')


            <div class="container">
                <div class="whole-section">
                    <div class="row">
                        <div class="col-md-3 d-none d-md-block">
                            @include('website.shop.partals.sidebar')
                        </div>
                        <div class="col-12 col-md-9">
                            <div class="products-section">
                                @include('website.shop.partals.topebar')
                                <div class="girl-products">
                                    @foreach($products  as $product)
                                        @include('website.partals.product' , ['product' => $product])
                                    @endforeach
                                </div>
                                <nav>{{$links}}</nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @include('website.partals.services')
    @include('website.partals.subscribe')
    @include('website.partals.footer')
@stop()

@section('js')
    <script src="{{url('')}}/website/general/js/shop/shop.js"></script>
    <script src="{{url('')}}/website/general/js/general.js" type="text/javascript"></script>

<script>
    var product_min_price = {!! $product_min_price !!}
    var product_max_price = {!! $product_max_price !!}
    $("#slider-range , #slider-range2").slider({
        range: true,
            isRTL: true,
        min: product_min_price,
        max: product_max_price,
        values: [product_min_price, product_max_price],
        slide: function (event, ui) {
            $("#amount , #amount1").val("$" + ui.values[0] + " - $" + ui.values[1]);
            $('#min_price').val( ui.values[0])
            $('#max_price').val( ui.values[1])
        },
    });
    $("#amount , #amount1").val(
        "$" +
        $("#slider-range , #slider-range2").slider("values", 0) +
        " - $" +
        $("#slider-range , #slider-range2").slider("values", 1)
    );
</script>

@stop()

