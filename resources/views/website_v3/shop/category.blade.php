@extends('website_v3.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@section('content')

    <div class="-filter">
        <div class="filter_menu">

            <div class="">
                <div class="filter_head">
                    <img src="{{asset('website_v3/img/filterh.svg')}}" alt="">
                    <span>فلترة</span>
                </div>
                <div class="main_category banner_hm_sm wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.1s">
                    <ul>
                        <li><a href="category.html">
                                <div class="cat_item">
                                    <div class="cat_item_img">
                                        <img src="{{asset('website_v3/img/cat1.svg')}}" alt="..">
                                        <h4>أكواب</h4>
                                    </div>
                                    <div class="cat_count">
                                        500
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><a href="category.html">
                                <div class="cat_item">
                                    <div class="cat_item_img">
                                        <img src="{{asset('website_v3/img/cat2.svg')}}" alt="..">
                                        <h4>اكسسوارات</h4>
                                    </div>
                                    <div class="cat_count">
                                        500
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><a href="category.html">
                                <div class="cat_item">
                                    <div class="cat_item_img">
                                        <img src="{{asset('website_v3/img/cat3.svg')}}" alt="..">
                                        <h4>فخاريات</h4>
                                    </div>
                                    <div class="cat_count">
                                        500
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><a href="category.html">
                                <div class="cat_item">
                                    <div class="cat_item_img">
                                        <img src="{{asset('website_v3/img/cat4.svg')}}" alt="..">
                                        <h4>مباخر</h4>
                                    </div>
                                    <div class="cat_count">
                                        500
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><a href="category.html">
                                <div class="cat_item">
                                    <div class="cat_item_img">
                                        <img src="{{asset('website_v3/img/cat5.svg')}}" alt="..">
                                        <h4>أعمال فنية</h4>
                                    </div>
                                    <div class="cat_count">
                                        500
                                    </div>
                                </div>
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="box_side_cate">
                    <div class="box_s_head">
                        <h3>الأسعار (د.ك)</h3>
                    </div>
                    <div class="box_s_body">
                        <div class="filter_range">
                            <p>من - إلى</p>
                        </div>
                        <div class="wg-body">
                            <div class="price-range-selector needsclick" data-min="0" data-max="500"></div>
                            <div class="wgpf-label">
                                <p class="price-range-label" data-currency-sign="د.ك" data-cursign-before="true"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box_side_cate">
                    <div class="box_s_head">
                        <h3>الألوان</h3>
                    </div>
                    <div class="box_s_body">
                        <div class="color_cate_list">
                            <div class="owl-carousel" id="color_cate_slider">
                                <div class="item">
                                    <div class="itm_color">
                                        <input type="radio" class="radio_sty" name="color" checked>
                                        <div class="color_btn" style="background-color: #006CFF;"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="itm_color">
                                        <input type="radio" class="radio_sty" name="color">
                                        <div class="color_btn" style="background-color: #FC3E39;"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="itm_color">
                                        <input type="radio" class="radio_sty" name="color">
                                        <div class="color_btn" style="background-color: #171717;"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="itm_color">
                                        <input type="radio" class="radio_sty" name="color">
                                        <div class="color_btn" style="background-color: #FFF600;"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="itm_color">
                                        <input type="radio" class="radio_sty" name="color">
                                        <div class="color_btn" style="background-color: #FF00B4;"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="itm_color">
                                        <input type="radio" class="radio_sty" name="color">
                                        <div class="color_btn" style="background-color: #EFDFDF;"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="itm_color">
                                        <input type="radio" class="radio_sty" name="color">
                                        <div class="color_btn" style="background-color: #FF00B4;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box_side_cate">
                    <div class="box_s_head">
                        <h3>المتاجر</h3>
                    </div>
                    <div class="box_s_body">
                        <div class="markat_list">
                            <div class="marka_itm">
                                <input type="radio" class="radio_sty" name="marka">
                                <div class="marka_label">
                                    <p>PACK</p>
                                    <span>99</span>
                                </div>
                            </div>
                            <div class="marka_itm">
                                <input type="radio" class="radio_sty" name="marka" checked>
                                <div class="marka_label">
                                    <p>Z VERSATILE PRO ORANGE</p>
                                    <span>99</span>
                                </div>
                            </div>
                            <div class="marka_itm">
                                <input type="radio" class="radio_sty" name="marka">
                                <div class="marka_label">
                                    <p>Victoria Arduino</p>
                                    <span>99</span>
                                </div>
                            </div>
                            <div class="marka_itm">
                                <input type="radio" class="radio_sty" name="marka">
                                <div class="marka_label">
                                    <p>أمال</p>
                                    <span>99</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box_side_cate">
                    <div class="box_s_head">
                        <h3>النقوش</h3>
                    </div>
                    <div class="inscriptions_list">
                        <div class="inscriptions_itm">
                            <input type="radio" class="radio_sty" name="inscription" checked>
                            <div class="inscription_label">
                                <img src="img/n1.png" alt="">
                            </div>
                        </div>
                        <div class="inscriptions_itm">
                            <input type="radio" class="radio_sty" name="inscription">
                            <div class="inscription_label">
                                <img src="img/n2.png" alt="">
                            </div>
                        </div>
                        <div class="inscriptions_itm">
                            <input type="radio" class="radio_sty" name="inscription">
                            <div class="inscription_label">
                                <img src="img/n3.png" alt="">
                            </div>
                        </div>
                        <div class="inscriptions_itm">
                            <input type="radio" class="radio_sty" name="inscription">
                            <div class="inscription_label">
                                <img src="img/n4.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="m-overlay"></div>
    </div>

    <div class="main-wrapper">

        <div class="block_search_mobile">
            <div class="container">
                <div class="search_head">
                    <form class="form_search_head" action="#">
                        <input type="text" class="form-control" placeholder="ابحث عن منتج">
                        <span class="search_icon"><i class="far fa-search"></i></span>
                        <button type="submit" class="btn btn_search">بحث الآن</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="banner_inner_bg" >
            <img src="{{asset('website_v3/img/inner.png')}}" alt="...">
        </div>
        <div class="block_breadcrumb">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{asset('/')}}">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{LaravelLocalization::localizeUrl('shop')}}?category=">كافة الأقسام</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$category_name_title}}</li>
                </ol>
            </div>
        </div>
        <div class="content_innerPage skin_bg">
            <div class="container">
                @include('website_v3.shop.partals.box_filter_cate')

                <div class="list_favorite_products">
                    <div class="row">
                        @foreach($products as $product)
                            @include('website_v3.partals.product_category' , ['product' => $product])
                        @endforeach

                    </div>
                    <ul class="pagination clearfix">

                        <li  class="page-item  @if(\Illuminate\Support\Facades\Request::is("ar/shop?category=11&per_page=16&orderby=date&page=$links" )) active @endif">{{$links}}</li>


                    </ul>
                </div>
            </div>
        </div>
        <!--Subscribe section start-->
        <div class="subscribe">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="join">
                            <i class="far fa-envelope"></i>
                            <h3>اشترك بالقائمة البريدية</h3>
                        </div>
                        <div class="sub_p">
                            <p>اشترك في النشرة البريدية لدينا للحصول على آخر تحديثات المنتجات</p>
                        </div>
                    </div>


                    <div class="col-md-6 col-12">
                        <div class="mb-3">

                            <input type="text" class="form-control" placeholder="بريدك الالكتروني ...">
                            <div class="">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon1">اشتراك</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>



