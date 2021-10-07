<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8">
    <link rel="pingback" href="xmlrpc.php">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{url('')}}/website/wp-content/themes/mamnonfashion/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{url('')}}/website/wp-content/themes/mamnonfashion/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="{{url('')}}/website/wp-content/themes/mamnonfashion/css/font-awesome.css">
    <link rel="stylesheet"
          href="{{url('')}}/website/wp-content/themes/mamnonfashion/css/font-stroke/css/font-stroke.min.css">
    <link rel="stylesheet" href="{{url('')}}/website/wp-content/themes/mamnonfashion/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,600,700,900&subset=arabic" rel="stylesheet">
    <link rel="stylesheet" href="{{url('')}}/website/wp-content/themes/mamnonfashion/css/style.css">
    <link rel="stylesheet" href="{{url('')}}/website/wp-content/themes/mamnonfashion/style.css">
    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="f3bfd642b150640c57931bb2-text/javascript">
        document.documentElement.className = document.documentElement.className + ' yes-js js_active js'

    </script>
    <title>
        @yield('title')
    </title>
    <link rel='dns-prefetch' href='//cdn.jsdelivr.net'/>
    <link rel='dns-prefetch' href='//s.w.org'/>
    <script type="f3bfd642b150640c57931bb2-text/javascript">
        window._wpemojiSettings = {
            "baseUrl": "https:\/\/s.w.org\/images\/core\/emoji\/12.0.0-1\/72x72\/",
            "ext": ".png",
            "svgUrl": "https:\/\/s.w.org\/images\/core\/emoji\/12.0.0-1\/svg\/",
            "svgExt": ".svg",
            "source": {
                "concatemoji": "https:\/\/mamnonfashion.com\/wp-includes\/js\/wp-emoji-release.min.js?ver=5.3.2"
            }
        };
        ! function(e, a, t) {
            var r, n, o, i, p = a.createElement("canvas"),
                s = p.getContext && p.getContext("2d");

            function c(e, t) {
                var a = String.fromCharCode;
                s.clearRect(0, 0, p.width, p.height), s.fillText(a.apply(this, e), 0, 0);
                var r = p.toDataURL();
                return s.clearRect(0, 0, p.width, p.height), s.fillText(a.apply(this, t), 0, 0), r === p.toDataURL()
            }

            function l(e) {
                if (!s || !s.fillText) return !1;
                switch (s.textBaseline = "top", s.font = "600 32px Arial", e) {
                    case "flag":
                        return !c([127987, 65039, 8205, 9895, 65039], [127987, 65039, 8203, 9895, 65039]) && (!c([55356, 56826, 55356, 56819], [55356, 56826, 8203, 55356, 56819]) && !c([55356, 57332, 56128, 56423, 56128, 56418, 56128, 56421, 56128, 56430, 56128, 56423, 56128, 56447], [55356, 57332, 8203, 56128, 56423, 8203, 56128, 56418, 8203, 56128, 56421, 8203, 56128, 56430, 8203, 56128, 56423, 8203, 56128, 56447]));
                    case "emoji":
                        return !c([55357, 56424, 55356, 57342, 8205, 55358, 56605, 8205, 55357, 56424, 55356, 57340], [55357, 56424, 55356, 57342, 8203, 55358, 56605, 8203, 55357, 56424, 55356, 57340])
                }
                return !1
            }

            function d(e) {
                var t = a.createElement("script");
                t.src = e, t.defer = t.type = "text/javascript", a.getElementsByTagName("head")[0].appendChild(t)
            }
            for (i = Array("flag", "emoji"), t.supports = {
                    everything: !0,
                    everythingExceptFlag: !0
                }, o = 0; o < i.length; o++) t.supports[i[o]] = l(i[o]), t.supports.everything = t.supports.everything && t.supports[i[o]], "flag" !== i[o] && (t.supports.everythingExceptFlag = t.supports.everythingExceptFlag && t.supports[i[o]]);
            t.supports.everythingExceptFlag = t.supports.everythingExceptFlag && !t.supports.flag, t.DOMReady = !1, t.readyCallback = function() {
                t.DOMReady = !0
            }, t.supports.everything || (n = function() {
                t.readyCallback()
            }, a.addEventListener ? (a.addEventListener("DOMContentLoaded", n, !1), e.addEventListener("load", n, !1)) : (e.attachEvent("onload", n), a.attachEvent("onreadystatechange", function() {
                "complete" === a.readyState && t.readyCallback()
            })), (r = t.source || {}).concatemoji ? d(r.concatemoji) : r.wpemoji && r.twemoji && (d(r.twemoji), d(r.wpemoji)))
        }(window, document, window._wpemojiSettings);

    </script>
    <style type="text/css">
        img.wp-smiley,
        img.emoji {
            display: inline !important;
            border: none !important;
            box-shadow: none !important;
            height: 1em !important;
            width: 1em !important;
            margin: 0 .07em !important;
            vertical-align: -0.1em !important;
            background: none !important;
            padding: 0 !important;
        }
    </style>
    <link rel='stylesheet' id='wp-block-library-rtl-css'
          href='{{url('')}}/website/wp-includes//css/dist/block-library/style-rtl.min.css?ver=5.3.2' type='text/css'
          media='all'/>
    <link rel='stylesheet' id='jquery-selectBox-css'
          href='{{url('')}}/website/wp-content//plugins/yith-woocommerce-wishlist/assets/css/jquery.selectBox.css?ver=1.2.0'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='yith-wcwl-font-awesome-css'
          href='{{url('')}}/website/wp-content//plugins/yith-woocommerce-wishlist/assets/css/font-awesome.min.css?ver=4.7.0'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='yith-wcwl-main-css'
          href='{{url('')}}/website/wp-content//plugins/yith-woocommerce-wishlist/assets/css/style.css?ver=3.0.6'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='woocommerce-layout-rtl-css'
          href='{{url('')}}/website/wp-content//plugins/woocommerce/assets/css/woocommerce-layout-rtl.css?ver=3.5.7'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='woocommerce-smallscreen-rtl-css'
          href='{{url('')}}/website/wp-content//plugins/woocommerce/assets/css/woocommerce-smallscreen-rtl.css?ver=3.5.7'
          type='text/css' media='only screen and (max-width: 768px)'/>
    <link rel='stylesheet' id='woocommerce-general-rtl-css'
          href='{{url('')}}/website/wp-content//plugins/woocommerce/assets/css/woocommerce-rtl.css?ver=3.5.7'
          type='text/css' media='all'/>
    <style id='woocommerce-inline-inline-css' type='text/css'>
        .woocommerce form .form-row .required {
            visibility: visible;
        }
    </style>
    <link rel='stylesheet' id='woocommerce_prettyPhoto_css-rtl-css'
          href='//mamnonfashion.com/wp-content/plugins/woocommerce/assets/css/prettyPhoto-rtl.css?ver=5.3.2'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='tawcvs-frontend-css'
          href='{{url('')}}/website/wp-content//plugins/variation-swatches-for-woocommerce/assets/css/frontend.css?ver=20200222'
          type='text/css' media='all'/>
    <link rel='stylesheet' id='js_composer_front-css'
          href='{{url('')}}/website/wp-content//plugins/js_composer/assets/css/js_composer.min.css?ver=5.6'
          type='text/css' media='all'/>
    <script type="f3bfd642b150640c57931bb2-text/javascript"
            src='{{url('')}}/website/wp-includes//js/jquery/jquery.js?ver=1.12.4-wp'></script>
    <script type="f3bfd642b150640c57931bb2-text/javascript"
            src='{{url('')}}/website/wp-includes//js/jquery/jquery-migrate.min.js?ver=1.4.1'></script>
    <script type="f3bfd642b150640c57931bb2-text/javascript"
            src='{{url('')}}/website/wp-content//plugins/woocommerce/assets/js/jquery-blockui/jquery.blockUI.min.js?ver=2.70'></script>
    <script type="f3bfd642b150640c57931bb2-text/javascript">
        /*
        																		<![CDATA[ */
        var wc_add_to_cart_params = {
            "ajax_url": "\/wp-admin\/admin-ajax.php",
            "wc_ajax_url": "\/?wc-ajax=%%endpoint%%",
            "i18n_view_cart": "\u0639\u0631\u0636 \u0627\u0644\u0633\u0644\u0629",
            "cart_url": "https:\/\/mamnonfashion.com\/cart\/",
            "is_cart": "",
            "cart_redirect_after_add": "no"
        };
        /* ]]> */

    </script>
    <script type="f3bfd642b150640c57931bb2-text/javascript"
            src='{{url('')}}/website/wp-content//plugins/woocommerce/assets/js/frontend/add-to-cart.min.js?ver=3.5.7'></script>
    <script type="f3bfd642b150640c57931bb2-text/javascript">
        /*
        																		<![CDATA[ */
        var wc_additional_variation_images_local = {
            "ajax_url": "\/?wc-ajax=%%endpoint%%",
            "ajaxImageSwapNonce": "3b663b1254",
            "gallery_images_class": ".product .images .flex-control-nav, .product .images .thumbnails",
            "main_images_class": ".woocommerce-product-gallery",
            "lightbox_images": ".product .images a.zoom",
            "custom_swap": "",
            "custom_original_swap": "",
            "custom_reset_swap": "",
            "bwc": ""
        };
        /* ]]> */

    </script>
    <script type="f3bfd642b150640c57931bb2-text/javascript"
            src='{{url('')}}/website/wp-content//plugins/woocommerce-additional-variation-images/assets/js/variation-images-frontend.js?ver=5.3.2'></script>
    <script type="f3bfd642b150640c57931bb2-text/javascript"
            src='{{url('')}}/website/wp-content//plugins/js_composer/assets/js/vendors/woocommerce-add-to-cart.js?ver=5.6'></script>
    <link rel='https://api.w.org/' href='wp-json/'/>
    <link rel="EditURI" type="application/rsd+xml" title="RSD" href="xmlrpc.php?rsd"/>
    <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="{{url('')}}/website/wp-includes/wlwmanifest.xml"/>
    <link rel="stylesheet" href="{{url('')}}/website/wp-content/themes/mamnonfashion/rtl.css" type="text/css"
          media="screen"/>
    <link rel="canonical" href=""/>
    <link rel='shortlink' href=''/>
    <link rel="alternate" type="application/json+oembed"
          href="wp-json/oembed/1.0/embed?url=https%3A%2F%2Fmamnonfashion.com%2F"/>
    <link rel="alternate" type="text/xml+oembed"
          href="wp-json/oembed/1.0/embed?url=https%3A%2F%2Fmamnonfashion.com%2F&#038;format=xml"/>


    @stack('css')
    <noscript>
        <style>
            .woocommerce-product-gallery {
                opacity: 1 !important;
            }
        </style>
    </noscript>
    <meta name="generator" content="Powered by WPBakery Page Builder - drag and drop page builder for WordPress."/>
    <!--[if lte IE 9]>
    <link rel="stylesheet" type="text/css"
          href="{{url('')}}/website/wp-content/plugins/js_composer/assets/css/vc_lte_ie9.min.css" media="screen">
    <![endif]-->
    <link rel="icon" href="{{url('')}}/website/wp-content/upload/nlogo.png" sizes="32x32"/>
    <link rel="icon" href="{{url('')}}/website/wp-content/upload/nlogo.png" sizes="192x192"/>
    <link rel="apple-touch-icon-precomposed" href="{{url('')}}/website/wp-content/upload/nlogo.png"/>
    <meta name="msapplication-TileImage" content="{{url('')}}/website/wp-content/upload/nlogo.png"/>
    <style type="text/css" id="wp-custom-css">
        .jas-service .content p {
            color: #878787;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 5px;
        }

        .owl-stage-outer {
            height: 100%;
            min-width: 100%
        }

        .owl-carousel .owl-stage {
            height: 100%;
            min-width: 100%;
        }

        .owl-carousel {
            display: block;
        }

        .wpb_animate_when_almost_visible {
            opacity: 1;
        }

        .woocommerce .product-image img {
            max-height: 300px;
            width: auto;
            height: auto !important;
        }

        .product-image {
            min-height: 300px;
        }

        .owl-carousel.owl-baners .owl-item .has_mobile img.mobile-img,
        .has_mobile img.mobile-img {
            display: none;
        }

        .owl-carousel.owl-baners .owl-item img {
            width: 100%;
        }

        @media screen and (max-width: 500px) {
            .owl-carousel.owl-baners .owl-item .has_mobile img,
            .has_mobile img {
                display: none;
            }

            .owl-carousel.owl-baners .owl-item .has_mobile img.mobile-img,
            .has_mobile img.mobile-img {
                display: block;
            }
        }

        .woocommerce-tabs {
            display: none !important
        }

        #booking_now .modal-content {
            position: relative;
            background-color: transparent;
            -webkit-background-clip: padding-box;
            background-clip: padding-box;
            border: 0;
            border: 0;
            border-radius: 6px;
            outline: 0;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
        }

        button.close {
            -webkit-appearance: none;
            padding: 0;
            cursor: pointer;
            background: 0 0;
            position: absolute;
            z-index: 5;
            top: -22px;
            right: -22px;
            color: #fff;
            box-shadow: none;
            opacity: 1;
            font-size: 12px;
            font-weight: normal;
            width: 20px;
            height: 20px;
            text-align: center;
            line-height: 17px;
            border: 1px solid #fff;
            border-radius: 100%;
            text-shadow: none;
        }

        button.close:hover {
            background-color: #efb61c;
            border-color: #efb61c;
        }

        .holder {
            width: 30%;
        }

        .woocommerce-product-gallery__image img,
        .woocommerce-product-gallery__wrapper img {
        }

        /*
---------------------------------------------
preloader
---------------------------------------------
*/

        .loader-wrapper {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            right: 0px;
            bottom: 0px;
            z-index: 99999;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
        }

        .loader-wrapper .loader5 {
            position: absolute;
            top: 50%;
            left: 40%;
            margin-left: 10%;
            transform: translate3d(-50%, -50%, 0);
        }

        .loader-wrapper .loader5 .dot {
            width: 12px;
            height: 12px;
            background: #f06274;
            border-radius: 100%;
            display: inline-block;
            animation: slide 1.2s infinite;
        }

        .loader-wrapper .loader5 .dot:nth-child(1) {
            animation-delay: 0.1s;
            background: #f06274;
        }

        .loader-wrapper .loader5 .dot:nth-child(2) {
            animation-delay: 0.2s;
            background: #f06274;
        }

        .loader-wrapper .loader5 .dot:nth-child(3) {
            animation-delay: 0.3s;
            background: #f06274;
        }

        @-moz-keyframes slide {
            0% {
                transform: scale(1);
            }
            50% {
                opacity: 0.3;
                transform: scale(2);
            }
            100% {
                transform: scale(1);
            }
        }

        @-webkit-keyframes slide {
            0% {
                transform: scale(1);
            }
            50% {
                opacity: 0.3;
                transform: scale(2);
            }
            100% {
                transform: scale(1);
            }
        }

        @-o-keyframes slide {
            0% {
                transform: scale(1);
            }
            50% {
                opacity: 0.3;
                transform: scale(2);
            }
            100% {
                transform: scale(1);
            }
        }

        @keyframes slide {
            0% {
                transform: scale(1);
            }
            50% {
                opacity: 0.3;
                transform: scale(2);
            }
            100% {
                transform: scale(1);
            }
        }

        /* -------------- */

        .woocommerce-checkout-payment {
            margin-bottom: 25px;
        }

        .page-header,
        .woocommerce-shipping-destination {
            display: none;
        }

        .product-title {
            min-height: 65px;
            padding-top: 0;
            font-size: 14px;
            line-height: 1.5;
        }

        .product-title a {
            font-size: 14px;
        }

        .jas-col-md-3 .product-image img,
        .owl-carousel .owl-item .jas-col-md-3 .product-image img {
            height: 300px;
        }

        .woocommerce .woocommerce-breadcrumb a:after {
            display: none
        }

        .upsells.products {
            margin-top: 60px;
        }

        .right--img {
            float: right;
        }

        .img--sm {
            border: 1px solid #d0d0d0;
        }

        .img--sm > img {
            width: 140px;
        }

        .left--componet {
            margin-right: 150px;
            margin-top: 10px;
        }

        .left--componet > h2 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .product-name {
            vertical-align: middle;
        }

        form.cart {
            position: relative;
            display: block;
        }

        .woocommerce div.product div.summary {
            padding: 0;
        }

        .p-t-row {
            padding: 0;
        }

        .pt-salary {
            margin-bottom: 1.3em;
        }

        .woocommerce-shipping-totals .woocommerce-shipping-destination {
            color: transparent !important;
            position: relative;
        }

        .woocommerce-shipping-totals .woocommerce-shipping-destination:after {
            content: '';
            position: absolute;
            right: 0;
            height: 100%;
            background-color: #fff;
            color: #222;
            min-height: 26px;
            min-width: 274px;
            top: -3px;
        }

        .woocommerce ul.woocommerce-mini-cart li {
            min-height: 60px;
            margin: 0 0 5px;
            padding: 0;
        }

        .woocommerce ul.woocommerce-mini-cart li:hover a.remove {
            opacity: 1;
        }

        .woocommerce .jas-mini-cart a.remove,
        .widget_shopping_cart a.remove {
            border-radius: 0;
            margin: 0;
            left: auto;
        }

        .woocommerce ul.cart_list li img,
        .woocommerce ul.product_list_widget li img {
            width: 60px;
            height: 60px;
        }

        .woocommerce ul.cart_list li a,
        .woocommerce ul.product_list_widget li a {
            font-weight: 400;
        }

        .copy-right {
            font-size: 17px;
        }

        .footer-title {
            margin-bottom: 30px;
            font-size: 16px;
        }

        footer .payment img {
            margin-bottom: 15px;
        }

        .cart .chp {
            float: none;
            font-size: 24px;
            color: #222;
            padding: 0 4px;
        }

        .top-menu {
            margin-top: 30px;
        }

        .top-links {
            padding-top: 30px;
        }

        .tags-list > ul > li > a {
            font-size: 16px;
            font-weight: 600;
            color: #222;
            padding: 18px 12px;
        }

        .logo img {
            max-height: 75px;
        }

        .woocommerce div.product div.images.woocommerce-product-gallery {
            position: relative;
            overflow: hidden;
        }

        .woocommerce div.product div.images .woocommerce-product-gallery__trigger {
            position: absolute;
            top: 3.5em;
        }

        .woocommerce div.product div.images .flex-control-thumbs {
            margin-left: -5px !important;
            margin-right: -5px !important;
            display: inline-block;
            width: 20%;
        }

        .rtl.woocommerce div.product div.images .flex-control-thumbs li {
            float: none;
            display: block;
            text-align: center;
            width: 100%;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            padding: 0 !important;
        }

        .woocommerce div.product div.images .flex-control-thumbs li img {
            cursor: pointer;
            opacity: .5;
            margin: 0;
            max-height: 155px;
        }

        .flex-viewport {
            direction: ltr;
            width: 78%;
            float: left;
            margin-right: 2%;
        }

        woocommerce .woocommerce-breadcrumb a {
            padding: 0 2px;
        }

        .woocommerce .woocommerce-breadcrumb a:after {
            content: "";
        }

        .branches p {
            color: #000;
            margin-bottom: 5px !important;
            font-size: 14px;
            font-weight: 700;
            padding-right: 20px;
            position: relative;
        }

        .main-title-box {
            padding: 25px 0 15px;
        }

        .main-title-box h5 {
            color: #f06274;
            font-size: 18px;
            font-weight: 600;
        }

        .ui-state-default,
        .ui-widget-content .ui-state-default,
        .ui-widget-header .ui-state-default {
            border: 1px solid #e86173;
            background: #e86173 !important;
        }

        .ui-widget-header {
            background: #e86173 !important;
        }

        .branches .item {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fbfbfb;
            border: 1px solid #f1f1f1;
            background: #fbfbfb;
            min-height: 190px;
        }

        .block-content p {
            line-height: 24px;
            margin: 0 0 3px;
            padding: 0 46px 0 0;
            position: relative;
            height: 48px;
        }

        .block-content p:before {
            -webkit-transition: all .2s ease-out;
            -moz-transition: all .2s ease-out;
            -o-transition: all .2s ease-out;
            transition: all .2s ease-out;
            position: absolute;
            width: 34px;
            height: 34px;
            right: 0;
            top: -5px;
            text-align: center;
            border: 1px solid #bababa;
            -webkit-border-radius: 100%;
            -moz-border-radius: 100%;
            border-radius: 100%;
            display: inline-block;
            font: normal normal normal 14px/1 FontAwesome;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            transform: translate(0, 0);
            line-height: 34px;
            font-size: 17px;
            content: "\f041";
        }

        .block-content p.c-email:before {
            content: "\f003";
        }

        .block-content p.c-phone:before {
            content: "\f10b";
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #f06274;
        }

        #ninja_forms_required_items,
        .nf-field-container {
            margin-bottom: 5px;
        }

        .page-header h1 {
            color: #fff;
        }

        .woocommerce #respond input#submit.alt,
        .woocommerce a.button.alt,
        .woocommerce button.button.alt,
        .woocommerce input.button.alt {
            background-color: #f06274;
        }

        .woocommerce .coupon button.button {
            padding: 1em 1em;
        }

        @media screen and (max-width: 991px) {
            .top-banner .wpb_column {
                width: 100%;
                float: none;
            }
        }

        @media screen and (max-width: 768px) {
            .vertical-img-right.wpgis-slider-for {
                width: 100%;
                float: none;
                margin-right: 0;
            }

            .slick-slider {
                width: 100%;
                float: none
            }

            #wpgis-gallery .slick-slide img {
                height: 84px;
                margin: 5px;
                border: 1px solid #ccc;
            }

            #wpgis-gallery .slick-slide {
                border: none;
                margin-left: 5px;
            }

            .page-header h1 {
                font-size: 20px;
            }

            .woocommerce .woocommerce-breadcrumb a {
                font-size: 9px;
            }
        }
    </style>
    <style type="text/css" data-type="vc_shortcodes-custom-css">
        .vc_custom_1535308882892 {
            margin-right: 0px !important;
            margin-bottom: 50px !important;
            margin-left: 0px !important;
        }

        .vc_custom_1576484932228 {
            padding-top: 15px !important;
            padding-bottom: 15px !important;
            background-color: #f9f9f9 !important;
        }

        .vc_custom_1550395846203 {
            padding-top: 15px !important;
            padding-bottom: 15px !important;
            background-color: #f9f9f9 !important;
        }

        .vc_custom_1550395860403 {
            padding-top: 15px !important;
            padding-bottom: 15px !important;
            background-color: #f9f9f9 !important;
        }

        .vc_custom_1550133785255 {
            padding-top: 30px !important;
            padding-bottom: 30px !important;
        }

        .vc_custom_1550135334819 {
            padding-top: 15px !important;
            padding-bottom: 15px !important;
            background-color: #f9f9f9 !important;
        }

        .vc_custom_1574152056277 {
            margin-right: 0px !important;
            margin-left: 0px !important;
            padding-right: 0px !important;
            padding-left: 0px !important;
        }

        .vc_custom_1522772331263 {
            padding-right: 0px !important;
            padding-left: 0px !important;
        }

        .vc_custom_1550133769980 {
            margin-top: 15px !important;
            margin-bottom: 15px !important;
        }

        .vc_custom_1550133760849 {
            margin-top: 15px !important;
            margin-bottom: 15px !important;
        }

        .vc_custom_1550133752876 {
            margin-top: 15px !important;
            margin-bottom: 15px !important;
        }

        .vc_custom_1550133742502 {
            margin-top: 15px !important;
            margin-bottom: 15px !important;
        }

        .vc_custom_1550484470205 {
            padding-right: 0px !important;
            padding-left: 0px !important;
        }

        .vc_custom_1555225513550 {
            margin-top: 20px !important;
            margin-bottom: 15px !important;
        }
        .hidden {
            display: none!important;
        }
    </style>
    <noscript>
        <style type="text/css">
            .wpb_animate_when_almost_visible {
                opacity: 1;
            }
        </style>
    </noscript>
