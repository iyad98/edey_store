<!DOCTYPE html>
<html>
<head>
    <title>q8store Email</title>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="telephone=no" name="format-detection" />
    <title></title>
    <style type="text/css" data-premailer="ignore">
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
    </style>
    <?php
    app()->setLocale(isset($_lang_) ? $_lang_ : 'ar');
    $lang = app()->getLocale();
    $get_social_medial = get_social_medial_urls();
    ?>

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

        @media screen and (max-width: 400px), screen and (max-device-width: 400px) {
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
<body style="margin: 0; padding: 0; background-color: #ffffff; direction: rtl; text-align: right;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="width:100%; max-width:650px; margin:auto; background-color: #fff;">
    <tr>
        <td style="padding: 20px 20px;" class="td_padding">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="right">
                        <a href="https://www.q8store.co/" target="_blank" class="img-logo">
                            <img src="https://www.q8store.co/website_v2/email_assets/logo.png" alt="">
                        </a>
                    </td>
                    {{--<td align="left">--}}
                        {{--<p><a href="https://www.q8store.co/" target="_blank" style="display: inline-block; color: #1A1818; font-size:12px; font-weight: 600; text-decoration: none;">https://www.q8store.co</a></p>--}}
                    {{--</td>--}}
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="padding: 30px 20px; background-color: #E81F34;" class="td_padding">
            <img src="https://www.q8store.co/website_v2/email_assets/send.png" alt="" style="text-align: center; margin:auto; display: table;">
            <h2 style="color: #ffffff; font-size: 24px; font-weight: 700; text-align: center;">{{trans('website.thank_you_for_order' , [] , isset($_lang_) ? $_lang_ : 'ar' )}}</h2>
            <p style="color: #ffffff; font-size: 15px;">{!! $get_new_text !!}</p>


        </td>
    </tr>
    <tr>
        <td style="padding: 30px 20px; margin-top: 0;" class="td_padding">
            <h2 style="color: #000000; font-size: 20px; font-weight: 700;">رقم الطلب: <span style="display: inline-block; color: #E81F34;">#{{$order->id}} ({{$order->created_at}})</span></h2>
            <table width="100%" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th style="background-color: rgba(0,0,0,0.04); color: #262626; font-size: 18px; font-weight: 700; padding: 10px 10px;">المنتج</th>
                    <th style="background-color: rgba(0,0,0,0.04); color: #262626; font-size: 18px; font-weight: 700; padding: 10px 10px;">الكمية</th>
                    <th style="background-color: rgba(0,0,0,0.04); color: #262626; font-size: 18px; font-weight: 700; padding: 10px 10px; text-align: left;">السعر</th>
                </tr>
                </thead>
                <tbody>

                @foreach($order->order_products as $order_product)
                    <TR>
                    <tr>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;"> {{$order_product->product->name}} @if($order_product->attribute_values && $order_product->attribute_values->count() > 0)
                                <span> ( {{implode(" - " , $order_product->product_attribute_values__->pluck('name')->toArray())}}
                                    ) </span>
                            @endif
                        </td>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;">  {{$order_product->quantity}} </td>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px; text-align: left;"> {{$order_product->total_price}}</td>
                    </tr>

                @endforeach


                <tr>
                    <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;">{{trans('website.total_original_price')}}</td>
                    <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;"></td>
                    <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px; text-align: left;"> {{$order->price }}</td>
                </tr>

                @foreach($order->admin_discounts as $admin_discount)
                    @if($admin_discount->price)
                        <tr>
                            <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;">{{trans('api.admin_discount' , ['discount_rate' => $admin_discount->discount_rate])}}</td>
                            <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;"></td>
                            <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;text-align: left;">{{"-".$admin_discount->price }}</td>
                        </tr>
                    @endif
                @endforeach

                @if($order->first_order_discount > 0)
                    <tr>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;">
                                {{trans('admin.first_order_discount')}}
                        </td>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;"></td>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;text-align: left;">
                            {{"-".$order->first_order_discount }}
                        </td>
                    </tr>
                @endif

                @if($order->package_discount_price > 0)
                    <tr>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;">
                            {{trans('admin.package_discount') . " ( " . ($order->package && $order->package->package ? $order->package->package->name : '') ." ) "}}</b>
                            @if($order->package && $order->package->free_shipping == 1)
                                <small>{{trans('admin.package_free_shipping')}}</small>
                            @endif
                        </td>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;"></td>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;text-align: left;">
                            {{"-".$order->package_discount_price }}
                        </td>
                    </tr>
                @endif


                @foreach($order->coupon as $coupon)
                    <tr>
                        <td
                            style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;">
                                {{trans('admin.coupon_value')}}
                                (
                                <span>{{$coupon->coupon_code}}</span>
                                )
                        </td>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;"></td>

                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;text-align: left;">
                            {{"-".$coupon->coupon_price }}
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td
                        style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;">
                          {{trans('website.total_after_discount')}}
                    </td>
                    <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;"></td>

                    <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px; text-align: left;">
                        {{$order->price_after_discount_coupon}}
                    </td>
                </tr>
                <tr>
                    <td
                        style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;">
                            {{trans('admin.shipping')." ". ( $order->shipping_text )}}
                    </td>
                    <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;"></td>
                    <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;text-align: left;">
                        {{$order->shipping }}
                    </td>
                </tr>
                @if($order->cash_fees != 0)
                    <tr>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;">

                                {{trans('admin.cash_fees')}}
                        </td>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;"></td>
                        <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;text-align: left;">
                            {{$order->cash_fees }}
                        </td>
                    </tr>
                @endif

                <tr >
                    <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;">
                        {{trans('api.tax_text' , ['tax' => $order->tax_percentage])}}
                    </td>
                    <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;">
                    </td>
                    <td style="padding: 8px 10px; color: #262626; font-weight: 700; font-size: 16px;text-align: left;">
                        {{$order->tax}}
                    </td>
                </tr>



                </tbody>
            </table>
            <table width="100%" cellpadding="0" cellspacing="0" style="border-top:1px solid #DEDEDE; margin-top: 10px;">
                <tr>
                    <td align="right" style="padding: 15px 0;">
                        <h2 style="color: #22262A; font-size: 26px; font-weight: 700; margin:0;">الإجمالي</h2>
                    </td>
                    <td align="left" style="padding: 15px 0;">
                        <p style="color: #E92036; font-size: 26px; font-weight: 700; margin:0;">
                            {{$order->total_price ." ".$order->currency->symbol}}
                        </p>
                    </td>
                </tr>
            </table>
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
                <tr>
                    <td style="padding: 15px 10px; background-color: #F5F5F5;">
                        <h2 style="margin: 0; color: #1A1818; font-size: 18px; font-weight: 700;"> {{trans('website.shipping_company')}}:<span style="color: #E81F34; display: inline-block; margin-right: 10px;">{{$order->company_shipping ? $order->company_shipping->shipping_company_name : ""}}</span></h2>
                    </td>
                </tr>
            </table>
            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
                <tr>
                    <td width="50%" style="background-color: #F5F5F5; vertical-align: top; border-left: 5px solid #ffffff;">
                        <div style="height: 100%;  padding: 15px 10px;">
                            <?php
                            $city = $order->order_user_shipping ? $order->order_user_shipping->shipping_city : null;
                            $country = $city ? $city->country : null;
                            ?>

                            <h2 style="margin: 0 0 10px; font-weight: 700; color: #000000; font-size: 18px;"> {{trans('website.bill_address')}}</h2>
                            <p style="margin: 0; color: #000000; font-size: 15px;">{{$order->order_user_shipping->street }}، {{$order->order_user_shipping->avenue }}، {{$order->order_user_shipping->building_number }}</p>
                            <p style="margin: 0; color: #000000; font-size: 15px;">{{$order->order_user_shipping->phone }}</p>
                            <p style="margin: 0; color: #000000; font-size: 15px;">{{$order->order_user_shipping->email }}</p>
                            <p style="margin: 0; color: #000000; font-size: 15px;">{{$order->order_user_shipping->first_name . " ".$order->order_user_shipping->last_name}}</p>
                            <p style="margin: 0; color: #000000; font-size: 15px;">{{$country ? $country->name : ""}}</p>
                            <p style="margin: 0; color: #000000; font-size: 15px;">{{$city ? $city->name : ""}}</p>
                        </div>
                    </td>
                    <td width="50%" style="background-color: #F5F5F5; vertical-align: top; border-right: 5px solid #ffffff;">
                        <div style="height: 100%; padding: 15px 10px;">
                            <h2 style="margin: 0 0 10px; font-weight: 700; color: #000000; font-size: 18px;">{{trans('website.shipping_address')}}</h2>
                            <p style="margin: 0; color: #000000; font-size: 15px;">{{$order->order_user_shipping->first_name . " ".$order->order_user_shipping->last_name}}</p>
                            <p style="margin: 0; color: #000000; font-size: 15px;">{{$order->order_user_shipping && $order->order_user_shipping->shipping_city ? $order->order_user_shipping->shipping_city->name : ""}}</p>
                            <p style="margin: 0; color: #000000; font-size: 15px;">{{$order->order_user_shipping->phone}}</p>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    {{--<tr>--}}
        {{--<td style="padding: 30px 50px; background-color: #EDEEEF;" class="td_padding">--}}
            {{--<h2 style="text-align: center; color: #000000; font-size: 22px; font-weight: 700; margin-bottom: 30px;">عروض مميزة</h2>--}}
            {{--<table width="100%" cellpadding="0" cellspacing="0">--}}
                {{--<tr>--}}
                    {{--<td style="padding: 0 10px;">--}}
                        {{--<div class="item_product" style="margin-bottom: 30px;">--}}
                            {{--<a href="#" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; text-align: center; background-color: #ffffff; border-radius: 5px; overflow: hidden; height: 150px;">--}}
                                {{--<img src="assets/product.png" alt="" style="margin: auto; max-height: 100%;">--}}
                            {{--</a>--}}
                            {{--<h2 style="margin: 10px 0; line-height: 1;"><a href="#" style="color: #6D6F72; font-size: 16px; font-weight: 700; text-decoration: none !important;">طقم أواني طهي من الألومنيوم بطبقة مانعة للالتصاق</a></h2>--}}
                            {{--<p style="margin:0">--}}
                                {{--<img src="assets/star_ch.png">--}}
                                {{--<img src="assets/star_ch.png">--}}
                                {{--<img src="assets/star_ch.png">--}}
                                {{--<img src="assets/star_ch.png">--}}
                                {{--<img src="assets/star.png">--}}
                            {{--</p>--}}
                        {{--</div>--}}
                    {{--</td>--}}
                    {{--<td style="padding: 0 10px;">--}}
                        {{--<div class="item_product" style="margin-bottom: 30px;">--}}
                            {{--<a href="#" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; text-align: center; background-color: #ffffff; border-radius: 5px; overflow: hidden; height: 150px;">--}}
                                {{--<img src="assets/product.png" alt="" style="margin: auto; max-height: 100%;">--}}
                            {{--</a>--}}
                            {{--<h2 style="margin: 10px 0; line-height: 1;"><a href="#" style="color: #6D6F72; font-size: 16px; font-weight: 700; text-decoration: none !important;">طقم أواني طهي من الألومنيوم بطبقة مانعة للالتصاق</a></h2>--}}
                            {{--<p style="margin:0">--}}
                                {{--<img src="assets/star_ch.png">--}}
                                {{--<img src="assets/star_ch.png">--}}
                                {{--<img src="assets/star_ch.png">--}}
                                {{--<img src="assets/star_ch.png">--}}
                                {{--<img src="assets/star.png">--}}
                            {{--</p>--}}
                        {{--</div>--}}
                    {{--</td>--}}
                    {{--<td style="padding: 0 10px;">--}}
                        {{--<div class="item_product" style="margin-bottom: 30px;">--}}
                            {{--<a href="#" style="display: -webkit-box; display: -moz-box; display: -ms-flexbox; display: -webkit-flex; display: flex; text-align: center; background-color: #ffffff; border-radius: 5px; overflow: hidden; height: 150px;">--}}
                                {{--<img src="assets/product.png" alt="" style="margin: auto; max-height: 100%;">--}}
                            {{--</a>--}}
                            {{--<h2 style="margin: 10px 0; line-height: 1;"><a href="#" style="color: #6D6F72; font-size: 16px; font-weight: 700; text-decoration: none !important;">طقم أواني طهي من الألومنيوم بطبقة مانعة للالتصاق</a></h2>--}}
                            {{--<p style="margin:0">--}}
                                {{--<img src="assets/star_ch.png">--}}
                                {{--<img src="assets/star_ch.png">--}}
                                {{--<img src="assets/star_ch.png">--}}
                                {{--<img src="assets/star_ch.png">--}}
                                {{--<img src="assets/star.png">--}}
                            {{--</p>--}}
                        {{--</div>--}}
                    {{--</td>--}}
                {{--</tr>--}}
            {{--</table>--}}
        {{--</td>--}}
    {{--</tr>--}}
    {{--<tr>--}}
        {{--<td style="padding: 20px 70px;" class="td_padding">--}}
            {{--<table width="100%" cellpadding="0" cellspacing="0">--}}
                {{--<tr>--}}
                    {{--<td>--}}
                        {{--<div style="float: right;" class="float_none">--}}
                            {{--<h3 style="color:#1A1818; font-size: 18px; font-weight: 700; margin: 0;">لا تفوت العروض قبل فوات الأوان</h3>--}}
                            {{--<p style="color: #1A1818; font-size: 14px; margin: 10px 0 0;">%خصومات تصل حتى 50</p>--}}
                        {{--</div>--}}
                        {{--<a href="#" class="float_none" style="background-color: #1A1818; color: #FFD400; border-radius:5px; text-decoration: none; padding: 10px 30px; display: inline-block; float: left; margin-top: 10px;">% احصل على خصم</a>--}}
                    {{--</td>--}}
                {{--</tr>--}}
            {{--</table>--}}
        {{--</td>--}}
    {{--</tr>--}}
    <tr>
        <td style="padding: 0 70px;" class="td_padding">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <div style="padding: 20px 0; border-top:1px solid rgba(112,112,112,0.14);">
                            <p style="margin-top: 0; color: #000000; font-size: 16px;">لمزيد من المعلومات ، قم بزيارة<a href="https://www.q8store.co/" target="_blank" style="display: inline-block; color: #E81F34; text-decoration: none; font-weight: 700; margin: 0 2px;">الكويتية ستور </a>أو تواصل عبر <a href="mailto:{{$get_social_medial['email']}}" style="display: inline-block; color: #E81F34; text-decoration: none; font-weight: 700; margin: 0 2px;" target="_blank">البريد الإلكتروني </a>مباشرة</p>
                            <div class="social_block" style="display: table; margin: auto;">
                                <a href="{{$get_social_medial['facebook']}}" target="_blank" style="margin-right: 5px; float: left;"><img src="https://www.q8store.co/website_v2/email_assets/facebook.png" alt=""></a>
                                <a href="{{$get_social_medial['twitter']}}" target="_blank" style="margin-right: 5px; float: left;"><img src="https://www.q8store.co/website_v2/email_assets/twitter.png" alt=""></a>
                                <a href="{{$get_social_medial['instagram']}}" target="_blank" style="margin-right: 5px; float: left;"><img src="https://www.q8store.co/website_v2/email_assets/instgram.png" alt=""></a>
                                <a href="{{$get_social_medial['snapchat']}}" target="_blank" style="margin-right: 0; float: left;"><img src="https://www.q8store.co/website_v2/email_assets/snapchat.png" alt=""></a>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>