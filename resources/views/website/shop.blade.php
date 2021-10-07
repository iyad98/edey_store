@extends('website.layout')
@section('title') {{show_website_title(@$title)}} @endsection
@push('css')

@endpush


@section('content')
    <div id="jas-content">
        <div class="jas-wc dib w__100" role="main">
            <nav class="woocommerce-breadcrumb"><a href="https://mamnonfashion.com">الرئيسية</a>&nbsp;&#47;&nbsp;<a
                        href="{{url('')}}/website/product-category/%d8%a8%d9%86%d8%a7%d8%aa%d9%8a/">بناتي</a>&nbsp;&#47;&nbsp;طقم
            </nav>
            <div class="page-header page_">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1>طقم</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-3 sidebar">
                        <aside id="woocommerce_price_filter-2" class="widget woocommerce widget_price_filter">
                            <h3 class="widget-title tu fwsb">تصفية حسب السعر</h3>
                            <form method="get" >
                                <div class="price_slider_wrapper">
                                    <div class="price_slider" style="display:none;"></div>
                                    <div class="price_slider_amount">
                                        <input type="text" id="min_price" name="min_price" value="{{isset($min_price) ?$min_price : 0 }}"
                                               data-min="0" placeholder="أدنى سعر"/>
                                        <input type="text" id="max_price" name="max_price" value="{{isset($max_price) ?$max_price : 100 }}"
                                               data-max="100" placeholder="أعلى سعر"/>
                                        <button type="submit" class="button">تصفية</button>
                                        <div class="price_label" style="display:none;">
                                            السعر: <span class="from"></span> &mdash; <span class="to"></span>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <input type="hidden" name="page" value="1"/>
                                <input type="hidden" name="category" value="{{isset(request()->category) ? request()->category : ""}}">
                                <input type="hidden" name="brand" value="{{isset(request()->brand) ? request()->brand : ""}}">
                                <input type="hidden" name="orderby" value="{{isset(request()->orderby) ? request()->orderby : ""}}">
                                <input type="hidden" name="search" value="{{isset(request()->search) ? request()->search : ""}}">

                            </form>
                        </aside>
                    </div>
                    <div class="col-md-9">
                        <div class="woocommerce-notices-wrapper"></div>
                        <p class="woocommerce-result-count">
                        </p>
                        <form class="woocommerce-ordering" >
                            <select id="sort_by_orderby" name="orderby" class="orderby">
                                <option value="menu_order" {{$orderBy == "menu_order" ? 'selected' : ''}}>الترتيب
                                    الافتراضي
                                </option>

                                {{--
                                <option value="popularity">ترتيب حسب الأكثر شهرة</option>
                                <option value="rating">ترتيب حسب متوسط التقييم</option>
                                --}}
                                <option value="date" {{$orderBy == "date" ? 'selected' : ''}}>الفرز حسب الأحدث</option>
                                <option value="price" {{$orderBy == "price" ? 'selected' : ''}}>ترتيب حسب: الأقل سعراً
                                    للأعلى
                                </option>
                                <option value="price_desc" {{$orderBy == "price_desc" ? 'selected' : ''}}>ترتيب حسب: الأعلى
                                    سعراً للأدنى
                                </option>
                            </select>
                            <input type="hidden" name="page" value="1"/>
                            <input type="hidden" name="category" value="{{isset(request()->category) ? request()->category : ""}}">
                            <input type="hidden" name="brand" value="{{isset(request()->brand) ? request()->brand : ""}}">
                            <input type="hidden" name="min_price" value="{{isset(request()->min_price) ? request()->min_price : ""}}">
                            <input type="hidden" name="max_price" value="{{isset(request()->max_price) ? request()->max_price : ""}}">
                            <input type="hidden" name="search" value="{{isset(request()->search) ? request()->search : ""}}">

                        </form>
                        <ul class="products columns-4">
                            @foreach($products  as $product)
                                <div class="col-md-4 col-sm-6 post-18637 product type-product status-publish has-post-thumbnail product_cat-132 product_cat-344 product_cat-360 product_cat-364 product_cat-382 pa_size-356 pa_size-385 pa_size-395 pa_size-405 last instock sale shipping-taxable purchasable product-type-variable has-default-attributes">
                                    @include('website.includes.product' , ['product' => $product])
                                </div>
                            @endforeach
                        </ul>


                    </div>
                    <nav class="woocommerce-pagination">
                        {{$links}}

                    </nav>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{url('')}}/website/general/js/shop/shop.js"></script>

@endpush

