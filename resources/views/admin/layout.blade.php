<!DOCTYPE html>

<html lang="en">


<head>

    <meta charset="utf-8"/>
    <title>الكويتية ستور</title>
    <meta name="description" content="Default form examples">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="{{url('')}}/admin_assets/assets/demo/default/media/img/logo/favicon.png" type="image/gif" sizes="32x32">

{{--@include('feed::links')--}}

    <!--end::Web font -->

    <!--begin::Global Theme Styles -->
    <!--
    <link href="{{url('')}}/admin_assets/assets/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css"/>
    -->
    <link href="{{url('')}}/admin_assets/assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />


    <!--
    <link href="{{url('')}}/admin_assets/assets/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css"/>
    -->
    <link href="{{url('')}}/admin_assets/assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />
    <link href="{{url('')}}/admin_assets/assets/demo/default/base/customStyle.css" rel="stylesheet" type="text/css" />
<!--RTL version:-->
    <link href="{{url('')}}/admin_assets/assets/general/css/general.css" rel="stylesheet" type="text/css" />
    {{--
    <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/droid-arabic-kufi" type="text/css"/>
    --}}


    <link href="{{url('')}}/admin_assets/assets/new-style.css" rel="stylesheet" type="text/css" />

    @stack('css')
    <link rel="shortcut icon" href="{{url('')}}/website/images/logo.png"/>
    <link rel="icon" href="{{url('')}}/website/images/logo.png"/>
    <!--end::Global Theme Styles -->
    {{--<link rel="shortcut icon" href="{{url('')}}/admin_assets/assets/demo/default/media/img/logo/favicon.ico"/>--}}
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">



    <!-- BEGIN: Header -->
@include('admin.includes.top_nav')
<!-- END: Header -->
    <!-- begin::Body -->

    <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

        <input type="hidden" value="{{url('')}}" id="get_url">
        <input type="hidden" value="{{request()->admin_fcm}}" id="get_admin_fcm">
        <!-- BEGIN: Left Aside -->
    @include('admin.includes.sidebar')
    <!-- END: Left Aside -->
        <div class="m-grid__item m-grid__item--fluid m-wrapper"
             style="margin-top: -2.3rem;margin-left: 0.5ex;margin-right: 0.5ex;"
        >
             @yield('content')

            <audio class="hidden" controls id="music" allow="autoplay">
                <source src="{{url('')}}/bell.mp3" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>

        </div>
    </div>

    <!-- end:: Body -->

    <!-- begin::Footer -->
{{--@include('admin.includes.footer')--}}

<!-- end::Footer -->
</div>

<!-- end:: Page -->



<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>


