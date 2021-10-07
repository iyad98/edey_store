<style type="text/css">
    table {
        width: 100%;
    }

    table, td, th {
        border: 1px solid #ddd;
        text-align: center;
    }

    th, td {
        padding: 0 15px;
        text-align: center;
        vertical-align: middle;
    }

    .right-box {
        width: 50%;
        display: inline-block;
        float: right;
    }

    .right-box table {
        border: none;
        margin-bottom: 15px;
        text-align: center;
    }

    .right-box th, .right-box td {
        padding: 0 15px;
        text-align: right;
        vertical-align: middle;
        font-size: 14px;
    }

    #wc-print-button {
        float: left;
        background-color: #a00;
        color: #fff;
        padding: 5px 25px;
    }

    #woocommerce-order-items .woocommerce_order_items_wrapper table.woocommerce_order_items {
        width: 100%;
        background: #fff;
        font-size: 14px;
    }

    #woocommerce-order-items .wc-order-totals {
        font-size: 14px;
    }

    h1, h2, h3, h4, h5, h6, .ls__2 {
        font-size: 16px;
        line-height: 30px;
        margin: 0;
    }

    #order_data {
        margin: 15px 0;
    }

    .tax_ {
        position: absolute;
        left: 15px;
        top: 60px;
        font-size: 12px;
        font-weight: bold;
    }

    .tax_ p {
        margin: 0;
    }
</style>


<!doctype html>
<html lang="ar">
<head>
    <title>طباعة طلب</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://alfowzan.com/wp-content/themes/alfowzan/style.css">
    <link rel="stylesheet" href="https://alfowzan.com/wp-content/themes/alfowzan/rtl.css">
    <link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">
    <style type="text/css">
        body {
            direction: rtl;
            text-align: right;
            font-family: 'Cairo', sans-serif;
        }

        #woocommerce-order-items .wc-order-totals {
            float: left;
            width: 50%;
            margin: 0;
            padding: 0;
            text-align: left;
        }

        #woocommerce-order-items .woocommerce_order_items_wrapper table.woocommerce_order_items {
            width: 100%;
            background: #fff;
        }

        .addresss {
            padding-right: 15px;
            margin-top: 60px;
            margin-top: 100px;
        }

        .addresss p {
            margin: 0;
            font-size: 15px;

        }
    </style>
</head>
<!-- onload="window.print()" -->
<body data-rsssl=1  onload="window.print()">
<div class="panel-wrap woocommerce">
    <div style=" min-height: 80px;    margin-bottom: 34px;" id="order_data" class="panel ">
        <h2 style="top: 40px;position: relative;">رقم الفاتورة: {{$order->id}}</h2>
        <p style="top: 20px;position: relative;margin-bottom:20ox"><span
                    style='font-weight:bold;'>تاريخ الفاتورة :</span>
            </strong><span
                    style='    direction: ltr;text-align: left;display: inline-block;'>{{$order->created_at}}</span></p>
        <span style=" position: absolute;left: 0;top: 20px;display: block;text-align: center;width: 100%;">
	                                            <img style=" max-width: 200px;"
                                                     src="{{url('')}}/admin_assets/assets/demo/default/media/img/logo/logo-1.png"
                                                     alt="متجر الفوزان" class="img-responsive">
                                	    </span>
        {{--<div class="tax_">--}}
            {{--<p>رقم التسجيل الضريبي</p>--}}
            {{--<p>300047185700003</p>--}}
        {{--</div>--}}
    </div>
    <div class="right-box">

        <table>
            <tr>
                <td>اسم العميل</td>
                <td>{{$order->bill_name}} </td>
            </tr>
            <tr>
                <td>البريد الإلكتروني</td>
                <td><a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                       data-cfemail="f29f9d818693869acbc3b2959f939b9edc919d9f">{{$order->bill_email}}</a></td>
            </tr>
            <tr>
                <td>الجوال</td>
                <td style="direction: ltr;">{{$order->bill_phone}}</td>
            </tr>
            <tr>
                <td>العنوان - المدينة</td>
                <td>{{$order->order_user_shipping->country . " - ".($order->order_user_shipping->city && $order->order_user_shipping->shipping_city ?  $order->order_user_shipping->shipping_city->name : "")." - ".$order->order_user_shipping->address}} </td>
            </tr>
        </table>
    </div>
    <div class="right-box">
        <table>
            <tr>
                <td>تاريخ الطلب</td>
                <td>{{$order->created_at}}</td>
            </tr>
            <tr>
                <td>حالة الطلب</td>
                <td>{{$order->status_text}}</td>
            </tr>
            <tr>
                <td>بوليصة الشحن</td>
                <td>{{$order->shipping_policy}}</td>
            </tr>
            <tr>
                <td>وسيلة الدفع</td>
                <td>{{$order->payment_method->name}}</td>
            </tr>
        </table>
    </div>
