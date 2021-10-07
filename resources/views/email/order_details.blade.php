<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
$lang = isset($_lang_) ? $_lang_ : 'ar';
app()->setLocale($lang);
$get_social_medial = get_social_medial_urls();
?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;"/>
    <title>Mamnon</title>

    <style type="text/css">
        body {
            width: 100%;
            background-color: #7a7a7a;
            margin: 0;
            padding: 0;
            direction: rtl;
            -webkit-font-smoothing: antialiased;
            mso-margin-top-alt: 0px;
            mso-margin-bottom-alt: 0px;
            mso-padding-alt: 0px 0px 0px 0px;
        }

        p,
        h1,
        h2,
        h3,
        h4 {
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
        }

        span.preheader {
            display: none;
            font-size: 1px;
        }

        html {
            width: 100%;
        }

        table {
            font-size: 12px;
            border: 0;
        }

        .menu-space {
            padding-right: 25px;
        }

        table {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        tr,
        td {
            margin: 0;
            padding: 0;
            direction: rtl;
        }

        @media only screen and (max-width: 640px) {
            body {
                width: auto !important;
            }

            body[yahoo] .main {
                width: 440px !important;
            }

            body[yahoo] .two-left {
                width: 420px !important;
                margin: 0px auto;
            }

            body[yahoo] .full {
                width: 100% !important;
                margin: 0px auto;
            }

            body[yahoo] .alaine {
                text-align: center;
            }

            body[yahoo] .menu-space {
                padding-right: 0px;
            }

            body[yahoo] .banner {
                width: 438px !important;
            }

            body[yahoo] .menu {
                width: 438px !important;
                margin: 0px auto;
                border-bottom: #e1e0e2 solid 1px;
            }

            body[yahoo] .date {
                width: 438px !important;
                margin: 0px auto;
                text-align: center;
            }

            body[yahoo] .two-left-inner {
                width: 400px !important;
                margin: 0px auto;
            }

            body[yahoo] .menu-icon {
                display: block;
            }

            body[yahoo] .two-left-menu {
                text-align: center;
            }
        }

        @media only screen and (max-width: 479px) {
            body {
                width: auto !important;
            }

            body[yahoo] .main {
                width: 310px !important;
            }

            body[yahoo] .two-left {
                width: 300px !important;
                margin: 0px auto;
            }

            body[yahoo] .full {
                width: 100% !important;
                margin: 0px auto;
            }

            body[yahoo] .alaine {
                text-align: center;
            }

            body[yahoo] .menu-space {
                padding-right: 0px;
            }

            body[yahoo] .banner {
                width: 308px !important;
            }

            body[yahoo] .menu {
                width: 308px !important;
                margin: 0px auto;
                border-bottom: #e1e0e2 solid 1px;
            }

            body[yahoo] .date {
                width: 308px !important;
                margin: 0px auto;
                text-align: center;
            }

            body[yahoo] .two-left-inner {
                width: 280px !important;
                margin: 0px auto;
            }

            body[yahoo] .menu-icon {
                display: none;
            }

            body[yahoo] .two-left-menu {
                width: 310px !important;
                margin: 0px auto;
            }
        }
    </style>


</head>

<body yahoo="fix" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<!--Main Table Start-->

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#7a7a7a"
       style="background:#F7F7F7;-ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; margin-bottom: 0px; margin-left: 0px; margin-right: 0px; margin-top: 0px; padding-bottom: 0px; padding-left: 0px; padding-right: 0px; padding-top: 0px; font-family: Tahoma;">
    <tr>
        <td align="center" valign="top">

            <!--Header Start-->

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"
                   dir="{{isset($_lang_) && $_lang_ == 'ar' ? 'rtl' : 'ltr' }}">
                <tr>
                    <td align="center" valign="top">
                        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                            <tr>
                                <td align="left" valign="top" bgcolor="#242323"
                                    style="background: #242323 height:530px;">
                                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="100%" border="0" align="right" cellpadding="0"
                                                       cellspacing="0" class="full">
                                                    <tr>
                                                        <td align="left" valign="top" bgcolor="#e20048"
                                                            style="background:#e20048;">

                                                            <table width="100%" border="0" align="right" cellpadding="0"
                                                                   cellspacing="0" class="full">
                                                                <tr>
                                                                    <td align="center" valign="top" bgcolor="#FFFFFF"
                                                                        style="background:#F7F7F7; width: 100%;padding: 15px;">
                                                                        <a href="#"><img editable="true" mc:edit="logo"
                                                                                         src="http://67.205.147.150/admin_assets/assets/demo/default/media/img/logo/logo-1.png"
                                                                                         width="165" height="" alt=""
                                                                                         style="display:block;"/></a>
                                                                    </td>
                                                                </tr>
                                                            </table>

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    <!--
                                                                                    <tr>
                                                                                        <td height="190" align="center" valign="top" style="line-height:190px; background: #FFFFFF;"><img src="{{url('')}}/email/images/register.png" width="auto" height="100%" alt="" style="display:block;" /></td>
                                                                                    </tr>
                                        -->
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="700" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" class="main">
                                                    <tr>
                                                        <td align="left" valign="middle" bgcolor="#e20048"
                                                            style="background:#e20048; height:150px;">
                                                            <table width="100%" border="0" align="center"
                                                                   cellpadding="0"
                                                                   cellspacing="0">

                                                                <tr>
                                                                    <td align="center" valign="top"
                                                                        style=" font-size:30px; color:#FFF; line-height:30px; font-weight:bold;  width: 100%"
                                                                        mc:edit="twitter-text">
                                                                        <multiline
                                                                                style="font-family: Arial;padding:40px;">
                                                                            {{trans('website.thank_you_for_order' , [] , isset($_lang_) ? $_lang_ : 'ar' )}}
                                                                        </multiline>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td align="right" valign="top" bgcolor="#FFFFFF"
                                                style="background:#ffffff;">
                                                <table width="615" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" class="two-left-inner">

                                                    <tbody>
                                                    <tr>
                                                        <td align="left" valign="top">

                                                            <table width="100%" border="0" align="left" cellpadding="0"
                                                                   cellspacing="0">

                                                                <tbody>
                                                                <tr>
                                                                    <br>
                                                                    <td align="right" valign="top"
                                                                        style="font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:56px; color:#161616; font-weight:normal;"
                                                                        mc:edit="text-title">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="right" valign="top"
                                                                        style="font-family: Arial; font-size:17px; color:#4b4b4b; line-height:28px; font-weight:normal; padding:20px 0px;"
                                                                        mc:edit="text-inner">
                                                                        <multiline>
                                                                            @if(false)
                                                                                شكرا على طلبك, انه قيد الانتظار حتى
                                                                                يتم التحقق من دخول المبلغ إلى حسابنا.
                                                                                وفي
                                                                                الوقت نفسه, هذا تذكير بما طلبته


                                                                            @endif
                                                                            @if(true)
                                                                                <p style="direction: rtl">{!! $get_new_text !!}</p>
                                                                            @endif
                                                                            <h3 style="margin-top: 20px; font-weight:bold; color: #e20048;">
                                                                                {{trans('website.order_number')}}
                                                                                :#{{$order->id}}
                                                                                ({{$order->created_at}})</h3>
                                                                            <TABLE BORDER="2"
                                                                                   style="width: 100%; font-size:15px"
                                                                                   BORDERCOLOR="#EBEBEB">
                                                                                <TR>
                                                                                    <TD style="padding: 10px 20px;">
                                                                                        <b>{{trans('website.product')}}</b>
                                                                                    </TD>
                                                                                    <TD style="padding: 10px 20px;">
                                                                                        <b>{{trans('website.quantity')}}</b>
                                                                                    </TD>
                                                                                    <TD style="padding: 10px 20px;">
                                                                                        <b>{{trans('website.price')}}</b>
                                                                                    </TD>
                                                                                </TR>
                                                                                <TR>
                                                                                @foreach($order->order_products as $order_product)
                                                                                    <TR>
                                                                                        <TD style="padding: 10px 20px;">
                                                                                            {{$order_product->product->name}}
                                                                                            <br>
                                                                                            @if($order_product->attribute_values && $order_product->attribute_values->count() > 0)
                                                                                                <span> ( {{implode(" - " , $order_product->product_attribute_values__->pluck('name')->toArray())}}
                                                                                                    ) </span>
                                                                                            @endif

                                                                                        </TD>
                                                                                        <TD style="padding: 10px 20px;">
                                                                                            {{$order_product->quantity}}
                                                                                        </TD>
                                                                                        <TD style="padding: 10px 20px;">
                                                                                            {{$order_product->total_price." ".$order->currency->symbol}}
                                                                                        </TD>
                                                                                    </TR>
                                                                                @endforeach

                                                                                <tr align="right"
                                                                                    style="padding:20px 0px;">
                                                                                    <th colspan="2"
                                                                                        style="padding: 10px 20px;">
                                                                                        <b>{{trans('website.total_original_price')}}</b>
                                                                                    </th>
                                                                                    <td style="padding: 10px 20px;">
                                                                                        {{$order->price . " ".$order->currency->symbol}}
                                                                                    </td>
                                                                                </tr>

                                                                                @foreach($order->admin_discounts as $admin_discount)
                                                                                    @if($admin_discount->price)
                                                                                        <tr align="right"
                                                                                            style="padding:20px 0px;">
                                                                                            <th colspan="2"
                                                                                                style="padding: 10px 20px;direction: ltr">
                                                                                                <b>
                                                                                                    {{trans('api.admin_discount' , ['discount_rate' => $admin_discount->discount_rate])}}
                                                                                                </b>
                                                                                            </th>
                                                                                            <td style="padding: 10px 20px;">
                                                                                                {{"-".$admin_discount->price . " ".$order->currency->symbol}}
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endif
                                                                                @endforeach
                                                                                @if($order->first_order_discount > 0)
                                                                                    <tr align="right"
                                                                                        style="padding:20px 0px;">
                                                                                        <th colspan="2"
                                                                                            style="padding: 10px 20px;">
                                                                                            <b>
                                                                                                {{trans('admin.first_order_discount')}}
                                                                                            </b>
                                                                                        </th>
                                                                                        <td style="padding: 10px 20px;">
                                                                                            {{"-".$order->first_order_discount . " ".$order->currency->symbol}}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif

                                                                                @if($order->package_discount_price > 0)
                                                                                    <tr align="right"
                                                                                        style="padding:20px 0px;">
                                                                                        <th colspan="2"
                                                                                            style="padding: 10px 20px;">
                                                                                            <b>{{trans('admin.package_discount') . " ( " . ($order->package && $order->package->package ? $order->package->package->name : '') ." ) "}}</b>

                                                                                            <br>
                                                                                            @if($order->package && $order->package->free_shipping == 1)
                                                                                                <small>{{trans('admin.package_free_shipping')}}</small>
                                                                                            @endif
                                                                                        </th>
                                                                                        <td style="padding: 10px 20px;">
                                                                                            {{"-".$order->package_discount_price . " ".$order->currency->symbol}}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif


                                                                                @foreach($order->coupon as $coupon)
                                                                                    <tr align="right"
                                                                                        style="padding:20px 0px;">
                                                                                        <th colspan="2"
                                                                                            style="padding: 10px 20px;">
                                                                                            <b>

                                                                                                {{trans('admin.coupon_value')}}
                                                                                                (
                                                                                                <span>{{$coupon->coupon_code}}</span>
                                                                                                )
                                                                                            </b>
                                                                                        </th>
                                                                                        <td style="padding: 10px 20px;">
                                                                                            {{"-".$coupon->coupon_price . " ".$order->currency->symbol}}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach


                                                                                <tr align="right"
                                                                                    style="padding:20px 0px;">
                                                                                    <th colspan="2"
                                                                                        style="padding: 10px 20px;">
                                                                                        <b>{{trans('website.total_after_discount')}}</b>
                                                                                    </th>
                                                                                    <td style="padding: 10px 20px;">
                                                                                        {{$order->price_after_discount_coupon. " ".$order->currency->symbol}}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr align="right"
                                                                                    style="padding:20px 0px;">
                                                                                    <th colspan="2"
                                                                                        style="padding: 10px 20px;"><b>
                                                                                            {{trans('admin.shipping')." ". ( $order->shipping_text )}}
                                                                                        </b></th>
                                                                                    <td style="padding: 10px 20px;">
                                                                                        {{$order->shipping ." ".$order->currency->symbol}}
                                                                                    </td>
                                                                                </tr>
                                                                                @if($order->cash_fees != 0)
                                                                                    <tr align="right"
                                                                                        style="padding:20px 0px;">
                                                                                        <th colspan="2"
                                                                                            style="padding: 10px 20px;">
                                                                                            <b>
                                                                                                {{trans('admin.cash_fees')}}
                                                                                            </b></th>
                                                                                        <td style="padding: 10px 20px;">
                                                                                            {{$order->cash_fees ." ".$order->currency->symbol}}
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                                <tr align="right"
                                                                                    style="padding:20px 0px;">
                                                                                    <th colspan="2"
                                                                                        style="padding: 10px 20px;direction: ltr">
                                                                                        <b>
                                                                                            {{trans('api.tax_text' , ['tax' => $order->tax_percentage])}}
                                                                                        </b></th>
                                                                                    <td style="padding: 10px 20px;">

                                                                                        {{$order->tax." ".$order->currency->symbol}}
                                                                                    </td>
                                                                                </tr>
                                                                                <tr align="right"
                                                                                    style="padding:20px 0px;">
                                                                                    <th colspan="2"
                                                                                        style="padding: 10px 20px;">
                                                                                        <b>{{trans('website.total_price')}}

                                                                                        </b></th>
                                                                                    <td style="padding: 10px 20px;">
                                                                                        {{$order->total_price ." ".$order->currency->symbol}}
                                                                                    </td>
                                                                                </tr>
                                                                                </TR>
                                                                            </TABLE>
                                                                            <h5 style="margin-top: 40px; font-weight:normal; color: #e20048;">
                                                                                {{trans('website.shipping_company')}}:
                                                                                <span>{{$order->company_shipping ? $order->company_shipping->shipping_company_name : ""}}</span>
                                                                            </h5>

                                                                            <TABLE BORDER="2"
                                                                                   style="width: 100%; font-size:15px"
                                                                                   BORDERCOLOR="#EBEBEB">

                                                                                <TR>
                                                                                    <COLGROUP>
                                                                                        <TH align="right"
                                                                                            style="padding: 10px 20px; border: none;font-weight:bold; color: #e20048; font-size:20px;">
                                                                                            {{trans('website.bill_address')}}
                                                                                        </TH>
                                                                                        <TH align="right"
                                                                                            style="padding: 10px 20px; border: none;font-weight:bold; color: #e20048; font-size:20px;">
                                                                                            {{trans('website.shipping_address')}}
                                                                                        </TH>
                                                                                    </COLGROUP>
                                                                                </TR>
                                                                                <TR>
                                                                                    <TD style="padding: 10px 20px;">
                                                                                        <?php
                                                                                        $city = $order->order_user_shipping ? $order->order_user_shipping->shipping_city : null;
                                                                                        $country = $city ? $city->country : null;
                                                                                        ?>
                                                                                        <i>{{$order->order_user_shipping->first_name . " ".$order->order_user_shipping->last_name}}</i><br>
                                                                                        <i>{{$country ? $country->name : ""}}</i><br>
                                                                                        <i>{{$city ? $city->name : ""}}</i><br>
                                                                                        <i>{{$order->order_user_shipping->address}}</i><br>
                                                                                        <i style="direction: ltr">{{$order->order_user_shipping->phone}}</i><br>
                                                                                        <i><a href="mailto:ah@ah.com">{{$order->order_user_shipping->email}}</a></i>
                                                                                        @if(!empty($order->order_user_shipping->billing_national_address))
                                                                                            <li class="woocommerce-customer-details">
                                                                                                {{trans('website.national_address')}}
                                                                                                : {{$order->order_user_shipping->billing_national_address}}</li>
                                                                                        @endif

                                                                                        @if(!empty($order->order_user_shipping->billing_building_number))
                                                                                            <li class="woocommerce-customer-details">
                                                                                                {{trans('website.building_number')}}
                                                                                                : {{$order->order_user_shipping->billing_building_number}}</li>
                                                                                        @endif

                                                                                        @if(!empty($order->order_user_shipping->billing_postalcode_number))
                                                                                            <li class="woocommerce-customer-details">
                                                                                                {{trans('website.postalcode_number')}}
                                                                                                : {{$order->order_user_shipping->billing_postalcode_number}}</li>
                                                                                        @endif

                                                                                        @if(!empty($order->order_user_shipping->billing_unit_number))
                                                                                            <li class="woocommerce-customer-details">
                                                                                                {{trans('website.unit_number')}}
                                                                                                : {{$order->order_user_shipping->billing_unit_number}}</li>
                                                                                        @endif

                                                                                        @if(!empty($order->order_user_shipping->billing_extra_number))
                                                                                            <li class="woocommerce-customer-details">
                                                                                                {{trans('website.extra_number')}}
                                                                                                : {{$order->order_user_shipping->billing_extra_number}}</li>
                                                                                        @endif
                                                                                    </TD>
                                                                                    <TD style="padding: 10px 20px;">
                                                                                        <i>{{$order->order_user_shipping->first_name . " ".$order->order_user_shipping->last_name}}</i><br>
                                                                                        <i>{{$order->order_user_shipping && $order->order_user_shipping->shipping_city ? $order->order_user_shipping->shipping_city->name : ""}}</i><br>
                                                                                        <i style="direction: ltr">{{$order->order_user_shipping->phone}}</i><br>
                                                                                    </TD>
                                                                                </TR>

                                                                            </TABLE>

                                                                            <h5 style="margin-top: 40px; font-weight:normal; color: #e20048;">
                                                                                {{trans('website.look_to_execute_order')}}
                                                                            </h5>
                                                                        </multiline>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!--Header End-->


            <!--Welcome text Start-->

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" valign="top">
                        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                            <tr>
                                <td align="left" valign="top" bgcolor="#ffffff" style="background:#ffffff;">
                                    <table width="580" border="0" align="center" cellpadding="0" cellspacing="0"
                                           class="two-left-inner">
                                        <tr>
                                            <td align="center" valign="top">
                                                <table width="100%" border="0" align="center" cellpadding="0"
                                                       cellspacing="0">
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <table width="200" border="0" align="center" cellpadding="0"
                                                                   cellspacing="0">
                                                                <tr>
                                                                    <td align="center" valign="top"
                                                                        style="font-family:Arial, Helvetica, sans-serif; font-size:22px; color:#e20048; font-weight:normal; padding-bottom:14px; padding-top:8px;"
                                                                        mc:edit="get-in-touch">
                                                                        <multiline><a href="#"
                                                                                      style="color: #e20048;">{{trans('website.raq_shop')}}</a>
                                                                        </multiline>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!--Welcome text End-->


            <!--Copyright part Start-->

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center" valign="top">
                        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                            <tr>
                                <td align="left" valign="top" bgcolor="#e20048" style="background:#e20048;">
                                    <table width="610" border="0" align="center" cellpadding="0" cellspacing="0"
                                           class="two-left-inner">
                                        <tr>
                                            <td align="left" valign="top">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top">

                                                <table border="0" align="right" cellpadding="0" cellspacing="0"
                                                       class="two-left-inner">
                                                    <tr>
                                                        <td align="center" valign="top"
                                                            style="font-family: Tahoma;font-size:14px; color:#FFF; line-height:24px; font-weight:normal;"
                                                            mc:edit="copyright">
                                                            <multiline>{{trans('website.copyright')}} {{carbon\Carbon::now()->year}}
                                                            </multiline>
                                                        </td>
                                                    </tr>
                                                </table>

                                                <table border="0" align="left" cellpadding="0" cellspacing="0"
                                                       class="two-left-inner">
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <table width="155" border="0" align="center" cellpadding="0"
                                                                   cellspacing="0">
                                                                <tr>
                                                                    <td align="center" valign="middle">
                                                                        <table width="100%" border="0" align="center"
                                                                               cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td align="center" valign="middle">
                                                                                    <a target="_blank" href="{{$get_social_medial['facebook']}}"><img editable="true"
                                                                                                     mc:edit="facebook"
                                                                                                     src="{{url('')}}/email/images/facebook.png"
                                                                                                     width="26"
                                                                                                     height="26" alt=""
                                                                                                     style="display:block;"/></a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td align="center" valign="middle">
                                                                        <table width="100%" border="0" align="center"
                                                                               cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td align="center" valign="middle">
                                                                                    <a target="_blank" href="{{$get_social_medial['twitter']}}" ><img editable="true"
                                                                                                     mc:edit="twitter"
                                                                                                     src="{{url('')}}/email/images/twitter.png"
                                                                                                     width="26"
                                                                                                     height="26" alt=""
                                                                                                     style="display:block;"/></a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    {{--<td align="center" valign="middle">--}}
                                                                        {{--<table width="100%" border="0" align="center"--}}
                                                                               {{--cellpadding="0" cellspacing="0">--}}
                                                                            {{--<tr>--}}
                                                                                {{--<td align="center" valign="middle">--}}
                                                                                    {{--<a target="_blank" href="{{$get_social_medial['twitter']}}"><img editable="true"--}}
                                                                                                     {{--mc:edit="google-plus"--}}
                                                                                                     {{--src="{{url('')}}/email/images/google-plus.png"--}}
                                                                                                     {{--width="26"--}}
                                                                                                     {{--height="26" alt=""--}}
                                                                                                     {{--style="display:block;"/></a>--}}
                                                                                {{--</td>--}}
                                                                            {{--</tr>--}}
                                                                        {{--</table>--}}
                                                                    {{--</td>--}}
                                                                    <td align="center" valign="middle">
                                                                        <table width="100%" border="0" align="center"
                                                                               cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td align="center" valign="middle">
                                                                                    <a target="_blank" href="{{$get_social_medial['youtube']}}" ><img editable="true"
                                                                                                     mc:edit="youtube"
                                                                                                     src="{{url('')}}/email/images/you-tube.png"
                                                                                                     width="26"
                                                                                                     height="26" alt=""
                                                                                                     style="display:block;"/></a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td align="center" valign="middle">
                                                                        <table width="100%" border="0" align="center"
                                                                               cellpadding="0" cellspacing="0">
                                                                            <tr>
                                                                                <td align="center" valign="middle">
                                                                                    <a target="_blank" href="mailto:{{$get_social_medial['email']}}"><img editable="true"
                                                                                                     mc:edit="dribbble"
                                                                                                     src="{{url('')}}/email/images/gmail.png"
                                                                                                     width="26"
                                                                                                     height="26" alt=""
                                                                                                     style="display:block;"/></a>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>

                                                    </tr>
                                                </table>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top">&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!--Copyright part End-->

        </td>
    </tr>
</table>
{{app()->setLocale('ar')}}

<!--Main Table End-->

</body>

</html>

<style>
    table td {
        direction: rtl !important;
    }
</style>
