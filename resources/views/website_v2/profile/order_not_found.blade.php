@extends('website_v2.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection


@section('content')


    <div class="content_innerPage ">
    <div  class="container" >
        <div class="cart_empty_block">
            <img src="/website_v2/images/bag.svg" alt="bag">
            <p>عذرا، لا يمكنك عرض تفاصيل هذا الطلب</p>
            <a href="{{LaravelLocalization::localizeUrl('my-account/orders') }}" class="btn m_pro_addCart"><i class="fal fa-shopping-cart"></i>طلباتي</a>
        </div>
    </div>
    </div>



@endsection


@section('css')
@endsection