</div>
<div id="woocommerce-order-items" class="postbox ">
    <div class="woocommerce_order_items_wrapper wc-order-items-editable">
        <table cellpadding="0" cellspacing="0" class="woocommerce_order_items">
            <tr>
                <th width="40%">اسم المنتج</th>
                <th width="10%">SKU</th>
                <th width="10%">السعر</th>
                <th width="10%">الكمية</th>
                <th width="20%">الإجمالي</th>
            </tr>
            @foreach($order->order_products as $order_product)
                <tr>
                    <td>
                        {{$order_product->product->name}} <br>
                        <span>{{implode(" - " , $order_product->product_attribute_values__->pluck('name')->toArray())}}</span>

                    </td>
                    <td >{{$order_product->product_variation ? $order_product->product_variation->sku : '' }}</td>

                    <td>{{$order_product->price." ".get_currency()}}</td>
                    <td>
                        <small class="times">×</small>
                        {{$order_product->quantity}}
                    </td>

                    <td>{{$order_product->total_price." ".get_currency()}}</td>
                </tr>
            @endforeach

        </table>
    </div>
    <div class="wc-order-data-row wc-order-totals-items wc-order-items-editable">
        <table class="wc-order-totals">
            <tbody>
            <tr>
                <td class="label">{{trans('admin.order_price_before_discount')}}</td>
                <td class="total" width="20%">
                    <span class="woocommerce-Price-amount amount">{{$order->price}}<span
                                class="woocommerce-Price-currencySymbol">{{get_currency()}}</span></span></td>
            </tr>

            @foreach($order->admin_discounts as $admin_discount)
                <tr>
                    <td scope="row" style="direction: ltr">{{trans('api.admin_discount' , ['discount_rate' => $admin_discount->discount_rate])}}
                    </td>
                    <td>
                        -<span class="woocommerce-Price-amount amount">{{$admin_discount->price}}
                            &nbsp;<span
                                    class="woocommerce-Price-currencySymbol">{{get_currency()}}</span></span>
                    </td>
                </tr>
            @endforeach

            @if($order->first_order_discount >= 0)
                <tr>
                    <td class="label">{{trans('admin.first_order_discount')}}</td>
                    <td class="total" width="40%"><span class="woocommerce-Price-amount amount">{{"-".$order->first_order_discount}}<span
                                    class="woocommerce-Price-currencySymbol">{{get_currency()}}</span></span></td>
                </tr>
            @endif
            @if($order->package_discount_price >= 0)
                <tr>
                    <td class="label">
                        {{trans('admin.package_discount') . " ( " . ($order->package && $order->package->package ? $order->package->package->name : '') ." ) "}}
                        <br>
                        @if($order->package && $order->package->free_shipping == 1)
                            <small>{{trans('admin.package_free_shipping')}}</small>
                        @endif
                    </td>
                    <td class="total" width="40%"><span class="woocommerce-Price-amount amount"> {{"-".$order->package_discount_price }}<span
                                    class="woocommerce-Price-currencySymbol">{{get_currency()}}</span></span></td>
                </tr>
            @endif

            @foreach($order->coupon as $coupon)
                <tr>
                    <td scope="row">{{trans('admin.coupon')}}
                        ( <span>{{$coupon->coupon_code}}</span> )
                    </td>
                    <td>
                        -<span class="woocommerce-Price-amount amount">{{$coupon->coupon_price}}
                            &nbsp;<span
                                    class="woocommerce-Price-currencySymbol">{{get_currency()}}</span></span>
                    </td>
                </tr>
            @endforeach



            <tr>
                <td class="label">{{trans('admin.price_after_discount_coupon')}}</td>
                <td class="total" width="40%"><span class="woocommerce-Price-amount amount">{{$order->price_after_discount_coupon}}<span
                                class="woocommerce-Price-currencySymbol">{{get_currency()}}</span></span></td>
            </tr>

            <tr>
                <td class="label">{{trans('admin.shipping')}} </td>
                <td class="total" width="40%"><span class="woocommerce-Price-amount amount">
				    {{$order->shipping}}<span class="woocommerce-Price-currencySymbol">{{get_currency()}}</span></span></td>
            </tr>

            <tr>
                <td class="label">{{trans('admin.cash_fees')}}</td>
                <td class="total" width="40%"><span class="woocommerce-Price-amount amount">{{$order->cash_fees}}<span
                                class="woocommerce-Price-currencySymbol">{{get_currency()}}</span></span></td>
            </tr>

            <tr>
                <td class="label">{{trans('admin.price_before_tax')}}</td>
                <td class="total" width="40%"><span class="woocommerce-Price-amount amount">{{$order->price_before_tax}}<span
                                class="woocommerce-Price-currencySymbol">{{get_currency()}}</span></span></td>
            </tr>

            <tr>
                <td class='label' style="direction: ltr">{{trans('api.tax_text' , ['tax' => $order->tax_percentage])}}</td>
                <td><span class="woocommerce-Price-amount amount">{{$order->tax}}&nbsp;<span
                                class="woocommerce-Price-currencySymbol">{{get_currency()}}</span></span></td>
            </tr>

            <tr>
                <td class="label">إجمال الفاتورة المطلوبة من العميل:</td>
                <td class="total" width="40%"><span class="woocommerce-Price-amount amount">{{$order->total_price}}<span
                                class="woocommerce-Price-currencySymbol">{{get_currency()}}</span></span></td>
            </tr>

            </tbody>
        </table>
        <div class="clear"></div>

    </div>
    <div class="addresss">
        <p><strong>الادارة: </strong>{{$place}}</p>
        <p>
            <strong>هاتف: </strong>  {{$phone}}
        </p>
        <p>
            <strong>البريد الإلكتروني: </strong> <a href="#" class="__cf_email__"
                                                    data-cfemail="b1d2c4c2c5dedcd4c3d2d0c3d4f1d0ddd7dec6cbd0df9fd2dedc">{{$email}}</a>
        </p>

    </div>
</div>
</body>
</html>