</head>

<body class="rtl home page-template-default page page-id-27781 woocommerce woocommerce-no-js wpb-js-composer js-comp-ver-5.6 vc_responsive">
<div class="loader-wrapper">
    <div class="loader5">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
</div>
<div class="mask-overlay hidden"></div>
<div id="yith-wcwl-popup-message" style="margin-left: -103px;display: none; ">
    <div id="yith-wcwl-message">تم إضافة المنتج!</div>
</div>
<div class="jas-mini-cart jas-push-menu" id="get-cart-data">
    <div class="jas-mini-cart-content">
        <h3 class="mg__0 tc cw bgb tu ls__2">سلة المشتريات
            <i class="close-cart pe-7s-close pa" @click="hide_cart_data"></i>
        </h3>
        <div class="widget_shopping_cart_content">

            <ul class="woocommerce-mini-cart cart_list product_list_widget ">
                <li class="woocommerce-mini-cart-item mini_cart_item" v-for="product in cart_data.products">
                    <a :href="'{{LaravelLocalization::localizeUrl('products')}}/'+(product.id)+'?cart_product_id='+(product.cart_product_id)" class="remove remove_from_cart_button" aria-label="إزالة هذا المنتج"
                       data-product_id="28545" data-cart_item_key="c5d7d6e73f02dfc4428838d322447078"
                       data-product_sku="B13B00134"></a> <a
                            :href="'{{LaravelLocalization::localizeUrl('products')}}/'+(product.id)+'?cart_product_id='+(product.cart_product_id)">
                        <img width="500" height="692" :src="product.image"
                             class="attachment-woocommerce_thumbnail size-woocommerce_thumbnail" alt=""> @{{ product.name }}</a>
                    <span class="quantity"> @{{ product.quantity }} × <span class="woocommerce-Price-amount amount" > @{{ product.price }}<span
                                    class="woocommerce-Price-currencySymbol">@{{ cart_data.currency }}</span></span></span></li>
            </ul>

            <p class="woocommerce-mini-cart__total total"><strong>المجموع بعد الخصم :</strong> <span
                        class="woocommerce-Price-amount amount" > @{{ total_price }}<span
                            class="woocommerce-Price-currencySymbol" >@{{ cart_data.currency }}</span></span></p>


            <p class="woocommerce-mini-cart__buttons buttons"><a href="{{LaravelLocalization::localizeUrl('cart')}}"
                                                                 class="button wc-forward">عرض السلة</a><a
                        href="{{LaravelLocalization::localizeUrl('checkout')}}" class="button checkout wc-forward">إتمام الطلب</a>
            </p>


        </div>
    </div>
