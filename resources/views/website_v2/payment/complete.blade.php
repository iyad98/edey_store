
@extends('website_v2.app.layout')
@section('title'){{$payment_message}} @endsection

@section('content')


    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">



                <li class="breadcrumb-item"><a href="{{url('')}}">الرئيسية</a></li>
            </ol>
        </div>
    </div>
    <div class="content_innerPage">
        <div class="container">
            <div class="content_done_page">
                <img src="/website_v2/images/checked.svg" alt="...">
                <h3>{{$payment_message}}  </h3>
                <span>
						 رقم الطلب : {{$order['id']}}
					 </span>
                <p>يمكنك متابعة طلبك عن طريق الدخول لصحفة الطلبات </p>
                <a href="{{LaravelLocalization::localizeUrl('my-account/orders') }}" class="btn btn-block btn_prim">قائمة الطلبات  </a>

            </div>
        </div>
    </div>





@stop()

@section('js')


@stop()