<script>

    var pagination = {
        processing : "{{trans('pagination.processing')}}" ,
        search : "{{trans('pagination.search')}}" ,
        lengthMenu : "{{trans('pagination.lengthMenu')}}" ,
        info : "{{trans('pagination.info')}}" ,
        sZeroRecords : "{{trans('pagination.sZeroRecords')}}"
    };

    var translations = {
        sure_delete : "{{trans('admin.sure_delete')}}" ,
        sure_delete_2 : "{{trans('admin.sure_delete_2')}}",
        yes_delete : "{{trans('admin.yes_delete')}}" ,
        no_delete : "{{trans('admin.no_delete')}}" ,
        cancelled_delete : "{{trans('admin.cancelled_delete')}}" ,
        success_delete : "{{trans('admin.success_delete')}}" ,
        didnt_delete : "{{trans('admin.didnt_delete')}}" ,
        done_delete : "{{trans('admin.done_delete')}}" ,
        sure_approve : "{{trans('admin.sure_approve')}}" ,
        sure_reject : "{{trans('admin.sure_reject')}}" ,
        approved_done : "{{trans('admin.approved_done')}}" ,
        rejected_done : "{{trans('admin.rejected_done')}}" ,
        approved_not_done : "{{trans('admin.approved_not_done')}}" ,
        rejected_not_done : "{{trans('admin.rejected_not_done')}}" ,
        approve : "{{trans('admin.approve')}}" ,
        reject : "{{trans('admin.reject')}}" ,
        delivery_order : "{{trans('admin.delivery_order')}}" ,
        sure_delivery_order : "{{trans('admin.sure_delivery_order')}}" ,
        delivered_order : "{{trans('admin.delivered_order')}}" ,
        delivered_order_not_done : "{{trans('admin.delivered_order_not_done')}}" ,


        sure_approve_bank : "{{trans('admin.sure_approve_bank')}}" ,
        cancelled_approve : "{{trans('admin.cancelled_approve')}}" ,
        didnt_approve : "{{trans('admin.didnt_approve')}}" ,
        success_approve : "{{trans('admin.success_approve')}}" ,

        sure_reject_bank : "{{trans('admin.sure_reject_bank')}}" ,
        cancelled_reject : "{{trans('admin.cancelled_reject')}}" ,
        didnt_reject : "{{trans('admin.didnt_reject')}}" ,
        reject_reason : "{{trans('admin.reject_reason')}}" ,
        reject_reason : "{{trans('admin.reject_reason')}}" ,
        success_reject : "{{trans('admin.success_reject')}}" ,


        sure_cancel_delete : "{{trans('admin.sure_cancel_delete')}}" ,
        yes_cancel_delete : "{{trans('admin.yes_cancel_delete')}}" ,
        no_cancel_delete : "{{trans('admin.no_cancel_delete')}}" ,
        cancelled_cancel_delete : "{{trans('admin.cancelled_cancel_delete')}}" ,
        success_cancel_delete : "{{trans('admin.success_cancel_delete')}}" ,
        didnt_cancel_delete : "{{trans('admin.didnt_cancel_delete')}}" ,
        done_cancel_delete : "{{trans('admin.done_cancel_delete')}}" ,



        sure_approve_comment : "{{trans('admin.sure_approve_comment')}}" ,
        yes_approve_comment : "{{trans('admin.yes_approve_comment')}}" ,
        no_approve_comment : "{{trans('admin.no_approve_comment')}}" ,
        cancelled_approve_comment : "{{trans('admin.cancelled_approve_comment')}}" ,
        success_approve_comment : "{{trans('admin.success_approve_comment')}}" ,
        didnt_approve_comment : "{{trans('admin.didnt_approve_comment')}}" ,
        done_approve_comment : "{{trans('admin.done_approve_comment')}}" ,

        sure_disapprove_comment : "{{trans('admin.sure_disapprove_comment')}}" ,
        yes_disapprove_comment : "{{trans('admin.yes_disapprove_comment')}}" ,
        no_disapprove_comment : "{{trans('admin.no_disapprove_comment')}}" ,
        cancelled_disapprove_comment : "{{trans('admin.cancelled_disapprove_comment')}}" ,
        success_disapprove_comment : "{{trans('admin.success_disapprove_comment')}}" ,
        didnt_disapprove_comment : "{{trans('admin.didnt_disapprove_comment')}}" ,
        done_disapprove_comment : "{{trans('admin.done_disapprove_comment')}}" ,


        sure_active : "{{trans('admin.sure_active')}}" ,
        sure_not_active : "{{trans('admin.sure_not_active')}}" ,
        yes : "{{trans('admin.yes')}}" ,
        no : "{{trans('admin.no')}}" ,
        cancelled_change : "{{trans('admin.cancelled_change')}}" ,
        success_change : "{{trans('admin.success_change')}}" ,
        didnt_change : "{{trans('admin.didnt_change')}}" ,
        done_change : "{{trans('admin.done_change')}}" ,
        pending_delete : "{{trans('admin.pending_delete')}}" ,

        latest_product_ar : "{{trans('website.latest_products' , [] , 'ar')}}",
        latest_product_en : "{{trans('website.latest_products' , [] , 'en')}}",

        most_sales_ar : "{{trans('website.most_sales' , [] , 'ar')}}",
        most_sales_en : "{{trans('website.most_sales' , [] , 'en')}}" ,

        sure_cancel_shipping : "{{trans('admin.sure_cancel_shipping')}}" ,
        cancel_shipping_order : "{{trans('admin.cancel_shipping_order')}}" ,
        cancel_shipping_not_done : "{{trans('admin.cancel_shipping_not_done')}}" ,
        cancel_shipping_done : "{{trans('admin.cancel_shipping_done')}}" ,
    };
</script>
<script src="{{url('')}}/admin_assets/assets/vendors/base/vendors.bundle.js" type="text/javascript"></script>
<script src="{{url('')}}/admin_assets/assets/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
<script src="{{url('')}}/admin_assets/assets/demo/default/custom/crud/forms/widgets/select2.js" type="text/javascript"></script>
<script src="{{url('')}}/admin_assets/assets/demo/default/custom/crud/forms/widgets/bootstrap-select.js" type="text/javascript"></script>
<script src="{{asset('js/app.js')}}"></script>
<script src="{{url('')}}/admin_assets/assets/general/js/vee_vue.js"  type="text/javascript" ></script>
{{--<script src="https://cdn.jsdelivr.net/npm/vee-validate@2.2.0/dist/vee-validate.min.js"></script>--}}
{{--<script src="https://unpkg.com/vee-validate@2.0.0-beta.25"></script>--}}
<script src="{{url('')}}/admin_assets/assets/general/js/general.js"  type="text/javascript" ></script>


<script>

    var admin_fcm = document.getElementById('get_admin_fcm').value;

    var vm_notification = new Vue({
        el : '#notification' ,
        data : {
            msg : '' ,
            page : 1 ,
            notifications : [],
            unread_count : '',
            loading : false,

        },
        created : function () {
            this.get_notifications();
        },
        methods : {

            get_notifications : function () {
                this.loading = true;
                var page = this.page;
                axios.get('/admin/get-notifications-pagination' ,
                    {
                        params : {
                            page : page
                        }
                    }
                ).then(function (res) {

                    res.data['notifications'].forEach(function (t) {
                        vm_notification.notifications.push(t);

                    });
                    vm_notification.loading = false;
                    vm_notification.unread_count =res.data['unread_count']
                }).catch(function (err) {
                    console.log(res.data);
                });
            },

            update_read_notification : function () {
                var page = this.page;

                axios.get('/admin/update-read-notification' ,
                    {
                        params : {
                            page : page
                        }
                    }
                ).then(function (res) {
                    vm_notification.notifications = [];
                    console.log(res.data['notifications']);
                    res.data['notifications'].forEach(function (t) {
                        vm_notification.notifications.push(t);
                    });
                    vm_notification.unread_count =res.data['unread_count']
                }).catch(function (err) {


                });
            },
            next_page : function () {
                this.page = this.page + 1;
            }
        },

        watch : {
            page : function () {
                this.get_notifications();
            }
        }
    });