</div>
<div id="search" >
    <div class="overlay-close"></div>
    <div class="center-screen ">
        <form class="form_search">
            <div class="form-group">
                <button type="button" class="search_product_button search_submit "><i class="fa fa-search" aria-hidden="true"></i>
                </button>
                <input id="search_product_input" type="text" class="form-control" placeholder="البحث">
            </div>
        </form>
    </div>
</div>
<div class="mobile-menu">
    <div class="menu-mobile">
        <div class="brand-area">
            <a href="{{url('')}}/website/" title="متجر ممنون لملابس الأطفال">
                <img src="{{url('')}}/website/wp-content/upload/nlogo.png"
                     alt="متجر ممنون لملابس الأطفال" class="img-responsive">
            </a>
        </div>
        <div class="mmenu">
            <ul id="menu-%d8%a7%d9%84%d8%b1%d8%a6%d9%8a%d8%b3%d9%8a%d8%a9" class="">
                <li id="menu-item-27803"
                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-27781 current_page_item menu-item-27803">
                    <a href="{{url('')}}/website/" aria-current="page">الرئيسية</a>
                </li>
                <li id="menu-item-7039"
                    class="mega-menu menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-has-children menu-item-7039">
                    <a href="{{url('')}}/website/product-category/%d8%a8%d9%86%d8%a7%d8%aa%d9%8a/">بناتي</a>
                    <ul class="sub-menu">
                        <li id="menu-item-7270"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-7270"><a
                                    href="{{url('')}}/website/product-category/%d8%a8%d9%86%d8%a7%d8%aa%d9%8a/%d8%b7%d9%82%d9%85/">طقم</a>
                        </li>
                        <li id="menu-item-7221"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-7221"><a
                                    href="{{url('')}}/website/product-category/%d8%a8%d9%86%d8%a7%d8%aa%d9%8a/%d9%81%d8%b3%d8%aa%d8%a7%d9%86/">فستان</a>
                        </li>
                        <li id="menu-item-7261"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-7261"><a
                                    href="{{url('')}}/website/product-category/%d8%a8%d9%86%d8%a7%d8%aa%d9%8a/%d8%ac%d9%85%d8%a8%d8%b3%d9%88%d8%aa/">جمبسوت</a>
                        </li>
                        <li id="menu-item-7263"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-7263"><a
                                    href="{{url('')}}/website/product-category/%d8%a8%d9%86%d8%a7%d8%aa%d9%8a/%d8%a8%d9%84%d9%88%d8%b2%d8%a9/">بلوزة</a>
                        </li>
                        <li id="menu-item-7266"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-7266"><a
                                    href="{{url('')}}/website/product-category/%d8%a8%d9%86%d8%a7%d8%aa%d9%8a/%d8%aa%d9%86%d9%88%d8%b1%d9%87/">تنوره</a>
                        </li>
                        <li id="menu-item-7264"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-7264"><a
                                    href="{{url('')}}/website/product-category/%d8%a8%d9%86%d8%a7%d8%aa%d9%8a/%d8%a8%d9%86%d8%b7%d8%a7%d9%84/">بنطال</a>
                        </li>
                        <li id="menu-item-20639"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-20639"><a
                                    href="{{url('')}}/website/product-category/%d8%a8%d9%86%d8%a7%d8%aa%d9%8a/%d8%ac%d8%a7%d9%83%d9%8a%d8%aa/">جاكيت</a>
                        </li>
                        <li id="menu-item-7260"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-7260"><a
                                    href="{{url('')}}/website/product-category/%d8%a8%d9%86%d8%a7%d8%aa%d9%8a/%d8%a7%d9%83%d8%b3%d8%b3%d9%88%d8%a7%d8%b1/">اكسسوار</a>
                        </li>
                        <li id="menu-item-10704"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-10704"><a
                                    href="{{url('')}}/website/product-category/%d8%a8%d9%86%d8%a7%d8%aa%d9%8a/%d8%a3%d8%ad%d8%b0%d9%8a%d8%a9/">أحذية</a>
                        </li>
                    </ul>
                </li>
                <li id="menu-item-7043"
                    class="mega-menu menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-has-children menu-item-7043">
                    <a href="{{url('')}}/website/product-category/%d9%88%d9%84%d8%a7%d8%af%d9%8a-2/">ولادي</a>
                    <ul class="sub-menu">
                        <li id="menu-item-7279"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-7279"><a
                                    href="{{url('')}}/website/product-category/%d9%88%d9%84%d8%a7%d8%af%d9%8a-2/%d8%b7%d9%82%d9%85-%d9%88%d9%84%d8%a7%d8%af%d9%8a-2/">طقم</a>
                        </li>
                        <li id="menu-item-7274"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-7274"><a
                                    href="{{url('')}}/website/product-category/%d9%88%d9%84%d8%a7%d8%af%d9%8a-2/%d8%a8%d9%84%d9%88%d8%b2%d8%a9-%d9%88%d9%84%d8%a7%d8%af%d9%8a-2/">بلوزة</a>
                        </li>
                        <li id="menu-item-7275"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-7275"><a
                                    href="{{url('')}}/website/product-category/%d9%88%d9%84%d8%a7%d8%af%d9%8a-2/%d8%a8%d9%86%d8%b7%d8%a7%d9%84-%d9%88%d9%84%d8%a7%d8%af%d9%8a-2/">بنطال</a>
                        </li>
                        <li id="menu-item-20638"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-20638"><a
                                    href="{{url('')}}/website/product-category/%d9%88%d9%84%d8%a7%d8%af%d9%8a-2/%d8%ac%d8%a7%d9%83%d9%8a%d8%aa-%d9%88%d9%84%d8%a7%d8%af%d9%8a-2/">جاكيت</a>
                        </li>
                        <li id="menu-item-7271"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-7271"><a
                                    href="{{url('')}}/website/product-category/%d9%88%d9%84%d8%a7%d8%af%d9%8a-2/%d8%a3%d8%ad%d8%b0%d9%8a%d8%a9-%d9%88%d9%84%d8%a7%d8%af%d9%8a-2/">أحذية</a>
                        </li>
                        <li id="menu-item-7273"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-7273"><a
                                    href="{{url('')}}/website/product-category/%d9%88%d9%84%d8%a7%d8%af%d9%8a-2/%d8%a7%d9%83%d8%b3%d8%b3%d9%88%d8%a7%d8%b1-%d9%88%d9%84%d8%a7%d8%af%d9%8a-2/">اكسسوار</a>
                        </li>
                    </ul>
                </li>
                <li id="menu-item-7041"
                    class="mega-menu menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-has-children menu-item-7041">
                    <a href="{{url('')}}/website/product-category/%d8%aa%d8%b4%d9%83%d9%8a%d9%84%d8%a9-%d8%ac%d8%af%d9%8a%d8%af%d8%a9/">تشكيلة
                        جديدة</a>
                    <ul class="sub-menu">
                        <li id="menu-item-7280"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-7280"><a
                                    href="{{url('')}}/website/product-category/%d8%aa%d8%b4%d9%83%d9%8a%d9%84%d8%a9-%d8%ac%d8%af%d9%8a%d8%af%d8%a9/%d8%a8%d9%86%d8%a7%d8%aa%d9%8a-%d8%aa%d8%b4%d9%83%d9%8a%d9%84%d8%a9-%d8%ac%d8%af%d9%8a%d8%af%d8%a9/">بناتي</a>
                        </li>
                        <li id="menu-item-7281"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-7281"><a
                                    href="{{url('')}}/website/product-category/%d8%aa%d8%b4%d9%83%d9%8a%d9%84%d8%a9-%d8%ac%d8%af%d9%8a%d8%af%d8%a9/%d9%88%d9%84%d8%a7%d8%af%d9%8a/">ولادي1</a>
                        </li>
                    </ul>
                </li>
                <li id="menu-item-36023"
                    class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-has-children menu-item-36023">
                    <a href="{{url('')}}/website/product-category/%d8%a7%d9%84%d8%b9%d8%b1%d9%88%d8%b6/">العروض</a>
                    <ul class="sub-menu">
                        <li id="menu-item-36024"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-36024"><a
                                    href="{{url('')}}/website/product-category/%d8%a7%d9%84%d8%b9%d8%b1%d9%88%d8%b6/%d8%b4%d8%aa%d9%88%d9%8a/">شتوي</a>
                        </li>
                        <li id="menu-item-36025"
                            class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-36025"><a
                                    href="{{url('')}}/website/product-category/%d8%a7%d9%84%d8%b9%d8%b1%d9%88%d8%b6/%d8%b5%d9%8a%d9%81%d9%8a/">صيفي</a>
                        </li>
                    </ul>
                </li>
                <li id="menu-item-7310" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7310">
                    <a href="{{url('')}}/website/store/">معارض ممنون</a>
                </li>
            </ul>
        </div>
        <ul class="social-list">
            <li>
                <a href="https://www.facebook.com" class="fa fa-facebook" data-toggle="tooltip" title="فيسبوك"></a>
            </li>
            <li>
                <a href="https://twitter.com/mamnonkids" class="fa fa-twitter" data-toggle="tooltip" title="تويتر"></a>
            </li>
            <li>
                <a href="https://www.snapchat.com/add/mamnonkids" class="fa fa-snapchat-ghost" data-toggle="tooltip"
                   title="سناب شات"></a>
            </li>
            <li>
                <a href="https://instagram.com/mamnonkids" class="fa fa-instagram" data-toggle="tooltip"
                   title="انستجرام"></a>
            </li>
        </ul>
    </div>
    <div class="m-overlay"></div>
