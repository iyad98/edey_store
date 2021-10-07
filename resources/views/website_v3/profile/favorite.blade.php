
@extends('website_v3.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@section('content')





    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">المفضلة</li>
            </ol>
        </div>
    </div>

    @if(empty($products) )
        <div class="content_innerPage ">
            <div  class="container" >
                <div class="cart_empty_block">
                    <img src="/website_v3/images/bag.svg" alt="bag">
                    <p>عذرا، لا يوجد منتجات في المفضلة</p>
                    <a href="{{asset('/')}}" class="btn m_pro_addCart"><i class="fal fa-shopping-cart"></i>تسوق الآن</a>
                </div>
            </div>
        </div>
    @else
        <div class="content_innerPage skin_bg">
            <div class="container">
                <div class="list_favorite_products">
                    <div class="row">
                        @foreach($products  as $product)
                            @include('website_v3.partals.product_category' , ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif















@stop()

@section('js')

    <script src="{{url('')}}/website/general/js/cart/cart.js" type="text/javascript"></script>

@stop()

