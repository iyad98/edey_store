@extends('website.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@push('css')

    <style>
        input, textarea {
            width: 100%;
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
                                    @foreach($breadcrumb_arr as $key=>$breadcrumb)
                                        @if($key+1 == count($breadcrumb_arr))
                                            {{$breadcrumb['name']}}
                                        @else
                                            <a href="{{$breadcrumb['url']}}">{{$breadcrumb['name']}}</a>
                                        @endif
                                    @endforeach
                                </nav>
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="" id="details_page">
        <div class="container">
            <div class="row">
                <div class="col-md-12 margin-t-b">
                    <div class="single-page">
                        <div class="row">
                            <div class="col-md-12 margin-t-b">
                                <div class="des-10 page-vc">
                                    <div class="vc_row wpb_row vc_row-fluid vc_custom_1464951274092">
                                        <div class="wpb_column vc_column_container vc_col-sm-6">
                                            <div class="vc_column-inner ">
                                                <div class="wpb_wrapper">
                                                    <div class="wpb_text_column wpb_content_element  vc_custom_1511098281840">
                                                        <div class="wpb_wrapper">
                                                            <h3>بيانات التواصل</h3>

                                                        </div>
                                                    </div>

                                                    <div class="wpb_text_column wpb_content_element "
                                                         style="margin-top: 7px;">
                                                        <div class="wpb_wrapper">
                                                            <div class="block-content clearfix">
                                                                <p class="c-address"> {{$footer_data['place']}}                                                                 </p>
                                                                <p class="c-email">{{$footer_data['email']}}</p>
                                                                <p class="c-phone"><label>{{trans('website.phone')}}:&nbsp;{{$footer_data['phone']}}</label>
                                                                </p>
                                                                {!! $contact_us !!}
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="wpb_column vc_column_container vc_col-sm-6">
                                            <div class="vc_column-inner ">
                                                <div class="wpb_wrapper">
                                                    <div class="wpb_text_column wpb_content_element  vc_custom_1511098270033">
                                                        <div class="wpb_wrapper">
                                                            <h3>{{trans('website.contact_us')}}</h3>

                                                        </div>
                                                    </div>
                                                    <ul class="msg woocommerce-error hidden" role="alert"
                                                        v-show="error_msg != ''">
                                                        <li><strong>{{trans('website.error_')}}:</strong> @{{ error_msg
                                                            }}
                                                        </li>
                                                    </ul>


                                                    <div v-show="success_msg != ''"
                                                         class="msg hidden woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
                                                        @{{ success_msg }}
                                                    </div>
                                                    <form>
                                                        <div>

                                                            <div class="nf-form-content ">

                                                                <div id="nf-field-1-container"
                                                                     class="nf-field-container textbox-container  label-above ">

                                                                    <div class="nf-field">
                                                                        <div id="nf-field-1-wrap"
                                                                             class="field-wrap textbox-wrap nf-fail "
                                                                             data-field-id="1">


                                                                            <div class="nf-field-label">
                                                                                <label for="nf-field-1"
                                                                                       id="nf-label-field-1"
                                                                                       class="">{{trans('website.full_name')}}
                                                                                    <span class="ninja-forms-req-symbol">*</span>
                                                                                </label></div>


                                                                            <div class="nf-field-element">
                                                                                <input type="text"
                                                                                       v-model="contact.name"
                                                                                       value=""
                                                                                       class="ninja-forms-field nf-element"
                                                                                       id="nf-field-1"
                                                                                       name="nf-field-1"
                                                                                       aria-invalid="true"
                                                                                       aria-describedby="-1"
                                                                                       aria-labelledby="nf-label-field-1"
                                                                                       required="">
                                                                            </div>


                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div id="nf-field-2-container"
                                                                     class="nf-field-container email-container  label-above ">

                                                                    <div class="nf-field">
                                                                        <div id="nf-field-2-wrap"
                                                                             class="field-wrap email-wrap nf-fail "
                                                                             data-field-id="2">


                                                                            <div class="nf-field-label">
                                                                                <label for="nf-field-2"
                                                                                       id="nf-label-field-2"
                                                                                       class="">{{trans('website.email')}}
                                                                                    <span
                                                                                            class="ninja-forms-req-symbol">*</span>
                                                                                </label></div>


                                                                            <div class="nf-field-element">
                                                                                <input type="email"
                                                                                       v-model="contact.email"
                                                                                       value=""
                                                                                       class="ninja-forms-field nf-element"
                                                                                       id="nf-field-2"
                                                                                       name="email"
                                                                                       autocomplete="email"
                                                                                       aria-invalid="true"
                                                                                       aria-describedby="-2"
                                                                                       aria-labelledby="nf-label-field-2"
                                                                                       required="">
                                                                            </div>


                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div id="nf-field-3-container"
                                                                     class="nf-field-container email-container  label-above ">

                                                                    <div class="nf-field">
                                                                        <div id="nf-field-2-wrap"
                                                                             class="field-wrap email-wrap nf-fail "
                                                                             data-field-id="2">


                                                                            <div class="nf-field-label">
                                                                                <label for="nf-field-2"
                                                                                       id="nf-label-field-2"
                                                                                       class="">{{trans('website.phone')}}
                                                                                    <span
                                                                                            class="ninja-forms-req-symbol">*</span>
                                                                                </label></div>


                                                                            <div class="nf-field-element">
                                                                                <input type="email"
                                                                                       v-model="contact.phone"
                                                                                       value=""
                                                                                       class="ninja-forms-field nf-element"
                                                                                       id="nf-field-2"
                                                                                       name="phone"
                                                                                      >
                                                                            </div>


                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div id="nf-field-4-container"
                                                                     class="nf-field-container textarea-container  label-above ">

                                                                    <div class="nf-field">
                                                                        <div id="nf-field-3-wrap"
                                                                             class="field-wrap textarea-wrap"
                                                                             data-field-id="3">


                                                                            <div class="nf-field-label">
                                                                                <label for="nf-field-3"
                                                                                       id="nf-label-field-3"
                                                                                       class="">{{trans('website.message')}}
                                                                                    <span class="ninja-forms-req-symbol">*</span>
                                                                                </label></div>


                                                                            <div class="nf-field-element">
                                                                                                    <textarea
                                                                                                            v-model="contact.message"
                                                                                                            id="nf-field-3"
                                                                                                            name="nf-field-3"
                                                                                                            aria-invalid="false"
                                                                                                            aria-describedby="-3"
                                                                                                            class="ninja-forms-field nf-element"
                                                                                                            aria-labelledby="nf-label-field-3"
                                                                                                            required=""></textarea>
                                                                            </div>


                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <div id="nf-field-5-container"
                                                                     class="nf-field-container submit-container  label-above  textbox-container">
                                                                    <div class="nf-before-field">

                                                                    </div>
                                                                    <div class="nf-field">

                                                                        <div id="nf-field-4-wrap"
                                                                             class="field-wrap submit-wrap textbox-wrap"
                                                                             data-field-id="4">
                                                                            <div class="nf-field-label"></div>
                                                                            <div class="nf-field-element">

                                                                                <input id="nf-field-4"
                                                                                       class="ninja-forms-field nf-element "
                                                                                       type="button"
                                                                                       @click="send_contact"
                                                                                       value="{{trans('website.send_conatct_us')}}"
                                                                                >
                                                                            </div>
                                                                            <div class="-wrap"></div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="nf-after-field">

                                                                    </div>
                                                                </div>

                                                            </div>

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
        </div>
    </div>
@endsection

@push('js')
    <script src="{{url('')}}/website/general/js/contact/contact.js" type="text/javascript"></script>


@endpush