</div>
<div class="main-wrapper">
    <input type="hidden" value="{{LaravelLocalization::localizeUrl('/')}}" id="get_url">
    <input type="hidden" value="{{url('')}}" id="get_source_url">
    <input type="hidden" value="ar" id="get_lang">

    @include('website.includes.header')
    @yield('content')
    @include('website.includes.footer')
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


<script type="application/ld+json">
            {"@context":"https:\/\/schema.org\/","@type":"BreadcrumbList","itemListElement":[{"@type":"ListItem","position":1,"item":{"name":"\u0627\u0644\u0631\u0626\u064a\u0633\u064a\u0629","@id":"https:\/\/mamnonfashion.com"}},{"@type":"ListItem","position":2,"item":{"name":"\u0628\u0646\u0627\u062a\u064a","@id":"https:\/\/mamnonfashion.com\/product-category\/%d8%a8%d9%86%d8%a7%d8%aa%d9%8a\/"}},{"@type":"ListItem","position":3,"item":{"name":"\u0637\u0642\u0645","@id":"https:\/\/mamnonfashion.com\/product-category\/%d8%a8%d9%86%d8%a7%d8%aa%d9%8a\/%d8%b7%d9%82%d9%85\/"}}]}

</script>

<link rel='stylesheet' id='dashicons-css'
      href='{{url('')}}/website/wp-includes/css/dashicons.min.css?ver=5.3.2' type='text/css' media='all'/>