@endsection


@push('css')
@endpush

@push('js')
@endpush



@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@stop()

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{asset('website_v3/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('website_v3/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('website_v3/js/jquery.ui.slider-rtl.js')}}"></script>
    <script src="{{asset('website_v3/js/select2.full.min.js')}}"></script>
    <script src="{{asset('website_v3/js/script.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{url('')}}/website/general/js/shop/shop.js"></script>
    <script type="text/javascript">
        // ============================================================================
        // Price range filters init
        // ============================================================================

        $(function() {
            if(!$.fn.slider) return;

            $( ".price-range-selector" ).each(function(){
                var $price_label = $(this).siblings('.wgpf-label').find('.price-range-label');
                var cur_sign = $price_label.data('currency-sign');
                var cursign_before = $price_label.data('cursign-before');
                $(this).slider({
                    isRTL: true,
                    range: true,
                    min: $(this).data('min'),
                    max: $(this).data('max'),
                    values: [ 0, $(this).data('max') ],
                    slide: function( event, ui ) {
                        set_range_label(ui.values[ 0 ], ui.values[ 1 ]);
                    }
                });

                function set_range_label(value1, value2){
                    if(cursign_before)
                        $price_label.html( cur_sign + value1 + " <span>" + cur_sign + value2 + "</span> " );
                    else
                        $price_label.html( value1 + cur_sign + " <span>" + value2 + cur_sign + "</span> " );
                }

                set_range_label($(this).data('min'), $(this).data('max'));
            });
        });
    </script>


@stop()

