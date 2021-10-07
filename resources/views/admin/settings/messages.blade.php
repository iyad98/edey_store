@extends('admin.layout')


@push('css')



@endpush


@section('content')
    <!-- BEGIN: Subheader -->

    <!-- END: Subheader -->
    <div class="m-content" id="app">

        <div class="m-portlet add_form hidden">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                        <h3 class="m-portlet__head-text"
                            v-text="add ? '{{trans('admin.add_new_offer')}}' : '{{trans('admin.edit_offer')}}'">
                        </h3>
                    </div>
                </div>
            </div>

            <!--begin::Form-->



            <!--end::Form-->
        </div>

        <div class="m-portlet m-portlet--mobile show_data">
            <div class="m-portlet__body" id="app">
                <form class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                    {{csrf_field()}}
                    <div class="m-portlet__body">

                        <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>

                        <div class="form-group m-form__group row top_row">
                            <div class="col-sm-4">
                                <label>{{$sms_user_account->name}}</label>
                                <input class="form-control"  v-model="settings.sms_user_account" placeholder="" />
                            </div>
                            <div class="col-sm-4">
                                <label>{{$sms_user_pass->name}}</label>
                                <input class="form-control"  v-model="settings.sms_user_pass" placeholder="" />
                            </div>
                            <div class="col-sm-4">
                                <label>{{$sms_sender->name}}</label>
                                <input class="form-control"  v-model="settings.sms_sender" placeholder="" />
                            </div>

                            <div class="col-sm-4"></div>
                            <div class="col-sm-4 mt-4">

                                <div class="alert alert-primary alert-dismissible fade show   m-alert m-alert--air m-alert--outline" role="alert">
                                    {{$balance}}
                                </div>
                            </div>
                            <div class="col-sm-4"></div>

                        </div>

                        <div class="form-group m-form__group row">
                            <div class="col-sm-6">
                                <label>{{trans('admin.cash_ar')}}</label>
                                <textarea class="form-control" style="height: 150px;" v-model="settings.cash_text_ar" placeholder=""></textarea>
                            </div>
                            <div class="col-sm-6">
                                <label>{{trans('admin.cash_en')}}</label>
                                <textarea dir="ltr" class="form-control" style="height: 150px;" v-model="settings.cash_text_en" placeholder=""></textarea>
                            </div>


                            <div class="col-sm-6">
                                <label>{{trans('admin.visa_ar')}}</label>
                                <textarea class="form-control" style="height: 150px;" v-model="settings.visa_text_ar" placeholder=""></textarea>
                            </div>
                            <div class="col-sm-6">
                                <label>{{trans('admin.visa_en')}}</label>
                                <textarea dir="ltr" class="form-control" style="height: 150px;" v-model="settings.visa_text_en" placeholder=""></textarea>
                            </div>


                            {{--<div class="col-sm-6">--}}
                                {{--<label>{{trans('admin.bank_ar')}}</label>--}}
                                {{--<textarea class="form-control" style="height: 150px;" v-model="settings.bank_transfer_text_ar" placeholder=""></textarea>--}}
                            {{--</div>--}}
                            {{--<div class="col-sm-6">--}}
                                {{--<label>{{trans('admin.bank_en')}}</label>--}}
                                {{--<textarea dir="ltr" class="form-control" style="height: 150px;" v-model="settings.bank_transfer_text_en" placeholder=""></textarea>--}}
                            {{--</div>--}}


                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-sm-6">
                                <label>{{trans('admin.shipping_order_ar')}}</label>
                                <textarea class="form-control" style="height: 150px;" v-model="settings.shipping_order_ar" placeholder=""></textarea>
                            </div>
                            <div class="col-sm-6">
                                <label>{{trans('admin.shipping_order_en')}}</label>
                                <textarea dir="ltr" class="form-control" style="height: 150px;" v-model="settings.shipping_order_en" placeholder=""></textarea>
                            </div>

                            <div class="col-sm-6">
                                <label>{{trans('admin.finished_order_ar')}}</label>
                                <textarea class="form-control" style="height: 150px;" v-model="settings.finished_order_ar" placeholder=""></textarea>
                            </div>
                            <div class="col-sm-6">
                                <label>{{trans('admin.finished_order_en')}}</label>
                                <textarea dir="ltr" class="form-control" style="height: 150px;" v-model="settings.finished_order_en" placeholder=""></textarea>
                            </div>

                            <div class="col-sm-6">
                                <label>{{trans('admin.cancel_order_ar')}}</label>
                                <textarea class="form-control" style="height: 150px;" v-model="settings.cancel_order_ar" placeholder=""></textarea>
                            </div>
                            <div class="col-sm-6">
                                <label>{{trans('admin.cancel_order_en')}}</label>
                                <textarea dir="ltr" class="form-control" style="height: 150px;" v-model="settings.cancel_order_en" placeholder=""></textarea>
                            </div>

                            <div class="col-sm-6">
                                <label>{{trans('admin.failed_order_ar')}}</label>
                                <textarea class="form-control" style="height: 150px;" v-model="settings.failed_order_ar" placeholder=""></textarea>
                            </div>
                            <div class="col-sm-6">
                                <label>{{trans('admin.failed_order_en')}}</label>
                                <textarea dir="ltr" class="form-control" style="height: 150px;" v-model="settings.failed_order_en" placeholder=""></textarea>
                            </div>

                            <div class="col-sm-6">
                                <label>{{trans('admin.order_in_the_warehouse_ar')}}</label>
                                <textarea class="form-control" style="height: 150px;" v-model="settings.order_in_the_warehouse_ar" placeholder=""></textarea>
                            </div>
                            <div class="col-sm-6">
                                <label>{{trans('admin.order_in_the_warehouse_en')}}</label>
                                <textarea dir="ltr" class="form-control" style="height: 150px;" v-model="settings.order_in_the_warehouse_en" placeholder=""></textarea>
                            </div>

                        </div>


                    </div>
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row top_row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4">
                                    <button style="width: 215px;margin-bottom: 15px;" type="button" :disabled="loading" @click="validateForm"
                                            class="btn m-btn btn-primary"
                                            :class="loading ? 'm-loader m-loader--light m-loader--left' : ''">
                                        {{trans('admin.save')}}
                                    </button>
                                </div>
                                <div class="col-lg-4"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
@endsection





@push('js')

    <script src="{{url('')}}/admin_assets/assets/demo/default/custom/crud/forms/widgets/summernote.js" type="text/javascript"></script>

    <script>
        var cash = {!! $cash !!};
        var visa = {!! $visa !!};
        var bank_transfer = {!! $bank_transfer !!};

        var shipping_order = {!! $shipping_order !!};
        var finished_order = {!! $finished_order !!};

        var cancel_order = {!! $cancel_order !!};
        var failed_order = {!! $failed_order !!};
        var order_in_the_warehouse = {!! $order_in_the_warehouse !!}


        var sms_user_account = {!! $sms_user_account !!};
        var sms_user_pass = {!! $sms_user_pass !!};
        var sms_sender = {!! $sms_sender !!};

    </script>
    <script src="{{url('')}}/admin_assets/assets/general/js/settings/messages.js"
            type="text/javascript"></script>

@endpush

