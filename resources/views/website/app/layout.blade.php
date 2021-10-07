<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title')
    </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
          integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
          crossorigin="anonymous" />
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
          integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
          crossorigin="anonymous" />

    <link rel="stylesheet" href="{{asset('/website/css/jquery-countryselector.min.css')}}">
    <link rel="stylesheet" href="{{asset('/website/fonts/The-Sans-Plain.otf')}}">
    <link rel="stylesheet" href="{{asset('/website/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/website/css/style-rtl.css')}}">
    <style>
        .slider img{border-radius: 0px !important; }
.hidden{
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
        .overlay .btn{
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
        .custom-map-control-button{
            width: 50px !important;
            height: 40px !important;
            left: 10px !important;
            top: 10px !important;
        }

        .gm-style-iw-d div{
            text-align: center;
        }
    </style>

    @yield('css')


</head>

<body>
<div class="loader-wrapper">
    <div class="loader5">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
    </div>
</div>
<input type="hidden" value="{{LaravelLocalization::localizeUrl('/')}}" id="get_url">
<input type="hidden" value="{{url('')}}" id="get_source_url">
<input type="hidden" value="ar" id="get_lang">

@yield('content-page')




<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.2/lazysizes.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous"></script>
<script src="{{asset('/website/js/jquery.countrySelector.js')}}"></script>
<script src="{{asset('/website/js/main.js')}}"></script>

<script src="{{asset('js/app.js')}}"></script>

<script src="{{url('')}}/admin_assets/assets/general/js/vee_vue.js" type="text/javascript"></script>
<script src="{{url('')}}/admin_assets/assets/general/js/general.js" type="text/javascript"></script>
<script src="{{url('')}}/website/general/js/general.js" type="text/javascript"></script>
<script src="{{url('')}}/website/general/js/notify.min.js" type="text/javascript"></script>
<script src="{{url('')}}/website/general/js/product/product_details.js" type="text/javascript"></script>

@yield('js')

<script>
    $(window).on("load", function() {
        $(".loader-wrapper").fadeOut();
    });
</script>

</body>

</html>
