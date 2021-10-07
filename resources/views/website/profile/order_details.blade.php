@extends('website.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@section('content-page')
    @include('website.partals.header')
    @include('website.partals.nav')

    <div class="order-details-page" id="order">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">تفاصيل الطلب</li>
            </ol>
        </nav>
        <div class="container">
            <div class="alert alert-danger dan_alert hidden" role="alert">

            </div>
            <div class="alert alert-success suc_alert hidden" role="alert ">
            </div>
            <div class="row">

                <div class="col-12 col-md-8">
                    <div class="head-title">
                        تفاصيل الطلب
                        <span>(@if(in_array($order->status , [6,9,10]))R @endif{{$order->id}}) </span>
                    </div>
                    <div class="container">
                        <ul id="progressbar" class="text-center">





                            @if(in_array($order->status , [6 , 9 , 10]))
                                <li @if(in_array($order->status ,[6 , 9 , 10]   )) class="active" @endif id="step6">
                                    <div class="d-none d-md-block"></div>
                                </li>
                                <li @if(in_array($order->status,[ 6 , 10]   )) class="active" @endif  id="step9">
                                    <div class="d-none d-md-block"></div>
                                </li>
                                <li @if($order->status == 6   ) class="active" @endif id="step10">
                                    <div class="d-none d-md-block"></div>
                                </li>
                            @else
                                <li @if($order->status >= 0   ) class="active" @endif id="step1">
                                    <div class="d-none d-md-block"></div>
                                </li>
                                <li @if($order->status >= 1  && $order->status <= 5 ) class="active" @endif id="step2">
                                    <div class="d-none d-md-block"></div>
                                </li>
                                <li @if($order->status >= 2 && $order->status <= 5 ) class="active" @endif id="step3">
                                    <div class="d-none d-md-block"></div>
                                </li>
                                @if($order->status <= 4 )
                                    <li @if($order->status == 4 ) class="active" @endif id="step4">
                                        <div class="d-none d-md-block"></div>
                                    </li>
                                @endif
                                @if($order->status == 5 )
                                    <li class="active active_cuncel" id="step5">
                                        <div class="d-none d-md-block"></div>
                                    </li>

                                @endif
                            @endif
                        </ul>
                    </div>
                    <div class="about-tables">
                        <table class="table1">
                            <thead>
                            <tr>
                                <td>تفاصيل المنتج</td>
                                <td class="txt-left p-30">السعر</td>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($order->order_products as $product)


                                <tr @if($product->is_returned ==1 ) style="background: #ddd;" @endif>
                                    <td class="product-details">
                                        <div class="about-img">
                                            <img src="{{$product->product->image}}" alt="">
                                        </div>
                                        <div class="name-quantity">
                                            <h6 class="name">{{$product->product->name}}
                                                {{--( <span v-text="get_attribute_values_name('{{$product->product_attribute_values__}}')"></span> )--}}

                                            </h6>
                                            <span class="quantity-no">الكمية: {{$product->quantity}}</span>
                                        </div>
                                    </td>

                                    <td class="price txt-left p-30">{{$product->total_price}} {{$order->currency->symbol}}</td>

                                </tr>

                            @endforeach


                            </tbody>
                        </table>
                        <table class="table2">

                            <tbody>

                            <tr>
                                <td>
                                    {{trans('admin.order_price_before_discount')}}
                                </td>
                                <td class="txt-left p-30">
                                    {{$order->price}} {{$order->currency->symbol}}
                                </td>
                            </tr>


                            @foreach($order->admin_discounts as $admin_discount)
                                @if($admin_discount->price > 0)
                                    <tr>
                                        <td>{{trans('api.admin_discount' , ['discount_rate' => $admin_discount->discount_rate])}}</td>
                                        <td class="txt-left p-30">
                                            {{$admin_discount->price}}
                                            &nbsp;{{$order->currency->symbol}}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                            @if($order->package_discount_price > 0)
                                <tr>
                                    <td>
                                        {{trans('admin.package_discount') . " ( " . ($order->package && $order->package->package ? $order->package->package->name : '') ." ) "}}

                                        <br>
                                        @if($order->package && $order->package->free_shipping == 1)
                                            <small>{{trans('admin.package_free_shipping')}}</small>
                                        @endif
                                    </td>
                                    <td class="txt-left p-30">
                                        {{"-".$order->package_discount_price}}
                                        {{$order->currency->symbol}}
                                    </td>
                                </tr>
                            @endif

                            @foreach($order->coupon as $coupon)
                                <tr>
                                    <td>{{trans('admin.coupon_value')}}
                                        ( <span>{{$coupon->coupon_code}}</span> )
                                    </td>
                                    <td class="txt-left p-30">
                                        {{$coupon->coupon_price}}
                                        &nbsp;{{$order->currency->symbol}}
                                    </td>
                                </tr>
                            @endforeach

                            <tr>
                                <td>{{trans('admin.price_after_discount_coupon')}}</td>
                                <td class="txt-left p-30">{{$order->price_after_discount_coupon}}
                                    {{$order->currency->symbol}}
                                </td>
                            </tr>


                            @if($order->first_order_discount)
                                <tr>
                                    <td>{{trans('admin.first_order_discount')}}</td>
                                    <td class="txt-left p-30" data-title="{{trans('admin.first_order_discount')}}">
                                        {{$order->first_order_discount}}
                                        {{$order->currency->symbol}}
                                    </td>
                                </tr>
                            @endif

                            <tr>
                                <td>{{trans('admin.shipping')}}
                                    ( {{ $order->shipping_text }}
                                    )
                                </td>
                                <td class="txt-left p-30">
                                    {{$order->shipping == 0 ? trans('admin.free_shipping'): $order->shipping}}
                                    {{$order->shipping == 0 ? "" : get_currency()}}
                                </td>
                            </tr>

                            <tr>
                                <td>{{trans('admin.cash_fees')}}</td>
                                <td class="txt-left p-30">
                                    {{$order->cash_fees}}
                                    {{$order->currency->symbol}}
                                </td>
                            </tr>


                            <tr>
                                <td>{{trans('admin.price_before_tax')}}</td>
                                <td class="txt-left p-30">
                                    {{$order->price_before_tax}}
                                    {{$order->currency->symbol}}
                                </td>
                            </tr>
                            <tr>
                                <td>{{trans('api.tax_text' , ['tax' => $order->tax_percentage])}}</td>
                                <td class="txt-left p-30">
                                    {{$order->tax}}
                                    {{$order->currency->symbol}}
                                </td>
                            </tr>
                            <tr>
                                <td>{{trans('website.payment_method')}}</td>
                                <td class="txt-left p-30">{{$order->payment_method->name}}</td>
                            </tr>

                            </tbody>
                            <tfoot>
                            <tr>
                                <td>
                                    الإجمالي
                                </td>
                                <td class="price txt-left p-30">
                                    {{$order->total_price}}
                                    <span> {{$order->currency->symbol}}</span>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="ship-info col-12">


                        @if(in_array($order->status ,[6 , 9 , 10]   ))

                            <div class="head-title ">
                                ملاحظات على الاسترجاع
                            </div>
                            <p> {{$order->return_order_note_text}}</p>

                            @if($order->return_order_note_file_name != null )
                            <div class="attached-files">
                                <label> الملفات المرفقة</label>
                                <a href="{{$order->return_order_note_file}}" target="_blank"> <button class="btn"><i class="fas fa-paperclip"></i> تحميل الملف</button>
                                </a>
                            </div>
                            @endif

                        @if($order->shipping_policy_return != null )
                            <div class="attached-files">
                                <button id="print_shipping_policy"   @click="print_shipping_policy(1)" class="btn ">طباعة بوليصة الشحن
                                </button>

                            </div>
                            @endif




                            <br>

                        @endif



                        @if($order->order_user_shipping->is_gift == 1)
                            <div class="head-title ">
                                معلومات المهدى له

                            </div>
                            <ul class="list-unstyled">
                                <li><span>الاسم : </span>{{$order->order_user_shipping->gift_first_name . " ".$order->order_user_shipping->gift_last_name}}</li>
{{--                                <li>{{$order->order_user_shipping->gift_target_email}}</li>--}}
                                <li><span>رقم الجوال :</span> {{$order->order_user_shipping->gift_target_phone}}</li>
                                <li><span>نص الاهداء :</span> {{$order->order_user_shipping->gift_text}}</li>


                            </ul>

                        @endif
                        <div class="head-title">
                            معلومات الشحن

                        </div>
                        <ul class="list-unstyled">
                            <li> <span>المدينة :</span> {{$order->order_user_shipping && $order->order_user_shipping->shipping_city ? $order->order_user_shipping->shipping_city->name : ""}}

                            </li>

                            <li><span>المحافظه :</span> {{$order->order_user_shipping->state}}</li>
                            <li><span>العنوان :</span>
                                {{$order->order_user_shipping->address}}
                            </li>



                            @if(!empty($order->order_user_shipping->billing_national_address))
                                <li>{{trans('website.national_address')}}
                                    : {{$order->order_user_shipping->billing_national_address}}</li>
                            @endif

                            @if(!empty($order->order_user_shipping->billing_building_number))
                                <li>{{trans('website.building_number')}}
                                    : {{$order->order_user_shipping->billing_building_number}}</li>
                            @endif

                            @if(!empty($order->order_user_shipping->billing_postalcode_number))
                                <li>{{trans('website.postalcode_number')}}
                                    : {{$order->order_user_shipping->billing_postalcode_number}}</li>
                            @endif

                            @if(!empty($order->order_user_shipping->billing_unit_number))
                                <li>{{trans('website.unit_number')}}
                                    : {{$order->order_user_shipping->billing_unit_number}}</li>
                            @endif

                            @if(!empty($order->order_user_shipping->billing_extra_number))
                                <li>{{trans('website.extra_number')}}
                                    : {{$order->order_user_shipping->billing_extra_number}}</li>
                            @endif


                        </ul>

                        <div class="head-title">
                            معلومات المشتري

                        </div>
                        <ul class="list-unstyled">
                            <li> <span>الاسم :</span> {{$order->order_user_shipping->first_name . " ".$order->order_user_shipping->last_name}}</li>

                            <li> <span>الايميل :</span> {{$order->order_user_shipping->email}}</li>
                            <li> <span>رقم الجوال :</span> {{$order->order_user_shipping->phone}}</li>

                        </ul>

                            <div class="transfer-type">
                                <label>نوع التحويل</label>
                                <h5>{{$order->payment_method->name}}</h5>
                            </div>
                    </div>

                    @if(! in_array($order->status ,[6 , 9 , 10 ,5]   ))
                        <div class="col-12">
                            <div class="take-back-products">
                                <div class="title">
                                    <h3>استرجاع المنتجات</h3>
                                    <p>اختر المنتجات المراد استرجاعها (يحق
                                        لك استرجاع المنتجات فقط خلال <span>{{$return_order_time}} أيام</span>
                                        من تاريخ الطلب)</p>

                                </div>
                                <div class="all-product">


                                    @foreach($order->order_products as $order_product)

                                        <div class="take-back-product">
                                            <div class="single-product text-right">
                                                <div class="product-item row p-1">
                                                    <div class="row-check col-1 p-0">
                                                        @if($product->is_returned != 1)
                                                            <input type="checkbox" value="{{$order_product->id}}"
                                                                   name="return_products">
                                                        @endif
                                                    </div>
                                                    <div class="col-3 p-0">
                                                        <img src="{{$order_product->product->image}}" class=""
                                                             height="130" width="130">
                                                    </div>
                                                    <div class="col-8 pr-1">
                                                        <div class="product-item-data row">
                                                            <div class="col-7 p-2">
                                                                <h6> {{$order_product->product->name}}

                                                                </h6>

                                                                <div class="Quantity">
                                                                    الكمية: {{$product->quantity}}
                                                                </div>
                                                            </div>
                                                            {{--<div class="take-back-data col-5 p-0">--}}
                                                            {{--<label>الكمية المسترجعة</label>--}}
                                                            {{--<input type="text" value="ادخل الكمية">--}}
                                                            {{--</div>--}}
                                                            <input type="hidden"
                                                                   id="get_order_id_hidden"
                                                                   value="{{$order->id}}">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                    @endforeach


                                    <div class="take-back-btn text-left">
                                        <div class="row-check col-12 p-2 return_products_accept_polocy">
                                        <input type="checkbox" id="return_products_accept_polocy">
<a target="_blank"  href="{{LaravelLocalization::localizeUrl('return-policy')}}">اوافق على سياسة الاسترجاع</a>
                                        </div>



                                        <button class="btn" @click="return_order"
                                                :disabled="loading"
                                                id="place_order"><img
                                                    src="/website/img/Icon material-settings-backup-restore.svg"


                                            > استرجاع المنتجات
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>



    @include('website.partals.subscribe')
    @include('website.partals.footer')
@stop()



@section('js')
    <script>
        var order = {!! $order !!};

    </script>
    <script src="{{url('')}}/website/general/js/user/order.js" type="text/javascript"></script>

@endsection

@section('css')
    <style>
        .take-back-data input {
            width: 90px;
            height: 24px;
            border-radius: 4px;
            border: navajowhite;
            font-size: 10px;
            background: none;
            padding: 2px;
            background: #f6f7f8;
            color: #a5a5a5;
        }

        .title p {
            font-size: 14px;
            color: #858189;
        }

        .title span {
            color: #ED0C6E;
            font-weight: bold
        }

        .take-back-product .product-item img {
            border: 1px solid #DFDFDF;
            border-radius: 3px;
            width: 63px;
            margin: 5px;
            height: 63px;
        }

        .all-product {
            border-radius: 4px;
            border: solid 3px #f6f7f8;
            padding: 5px;
        }

        .product-item-data h6 {
            font-size: 13px;
            margin-bottom: 15px;
        }

        .product-item-data .Quantity {
            font-size: 10px;
            color: #ED0C6E;
        }

        .take-back-data label {
            font-size: 8px;
        }

        .product-item {
            width: 100%;
            margin: 0;
            border-bottom: solid 2px #f6f7f8;
        }

        .row-check {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .take-back-btn button {
            color: white;
            width: 135px;
            height: 33px;
            font-size: 12px;
            margin: 10px 0;
            border-radius: 4px;
            background-color: #22262a;
        }

        /**/
        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            color: #455A64;
            padding-left: 0px;
            margin-top: 30px;
            text-align: right;
            display: flex;
        }

        #progressbar li {
            list-style-type: none;
            width: 34%;
            float: left;
            position: relative;
            font-weight: 400
        }

        #progressbar #step6:before {
            content: "طلب استرجاع";
        }

        #progressbar #step9:before {
            content: "قيد الاسترجاع";
        }

        #progressbar #step10:before {
            content: "تم الاسترجاع";
        }

        #progressbar li:before {
            width: 68px;
            height: 68px;
            padding: 35px;
            text-align: center;
            display: flex;
            padding: -1px;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: bold;
            background: #fff;
            border-radius: 50%;
            margin: auto;
            color: #000;
            border: 1px solid #111;
        }

        #progressbar li:after {
            content: '';
            width: 100%;
            height: 5px;
            background: #eaeaea;
            position: absolute;
            left: 0;
            top: 33px;
            z-index: -1
        }

        #progressbar li:last-child:after {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            position: absolute;
            right: -50%
        }

        #progressbar li:first-child:after {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            position: absolute;
            right: 50%
        }

        #progressbar li:last-child:after {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px
        }

        #progressbar li:first-child:after {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px
        }

        #progressbar li.active:before,
        #progressbar li.active:after {
            background: #ED0C6E;
            border: none;
            color: #fff;
        }

        .attached-files {
            margin-bottom: 20px;
        }

        .attached-files label, .transfer-type label {
            color: #ED0C6E;
        }

        .attached-files button {
            width: 160px;
            height: 35px;
            background-color: #ED0C6E;
            color: #ffffff;
            font-size: 14px;
            display: block;
        }

        .ship-info .list-unstyled span{color: #000 !important;}
    </style>

    @if($order->status == 5 )
        <style>
            #progressbar li.active:before,
            #progressbar li.active:after {
                background: red;
            }
        </style>
    @endif
@endsection