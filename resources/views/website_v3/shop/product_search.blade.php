@extends('website_v3.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection


@section('content')



    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{asset('/')}}">الرئيسية</a></li>
                <li class="breadcrumb-item" aria-current="page"><a
                        href="{{LaravelLocalization::localizeUrl('shop')}}?category=">جميع المنتجات</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">{{$breadcrumb_last_item}}</a></li>
            </ol>
        </div>
    </div>




    <div class="store_header"
         style="background-image:@if(!$merchant->image_banar_store) url({{asset("/website_v3/images/store_back.png")}});@else url({{asset("/website_v3/images/$merchant->image_banar_store")}});@endif">
        <div class="container">
            <div class="fillter_btn">
                <img src="{{asset('/website_v3/images/pulsing_btn.svg')}}" alt="...">
            </div>
            <div class="header_inner">
                <div class="row">
                    <div class="col-md-1 col-sm-3 col-12 pl-0">
                        <div class="store_img">
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-9 col-12">
                        <div class="store_name">
                            <h2>{{$merchant->store_name}}
                                /{{$merchant->merchant_first_name}} {{$merchant->merchant_last_name}}</h2>
                            <div class="sn_eva"><i class="fas fa-star"></i>4.5</div>
                            <p>عرض نتائج البحث</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="products-tabs">
        <div class="container">

            @if(!$products_merchants)
                <div class="content_innerPage">
                    <div class="container">
                        <div class="cart_empty_block">
                            <img src="{{asset('website_v3/img/empty_noti.png')}}" alt="bag">
                            <p>عذراً، لا يوجد بحث</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab">

                    <div class="list_favorite_products">
                        <div class="row">

                            @foreach($products_merchants as $product_merchant)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="product_item">
                                        <div class="cn_product_thumb">
                                            <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product_merchant->product->id}}"
                                               class="thumb_pro img-hover">
                                                <img src='{{asset($product_merchant->product->image)}}' alt="">
                                            </a>

                                            @if($product_merchant->product->in_offer)
                                                <div
                                                    class="label_pro">{{ ($product_merchant->max_price ) - (($product_merchant->min_price /100) *100)}}
                                                    %
                                                </div>
                                            @endif

                                        </div>
                                        <div class="cn_product_txt">
                                            <h2>
                                                <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product_merchant->product->id}}">{{$product_merchant->product->name_ar}}  </a>
                                            </h2>
                                            <div class="seller_info">
                                                <img src="{{asset('/website_v3/images/seller.svg')}}" alt="...">
                                                <span class="seller_name">{{$merchant->store_name}}</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <div class="pro_evaluate">

                                                    <i class="fas fa-star checked"></i>
                                                    <p class="ev_rate">4.7</p>
                                                </div>
                                                <div class="sale_pro d-flex justify-content-between">
                                                    @isset($product_merchant->product->max_price)
                                                        <div class="sale_old"><p>
                                                                <span>{{$product_merchant->product->max_price}}</span>ر.س
                                                            </p>
                                                        </div>@endisset
                                                    @isset($product_merchant->product->min_price)
                                                        <div class="sale_new"><p>
                                                                <span>{{$product_merchant->product->min_price}}</span>ر.س
                                                            </p>
                                                        </div>@endisset
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
        </div>
    </div>

@endsection


@section('css')
@stop()

@section('js')
    <script type="text/javascript">
        // ============================================================================
        // Price range filters init
        // ============================================================================

        $(function () {
            if (!$.fn.slider) return;

            $(".price-range-selector").each(function () {
                var $price_label = $(this).siblings('.wgpf-label').find('.price-range-label');
                var cur_sign = $price_label.data('currency-sign');
                var cursign_before = $price_label.data('cursign-before');
                $(this).slider({
                    isRTL: true,
                    range: true,
                    min: $(this).data('min'),
                    max: $(this).data('max'),
                    values: [0, $(this).data('max')],
                    slide: function (event, ui) {
                        set_range_label(ui.values[0], ui.values[1]);
                    }
                });

                function set_range_label(value1, value2) {

                    if (cursign_before)

                        $price_label.html(cur_sign + value1 + " <span>" + cur_sign + value2 + "</span> ");
                }

                set_range_label($(this).data('min'), $(this).data('max'));
            });
        });
    </script>


@endsection
