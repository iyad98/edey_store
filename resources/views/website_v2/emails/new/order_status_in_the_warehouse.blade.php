<!DOCTYPE html>
<html>
<head>
    <title>q8store Email</title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="telephone=no" name="format-detection" />
    <title></title>
    {{--<style type="text/css" data-premailer="ignore">--}}
    {{--@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');--}}
    {{--</style>--}}

    <style type="text/css">
        body, table, td {
            font-family: Montserrat, -apple-system, BlinkMacSystemFont, Roboto, Helvetica Neue, Helvetica, Arial, sans-serif;
        }
        @media screen and (max-width: 640px), screen and (max-device-width: 640px) {

            table[class="table-responsive"]{
                width: 100%;
            }
            table[class="table-responsive"] td{
                display: block;
                width: 48%;
                float: right;
            }

            table[class="table-responsive"] tr{
                display: block;
                /*width: 50%;*/
            }
            table[class="table-responsive"] td img[class="img_"]{
                width: 100%;
            }
            td.td_padding{
                padding-right: 15px !important;
                padding-left: 15px !important;
            }

        }

        @media screen and (max-width: 450px), screen and (max-device-width: 400px) {
            h2{
                font-size: 0.5rem !important;
            }
            p{
                font-size: 0.5rem !important;
            }
            td{
                font-size: 10px !important;
            }
            .total{
                width: 100% !important;
            }
            .f_img{
                height: 25px !important;
                width: 25px !important;
            }
            .item_product h2 a{
                font-size: 10px !important;
            }
            .total{
                width: 100% !important;
            }
            table[class="table-responsive"] td{
                /*display: block;*/
                width: 100%;
            }
            table[class="offer-table"] {
                margin-top: 20px;
                margin-bottom: 20px;
            }
            table[class="offer-table"] td {
                width: 100%;
                display: block;
                text-align: center;
            }
            table[class="offer-table"] td span{
                margin-top: 5px !important;
                margin-bottom: 5px !important;
            }
            .img-logo{
                max-width: 150px;
            }
            .float_none{
                float: none !important;
                text-align: center;
            }
            a.float_none{
                display: table !important;
                margin-left: auto;
                margin-right: auto;
            }
        }
        .img-logo > img{
            max-width: 100%;
        }
    </style>
</head>
<?php
app()->setLocale(isset($_lang_) ? $_lang_ : 'ar');
$lang = app()->getLocale();
$get_social_medial = get_social_medial_urls();
?>
<body style="margin: 0; padding: 0; background-color: #d8d8d8; direction: rtl; text-align: right;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width:100%; max-width:650px; margin:auto;">
    <tr>
        <td style="padding: 20px 20px;background-color: #fff; border-top-right-radius: 15px;border-top-left-radius: 15px;" class="td_padding">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="right">
                        <a href="https://www.q8store.co" class="img-logo">
                            <img src="https://www.q8store.co/email/images/logo.png" alt="">
                        </a>
                    </td>
                    <td align="left">
                        <a href="https://www.q8store.co" class="img-logo">
                            <img src="https://www.q8store.co/email/images/warehouse.png" style="height: 100px;" alt="">
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td width="100%" style="padding: 5px 20px;background: #e81f34;color: #fff;font-weight: 700;"><p style="margin: 0;">{{$_subject_}}</p></td>
    </tr>
    <tr>
        <td style="padding: 30px 20px;background-color: #fff; " class="td_padding">
            <p style="color: #000; font-size: 15px;">{!! $_message_ !!}</p>
            <p style="color: #000; font-size: 15px;">لاستعراض تفاصيل الطلب اضغط على الرابط التالي : </p>
            <a href="https://www.q8store.co/ar/my-account/orders/{{$order->id}}">https://www.q8store.co/ar/my-account/orders/{{$order->id}}</a>
            <p style="color: #000; font-size: 15px;">الرجاء الرد على هذا البريد في حالة كان هنالك استفسارات</p>
        </td>
    </tr>
    <tr>
        <td style="padding: 15px 20px;margin-top: 0;background-color: #fff;" class="td_padding">
            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #F5F5F5;border-radius: 15px; padding: 15px;">
                <tr>
                    <td> <h2 style="margin: 0; font-weight: 700; color: #000000; font-size: 18px;">ملخص الطلب</h2></td>

                </tr>
                <tr>
                    <td width="20%" style=" vertical-align: top;">
                        <div style="height: 100%;  padding: 15px 10px;">
                            <p style="margin: 0;color: #a3a3a3;font-size: 15p;margin-bottom: 15px;">رقم الطلب</p>
                            <p style="margin: 0; color: #000000; font-size: 15px;font-weight: 700;">#{{$order->id}}</p>
                        </div>
                    </td>
                    <td width="20%" style=" vertical-align: top; ">
                        <div style="height: 100%;  padding: 15px 10px;">
                            <p style="margin: 0;color: #a3a3a3;font-size: 15p;margin-bottom: 15px;">تاريخ الطلب</p>
                            <p style="margin: 0; color: #000000; font-size: 15px;font-weight: 700;">{{\Carbon\Carbon::parse($order->created_at)->format('Y-m-d')}}</p>
                        </div>
                    </td>
                    <td width="20%" style=" vertical-align: top;">
                        <div style="height: 100%;  padding: 15px 10px;">
                            <p style="margin: 0;color: #a3a3a3;font-size: 15p;margin-bottom: 15px;">طريقة الدفع </p>
                            <p style="margin: 0; color: #000000; font-size: 15px;font-weight: 700;">{{$order->payment_method->name}}</p>
                        </div>
                    </td>
                    <td width="20%" style=" vertical-align: top;" >
                        <div style="height: 100%;  padding: 15px 10px;">
                            <p style="margin: 0;color: #a3a3a3;font-size: 15p;margin-bottom: 15px;">قمية الطلب</p>
                            <p style="margin: 0; color: #000000; font-size: 15px;font-weight: 700;">{{$order->total_price ." ".$order->currency->symbol}}</p>
                        </div>
                    </td>
                    <td width="20%" style=" vertical-align: top;" >
                        <div style="height: 100%;  padding: 15px 10px;">
                            <p style="margin: 0;color: #a3a3a3;font-size: 15p;margin-bottom: 15px;">حالة الطب</p>
                            <p style="margin: 0; color: #000000; font-size: 15px;font-weight: 700;">{{trans_orignal_order_status()[$order->status]}}</p>
                        </div>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 5px 15px ; background-color: #fff;">
            <h2 style="margin: 0; color: #1A1818; font-size: 18px; font-weight: 700;"><span style="color: #E81F34; display: inline-block; margin-right: 10px;">طريقة التسليم : {{$order->order_user_shipping->billing_shipping_type_->name }}</span></h2>
        </td>
    </tr>
    @if($order->order_user_shipping->billing_shipping_type_->id != 1)
        <tr>
            <td style="padding: 15px 20px;margin-top: 0;background-color: #fff;" class="td_padding">
                <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;background-color: #F5F5F5;border-radius: 15px; padding: 15px;">
                    <tr>
                        <td> <h2 style="margin-bottom: 15px; font-weight: 700; color: #000000; font-size: 18px;">عنوان الشحن</h2></td>

                    </tr>
                    <tr>
                        <td  style=" vertical-align: top;">
                            <div style="height: 100%;">
                                <p> المحافظة : {{$order->order_user_shipping->shipping_city->name }}</p>

                                <p> القطعة : {{$order->order_user_shipping->state }} </p>

                                <p>  الشارع : {{$order->order_user_shipping->street }} </p>

                                <p> الجادة :  {{$order->order_user_shipping->avenue }}</p>
                                <p> رقم المبني :{{$order->order_user_shipping->building_number }} </p>

                                <p> رقم الطابق : {{$order->order_user_shipping->floor_number }} </p>

                                <p>  رقم الشقة : {{$order->order_user_shipping->apartment_number }}</p>

                            </div>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    @endif

    <tr>
        <td style="padding: 0px 20px; margin-top: 0;background-color: #fff;" class="td_padding">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tbody>
                @foreach($order->order_products as $product)
                    <tr>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;"><div class="product_img">
                                <img style="height: 110px;width: 110px;" src="{{$product->product->image}}" alt="">
                            </div></td>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;vertical-align: top; line-height: 1.5;">{{$product->product->name}}
                            <hr>
                        </td>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px; text-align: left;vertical-align: top;">{{ number_format($product->total_price_after , round_digit()) }} {{$order->currency->symbol}}</td>
                    </tr>


                @endforeach

                </tbody>
            </table>

        </td>
    </tr>
    <tr>
        <td style="padding: 30px 20px; margin-top: 0;background-color: #fff;" class="td_padding">
            <table class="total"  style="width: 45%;margin-right: auto; " cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td style="padding: 8px 10px; color: #262626; font-size: 16px;">السعر</td>
                    <td style="padding: 8px 10px; color: #262626; font-size: 16px; text-align: left;">{{$order->price}}</td>
                </tr>
                @foreach($order->coupon as $coupon)
                    <tr>
                        <td style="padding: 8px 10px; color: #262626; font-size: 16px;">{{trans('admin.coupon_value')}}

                            ( <span>{{$coupon->coupon_code}}</span> )
                        </td>
                        <td style="padding: 8px 10px; color: #262626; font-size: 16px; text-align: left;"> {{"-".number_format($coupon->coupon_price , round_digit()) }}</td>

                    </tr>
                @endforeach
                <tr>
                    <td style="padding: 8px 10px; color: #262626; font-size: 16px;">
                        اجمالي المبلغ بعد الخصم
                    </td>
                    <td style="padding: 8px 10px; color: #262626; font-size: 16px; text-align: left;">
                        {{$order->price_after_discount_coupon}}
                    </td>
                </tr>


                @if($order->shipping > 0)
                    <tr>
                        <td style="padding: 8px 10px; color: #262626; font-size: 16px;">
                            تكاليف الشحن
                        </td>
                        <td style="padding: 8px 10px; color: #262626; font-size: 16px; text-align: left;">
                            {{$order->shipping == 0 ? trans('admin.free_shipping'): $order->shipping}}
                        </td>
                    </tr>
                @endif
                <tr>
                    <td style="padding: 8px 10px; color: #262626; font-size: 16px;">
                        الضريبة المضافه
                    </td>
                    <td style="padding: 8px 10px; color: #262626; font-size: 16px; text-align: left;">
                        {{$order->tax}}
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="total" style="width: 45%;margin-right: auto;border-top:1px solid #DEDEDE; margin-top: 10px; " cellpadding="0" cellspacing="0" >
                <tr>
                    <td align="right" style="padding: 15px 0;">
                        <h2 style="color: #000;font-size: 16px; font-weight: 700; margin:0;">الاجمالي النهائي</h2>
                    </td>
                    <td align="left" style="padding: 15px 0;">
                        <p style="color: #000; font-size: 16px; font-weight: 700; margin:0;">{{$order->total_price}}   {{$order->currency->symbol}}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    @if($order->order_user_shipping->billing_shipping_type_->id == 1)
    <tr>
        <td style="padding: 30px 20px; background-color: #ffffff;" class="td_padding">
            <h2 style="color: #e81f34;font-size: 20px;font-weight: 700;">عنوان الاستلام من المستودع :</h2>
            <p style="color: #000; font-size: 17px; line-height: 5px;">العارضية </p>
            <p style="color: #000; font-size: 17px; line-height: 5px;"> الدوام من يوم السبت الى الخميس (الجمعة اجازة) </p>
            <p style="color: #000; font-size: 17px;line-height: 5px;">من الساعة 9 صباحا الى 4 مساءا </p>
            <p style="color: #e81f34; font-size: 18px;">العنوان على الخريطة : </p>
            <a href="https://goo.gl/maps/UWHoPyetu4AddDdS9" target="_blank">https://goo.gl/maps/UWHoPyetu4AddDdS9</a>
        </td>
    </tr>
    @endif
    <tr>
        <td style="padding: 30px; background-color: #e81f34;border-bottom-left-radius: 15px;border-bottom-right-radius: 15px;" class="td_padding">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tbody><tr>
                    <td style="padding: 0 10px;">
                        <div class="item_product" style="display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;align-items: center;">
                            <div class="f_img" style="margin-left: 10px;width: 50px;border-radius: 50%;height: 50px; display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;text-align: center;background-color:rgba(255,255,255,0.15);justify-content: center;
align-items: center;">
                                <a href="https://www.q8store.co/email/images/email.png">
                                    <img src="https://www.q8store.co/email/images/email.png" alt="" style="margin: auto; max-height: 100%;">
                                </a>
                            </div>
                            <div>
                                <h2 style="margin: 10px 0; line-height: 1;"><a href="tomail:{{$get_social_medial['email']}}" style="color: #fff; font-size: 14px; font-weight: 500; text-decoration: none !important;">البريد الالكتروني</a></h2>
                                <p style="color: #fff; font-size: 14px; font-weight: 700;margin-top: 0;">{{$get_social_medial['email']}}</p>
                            </div>

                        </div>
                    </td>
                    <td style="padding: 0 10px;">
                        <div class="item_product" style="display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;align-items: center;">
                            <div class="f_img" style="margin-left: 10px;width: 50px;border-radius: 50%;height: 50px; display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;text-align: center;background-color:rgba(255,255,255,0.15) ; justify-content: center;
align-items: center;">
                                <a href="https://www.q8store.co/email/images/call.png">
                                    <img src="https://www.q8store.co/email/images/call.png" alt="" style="margin: auto; max-height: 100%;" >
                                </a>
                            </div>
                            <div>
                                <h2 style="margin: 10px 0; line-height: 1;"><a href="tel:{{$get_social_medial['phone']}}" style="color: #fff; font-size: 14px; font-weight: 500; text-decoration: none !important;">للاتصال المباشر </a></h2>
                                <p style="color: #fff; font-size: 14px; font-weight: 700;margin-top: 0;">{{$get_social_medial['phone']}}</p>
                            </div>

                        </div>
                    </td>
                    <td style="padding: 0 10px;">
                        <div class="item_product" style="display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;align-items: center;">
                            <div class="f_img" style="margin-left: 10px;width: 50px;border-radius: 50%;height: 50px; display: -webkit-box;display: -moz-box;display: -ms-flexbox;display: -webkit-flex;display: flex;text-align: center;background-color:rgba(255,255,255,0.15);justify-content: center;
align-items: center;">
                                <a href="https://www.q8store.co/email/images/whats.png">
                                    <img src="https://www.q8store.co/email/images/whats.png" alt="" style="margin: auto; max-height: 100%;">
                                </a>
                            </div>
                            <div>
                                <h2 style="margin: 10px 0; line-height: 1;"><a href="https://api.whatsapp.com/send?phone={{$get_social_medial['phone']}}" target="_blank" style="color: #fff; font-size: 14px; font-weight: 500; text-decoration: none !important;">التواصل عبر</a></h2>
                                <p style="color: #fff; font-size: 18px; font-weight: 700;margin-top: 0;">الواتساب</p>
                            </div>

                        </div>
                    </td>
                </tr>
                </tbody></table>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px 20px;background-color: #d8d8d8; " class="td_padding">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="right">
                        <a href="https://apps.apple.com/us/app/%D8%A7%D9%84%D9%83%D9%88%D9%8A%D8%AA%D9%8A%D9%87-%D8%B3%D8%AA%D9%88%D8%B1/id1556395578" class="img-logo" style="text-decoration: none !important;">
                            <img src="https://www.q8store.co/email/images/AppleStore.png" alt="" STYLE=" height: 100%;">
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.ict.alkuwaitiyastore" class="img-logo" style="text-decoration: none !important;">
                            <img src="https://www.q8store.co/email/images/GooglePlay.png" alt="" STYLE=" height: 100%;">
                        </a>
                    </td>
                    <td align="left">
                        <a href="{{$get_social_medial['facebook']}}" class="img-logo" style="text-decoration: none !important; margin-left: 5px;">
                            <img src="https://www.q8store.co/email/images/f.png"  alt="">
                        </a>
                        <a href="{{$get_social_medial['youtube']}}" class="img-logo" style="text-decoration: none !important; margin-left: 5px;" >
                            <img src="https://www.q8store.co/email/images/y.png"  alt="">
                        </a>

                        <a href="{{$get_social_medial['instagram']}}" class="img-logo" style="text-decoration: none !important; margin-left: 5px;">
                            <img src="https://www.q8store.co/email/images/insta.png"  alt="">
                        </a>
                        <a href="{{$get_social_medial['twitter']}}" class="img-logo" style="text-decoration: none !important; margin-left: 5px;">
                            <img src="https://www.q8store.co/email/images/tw.png"  alt="">
                        </a>
                        <a href="{{$get_social_medial['telegram']}}" class="img-logo" style="text-decoration: none !important; margin-left: 5px;">
                            <img src="https://www.q8store.co/email/images/tel.png"  alt="">
                        </a>
                        <a href="{{$get_social_medial['snapchat']}}" class="img-logo" style="text-decoration: none !important; margin-left: 5px;">
                            <img src="https://www.q8store.co/email/images/snap.png"  alt="">
                        </a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>