<style id='dashicons-inline-css' type='text/css'>
    [data-font="Dashicons"]:before {
        font-family: 'Dashicons' !important;
        content: attr(data-icon) !important;
        speak: none !important;
        font-weight: normal !important;
        font-variant: normal !important;
        text-transform: none !important;
        line-height: 1 !important;
        font-style: normal !important;
        -webkit-font-smoothing: antialiased !important;
        -moz-osx-font-smoothing: grayscale !important;
    }
</style>
<link rel='stylesheet' id='nf-display-css'
      href='{{url('')}}/website/wp-content/plugins/ninja-forms/assets/css/display-structure.css?ver=5.3.2'
      type='text/css' media='all'/>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-content/plugins/yith-woocommerce-wishlist/assets/js/jquery.selectBox.min.js?ver=1.2.0'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript">
                /* <![CDATA[ */
                var yith_wcwl_l10n = {
                    "ajax_url": "\/wp-admin\/admin-ajax.php",
                    "redirect_to_cart": "no",
                    "multi_wishlist": "",
                    "hide_add_button": "1",
                    "enable_ajax_loading": "",
                    "ajax_loader_url": "https:\/\/mamnonfashion.com\/wp-content\/plugins\/yith-woocommerce-wishlist\/assets\/images\/ajax-loader-alt.svg",
                    "remove_from_wishlist_after_add_to_cart": "1",
                    "labels": {
                        "cookie_disabled": "We are sorry, but this feature is available only if cookies on your browser are enabled.",
                        "added_to_cart_message": "<div class=\"woocommerce-notices-wrapper\"><div class=\"woocommerce-message\" role=\"alert\">Product added to cart successfully<\/div><\/div>"
                    },
                    "actions": {
                        "add_to_wishlist_action": "add_to_wishlist",
                        "remove_from_wishlist_action": "remove_from_wishlist",
                        "reload_wishlist_and_adding_elem_action": "reload_wishlist_and_adding_elem",
                        "load_mobile_action": "load_mobile",
                        "delete_item_action": "delete_item",
                        "load_fragments": "load_fragments"
                    }
                };
                /* ]]> */


</script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-content/plugins/yith-woocommerce-wishlist/assets/js/jquery.yith-wcwl.js?ver=3.0.6'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-content/plugins/woocommerce/assets/js/js-cookie/js.cookie.min.js?ver=2.1.4'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript">
                /* <![CDATA[ */
                var woocommerce_params = {
                    "ajax_url": "\/wp-admin\/admin-ajax.php",
                    "wc_ajax_url": "\/?wc-ajax=%%endpoint%%"
                };
                /* ]]> */


</script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-content/plugins/woocommerce/assets/js/frontend/woocommerce.min.js?ver=3.5.7'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript">
                /* <![CDATA[ */
                var wc_cart_fragments_params = {
                    "ajax_url": "\/wp-admin\/admin-ajax.php",
                    "wc_ajax_url": "\/?wc-ajax=%%endpoint%%",
                    "cart_hash_key": "wc_cart_hash_9e0cfe6c1de0aebee6ab9f527a0e2532",
                    "fragment_name": "wc_fragments_9e0cfe6c1de0aebee6ab9f527a0e2532"
                };
                /* ]]> */


