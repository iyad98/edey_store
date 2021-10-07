@extends('website_v2.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection


@section('content')

    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('')}}">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">عربة التسوق</li>
            </ol>
        </div>
    </div>
    <div class="content_innerPage ">
        <div  class="container" >
            <div class="cart_empty_block">
                <img src="/website_v2/images/bag.svg" alt="bag">
                <p>عذرا، يجب اضافة منتجين للمقارنة</p>
                <a href="{{asset('/')}}" class="btn m_pro_addCart"><i class="fal fa-shopping-cart"></i>تسوق الآن</a>
            </div>
        </div>
    </div>



@endsection


@section('css')
@endsection

@section('js')

@endsection
