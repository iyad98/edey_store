@extends('website.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@push('css')

    <style>
        .woocommerce-MyAccount-navigation {
            float: none;
        }
        .pagination > .active > span {
            background: #2e3379 !important;
            border-color: #2e3379 !important;
        }
        .pagination > .active > span:hover {
            background: #2e3379 !important;
            border-color: #2e3379 !important;
        }
        .row {
            margin-left: 0;
            margin-right: 0;
        }
    </style>
@endpush


@section('content')
    <div class="page-header page_">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>{{$breadcrumb_title}}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="breadcrumb">
                        <div id="primary" class="content-area">
                            <main id="main" class="site-main" role="main">
                                <nav class="woocommerce-breadcrumb">
                                    @foreach($breadcrumb_arr as $breadcrumb)
                                        <a href="{{$breadcrumb['url']}}">{{$breadcrumb['name']}}</a>
                                    @endforeach

                                    {{$breadcrumb_last_item}}
                                </nav>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <div class="container">
            <div class="row">
                <div class="col-md-12 margin-t-b">
                    <div class="single-page">
                        <div class="row">


                            <div class="col-md-12 margin-t-b">
                                <div class="des-10 page-vc">
                                    <div id="yith-wcwl-messages"></div>
                                    <div class="wishlist-title wishlist-title-with-form">
                                        <h2>{{trans('website.wishlist')}}</h2>
                                    </div>
                                    <form id="yith-wcwl-form" action="wishlist/view.html" method="post"
                                          class="woocommerce">
                                        <input type="hidden" id="yith_wcwl_form_nonce" name="yith_wcwl_form_nonce"
                                               value="2664423173"/>
                                        <input type="hidden" name="_wp_http_referer"
                                               value="/%d9%82%d8%a7%d8%a6%d9%85%d8%a9-%d8%a7%d9%84%d8%b1%d8%ba%d8%a8%d8%a7%d8%aa/"/>
                                        <!-- TITLE -->
                                        <!-- WISHLIST TABLE -->


                                        <div  class="remove_to_wishlist_loading blockUI blockOverlay hidden"
                                              style="z-index: 1000; border: none; margin: 0px; padding: 0px; width: 100%; height: 100%; top: -7px; left: 0px; opacity: 0.6; cursor: wait;position: absolute;background:white"></div>

                                        <table class="shop_table cart wishlist_table" data-pagination="no"
                                               data-per-page="5" data-page="1" data-id="" data-token="">
                                            <thead>
                                            <tr>
                                                <th class="product-remove"></th>
                                                <th class="product-thumbnail"></th>
                                                <th class="product-name">
                                                    <span class="nobr">المنتج</span>
                                                </th>
                                                <th class="product-price">
                                                            <span class="nobr">
                        سعر الوحدة                    </span>
                                                </th>
                                                <th class="product-stock-status">
                                                            <span class="nobr">
                        حالة المخزون                    </span>
                                                </th>
                                                <th class="product-add-to-cart"></th>
                                            </tr>
                                            </thead>


                                            <tbody>
                                            @foreach($products as $product)
                                                <tr id="yith-wcwl-row-6448" data-row-id="6448" class="get_favorite_product_{{$product['id']}}">

                                                    <td class="product-remove">
                                                        <div>
                                                            <a href="javascript:;" onclick="remove_from_wishlist('{{$product['id']}}')"
                                                               class="remove "
                                                               title="حذف هذا المنتج">×</a>
                                                        </div>
                                                    </td>

                                                    <td class="product-thumbnail">
                                                        <a href="{{$product['image']}}">
                                                            <img width="300" height="300"
                                                                 src="{{$product['image']}}"
                                                                 class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail"
                                                                 alt=""
                                                                 srcset="{{$product['image']}}"
                                                                 sizes="(max-width: 300px) 100vw, 300px"> </a>
                                                    </td>

                                                    <td class="product-name">
                                                        <a href="{{url('')}}/products/{{$product['id']}}">
                                                            {{$product['name']}}
                                                        </a>
                                                    </td>

                                                    <td class="product-price">
                                                        @if($product['is_discount'])
                                                            <del>
                                                        <span class="woocommerce-Price-amount amount">{{$product['price']}}
                                                            &nbsp;<span
                                                                    class="woocommerce-Price-currencySymbol">{{$product['currency']}}</span></span>
                                                            </del>
                                                        @endif
                                                        <ins>
                                                    <span class="woocommerce-Price-amount amount">{{$product['price_after']}}
                                                        &nbsp;<span
                                                                class="woocommerce-Price-currencySymbol">{{$product['currency']}}</span>
                                                    </span>
                                                        </ins>
                                                        @if($product['is_discount'])
                                                            <p class="saved-sale">خصم: <em>({{$product['discount_rate']}})</em></p>
                                                    @endif

                                                    <td class="product-stock-status">
                                                        @if(!$product['in_stock'])
                                                            <div class="flash"><span class="new yellow-bg ">غير متوفر</span></div>
                                                        @else
                                                            <span class="wishlist-in-stock">متوفر</span>
                                                        @endif

                                                    </td>

                                                    <td class="product-add-to-cart">
                                                        <!-- Date added -->

                                                        <!-- Add to cart button -->
                                                        <a href="{{url('')}}/products/{{$product['id']}}"
                                                           data-quantity="1"
                                                           class="button add_to_cart_button add_to_cart alt"
                                                           data-product_id="6448" data-product_sku="E63"
                                                           rel="nofollow">حدد أحد الخيارات</a>
                                                        <!-- Change wishlist -->

                                                        <!-- Remove from wishlist -->
                                                    </td>
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                        <input type="hidden" id="yith_wcwl_edit_wishlist" name="yith_wcwl_edit_wishlist"
                                               value="69a36ade70"/>
                                        <input type="hidden" name="_wp_http_referer"
                                               value="/%d9%82%d8%a7%d8%a6%d9%85%d8%a9-%d8%a7%d9%84%d8%b1%d8%ba%d8%a8%d8%a7%d8%aa/"/>
                                        <input type="hidden" value="" name="wishlist_id" id="wishlist_id">
                                    </form>
                                </div>
                            </div>

                            <nav class="woocommerce-pagination">
                                {{$links}}

                                {{--
                                <ul class='page-numbers'>
                                    <li><span aria-current="page" class="page-numbers current">1</span></li>
                                    <li><a class="page-numbers" href="shop/page/2.html">2</a></li>
                                    <li><a class="page-numbers" href="shop/page/3.html">3</a></li>
                                    <li><a class="page-numbers" href="shop/page/4.html">4</a></li>
                                    <li><span class="page-numbers dots">&hellip;</span></li>
                                    <li><a class="page-numbers" href="shop/page/15.html">15</a></li>
                                    <li><a class="page-numbers" href="shop/page/16.html">16</a></li>
                                    <li><a class="page-numbers" href="shop/page/17.html">17</a></li>
                                    <li><a class="next page-numbers" href="shop/page/2.html">&rarr;</a></li>
                                </ul>
                                --}}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

@endpush