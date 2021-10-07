@extends('website.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@section('content-page')
    @include('website.partals.header')
    @include('website.partals.nav')





    <div class="favourite-page">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">المفضلة</li>
            </ol>
        </nav>


        @if(count($products) <= 0)
            <div class="empty_product show_empty_cart">
                <div class="container">
                    <div class="empty-container">
                        <div>
                            <img src="/website/img/empty_product.svg" alt="...">
                            <div class="back-home text-center">
                                <p>لا يوجد منتجات في المفضلة </p><a href="{{LaravelLocalization::localizeUrl('/')}}">العودة الى الرئيسية</a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        @endif

        <div class="container">
            <div class="category-page">
                <div class="boys-clothes ">
                    <div class="whole-section">


                        <div class="products-section">
                            <div class="girl-products">

                                @foreach($products  as $product)


                                    <div class="product-box  get_favorite_product_{{$product['product_w_id']}}" >

                                        <div class="about-img">


                                            <div class=" wishlist_comp_{{$product['product_w_id']}} fav-fav @if($product['in_favorite'] == true) infav @endif"  onclick="remove_from_wishlist('{{$product['product_w_id']}}')">
                                                <button class="btn">
                                                    <i class="far fa-heart"></i>
                                                </button>
                                            </div>
                                            <img class="lazyload"  data-src="{{$product['image']}}" alt="">
                                            <div class="overlay">
                                                <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['product_w_id']}}" class="btn">
                                                    أضف إلى السلة
                                                </a>
                                                <div class="colors-title">
                                                    {{$product['categories']}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="description">
                                            <div class="name">
                                                <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['product_w_id']}}">   <h6>{{$product['name']}} </h6></a>
                                            </div>
                                            <div class="price">


                                                @if($product['is_discount'])
                                                    <div class="old-price">
                                                        {{$product['price']}}  {{$product['currency']}}
                                                    </div>
                                                @endif
                                                <div class="new-price">
                                                    {{$product['price_after']}}  {{$product['currency']}}
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
    </div>




    @include('website.partals.subscribe')
    @include('website.partals.footer')
@stop()



@section('js')

    <script>
    </script>
    <script src="{{url('')}}/website/general/js/cart/cart.js" type="text/javascript"></script>
@endsection