@extends('website_v2.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection


@section('content')

    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{asset('/')}}">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">حسابي</li>
            </ol>
        </div>
    </div>
    <div class="content_innerPage" id="shipping">
        <div class="container">
            <h2 class="title_page">حسابي</h2>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    <div class="side_menu_profile">
                        <ul class="menu_profile">
                            <li><a href="{{LaravelLocalization::localizeUrl('my-account') }}">{{trans('website.user_info')}}</a></li>
                            <li class="active"><a href="{{LaravelLocalization::localizeUrl('my-account/addresses') }}">{{trans('website.my_addresses')}}</a></li>
                            <li ><a href="{{LaravelLocalization::localizeUrl('my-account/create-address') }}">{{trans('website.add_new_address')}}</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="alert alert-danger dan_alert hidden" role="alert">

                    </div>
                    <div class="alert alert-success suc_alert hidden" role="alert ">

                    </div>
                    <div class="delivery_info">
                        <div class="row">
                            @foreach($all_user_shipping as $user_shipping)

                            <div class="col-md-12" :class="'shipping_class_'+{{$user_shipping->id}}">

                                <div class="single-title">
                                    <span class="title-span"> {{is_verified_text($user_shipping->is_verified)}}</span>
                                    <ul>
                                        <li>
                                            <span>الاسم :</span> {{isset($user_shipping->first_name)?$user_shipping->first_name:'' }} {{isset($user_shipping->last_name)?$user_shipping->last_name:''}}
                                        </li>
                                        <li>
                                            <span>رقم الجوال : </span> {{isset($user_shipping->phone)?$user_shipping->phone :'' }}
                                        </li>

                                        <li>
                                            <span>المدينة :</span>{{ isset($user_shipping->shipping_city) ? $user_shipping->shipping_city['name'] : ''}} </li>
                                        <span>القطعة :</span> {{isset($user_shipping->state)?$user_shipping->state:''}}

                                        <li>
                                            <span>الشارع : </span>{{isset($user_shipping->street)?$user_shipping->street:''}}
                                            <span>الجادة : </span> {{isset($user_shipping->avenue)?$user_shipping->avenue :'' }}
                                        </li>
                                        <li>
                                            <span>رقم المبني :</span> {{isset($user_shipping->building_number)?$user_shipping->building_number:''}}
                                            <span>رقم الطابق :</span> {{isset($user_shipping->floor_number)?$user_shipping->floor_number:''}}
                                        </li>
                                        <li>
                                            <span> رقم الشقة :</span> {{isset($user_shipping->apartment_number)?$user_shipping->apartment_number:''}}
                                        </li>

                                    </ul>
                                    <div class="actionRow">

                                        <a class="editAction" href="{{LaravelLocalization::localizeUrl('my-account/edit-address/'.$user_shipping->id) }}">{{trans('website.edit')}}</a>
                                        <span class="dots">●</span>
                                        <button class="deleteAction" @click="delete_address({{$user_shipping->id}})">{{trans('website.delete')}}</button>
                                    </div>
                                </div>
                            </div>
                            @endforeach


                        </div>

                        <div class="row">


                            <div class="col md-12 ">
                                <a href="{{LaravelLocalization::localizeUrl('my-account/create-address') }}"  class="btn btn_prim  add-title">{{trans('website.add_new_address')}}</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('css')
@endsection

@section('js')
    <script>
        var user = {!! $user !!};
        var user_shipping = {!! $user_shipping !!};
        var country_code = "{{$country_code}}";

    </script>
    <script src="{{url('')}}/website/general/js/user/profile.js" type="text/javascript"></script>
    <script src="{{url('')}}/website/general/js/user/shipping.js" type="text/javascript"></script>

@endsection
