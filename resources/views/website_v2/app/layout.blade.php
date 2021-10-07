<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title')
    </title>    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="/website_v2/css/all.css" rel="stylesheet">
    <link href="/website_v2/css/fontawesome-all.css" rel="stylesheet">
    <link href="/website_v2/css/owl.carousel.min.css" rel="stylesheet">
    <link href="/website_v2/css/owl.theme.default.min.css" rel="stylesheet">
    <link href="/website_v2/css/slick.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"/>

    <link href="/website_v2/css/style.css" rel="stylesheet">
    <!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link href="/website_v2/css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--[if lt IE 9]>
    <script src="/website_v2/js/respond.js"></script><![endif]-->
    <script src="/website_v2/js/jquery-1.12.2.min.js"></script>
    <link rel="icon" href="/website_v2/images/favicon.png" type="image/gif" sizes="32x32">

    <meta property="al:ios:url" content="https://apps.apple.com/ae/app/infltr-infinite-filters/id935623257"/>
    <meta property="al:ios:app_name" content="Example App"/>
    <meta property="al:ios:app_store_id" content="935623257"/>
    <meta property="al:android:package" content="com.example.client"/>
    <meta property="al:android:app_name" content="Example App"/>
    <meta property="al:android:url" content="example://test"/>
    <style>
        .call_number {
            color: #e92036 !important;
            display: unset !important;
            padding: 6px !important;
        }

        .call_number:before {
            display: none !important;
        }

        #customers_service {
            margin-top: 10px;
            margin-bottom: -10px;
        }
    </style>
    @yield('css')

</head>
<body>
<input type="hidden" value="{{LaravelLocalization::localizeUrl('/')}}" id="get_url">
<input type="hidden" value="{{url('')}}" id="get_source_url">
<input type="hidden" value="ar" id="get_lang">
<!-- preloader -->
<div id="preloader">
    <div id="spinner">
        <div class="floating">
            <img src="/website_v2/images/logo.png" alt="" class="img-responsive">
        </div>
    </div>
</div>
@include('website_v2.partals.mobile_menu')
<div class="main-wrapper">

    @include('website_v2.partals.header')
    @include('website_v2.partals.search_mobile')



    @yield('content')



    @include('website_v2.partals.subscribe')
    @include('website_v2.partals.clients')
    @include('website_v2.partals.footer')


</div><!--main-wrapper-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="/website_v2/js/owl.carousel.min.js" type="text/javascript"></script>
<script src="/website_v2/js/slick.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src='/website_v2/js/jquery.zoom.js'></script>

<script src="/website_v2/js/wow.min.js"></script>

<script src="/website_v2/js/script.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="{{url('/js/app.js')}}"></script>
<script src="{{url('')}}/admin_assets/assets/general/js/vee_vue.js" type="text/javascript"></script>
<script src="{{url('')}}/admin_assets/assets/general/js/general.js" type="text/javascript"></script>
<script src="{{url('')}}/website/general/js/general.js" type="text/javascript"></script>
<script src="{{url('')}}/website/general/js/notify.min.js" type="text/javascript"></script>

@yield('js')

<!-- Start of LiveChat (www.livechatinc.com) code -->
<script>
    function open_chat() {
        LiveChatWidget.call('maximize')
    }

    window.__lc = window.__lc || {};
    window.__lc.license = 12473325;
    ;(function (n, t, c) {
        function i(n) {
            return e._h ? e._h.apply(null, n) : e._q.push(n)
        }

        var e = {
            _q: [], _h: null, _v: "2.0", on: function () {
                i(["on", c.call(arguments)])
            }, once: function () {
                i(["once", c.call(arguments)])
            }, off: function () {
                i(["off", c.call(arguments)])
            }, get: function () {
                if (!e._h) throw new Error("[LiveChatWidget] You can't use getters before load.");
                return i(["get", c.call(arguments)])
            }, call: function () {
                i(["call", c.call(arguments)])
            }, init: function () {
                var n = t.createElement("script");
                n.async = !0, n.type = "text/javascript", n.src = "https://cdn.livechatinc.com/tracking.js", t.head.appendChild(n)
            }
        };
        !n.__lc.asyncInit && e.init(), n.LiveChatWidget = n.LiveChatWidget || e
    }(window, document, [].slice))
</script>


</body>
</html>
