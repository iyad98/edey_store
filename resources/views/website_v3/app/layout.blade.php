<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title')
    </title>     <!-- Stylesheets -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="{{asset('website_v3/css/all.css')}}" rel="stylesheet">
    <link href="{{asset('website_v3/css/fontawesome-all.css')}}" rel="stylesheet">
    <link href="{{asset('website_v3/css/owl.carousel.min.css')}}" rel="stylesheet">

    <link href="{{asset('website_v3/css/owl.theme.default.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('website_v3/plugins/jquery-ui/jquery-ui.min.css')}}">
    <link rel="stylesheet" href="{{asset('website_v3/plugins/jquery-ui/jquery-ui.structure.min.css')}}">
    <link rel="stylesheet" href="{{asset('website_v3/plugins/jquery-ui/jquery-ui.theme.css')}}">
    <link rel="stylesheet" href="{{asset('website_v3/js/jquery.ui.slider-rtl.css')}}">
    <link href="{{asset('website_v3/css/style.css')}}" rel="stylesheet">


    <link type="text/css" rel="stylesheet" href="{{asset('website_v3/css/lightslider.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('website_v3/css/lightgallery.css')}}"/>

<!-- Responsive -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset('website_v3/css/responsive.css')}}" rel="stylesheet">
    <script src="{{asset('website_v3/js/jquery-1.12.2.min.js')}}"></script>



    <meta property="al:ios:url" content="https://apps.apple.com/ae/app/infltr-infinite-filters/id935623257"/>
    <meta property="al:ios:app_name" content="Example App"/>
    <meta property="al:ios:app_store_id" content="935623257"/>
    <meta property="al:android:package" content="com.example.client"/>
    <meta property="al:android:app_name" content="Example App"/>
    <meta property="al:android:url" content="example://test"/>
    <style>
        .slider img {
            border-radius: 0px !important;
        }

        .hidden {
            display: none;
        }

        .alert {
            text-align: right;
        }

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

        .overlay .btn {
            width: 126px;
            height: 46px;
            background-color: #ffffff;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            font-size: 14px;
            font-weight: bold;
            color: #000000;
            border-radius: 0;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.2em;
            margin-bottom: 6px;
            margin-right: 10px;
        }

        .btn:hover {
            color: #ffffff;
            text-decoration: none;
        }

        .custom-map-control-button {
            width: 50px !important;
            height: 40px !important;
            left: 10px !important;
            top: 10px !important;
        }

        .gm-style-iw-d div {
            text-align: center;
        }
    </style>

    @yield('css')

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
            <img src="{{asset('website_v3/img/logo.png')}}" alt="إيدي ستور" class="img-responsive">
        </div>
    </div>
</div>
<div class="main-wrapper">
    @include('website_v3.partals.header')


    @yield('content')


    @include('website_v3.partals.subscribe')
    @include('website_v3.partals.footer')


</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="{{asset('website_v3/js/owl.carousel.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="{{asset('website_v3/js/wow.min.js')}}"></script>
<script src='/website_v2/js/jquery.zoom.js'></script>

<script src="{{asset('website_v3/js/script.js')}}"></script>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>

<script src="{{url('/js/app.js')}}"></script>
<script src="{{asset('admin_assets/assets/general/js/vee_vue.js')}}" type="text/javascript"></script>
<script src="{{asset('admin_assets/assets/general/js/general.js')}}" type="text/javascript"></script>
<script src="{{asset('website_v3/general/js/general.js')}}" type="text/javascript"></script>
<script src="{{asset('website_v3/general/js/notify.min.js')}}" type="text/javascript"></script>


<script>
    $(window).on("load", function () {
        $(".loader-wrapper").fadeOut();
    });
</script>

@yield('js')

<script>
    $(document).on('click', '#kareem', function (e) {
        var formData = new FormData($('#form_search_category')[0]); //get all data in form
        $.ajax({
            type: 'get',
            enctype: 'multipart/form-data',
            url: "{{route('search.category.home')}}",
            data: formData, // send this data to controller
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                if (data.status === true) {
                    // console.log(data);
                    // showAllPosts();
                }
            }, error: function (reject) {

            }
        });
    });

</script>


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


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="{{asset('website_v3/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('website_v3/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{asset('website_v3/js/jquery.ui.slider-rtl.js')}}"></script>
<script src="{{asset('website_v3/js/script.js')}}"></script>


</body>
</html>
