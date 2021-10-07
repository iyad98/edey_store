@extends('website_v3.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection


@section('content')



    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{asset('/')}}">الرئيسية</a></li>
                <li class="breadcrumb-item" aria-current="page"><a
                        href="{{LaravelLocalization::localizeUrl('shop')}}?category=">تفاصيل المنتج</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">{{$breadcrumb_last_item}}</a></li>
            </ol>
        </div>
    </div>

    <div class="-filter">
        <div class="filter_menu">

            <div class="">
                <div class="filter_head">
                    <img src="img/filterh.svg" alt="">
                    <span>فلترة</span>
                </div>
                <div class="main_category banner_hm_sm wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.1s">
                    <ul>


                        @foreach($categories_merchants as $categories_merchant)
                            <li><a href="category.html">
                                    <div class="cat_item">
                                        <div class="cat_item_img">
                                            <img src="{{asset($categories_merchant->image)}}" alt="..">
                                            <h4>{{$categories_merchant->name_ar}}</h4>
                                        </div>
                                        <div class="cat_count">
                                            500
                                        </div>
                                    </div>
                                </a>
                            </li>

                        @endforeach

                    </ul>
                </div>

                <form id="form_left_filter">
                    @csrf

                    <div class="box_side_cate">
                        <div class="box_s_head">
                            <h3>الأسعار (د.ك)</h3>
                        </div>
                        <div class="box_s_body">
                            <div class="filter_range">
                                <p>من - إلى</p>
                            </div>
                            <div class="wg-body">
                                <div class="price-range-selector needsclick" data-min="0" data-max="800"></div>
                                <div class="wgpf-label">
                                    <p class="price-range-label" data-currency-sign="د.ك"
                                       data-cursign-before="true"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @foreach($attributeTypes as $attributeType)

                        @if($attributeType->name_en == "color")
                            @foreach($attributeType->attribute as $clore)
                                <div class="box_side_cate">
                                    <div class="box_s_head">
                                        <h3>الألوان</h3>
                                    </div>
                                    <div class="box_s_body">
                                        <div class="color_cate_list">
                                            <div class="owl-carousel" id="color_cate_slider">
                                                @foreach($clore->attribute_values as $data)
                                                    <div class="item">
                                                        <div class="itm_color">
                                                            <input type="radio" class="radio_sty" name="color_filter"
                                                                   id="color_filter"
                                                                   value="{{$data->value}}" checked>
                                                            <div class="color_btn"
                                                                 style="background-color: {{$data->value}};"></div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @elseif($attributeType->name_en == "image")
                            <div class="box_side_cate">
                                <div class="box_s_head">
                                    <h3>النقوش</h3>
                                </div>
                                <div class="inscriptions_list">
                                    @foreach($attributeType->attribute as $image)
                                        @foreach($image->attribute_values as $data)

                                            <div class="inscriptions_itm">

                                                <input type="radio" class="radio_sty" name="image_filter"
                                                       id="image_filter"
                                                       value="{{$data->value}}">
                                                <div class="inscription_label">
                                                    <img src='{{getImage('' , true , $data->value)}}' alt="">
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                            <button id="btn_filter" class="btn" style="background-color: #a9a4d1;width: 100%">بحث
                            </button>
                        @endif
                    @endforeach


                </form>
            </div>
        </div>
        <div class="m-overlay"></div>
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
                            <img
                                @if(!$merchant->logo_store) src='{{asset("/website_v3/images/store_img.svg")}}'
                                @else src='{{asset("$merchant->logo_store")}}'
                                @endif alt="store_img">
                            <span>2000 المبيعات</span>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-9 col-12">
                        <div class="store_name">
                            <h2>{{$merchant->store_name}}
                                /{{$merchant->merchant_first_name}} {{$merchant->merchant_last_name}}</h2>
                            <div class="sn_eva"><i class="fas fa-star"></i>4.5</div>
                            <p>{{$merchant->about_us_merchants}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="products-tabs">
        <div class="container">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link"
                       id="nav-new-tab" href='{{url("merchant/$merchant->id")}}'>الكل</a>

                    @foreach($categories_merchants as $categories_merchant)
                        @if($categories_merchant)
                            <a class="nav-item nav-link @if($category_name == $categories_merchant->name_ar) active @endif"
                               id="nav-new-tab"
                               href='{{url("merchant/$merchant->id/$categories_merchant->id")}}'>{{$categories_merchant->name_ar}}</a>

                        @endif
                    @endforeach
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab">
                    <div class="block_search_filter">
                        <div class="row">
                            <div class="col-md-4">
                                <form class="form_search_order" method="post" action="{{route('merchant.search.product',$merchant->id)}}">
                                    @csrf
                                    <input type="text" name="name" class="form-control" placeholder="ابحث عن المنتج">
                                    <span class="search_icon"><i class="far fa-search"></i></span>
                                    <button type="submit" class="btn btn_search">بحث</button>
                                </form>
                            </div>
                            <div class="col-md-8">
                                <div class="filter_serch">
                                    <ul>
                                        <li>
                                            <div class="single_serch">
                                                $100 - $1000
                                                <button class="btn_remove"><i class="fal fa-times"></i></button>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="single_serch">
                                                LEATHER
                                                <button class="btn_remove"><i class="fal fa-times"></i></button>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list_favorite_products">
                        <div class="row">

                            @foreach($products_merchants as $product_merchant)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                                    <div class="product_item">
                                        <div class="cn_product_thumb">
                                            <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product_merchant->product->id}}" class="thumb_pro img-hover">
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
                        <ul class="pagination clearfix">
                            <li class="page-item"><a class="page-link active" href="#">
                                    <div>01</div>
                                </a></li>
                            <li class="page-item"><a class="page-link" href="#">
                                    <div>02</div>
                                </a></li>
                            <li class="page-item"><a class="page-link" href="#">
                                    <div>03</div>
                                </a></li>
                            <li class="page-item"><a class="page-link" href="#">
                                    <div>04</div>
                                </a></li>
                            <li class="page-item"><a class="page-link" href="#">
                                    <div>05</div>
                                </a></li>
                            <li class="page-item"><a class="page-link" href="#">
                                    <div>06</div>
                                </a></li>
                            <li class="page-item"><a class="page-link" href="#">
                                    <div>07</div>
                                </a></li>
                        </ul>
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