</script>
{{--<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"--}}
{{--src='{{url('')}}/website/wp-content/plugins/woocommerce/assets/js/frontend/cart-fragments.min.js?ver=3.5.7'></script>--}}
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='//mamnonfashion.com/wp-content/plugins/woocommerce/assets/js/prettyPhoto/jquery.prettyPhoto.min.js?ver=3.1.6'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-content/themes/mamnonfashion/js/jquery.min.js?ver=5.3.2'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-content/themes/mamnonfashion/js/bootstrap.min.js?ver=5.3.2'></script>
<script type="f3bfd642b150640c57931bb2-text/javascript" src='{{url('')}}/website/wp-content/themes/mamnonfashion/js/owl.carousel.js?ver=5.3.2'></script>

<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-content/themes/mamnonfashion/js/wow.js?ver=5.3.2'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-content/themes/mamnonfashion/js/jquery.sticky.js?ver=5.3.2'></script>
{{--<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"--}}
{{--src='{{url('')}}/website/wp-content/themes/mamnonfashion/js/script2.js?ver=5.3.2'></script>--}}
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js?ver=5.3.2'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-content/plugins/variation-swatches-for-woocommerce/assets/js/frontend.js?ver=20160615'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript">
                var mejsL10n = {
                    "language": "ar",
                    "strings": {
                        "mejs.install-flash": "\u0623\u0646\u062a \u062a\u0633\u062a\u062e\u062f\u0645 \u0645\u062a\u0635\u0641\u062d \u0644\u0627 \u064a\u062d\u062a\u0648\u064a \u0639\u0644\u0649 \u0645\u0634\u063a\u0644 \u0641\u0644\u0627\u0634 \u0645\u0641\u0639\u0651\u0644 \u0623\u0648 \u0645\u0646\u0635\u0651\u0628 \u0645\u0633\u0628\u0642\u0627\u064b. \u0627\u0644\u0631\u062c\u0627\u0621 \u0642\u0645 \u0628\u062a\u0641\u0639\u064a\u0644 \u0625\u0636\u0627\u0641\u0629 \u0645\u0634\u063a\u0644 \u0627\u0644\u0641\u0644\u0627\u0634 (Flash player plugin) \u0639\u0644\u0649 \u0645\u062a\u0635\u0641\u062d\u0643 \u0623\u0648 \u0642\u0645 \u0628\u062a\u0646\u0632\u064a\u0644 \u0622\u062e\u0631 \u0625\u0635\u062f\u0627\u0631 \u0645\u0646 https:\/\/get.adobe.com\/flashplayer\/",
                        "mejs.fullscreen-off": "\u0625\u064a\u0642\u0627\u0641 \u0627\u0644\u0634\u0627\u0634\u0647 \u0627\u0644\u0643\u0627\u0645\u0644\u0629",
                        "mejs.fullscreen-on": "\u0627\u0644\u0627\u0646\u062a\u0642\u0627\u0644 \u0625\u0644\u0649 \u0627\u0644\u0634\u0627\u0634\u0647 \u0627\u0644\u0643\u0627\u0645\u0644\u0629",
                        "mejs.download-video": "\u062a\u062d\u0645\u064a\u0644 \u0627\u0644\u0641\u064a\u062f\u064a\u0648",
                        "mejs.fullscreen": "\u0634\u0627\u0634\u0629 \u0643\u0627\u0645\u0644\u0629",
                        "mejs.time-jump-forward": ["\u0627\u0644\u0642\u0641\u0632 \u0625\u0644\u0649 \u0627\u0644\u0623\u0645\u0627\u0645 \u062b\u0627\u0646\u064a\u0629 \u0648\u0627\u062d\u062f\u0629", "\u0627\u0644\u0642\u0641\u0632 %1 \u062b\u0627\u0646\u064a\u0629 \u0625\u0644\u0649 \u0627\u0644\u0623\u0645\u0627\u0645"],
                        "mejs.loop": "\u062a\u0628\u062f\u064a\u0644 \u0627\u0644\u062d\u0644\u0642\u0629",
                        "mejs.play": "\u062a\u0634\u063a\u064a\u0644",
                        "mejs.pause": "\u0625\u064a\u0642\u0627\u0641 \u0645\u0624\u0642\u062a",
                        "mejs.close": "\u0625\u063a\u0644\u0627\u0642",
                        "mejs.time-slider": "\u0634\u0631\u064a\u0637 \u062a\u0645\u0631\u064a\u0631 \u0627\u0644\u0648\u0642\u062a",
                        "mejs.time-help-text": "\u0627\u0633\u062a\u062e\u062f\u0645 \u0645\u0641\u0627\u062a\u064a\u062d \u0627\u0644\u0623\u0633\u0647\u0645 \u064a\u0633\u0627\u0631\/\u064a\u0645\u064a\u0646 \u0644\u0644\u062a\u0642\u062f\u0645 \u062b\u0627\u0646\u064a\u0629 \u0648\u0627\u062d\u062f\u0629\u060c \u0623\u0633\u0647\u0645 \u0623\u0639\u0644\u0649\/\u0623\u0633\u0641\u0644 \u0644\u0644\u062a\u0642\u062f\u0645 \u0639\u0634\u0631 \u062b\u0648\u0627\u0646\u064a.",
                        "mejs.time-skip-back": ["\u062a\u062e\u0637\u064a \u062b\u0627\u0646\u064a\u0629 \u0625\u0644\u0649 \u0627\u0644\u062e\u0644\u0641", "\u0627\u0644\u062a\u062e\u0637\u064a \u0644\u0644\u062e\u0644\u0641 %1 \u062b\u0627\u0646\u064a\u0629"],
                        "mejs.captions-subtitles": "\u0643\u0644\u0645\u0627\u062a \u062a\u0648\u0636\u064a\u062d\u064a\u0629\/\u062a\u0631\u062c\u0645\u0627\u062a",
                        "mejs.captions-chapters": "\u0641\u0635\u0648\u0644",
                        "mejs.none": "\u0628\u062f\u0648\u0646",
                        "mejs.mute-toggle": "\u062a\u0628\u062f\u064a\u0644 \u0627\u0644\u0643\u062a\u0645",
                        "mejs.volume-help-text": "\u0627\u0633\u062a\u062e\u062f\u0645 \u0645\u0641\u0627\u062a\u064a\u062d \u0627\u0644\u0623\u0633\u0647\u0645 \u0623\u0639\u0644\u0649\/\u0623\u0633\u0641\u0644 \u0644\u0632\u064a\u0627\u062f\u0629 \u0623\u0648 \u062e\u0641\u0636 \u0645\u0633\u062a\u0648\u0649 \u0627\u0644\u0635\u0648\u062a.",
                        "mejs.unmute": "\u0625\u0644\u063a\u0627\u0621 \u0643\u062a\u0645 \u0627\u0644\u0635\u0648\u062a",
                        "mejs.mute": "\u0635\u0627\u0645\u062a",
                        "mejs.volume-slider": "\u0634\u0631\u064a\u0637 \u062a\u0645\u0631\u064a\u0631 \u0645\u0633\u062a\u0648\u0649 \u0627\u0644\u0635\u0648\u062a",
                        "mejs.video-player": "\u0645\u0634\u063a\u0644 \u0627\u0644\u0641\u064a\u062f\u064a\u0648",
                        "mejs.audio-player": "\u0645\u0634\u063a\u0644 \u0627\u0644\u0635\u0648\u062a",
                        "mejs.ad-skip": "\u062a\u062e\u0637\u064a \u0627\u0644\u0625\u0639\u0644\u0627\u0646",
                        "mejs.ad-skip-info": ["\u0627\u0644\u062a\u062e\u0637\u064a \u0641\u064a \u062b\u0627\u0646\u064a\u0629", "\u0627\u0644\u062a\u062e\u0637\u064a \u0641\u064a %1 \u062b\u0627\u0646\u064a\u0629"],
                        "mejs.source-chooser": "\u0645\u064f\u062d\u062f\u062f \u0627\u0644\u0645\u0635\u062f\u0631",
                        "mejs.stop": "\u062a\u0648\u0642\u0641",
                        "mejs.speed-rate": "\u0645\u0639\u062f\u0644 \u0627\u0644\u0633\u0631\u0639\u0629",
                        "mejs.live-broadcast": "\u0628\u062b \u0645\u0628\u0627\u0634\u0631",
                        "mejs.afrikaans": "\u0627\u0644\u0625\u0641\u0631\u064a\u0642\u0627\u0646\u064a\u0629",
                        "mejs.albanian": "\u0627\u0644\u0623\u0644\u0628\u0627\u0646\u064a\u0629",
                        "mejs.arabic": "\u0627\u0644\u0639\u0631\u0628\u064a\u0629",
                        "mejs.belarusian": "\u0628\u064a\u0644\u0627\u0631\u0648\u0633\u064a\u0629",
                        "mejs.bulgarian": "\u0628\u0644\u063a\u0627\u0631\u064a\u0629",
                        "mejs.catalan": "\u0643\u0627\u062a\u0627\u0644\u0648\u0646\u064a\u0629",
                        "mejs.chinese": "\u0635\u064a\u0646\u064a\u0629",
                        "mejs.chinese-simplified": "\u0635\u064a\u0646\u064a\u0629 (\u0627\u0644\u0645\u0628\u0633\u0637\u0629)",
                        "mejs.chinese-traditional": "\u0635\u064a\u0646\u064a\u0629 (\u0627\u0644\u062a\u0642\u0644\u064a\u062f\u064a\u0629)",
                        "mejs.croatian": "\u0627\u0644\u0643\u0631\u0648\u0627\u062a\u064a\u0629",
                        "mejs.czech": "\u062a\u0634\u064a\u0643\u064a\u0629",
                        "mejs.danish": "\u062f\u0646\u0645\u0627\u0631\u0643\u064a\u0629",
                        "mejs.dutch": "\u0647\u0648\u0644\u0646\u062f\u064a\u0629",
                        "mejs.english": "\u0625\u0646\u062c\u0644\u064a\u0632\u064a\u0629",
                        "mejs.estonian": "\u0627\u0644\u0625\u0633\u062a\u0648\u0646\u064a\u0629",
                        "mejs.filipino": "\u0627\u0644\u0641\u0644\u0628\u064a\u0646\u064a\u0629",
                        "mejs.finnish": "\u0627\u0644\u0641\u0646\u0644\u0646\u062f\u064a\u0629",
                        "mejs.french": "\u0627\u0644\u0641\u0631\u0646\u0633\u064a\u0629",
                        "mejs.galician": "\u0627\u0644\u062c\u0627\u0644\u064a\u0643\u064a\u0629",
                        "mejs.german": "\u0627\u0644\u0623\u0644\u0645\u0627\u0646\u064a\u0629",
                        "mejs.greek": "\u0627\u0644\u064a\u0648\u0646\u0627\u0646\u064a\u0629",
                        "mejs.haitian-creole": "\u0627\u0644\u0643\u0631\u064a\u0648\u0644\u064a\u0629 \u0627\u0644\u0647\u0627\u064a\u062a\u064a\u0629",
                        "mejs.hebrew": "\u0627\u0644\u0639\u0628\u0631\u064a\u0629",
                        "mejs.hindi": "\u0627\u0644\u0647\u0646\u062f\u064a\u0629",
                        "mejs.hungarian": "\u0627\u0644\u0647\u0646\u063a\u0627\u0631\u064a\u0629",
                        "mejs.icelandic": "\u0623\u064a\u0633\u0644\u0646\u062f\u064a\u0629",
                        "mejs.indonesian": "\u0623\u0646\u062f\u0648\u0646\u064a\u0633\u064a\u0629",
                        "mejs.irish": "\u0625\u064a\u0631\u0644\u0646\u062f\u064a\u0629",
                        "mejs.italian": "\u0625\u064a\u0637\u0627\u0644\u064a\u0629",
                        "mejs.japanese": "\u064a\u0627\u0628\u0627\u0646\u064a\u0629",
                        "mejs.korean": "\u0643\u0648\u0631\u064a",
                        "mejs.latvian": "\u0627\u0644\u0644\u0627\u062a\u0641\u064a\u0629",
                        "mejs.lithuanian": "\u0627\u0644\u0644\u064a\u062a\u0648\u0627\u0646\u064a\u0629",
                        "mejs.macedonian": "\u0645\u0643\u062f\u0648\u0646\u064a\u0629",
                        "mejs.malay": "\u0627\u0644\u0645\u0627\u0644\u064a\u0629",
                        "mejs.maltese": "\u0627\u0644\u0645\u0627\u0644\u0637\u064a\u0629",
                        "mejs.norwegian": "\u0646\u0631\u0648\u064a\u062c\u064a",
                        "mejs.persian": "\u0625\u064a\u0631\u0627\u0646\u064a",
                        "mejs.polish": "\u0628\u0648\u0644\u0646\u062f\u064a\u0629",
                        "mejs.portuguese": "\u0628\u0631\u062a\u063a\u0627\u0644\u064a",
                        "mejs.romanian": "\u0631\u0648\u0645\u0627\u0646\u064a",
                        "mejs.russian": "\u0631\u0648\u0633\u064a",
                        "mejs.serbian": "\u0635\u0631\u0628\u064a",
                        "mejs.slovak": "\u0633\u0644\u0648\u0641\u0627\u0643\u064a\u0629",
                        "mejs.slovenian": "\u0633\u0644\u0648\u0641\u064a\u0646\u064a\u0629",
                        "mejs.spanish": "\u0627\u0633\u0628\u0627\u0646\u064a\u0629",
                        "mejs.swahili": "\u0633\u0648\u0627\u062d\u0644\u064a\u0629",
                        "mejs.swedish": "\u0633\u0648\u064a\u062f\u064a",
                        "mejs.tagalog": "\u062a\u063a\u0627\u0644\u0648\u063a\u064a\u0629",
                        "mejs.thai": "\u062a\u0627\u064a\u0644\u0627\u0646\u062f\u064a",
                        "mejs.turkish": "\u062a\u0631\u0643\u064a",
                        "mejs.ukrainian": "\u0627\u0648\u0643\u0631\u0627\u0646\u064a",
                        "mejs.vietnamese": "\u0641\u064a\u062a\u0627\u0646\u0627\u0645\u064a\u0629",
                        "mejs.welsh": "\u0648\u064a\u0644\u0632\u064a\u0629",
                        "mejs.yiddish": "\u064a\u062f\u064a\u0634\u064a\u0629"
                    }
                };


</script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-includes/js/mediaelement/mediaelement-and-player.min.js?ver=4.2.13-9993131'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-includes/js/mediaelement/mediaelement-migrate.min.js?ver=5.3.2'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript">
                /* <![CDATA[ */
                var _wpmejsSettings = {
                    "pluginPath": "\/wp-includes\/js\/mediaelement\/",
                    "classPrefix": "mejs-",
                    "stretching": "responsive"
                };
                /* ]]> */


</script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-includes/js/wp-embed.min.js?ver=5.3.2'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-includes/js/jquery/ui/core.min.js?ver=1.11.4'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-includes/js/jquery/ui/widget.min.js?ver=1.11.4'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-includes/js/jquery/ui/mouse.min.js?ver=1.11.4'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-includes/js/jquery/ui/slider.min.js?ver=1.11.4'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-content/plugins/woocommerce/assets/js/jquery-ui-touch-punch/jquery-ui-touch-punch.min.js?ver=3.5.7'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-content/plugins/woocommerce/assets/js/accounting/accounting.min.js?ver=0.4.2'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript">
                /* <![CDATA[ */
                var woocommerce_price_slider_params = {
                    "currency_format_num_decimals": "0",
                    "currency_format_symbol": "\u0631.\u0633",
                    "currency_format_decimal_sep": ".",
                    "currency_format_thousand_sep": ",",
                    "currency_format": "%v\u00a0%s"
                };
                /* ]]> */


</script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-content/plugins/woocommerce/assets/js/frontend/price-slider.min.js?ver=3.5.7'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-includes/js/underscore.min.js?ver=1.8.3'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-includes/js/backbone.min.js?ver=1.4.0'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-content/plugins/ninja-forms/assets/js/min/front-end-deps.js?ver=3.4.23'></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript">
                /* <![CDATA[ */
                var nfi18n = {
                    "ninjaForms": "\u0627\u0644\u0646\u0645\u0627\u0630\u062c",
                    "changeEmailErrorMsg": "Please enter a valid email address!",
                    "changeDateErrorMsg": "Please enter a valid date!",
                    "confirmFieldErrorMsg": "These fields must match!",
                    "fieldNumberNumMinError": "Number Min Error",
                    "fieldNumberNumMaxError": "Number Max Error",
                    "fieldNumberIncrementBy": "Please increment by ",
                    "fieldTextareaRTEInsertLink": "Insert Link",
                    "fieldTextareaRTEInsertMedia": "Insert Media",
                    "fieldTextareaRTESelectAFile": "Select a file",
                    "formErrorsCorrectErrors": "Please correct errors before submitting this form.",
                    "formHoneypot": "If you are a human seeing this field, please leave it empty.",
                    "validateRequiredField": "This is a required field.",
                    "honeypotHoneypotError": "Honeypot Error",
                    "fileUploadOldCodeFileUploadInProgress": "File Upload in Progress.",
                    "fileUploadOldCodeFileUpload": "FILE UPLOAD",
                    "currencySymbol": "",
                    "fieldsMarkedRequired": "Fields marked with an <span class=\"ninja-forms-req-symbol\">*<\/span> are required",
                    "thousands_sep": "\u066c",
                    "decimal_point": ".",
                    "siteLocale": "ar",
                    "dateFormat": "m\/d\/Y",
                    "startOfWeek": "6",
                    "of": "of",
                    "previousMonth": "Previous Month",
                    "nextMonth": "Next Month",
                    "months": ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                    "monthsShort": ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    "weekdays": ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                    "weekdaysShort": ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                    "weekdaysMin": ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
                };
                var nfFrontEnd = {
                    "adminAjax": "https:\/\/mamnonfashion.com\/wp-admin\/admin-ajax.php",
                    "ajaxNonce": "8696931929",
                    "requireBaseUrl": "https:\/\/mamnonfashion.com\/wp-content\/plugins\/ninja-forms\/assets\/js\/",
                    "use_merge_tags": {
                        "user": {
                            "address": "address",
                            "textbox": "textbox",
                            "button": "button",
                            "checkbox": "checkbox",
                            "city": "city",
                            "confirm": "confirm",
                            "date": "date",
                            "email": "email",
                            "firstname": "firstname",
                            "html": "html",
                            "hidden": "hidden",
                            "lastname": "lastname",
                            "listcheckbox": "listcheckbox",
                            "listcountry": "listcountry",
                            "listimage": "listimage",
                            "listmultiselect": "listmultiselect",
                            "listradio": "listradio",
                            "listselect": "listselect",
                            "liststate": "liststate",
                            "note": "note",
                            "number": "number",
                            "password": "password",
                            "passwordconfirm": "passwordconfirm",
                            "product": "product",
                            "quantity": "quantity",
                            "recaptcha": "recaptcha",
                            "shipping": "shipping",
                            "spam": "spam",
                            "starrating": "starrating",
                            "submit": "submit",
                            "terms": "terms",
                            "textarea": "textarea",
                            "total": "total",
                            "unknown": "unknown",
                            "zip": "zip",
                            "hr": "hr"
                        },
                        "post": {
                            "address": "address",
                            "textbox": "textbox",
                            "button": "button",
                            "checkbox": "checkbox",
                            "city": "city",
                            "confirm": "confirm",
                            "date": "date",
                            "email": "email",
                            "firstname": "firstname",
                            "html": "html",
                            "hidden": "hidden",
                            "lastname": "lastname",
                            "listcheckbox": "listcheckbox",
                            "listcountry": "listcountry",
                            "listimage": "listimage",
                            "listmultiselect": "listmultiselect",
                            "listradio": "listradio",
                            "listselect": "listselect",
                            "liststate": "liststate",
                            "note": "note",
                            "number": "number",
                            "password": "password",
                            "passwordconfirm": "passwordconfirm",
                            "product": "product",
                            "quantity": "quantity",
                            "recaptcha": "recaptcha",
                            "shipping": "shipping",
                            "spam": "spam",
                            "starrating": "starrating",
                            "submit": "submit",
                            "terms": "terms",
                            "textarea": "textarea",
                            "total": "total",
                            "unknown": "unknown",
                            "zip": "zip",
                            "hr": "hr"
                        },
                        "system": {
                            "address": "address",
                            "textbox": "textbox",
                            "button": "button",
                            "checkbox": "checkbox",
                            "city": "city",
                            "confirm": "confirm",
                            "date": "date",
                            "email": "email",
                            "firstname": "firstname",
                            "html": "html",
                            "hidden": "hidden",
                            "lastname": "lastname",
                            "listcheckbox": "listcheckbox",
                            "listcountry": "listcountry",
                            "listimage": "listimage",
                            "listmultiselect": "listmultiselect",
                            "listradio": "listradio",
                            "listselect": "listselect",
                            "liststate": "liststate",
                            "note": "note",
                            "number": "number",
                            "password": "password",
                            "passwordconfirm": "passwordconfirm",
                            "product": "product",
                            "quantity": "quantity",
                            "recaptcha": "recaptcha",
                            "shipping": "shipping",
                            "spam": "spam",
                            "starrating": "starrating",
                            "submit": "submit",
                            "terms": "terms",
                            "textarea": "textarea",
                            "total": "total",
                            "unknown": "unknown",
                            "zip": "zip",
                            "hr": "hr"
                        },
                        "fields": {
                            "address": "address",
                            "textbox": "textbox",
                            "button": "button",
                            "checkbox": "checkbox",
                            "city": "city",
                            "confirm": "confirm",
                            "date": "date",
                            "email": "email",
                            "firstname": "firstname",
                            "html": "html",
                            "hidden": "hidden",
                            "lastname": "lastname",
                            "listcheckbox": "listcheckbox",
                            "listcountry": "listcountry",
                            "listimage": "listimage",
                            "listmultiselect": "listmultiselect",
                            "listradio": "listradio",
                            "listselect": "listselect",
                            "liststate": "liststate",
                            "note": "note",
                            "number": "number",
                            "password": "password",
                            "passwordconfirm": "passwordconfirm",
                            "product": "product",
                            "quantity": "quantity",
                            "recaptcha": "recaptcha",
                            "shipping": "shipping",
                            "spam": "spam",
                            "starrating": "starrating",
                            "submit": "submit",
                            "terms": "terms",
                            "textarea": "textarea",
                            "total": "total",
                            "unknown": "unknown",
                            "zip": "zip",
                            "hr": "hr"
                        },
                        "calculations": {
                            "html": "html",
                            "hidden": "hidden",
                            "note": "note",
                            "unknown": "unknown"
                        }
                    },
                    "opinionated_styles": ""
                };
                /* ]]> */


</script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
        src='{{url('')}}/website/wp-content/plugins/ninja-forms/assets/js/min/front-end.js?ver=3.4.23'></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-118423805-1"
        type="c2f3a75456e97d73a7ddc2b5-text/javascript"></script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript">
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }
                gtag('js', new Date());

                gtag('config', 'UA-118423805-1');


</script>
<script type="c2f3a75456e97d73a7ddc2b5-text/javascript">
                $("#headerStore").sticky({
                    topSpacing: 0
                });
                $(window).on("load", function() {
                    $(".loader-wrapper").fadeOut();
                });


</script>
{{--<script type="c2f3a75456e97d73a7ddc2b5-text/javascript">--}}
                {{--jQuery(document).ready(function($) {--}}
                    {{--$('img[title]').each(function() {--}}
                        {{--$(this).removeAttr('title');--}}
                    {{--});--}}

                {{--});--}}
                {{--$(window).load(function() {--}}
                    {{--$('.owl-baners').owlCarousel({--}}
                        {{--rtl: true,--}}
                        {{--loop: false,--}}
                        {{--margin: 0,--}}
                        {{--nav: false,--}}
                        {{--dots: false,--}}
                        {{--items: 1,--}}
                        {{--autoplay: true,--}}
                        {{--autoplayTimeout: 10000,--}}
                        {{--animateIn: 'fadeIn', // add this--}}
                        {{--animateOut: 'fadeOut' // and this--}}
                    {{--});--}}
                {{--});--}}


{{--</script>--}}
{{--<script type="c2f3a75456e97d73a7ddc2b5-text/javascript">--}}
                {{--jQuery(document).ready(function($) {--}}
                    {{--jQuery('.main_slider').slick({--}}
                        {{--dots: false,--}}
                        {{--infinite: true,--}}
                        {{--speed: 500,--}}
                        {{--fade: true,--}}
                        {{--cssEase: 'linear',--}}
                        {{--rtl: true,--}}
                        {{--autoplay: true,--}}
                        {{--autoplaySpeed: 2000,--}}
                        {{--adaptiveHeight: true--}}
                    {{--});--}}
                {{--});--}}


{{--</script>--}}
<script id="tmpl-nf-empty" type="text/template">

            </script>
<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="c2f3a75456e97d73a7ddc2b5-|49" defer=""></script>


<script src="{{asset('js/app.js')}}"></script>
<script src="{{url('')}}/admin_assets/assets/general/js/vee_vue.js" type="text/javascript"></script>
<script src="{{url('')}}/admin_assets/assets/general/js/general.js" type="text/javascript"></script>
<script src="{{url('')}}/website/general/js/general.js" type="text/javascript"></script>
<script src="{{url('')}}/website/general/js/notify.min.js" type="text/javascript"></script>

<script>
    var translate = {
        select_shipping_company: "{{trans('website.select_shipping_company')}}",
        pleas_read_terms: "{{trans('website.pleas_read_terms')}}",
        select_shipping_company_firstly: "{{trans('website.select_shipping_company_firstly')}}",
        please_select_attribute: "{{trans('website.please_select_attribute')}}",

    };
</script>
@stack('js')
</body>

</html>