</script>

{{--   FCM   --}}

<script src="https://www.gstatic.com/firebasejs/4.10.1/firebase.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.10.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/4.10.1/firebase-messaging.js"></script>

{{--<script>--}}

  {{--//  let audio = new Audio('https://saidalista.com/bell.mp3');--}}
  {{--var myMusic= document.getElementById("music");--}}

    {{--var config = {--}}
        {{--apiKey: "AIzaSyDsO5D7KONVKfNWMTNATWQACHCZacQq4Jc",--}}
        {{--authDomain: "raqeeapp.firebaseapp.com",--}}
        {{--databaseURL: "https://raqeeapp.firebaseio.com",--}}
        {{--projectId: "raqeeapp",--}}
        {{--storageBucket: "raqeeapp.appspot.com",--}}
        {{--messagingSenderId: "469444076609"--}}
    {{--};--}}
    {{--firebase.initializeApp(config);--}}
    {{--var messaging = firebase.messaging();--}}

    {{--if(!admin_fcm) {--}}
        {{--messaging.requestPermission()--}}
            {{--.then(function () {--}}

                {{--//  console.log('Notification permission granted.');--}}
                {{--return messaging.getToken();--}}
            {{--})--}}
            {{--.then(function (token) {--}}
                {{--axios.post("/admin/set-fcm" ,--}}
                    {{--{--}}
                        {{--fcm : token--}}
                    {{--}--}}
                {{--).then(function (res) {--}}
                    {{--console.log(res.data);--}}
                {{--}).catch(function (err) {});--}}

            {{--})--}}
            {{--.catch(function (err) {--}}
                {{--console.log('Unable to get permission to notify.', err);--}}
            {{--});--}}


        {{--messaging.getToken().then(function (currentToken) {--}}
            {{--if (currentToken) {--}}

            {{--} else {--}}
                {{--console.log('No Instance ID token available. Request permission to generate one.');--}}
            {{--}--}}
        {{--}).catch(function (err) {--}}
            {{--console.log('An error occurred while retrieving token. ', err);--}}
        {{--});--}}
    {{--}--}}

     {{--messaging.onTokenRefresh(function() {--}}
        {{--messaging.getToken()--}}
            {{--.then(function(refreshedToken) {--}}

              {{--axios.post("/admin/set-fcm" ,--}}
                  {{--{--}}
                      {{--fcm : refreshedToken--}}
                  {{--}--}}
              {{--).then(function (res) {--}}
                  {{--console.log(res.data);--}}
              {{--}).catch(function (err) {});--}}
          {{--})--}}
          {{--.catch(function(err) {--}}
              {{--console.log('Unable to retrieve refreshed token ', err);--}}
          {{--});--}}
  {{--});--}}

    {{--messaging.onMessage(function (payload) {--}}
        {{--console.log(payload);--}}
        {{--myMusic.play();--}}
        {{--var notification = {--}}
            {{--order_id : payload.data.order_id ,--}}
            {{--title : payload.data.title ,--}}
            {{--sub_title : payload.data.sub_title ,--}}
            {{--human_date : payload.data.human_date ,--}}
            {{--read_at : payload.data.read_at ,--}}
            {{--url :payload.data.url ,--}}
        {{--};--}}
        {{--vm_notification.notifications.unshift(notification);--}}
        {{--vm_notification.unread_count = vm_notification.unread_count + 1;--}}
        {{--toastr.options = {--}}
            {{--"closeButton": false,--}}
            {{--"debug": false,--}}
            {{--"newestOnTop": false,--}}
            {{--"progressBar": false,--}}
            {{--"positionClass": "toast-top-center",--}}
            {{--"preventDuplicates": false,--}}
            {{--"onclick": null,--}}
            {{--"showDuration": "300",--}}
            {{--"hideDuration": "2000",--}}
            {{--"timeOut": "7000",--}}
            {{--"extendedTimeOut": "1000",--}}
            {{--"showEasing": "swing",--}}
            {{--"hideEasing": "linear",--}}
            {{--"showMethod": "fadeIn",--}}
            {{--"hideMethod": "fadeOut"--}}
        {{--};--}}

        {{--toastr.success(payload.data.sub_title);--}}
    {{--});--}}


{{--</script>--}}


@stack('js')
<!--end::Global Theme Bundle -->
</body>

<!-- end::Body -->
</html>
<link href="{{url('')}}/admin_assets/assets/demo/default/base/customStyle.css" rel="stylesheet" type="text/css" />
