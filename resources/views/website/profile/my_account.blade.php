@extends('website.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@section('content-page')
    @include('website.partals.header')
    @include('website.partals.nav')



    <div class="send-form-page" >


        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                @foreach($breadcrumb_arr as $breadcrumb)
                    <li class="breadcrumb-item"><a href="{{$breadcrumb['url']}}">{{$breadcrumb['name']}}</a></li>
                @endforeach
                <li class="breadcrumb-item active" aria-current="page">{{$breadcrumb_last_item}}</li>
            </ol>
        </nav>


        <div class="container">
            <div class="head-title">
                {{$breadcrumb_last_item}}
            </div>
            <div class="alert alert-danger dan_alert hidden" role="alert">

            </div>
            <div class="alert alert-success suc_alert hidden" role="alert ">
            </div>

            <div class="profile-info">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">

                        <a class="col-6 col-md-6 nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                           href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">المعلومات
                            الشخصية</a>


                        <a class="col-6 col-md-6 nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
                           href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">معلومات
                            التوصيل</a>

                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    @include('website.profile.partals.my_account')

                    @include('website.profile.partals.shipping')
                </div>
            </div>

        </div>
    </div>

    @include('website.partals.subscribe')
    @include('website.partals.footer')
@stop()



@section('js')
    <script>
        var user = {!! $user !!};
        var user_shipping = {!! $user_shipping !!};
        var country_code = "{{$country_code}}";

    </script>
    <script src="{{url('')}}/website/general/js/user/profile.js" type="text/javascript"></script>
    <script src="{{url('')}}/website/general/js/user/shipping.js" type="text/javascript"></script>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>


@endsection