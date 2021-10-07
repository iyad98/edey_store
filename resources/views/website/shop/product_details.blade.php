@extends('website.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@section('content-page')
    @include('website.partals.header')
    @include('website.partals.nav')
    <div class="category-page">

    <nav aria-label="breadcrumb" class="breadcrumb-nav">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
            <li class="breadcrumb-item active" aria-current="page">تفاصيل المنتج</li>
        </ol>
    </nav>
    <!--breadcrumb end-->
    <!--product-details section start-->
    <div class="product-details-page ">
        <div class="container"  >
            <div class="row">


                <div class="col-12 col-md-9" id="product_details_vue">
                    <div class="alert alert-danger dan_alert hidden" role="alert">

                    </div>
                    <div class="alert alert-success suc_alert hidden" role="alert">
                    </div>

                    <div class="right-section">
                        @include('website.shop.partals.single_product')
                    </div>
                </div>

                @if(count($sub_products))
                <div class="col-12 col-md-3 d-none d-md-block  ">
                    <div class="advertisements">
                        <div class="title">
                            منتجات مناسبة لهذا المنتج
                        </div>
                        <div class="advertise">
                            <div class="Suitable-products text-right">

                                @foreach($sub_products  as $k => $sub_produc)

                                    <div class="suitable-item row">
                                        <div class="col-5">
                                            <img src="{{$sub_produc['image']}}" class="" height="130" width="130" >
                                        </div>
                                        <div class="col-7 pr-1">
                                            <div class="suitable-item-data">
                                                <h6>{{$sub_produc['name']}}</h6>
                                                <div class="price">
                                                    @if($sub_produc['is_discount'])
                                                        <div class="old-price">
                                                            {{$sub_produc['price']}}  {{$sub_produc['currency']}}
                                                        </div>
                                                    @endif
                                                    <div class="new-price">
                                                        {{$sub_produc['price_after']}}  {{$sub_produc['currency']}}
                                                    </div>
                                                </div>
                                                <div class="counter-cart">

                                                    <div class="add-to-cart">
                                                        <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$sub_produc['id']}}" style="color:#fff; background: #000" class="btn">
                                                            <svg class="svg-inline--fa fa-shopping-cart fa-w-18" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="shopping-cart" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg=""><path fill="currentColor" d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"></path></svg><!-- <i class="fas fa-shopping-cart"></i> -->أضف للسلة
                                                        </a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

@endif

                <div class="col-12  mt-5">
                    <div class="related-products">
                        <div class="title">
                            منتجات ذات علاقة
                        </div>
                        <div class="owl-carousel">
                            @foreach($marketing_products as $marketing_product)
                                @include('website.partals.product' , ['product' => $marketing_product])
                            @endforeach
                        </div>

                    </div>
                </div>
                <div class="col-12">

                    <div class="related-products">
                        <div class="title">
                            منتجات مرتبطة
                        </div>
                        <div class="owl-carousel">
                            @foreach($similar_products as $similar_product)
                                @include('website.partals.product' , ['product' => $similar_product])
                            @endforeach
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

    <script>
        var product = {!! $get_product !!};
        var product_categories = {!! $product_categories !!};
        var cart_product_id = {!! $cart_product_id !!};
        var sub_products = {!! $sub_products !!};

    </script>

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('.quantity').on('click', '.plus', function (e) {

                $input = $(this).parent().parent().find('input[type=number].qty');
                var val = parseInt($input.val());
                console.log($input);
                $input.val(val + 1).change();
            });
            $('.quantity').on('click', '.minus', function (e) {
                $input = $(this).parent().parent().find('input[type=number].qty');
                var val = parseInt($input.val());
                if (val > 1) {
                    $input.val(val - 1).change();
                }
            });
        });

    </script>
    <script type="text/javascript">
        jQuery('input[type=number].qty').change(function () {
            var maxx = jQuery('input[type=number].qty').attr('max');
            if (!maxx) {
                jQuery('input[type=number].qty').attr('max', 1);
            }

        });


    </script>
    <script src="{{url('')}}/website/general/js/product/product_details.js" type="text/javascript"></script>


    <script src="{{url('')}}/website/js/lightslider.min.js"></script>
    <script src="{{url('')}}/website/js/lightgallery.js"></script>

    <!-- A jQuery plugin that adds cross-browser mouse wheel support. (Optional) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>

    <!-- lightgallery plugins -->
    <script src="{{url('')}}/website/js/lg-thumbnail.min.js"></script>
    <script src="{{url('')}}/website/js/lg-fullscreen.min.js"></script>



    <script type="text/javascript">
        $(document).ready(function() {
            $('#imageGallery').lightSlider({

                gallery:true,
                item:1,
                loop:true,
                rtl:true,
                thumbItem:9,
                slideMargin:0,
                zoom:true,
                scale:1,
                enableDrag: false,
                currentPagerPosition:'left',
                onSliderLoad: function(el) {
                    el.lightGallery({
                        selector: '#imageGallery .lslide'
                    });
                }
            });
        });
    </script>

@stop()
@section('css')
    <link type="text/css" rel="stylesheet" href="{{url('')}}/website/css/lightslider.css" />
    <link type="text/css" rel="stylesheet" href="{{url('')}}/website/css/lightgallery.css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.0/css/lightgallery.min.css" />



@stop

