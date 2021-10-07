@extends('website.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>
    <style>
        .woocommerce-MyAccount-navigation {
            float: right;
        }
        .woocommerce-MyAccount-content {
            width: 77%;
            float: left;
        }
    </style>
@endpush


@section('content')
    <div class="page-header page_">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>{{$breadcrumb_title}}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="breadcrumb">
                        <div id="primary" class="content-area">
                            <main id="main" class="site-main" role="main">
                                <nav class="woocommerce-breadcrumb">
                                    @foreach($breadcrumb_arr as $breadcrumb)
                                        <a href="{{$breadcrumb['url']}}">{{$breadcrumb['name']}}</a>
                                    @endforeach

                                    {{$breadcrumb_last_item}}
                                </nav>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="" id="shipping">
        <div class="container">
            <div class="row">
                <div class="col-md-12 margin-t-b">
                    <div class="single-page">
                        <div class="row">
                            <div class="col-md-12 margin-t-b ">
                                <div class="single-img">
                                </div>

                            </div>
                            <div class="col-md-12 margin-t-b">
                                <div class="des-10">
                                    <div class="woocommerce">
                                        @include('website.my_account.menu')

                                        <div class="woocommerce-MyAccount-content">

                                            <ul class="woocommerce-error hidden" role="alert" v-show="error_msg != '' ">
                                                <li><strong>{{trans('website.error_')}}:</strong> @{{ error_msg }} </li>
                                            </ul>

                                            <div v-show="success_msg != '' " class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info hidden">
                                                @{{ success_msg }}
                                            </div>

                                            <div class="woocommerce-notices-wrapper"></div>

                                            <form method="post">

                                                <h3>{{trans('website.billing_address')}}</h3>
                                                <div class="woocommerce-billing-fields__field-wrapper">
                                                    <p class="form-row form-row-first thwcfd-field-wrapper thwcfd-field-text validate-required"
                                                       id="billing_first_name_field" data-priority="10"><label
                                                                for="billing_first_name" class="">{{trans('website.first_name')}}&nbsp;<abbr
                                                                    class="required"
                                                                    title="مطلوب">*</abbr></label><span
                                                                class="woocommerce-input-wrapper"><input v-model="user_shipping.first_name"
                                                                                                         type="text" class="input-text "
                                                                                                         name="billing_first_name"
                                                                                                         id="billing_first_name" placeholder=""
                                                                                                         value="" autocomplete="given-name"></span>
                                                    </p>
                                                    <p class="form-row form-row-last thwcfd-field-wrapper thwcfd-field-text validate-required"
                                                       id="billing_last_name_field" data-priority="20"><label
                                                                for="billing_last_name" class="">{{trans('website.last_name')}}&nbsp;<abbr
                                                                    class="required"
                                                                    title="مطلوب">*</abbr></label><span
                                                                class="woocommerce-input-wrapper"><input v-model="user_shipping.last_name"
                                                                                                         type="text" class="input-text "
                                                                                                         name="billing_last_name"
                                                                                                         id="billing_last_name" placeholder=""
                                                                                                         value="" autocomplete="family-name"></span>
                                                    </p>
                                                    <p class="form-row form-row-wide address-field update_totals_on_change thwcfd-field-wrapper thwcfd-field-country validate-required"
                                                       id="billing_country_field" data-priority="30"><label
                                                                for="billing_country" class="">{{trans('website.country')}}&nbsp;<abbr
                                                                    class="required"
                                                                    title="مطلوب">*</abbr></label>

                                                        <select class="js-example-basic-single select_country"
                                                                disabled>
                                                            @foreach($countries as $country)
                                                                <option value="{{$country->iso2}}">{{$country->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </p>

                                                    <p class="form-row form-row-wide address-field thwcfd-field-wrapper thwcfd-field-text validate-required"
                                                       id="billing_city_field" data-priority="40"
                                                       data-o_class="form-row form-row-wide address-field thwcfd-field-wrapper thwcfd-field-text validate-required">
                                                        <label for="billing_city" class="">{{trans('website.city')}}&nbsp;<abbr
                                                                    class="required"
                                                                    title="مطلوب">*</abbr></label><span
                                                                class="woocommerce-input-wrapper">

                                                                    <select class="js-example-basic-single select_city"
                                                                            name="state">
                                                                        <option value="">{{trans('website.choose_your_city')}}</option>
                                                                        </select>
                                                                </span>
                                                    </p>
                                                    <p class="form-row form-row-wide thwcfd-field-wrapper thwcfd-field-text validate-required"
                                                       id="city2_field" data-priority="50"
                                                       style="display: none;"><label for="city2" class="">{{trans('website.others')}}&nbsp;<abbr
                                                                    class="required"
                                                                    title="مطلوب">*</abbr></label><span
                                                                class="woocommerce-input-wrapper"><input
                                                                    type="text" class="input-text " name="city2"
                                                                    id="city2" placeholder="{{trans('website.city')}}"
                                                                    value=""></span></p>
                                                    <p class="form-row form-row-wide address-field thwcfd-field-wrapper thwcfd-field-text validate-required"
                                                       id="billing_address_1_field" data-priority="60"><label
                                                                for="billing_address_1" class="">{{trans('website.street_address')}}&nbsp;<abbr class="required"
                                                                                                                                                title="مطلوب">*</abbr></label><span
                                                                class="woocommerce-input-wrapper"><input v-model="user_shipping.address"
                                                                                                         type="text" class="input-text "
                                                                                                         name="billing_address_1"
                                                                                                         id="billing_address_1"
                                                                                                         placeholder="{{trans('website.street_address')}}"
                                                                                                         value=""
                                                                                                         autocomplete="address-line1"></span></p>
                                                    <p class="form-row form-row-wide address-field thwcfd-field-wrapper thwcfd-field-state validate-state"
                                                       id="billing_state_field" data-priority="80"
                                                       data-o_class="form-row form-row-wide address-field thwcfd-field-wrapper thwcfd-field-state validate-state">
                                                        <label for="billing_state" class="">{{trans('website.governorate')}}&nbsp;<span
                                                                    class="optional">{{trans('website.optional')}}</span></label><span
                                                                class="woocommerce-input-wrapper"><input v-model="user_shipping.state"
                                                                                                         type="text" class="input-text " value=""
                                                                                                         placeholder="" name="billing_state"
                                                                                                         id="billing_state"
                                                                                                         autocomplete="address-level1"></span></p>
                                                    <p class="form-row form-row-wide thwcfd-field-wrapper thwcfd-field-tel validate-required validate-phone"
                                                       id="billing_phone_field" data-priority="100"><label
                                                                for="billing_phone" class="">{{trans('website.phone')}}&nbsp;<abbr
                                                                    class="required"
                                                                    title="مطلوب">*</abbr></label><span
                                                                class="woocommerce-input-wrapper"><input v-model="user_shipping.phone"
                                                                                                         type="tel" class="input-text "
                                                                                                         name="billing_phone" id="billing_phone"
                                                                                                         placeholder="" value="" autocomplete="tel"></span>
                                                    </p>
                                                    <p class="form-row form-row-wide thwcfd-field-wrapper thwcfd-field-email validate-required validate-email"
                                                       id="billing_email_field" data-priority="110"><label
                                                                for="billing_email" class="">{{trans('website.email')}}&nbsp;<abbr
                                                                    class="required"
                                                                    title="مطلوب">*</abbr></label><span
                                                                class="woocommerce-input-wrapper"><input v-model="user_shipping.email"
                                                                                                         type="email" class="input-text "
                                                                                                         name="billing_email" id="billing_email"
                                                                                                         placeholder="" value="fowzan@alfowzan.com"
                                                                                                         autocomplete="email username"></span>
                                                    </p>
                                                    <p class="form-row form-row-wide billing_shipping_type thwcfd-field-wrapper thwcfd-field-select validate-required"
                                                       id="billing_shipping_type_field" data-priority="120">
                                                        <label for="billing_shipping_type" class="">{{trans('website.shipping_company')}}&nbsp;<abbr
                                                                    class="required"
                                                                    title="مطلوب">*</abbr></label><span
                                                                class="woocommerce-input-wrapper">

                                                                <select class="js-example-basic-single select_shipping_company"
                                                                        name="state">
                                                                         <option value="">{{trans('website.select_shipping_company')}}</option>

                                                                        </select>
                                                                </span>
                                                    </p>

                                                    <p v-show="billing_national_address" class="hidden extra_shipping form-row form-row-wide thwcfd-field-wrapper thwcfd-field-email validate-required validate-email"
                                                       id="billing_national_address" data-priority="110"><label
                                                                for="billing_email" class="">{{trans('website.national_address')}}&nbsp;<abbr
                                                                    class="required"
                                                                    title="مطلوب">*</abbr></label><span
                                                                class="woocommerce-input-wrapper"><input v-model="user_shipping.billing_national_address"
                                                                                                         type="email" class="input-text "
                                                                                                         name="billing_email"
                                                                                                         placeholder="" value="fowzan@alfowzan.com"
                                                                                                         autocomplete="email username"></span>
                                                    </p>
                                                    <p v-show="billing_building_number" class="hidden extra_shipping form-row form-row-wide thwcfd-field-wrapper thwcfd-field-email validate-required validate-email"
                                                       id="billing_building_number" data-priority="110"><label
                                                                for="billing_email" class="">{{trans('website.building_number')}}&nbsp;<abbr
                                                                    class="required"
                                                                    title="مطلوب">*</abbr></label><span
                                                                class="woocommerce-input-wrapper"><input v-model="user_shipping.billing_building_number"
                                                                                                         type="email" class="input-text "
                                                                                                         name="billing_email"
                                                                                                         placeholder="" value="fowzan@alfowzan.com"
                                                                                                         autocomplete="email username"></span>
                                                    </p>
                                                    <p v-show="billing_postalcode_number" class="hidden extra_shipping form-row form-row-wide thwcfd-field-wrapper thwcfd-field-email validate-required validate-email"
                                                       id="billing_postalcode_number" data-priority="110"><label
                                                                for="billing_email" class="">{{trans('website.postalcode_number')}}&nbsp;<abbr
                                                                    class="required"
                                                                    title="مطلوب">*</abbr></label><span
                                                                class="woocommerce-input-wrapper"><input v-model="user_shipping.billing_postalcode_number"
                                                                                                         type="email" class="input-text "
                                                                                                         name="billing_email" id="billing_email"
                                                                                                         placeholder="" value="fowzan@alfowzan.com"
                                                                                                         autocomplete="email username"></span>
                                                    </p>
                                                    <p v-show="billing_unit_number" class="hidden extra_shipping form-row form-row-wide thwcfd-field-wrapper thwcfd-field-email validate-required validate-email"
                                                       id="billing_unit_number" data-priority="110"><label
                                                                for="billing_email" class="">{{trans('website.unit_number')}}&nbsp;<abbr
                                                                    class="required"
                                                                    title="مطلوب">*</abbr></label><span
                                                                class="woocommerce-input-wrapper"><input v-model="user_shipping.billing_unit_number"
                                                                                                         type="email" class="input-text "
                                                                                                         name="billing_email"
                                                                                                         placeholder="" value="fowzan@alfowzan.com"
                                                                                                         autocomplete="email username"></span>
                                                    </p>
                                                    <p v-show="billing_extra_number" class="hidden extra_shipping form-row form-row-wide thwcfd-field-wrapper thwcfd-field-email validate-required validate-email"
                                                       id="billing_extra_number" data-priority="110"><label
                                                                for="billing_email" class="">{{trans('website.additional_number')}}&nbsp;<abbr
                                                                    class="required"
                                                                    title="مطلوب">*</abbr></label><span
                                                                class="woocommerce-input-wrapper"><input v-model="user_shipping.billing_extra_number"
                                                                                                         type="email" class="input-text "
                                                                                                         name="billing_email"
                                                                                                         placeholder="" value="fowzan@alfowzan.com"
                                                                                                         autocomplete="email username"></span>
                                                    </p>

                                                    <p>
                                                        <button :disabled="loading" type="button" class="woocommerce-Button button" @click="update_shipping" value="حفظ العنوان">
                                                            <i v-show="loading" class="fa fa-spin fa-spinner"></i>
                                                            {{trans('website.save_information')}}
                                                        </button>
                                                    </p>
                                                </div>

                                            </form>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        var user_shipping = {!! $user_shipping !!};
        var country_code = "{{$country_code}}";
    </script>
    <script src="{{url('')}}/website/general/js/user/shipping.js" type="text/javascript"></script>

@endpush