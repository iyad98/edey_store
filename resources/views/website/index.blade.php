@extends('website.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@push('css')

@endpush


@section('content')

    @if(count($home_data['data']['main_slider']) > 0)
        <section data-vc-full-width="true" data-vc-full-width-init="true" data-vc-stretch-content="true"
                 class="vc_section vc_custom_1585947973730"
                 style="position: relative; left: 0px; box-sizing: border-box;margin-bottom: 50px;">
            <div class="vc_row wpb_row vc_row-fluid vc_custom_1574152056277">
                <div class="wpb_column vc_column_container vc_col-sm-12">
                    <div class="vc_column-inner vc_custom_1522772331263">
                        <div class="wpb_wrapper">
                            <div class="main_slider section_facts slick-initialized slick-slider">
                                <div class="slick-list draggable" style="height: 654px;">
                                    <div class="slick-track" style="opacity: 1;">

                                        @for($i=0 ; $i < count($home_data['data']['main_slider']) ; $i++)
                                            <div class="item slick-slide slick-current slick-active"
                                                 data-slick-index="0"
                                                 aria-hidden="false"
                                                 style="width: 100%; position: relative; right: 0px; top: 0px; z-index: 999; opacity: 1;"
                                                 tabindex="0">
                                                <div class="banner_slider-box over-hidden  has_mobile"><img
                                                            src="{{$home_data['data']['main_slider'][$i]['image_website']}}"
                                                            align="" class="img-responsive"><img
                                                            src="{{$home_data['data']['main_slider'][$i]['image_website']}}"
                                                            align="" class="img-responsive mobile-img"></div>
                                            </div>

                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @foreach($home_data['data']['cat_slider'] as $cat_slider)

        <?php
        $url = LaravelLocalization::localizeUrl('shop');
        switch ($cat_slider['type']) {
            case 1 :
                $category_slug = get_category_slug_data_from_id($all_categories, $cat_slider['data']['id']);
                $url .= "?category=" . get_slug_data_by_lang($category_slug);
                break;
            case 5 :
                $url .= "?orderby=date";
                break;
            case 6 :
                $url .= "?orderby=most_sales";
                break;
        }
        ?>

        @if(in_array($cat_slider['type'] , [1 , 5 , 6]) && count($cat_slider['data']['products']) > 0)
            <section class="vc_section">
                <div class="vc_row wpb_row vc_row-fluid container">
                    <div class="wpb_column vc_column_container vc_col-sm-12">
                        <div class="vc_column-inner">
                            <div class="wpb_wrapper">
                                <div class="wpb_text_column wpb_content_element  main-title-box">
                                    <div class="wpb_wrapper">
                                        <h5 style="text-align: center;"><strong><span
                                                        style="color: #999999;">=====</span>
                                                {{$cat_slider['data']['name']}}
                                                <span style="color: #999999;">=====</span></strong></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="vc_section products-block green vc_custom_1550395846203 vc_section-has-fill">
                <div class="vc_row wpb_row vc_row-fluid container">
                    <div class="wpb_column vc_column_container vc_col-sm-12">
                        <div class="vc_column-inner">
                            <div class="wpb_wrapper">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="title-box" style="background-color:#d72631 !important;">
                                            <h2><a style="color:#ffffff !important;" href="#" target="" title=""></a>
                                            </h2>
                                        </div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="sub-title" style="background-color:#d72631 !important;">
                                            <p style="color:#ffffff !important;"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="products red-title wpb_animate_when_almost_visible wpb_none wpb_start_animation animated">
                                    <div class="owl-carousel owl-products owl-theme owl-rtl owl-loaded">

                                        <div class="owl-stage-outer">
                                            <div class="owl-stage"
                                                 style="transition: all 0s ease 0s; width: 14160px;">
                                                @foreach($cat_slider['data']['products']  as $product)
                                                    <div class="owl-item cloned"
                                                         style="width: 226px; margin-left: 10px;">
                                                        <div class="item">
                                                            <div class="jas-col-md-3 jas-col-sm-4 jas-col-xs-6 mt__30 post-42439 product type-product status-publish has-post-thumbnail product_cat-132 product_cat-379 product_cat-358 product_cat-343 pa_size-395 pa_size-397 pa_size-356 pa_size-385  instock sale shipping-taxable purchasable product-type-variable has-default-attributes">
                                                                @include('website.includes.product' , ['product' => $product])
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach


                                            </div>
                                        </div>
                                        <div class="owl-controls">
                                            <div class="owl-nav">
                                                <div class="owl-prev" style=""><i class="fa fa-angle-right"></i></div>
                                                <div class="owl-next" style=""><i class="fa fa-angle-left"></i></div>
                                            </div>
                                            <div class="owl-dots" style="">
                                                <div class="owl-dot active"><span></span></div>
                                                <div class="owl-dot"><span></span></div>
                                                <div class="owl-dot"><span></span></div>
                                                <div class="owl-dot"><span></span></div>
                                                <div class="owl-dot"><span></span></div>
                                                <div class="owl-dot"><span></span></div>
                                                <div class="owl-dot"><span></span></div>
                                                <div class="owl-dot"><span></span></div>
                                                <div class="owl-dot"><span></span></div>
                                                <div class="owl-dot"><span></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        @elseif( in_array($cat_slider['type'] , [ 2]) && count($cat_slider['data']['products']) > 0)
            @foreach($cat_slider['data']['products']  as $product)
                <div class="wpb_column vc_column_container vc_col-sm-12">
                    <div class="vc_column-inner">
                        <div class="wpb_wrapper">
                            <div class="banner-box over-hidden  has_mobile"><a
                                        href="{{get_pointer_url($product)}}"
                                        title="" target=""><img
                                            src="{{$product['image_website']}}"
                                            align="" class="img-responsive scaled"><img
                                            src="{{$product['image_website']}}"
                                            align="" class="img-responsive scaled mobile-img"></a></div>
                        </div>
                    </div>
                </div>
            @endforeach
        @elseif( in_array($cat_slider['type'] , [ 3]) && count($cat_slider['data']['products']) > 0)
            @foreach($cat_slider['data']['products']  as $product)
                <div class="wpb_column vc_column_container vc_col-sm-6">
                    <div class="vc_column-inner">
                        <div class="wpb_wrapper">
                            <div class="banner-box over-hidden  has_mobile"><a
                                        href="{{get_pointer_url($product)}}"
                                        title="" target=""><img
                                            src="{{$product['image_website']}}"
                                            align="" class="img-responsive scaled"><img
                                            src="{{$product['image_website']}}"
                                            align="" class="img-responsive scaled mobile-img"></a></div>
                        </div>
                    </div>
                </div>
            @endforeach
        @elseif( in_array($cat_slider['type'] , [ 4]) && count($cat_slider['data']['products']) > 0)
            <section class="vc_section top-banner">
                <div class="vc_row wpb_row vc_row-fluid container wpb_animate_when_almost_visible wpb_left-to-right left-to-right wpb_start_animation animated">
                    @foreach($cat_slider['data']['products']  as $product)
                        <div class="wpb_column vc_column_container vc_col-sm-4">
                            <div class="vc_column-inner">
                                <div class="wpb_wrapper">
                                    <div class="banner-box over-hidden  has_mobile"><a
                                                href="{{get_pointer_url($product)}}"
                                                title="" target=""><img
                                                    src="{{$product['image_website']}}"
                                                    align="" class="img-responsive scaled"><img
                                                    src="{{$product['image_website']}}"
                                                    align="" class="img-responsive scaled mobile-img"></a></div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </section>

        @endif


    @endforeach


@endsection

@push('js')


@endpush
