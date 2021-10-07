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

                        <success-error-msg-component :success="msg.success"
                                                     :error="msg.error"></success-error-msg-component>

                        <div class="form-group m-form__group row top_row">
                            <div class="col-sm-3">
                                <label>{{trans('admin.tax')}} (%)</label>
                                <input type="text" v-model="settings.tax"
                                       name="tax"
                                       v-validate="'required|decimal'"
                                       :class="errors.has('tax') ? 'vue_border_error': ''"
                                       class="form-control m-input"

                                       placeholder="{{trans('admin.tax')}}">

                                <span class="m-form__help"
                                      :class="errors.has('tax') ? 'vue_error': ''"
                                      v-text="errors.has('tax') ? errors.first('tax') : ''"></span>
                            </div>
                            <div class="col-sm-3">
                                <label>{{trans('admin.default_shipping')}} ({{get_currency()}})</label>
                                <input type="text" v-model="settings.shipping"
                                       name="shipping"
                                       v-validate="'required|decimal'"
                                       :class="errors.has('shipping') ? 'vue_border_error': ''"
                                       class="form-control m-input"

                                       placeholder="{{trans('admin.shipping')}}">

                                <span class="m-form__help"
                                      :class="errors.has('shipping') ? 'vue_error': ''"
                                      v-text="errors.has('shipping') ? errors.first('shipping') : ''"></span>
                            </div>

                            <div class="col-sm-3">
                                <label>{{trans('admin.cancel_order_time')}}</label>
                                <input type="text" v-model="settings.cancel_order_time"
                                       name="shipping"
                                       v-validate="'required|decimal'"
                                       :class="errors.has('cancel_order_time') ? 'vue_border_error': ''"
                                       class="form-control m-input"

                                       placeholder="{{trans('admin.cancel_order_time')}}">

                                <span class="m-form__help"
                                      :class="errors.has('cancel_order_time') ? 'vue_error': ''"
                                      v-text="errors.has('cancel_order_time') ? errors.first('cancel_order_time') : ''"></span>
                            </div>

                            <div class="col-sm-3">
                                <label>{{trans('admin.point_price')}}</label>
                                <input type="text" v-model="settings.point_price"
                                       name="shipping"
                                       v-validate="'required|decimal'"
                                       :class="errors.has('point_price') ? 'vue_border_error': ''"
                                       class="form-control m-input"

                                       placeholder="{{trans('admin.point_price')}}">

                                <span class="m-form__help"
                                      :class="errors.has('point_price') ? 'vue_error': ''"
                                      v-text="errors.has('point_price') ? errors.first('point_price') : ''"></span>
                            </div>


                            {{--<div class="col-sm-3">--}}
                                {{--<label>{{trans('admin.first_order_discount')}} (%)</label>--}}
                                {{--<input type="text" v-model="settings.first_order_discount"--}}
                                       {{--name="tax"--}}
                                       {{--v-validate="'required|decimal'"--}}
                                       {{--:class="errors.has('first_order_discount') ? 'vue_border_error': ''"--}}
                                       {{--class="form-control m-input"--}}

                                       {{--placeholder="{{trans('admin.first_order_discount')}}">--}}

                                {{--<span class="m-form__help"--}}
                                      {{--:class="errors.has('first_order_discount') ? 'vue_error': ''"--}}
                                      {{--v-text="errors.has('first_order_discount') ? errors.first('first_order_discount') : ''"></span>--}}
                            {{--</div>--}}
                            {{--<div class="col-sm-3">--}}
                                {{--<label>{{trans('admin.package_discount_type')}} </label>--}}
                                {{--<div class="col-lg-12 col-md-12 col-sm-12">--}}
                                    {{--<select id="select_type_form" v-model="settings.package_discount_type"--}}
                                            {{--class="form-control " tabindex="-98">--}}

                                        {{--@foreach($coupon_types as $coupon_type)--}}
                                            {{--<option value="{{$coupon_type->id}}">{{$coupon_type->name}}</option>--}}
                                        {{--@endforeach--}}

                                    {{--</select>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-sm-4">--}}
                                {{--<label>{{trans('admin.failed_order_bank_time')}} (ساعات)</label>--}}
                                {{--<input type="text" v-model="settings.failed_order_bank_time"--}}
                                       {{--name="tax"--}}
                                       {{--v-validate="'required|decimal'"--}}
                                       {{--:class="errors.has('failed_order_bank_time') ? 'vue_border_error': ''"--}}
                                       {{--class="form-control m-input"--}}

                                       {{--placeholder="{{trans('admin.failed_order_bank_time')}}">--}}

                                {{--<span class="m-form__help"--}}
                                      {{--:class="errors.has('failed_order_bank_time') ? 'vue_error': ''"--}}
                                      {{--v-text="errors.has('failed_order_bank_time') ? errors.first('failed_order_bank_time') : ''"></span>--}}
                            {{--</div>--}}
                            {{--<div class="col-sm-4">--}}
                                {{--<label>{{trans('admin.return_order_time')}} (أيام)</label>--}}
                                {{--<input type="text" v-model="settings.return_order_time"--}}
                                       {{--name="return_order_time"--}}
                                       {{--v-validate="'required|decimal'"--}}
                                       {{--:class="errors.has('return_order_time') ? 'vue_border_error': ''"--}}
                                       {{--class="form-control m-input"--}}

                                       {{--placeholder="{{trans('admin.return_order_time')}}">--}}

                                {{--<span class="m-form__help"--}}
                                      {{--:class="errors.has('return_order_time') ? 'vue_error': ''"--}}
                                      {{--v-text="errors.has('return_order_time') ? errors.first('return_order_time') : ''"></span>--}}
                            {{--</div>--}}


                        </div>
                        <div class="form-group m-form__group row">
                            <div class="col-sm-6">
                                <label>{{trans('admin.checkout_label_ar')}}</label>
                                <input type="text" v-model="settings.checkout_label_ar"
                                       name="checkout_label"
                                       class="form-control m-input"
                                       placeholder="{{trans('admin.checkout_label_ar')}}">
                            </div>
                            <div class="col-sm-6">
                                <label>{{trans('admin.checkout_label_en')}}</label>
                                <input type="text" v-model="settings.checkout_label_en"
                                       name="checkout_label_en"
                                       class="form-control m-input"
                                       placeholder="{{trans('admin.checkout_label_en')}}">
                            </div>
                        </div>
                        <hr>
                        <div class="m-form__group form-group row" >
                            <label class="col-sm-2 col-form-label">{{trans('admin.close_app')}}</label>
                            <div class="col-sm-2">
																	 <span class="m-switch m-switch--outline m-switch--icon m-switch--info"><label><input
                                                                                     type="checkbox" name="" id="close_app"> <span></span></label></span>
                            </div>
                            <label class="col-sm-2 col-form-label">{{trans('admin.close_website')}}</label>
                            <div class="col-sm-2">
																	 <span class="m-switch m-switch--outline m-switch--icon m-switch--info"><label><input
                                                                                     type="checkbox" name="" id="close_website"> <span></span></label></span>
                            </div>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" v-model="settings.close_website_text" placeholder="{{trans('admin.close_website_text')}}">
                            </div>
                        </div>
                        <hr>

                    </div>
                    <div class="form-group m-form__group row top_row">
                        <div class="col-sm-3">
                            <label>{{trans('admin.price_tax_in_products')}} </label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <select v-model="settings.price_tax_in_products"
                                        class="form-control " tabindex="-98">
                                    <option value="1">{{trans('admin.with_tax')}}</option>
                                    <option value="0">{{trans('admin.without_tax')}}</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <label>{{trans('admin.price_tax_in_cart')}} </label>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <select v-model="settings.price_tax_in_cart"
                                        class="form-control " tabindex="-98">

                                    <option value="1">{{trans('admin.with_tax')}}</option>
                                    <option value="0">{{trans('admin.without_tax')}}</option>


                                </select>
                            </div>
                        </div>

                        {{--<div class="col-sm-3">--}}
                            {{--<label>{{trans('admin.product_details_note1')}}</label>--}}
                            {{--<input type="text" v-model="settings.product_details_note1"--}}
                                   {{--name="product_details_note1"--}}
                                   {{--class="form-control m-input"--}}
                                   {{--placeholder="{{trans('admin.product_details_note1')}}">--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-3">--}}
                            {{--<label>{{trans('admin.product_details_note2')}}</label>--}}
                            {{--<input type="text" v-model="settings.product_details_note2"--}}
                                   {{--name="product_details_note2"--}}
                                   {{--class="form-control m-input"--}}
                                   {{--placeholder="{{trans('admin.product_details_note2')}}">--}}
                        {{--</div>--}}

                        {{--<div class="col-sm-3">--}}
                            {{--<label>{{trans('admin.product_details_note_image')}}</label>--}}
                            {{--<input type="file" @change="get_file($event , '#product_details_note_image' , 'product_details_note_image')"--}}
                                   {{--class="form-control m-input"--}}
                                   {{--placeholder="{{trans('admin.image')}}">--}}
                            {{--<div class="input-group-prepend">--}}
                                    {{--<span class="input-group-text">--}}
                                        {{--<img id="product_details_note_image" width="100" height="100"--}}
                                             {{--:src="settings.product_details_note_image == ''? '{{get_general_path_default_image('settings')}}': '{{add_full_path($product_details_note_image->value , 'ads')}}'"--}}
                                        {{-->--}}
                                    {{--</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="col-sm-3">--}}
                            {{--<label>ملاحظه الخصم في صفحه المنتج</label>--}}
                            {{--<input type="text" v-model="settings.note_discount_product_details"--}}
                                   {{--name="shipping"--}}
                                   {{--:class="errors.has('note_discount_product_details') ? 'vue_border_error': ''"--}}
                                   {{--class="form-control m-input"--}}

                                   {{--placeholder="ملاحظه الخصم في صفحه المنتج">--}}

                            {{--<span class="m-form__help"--}}
                                  {{--:class="errors.has('note_discount_product_details') ? 'vue_error': ''"--}}
                                  {{--v-text="errors.has('note_discount_product_details') ? errors.first('note_discount_product_details') : ''"></span>--}}
                        {{--</div>--}}

                    </div>


                    <div class="form-group m-form__group row top_row">
                        <div class="col-sm-6">
                            <label>{{trans('admin.phone')}}</label>
                            <input type="text" v-model="settings.phone"
                                   name="phone"
                                   v-validate="'required'"
                                   :class="errors.has('phone') ? 'vue_border_error': ''"
                                   class="form-control m-input"

                                   placeholder="{{trans('admin.phone')}}">

                            <span class="m-form__help"
                                  :class="errors.has('phone') ? 'vue_error': ''"
                                  v-text="errors.has('phone') ? errors.first('phone') : ''"></span>
                        </div>
                        <div class="col-sm-6">
                            <label>{{trans('admin.email')}}</label>
                            <input type="text" v-model="settings.email"
                                   name="email"
                                   v-validate="'required'"
                                   :class="errors.has('email') ? 'vue_border_error': ''"
                                   class="form-control m-input"

                                   placeholder="{{trans('admin.email')}}">

                            <span class="m-form__help"
                                  :class="errors.has('email') ? 'vue_error': ''"
                                  v-text="errors.has('email') ? errors.first('email') : ''"></span>
                        </div>

                        <div class="col-sm-6">
                            <label>{{trans('admin.place_ar')}}</label>
                            <input type="text" v-model="settings.place_ar"
                                   name="place_ar"
                                   v-validate="'required'"
                                   :class="errors.has('place_ar') ? 'vue_border_error': ''"
                                   class="form-control m-input"

                                   placeholder="{{trans('admin.place_ar')}}">

                            <span class="m-form__help"
                                  :class="errors.has('place_ar') ? 'vue_error': ''"
                                  v-text="errors.has('place_ar') ? errors.first('place_ar') : ''"></span>
                        </div>
                        <div class="col-sm-6">
                            <label>{{trans('admin.place_en')}}</label>
                            <input type="text" v-model="settings.place_en"
                                   name="place_en"
                                   v-validate="'required'"
                                   :class="errors.has('place_en') ? 'vue_border_error': ''"
                                   class="form-control m-input"

                                   placeholder="{{trans('admin.place_en')}}">

                            <span class="m-form__help"
                                  :class="errors.has('place_en') ? 'vue_error': ''"
                                  v-text="errors.has('place_en') ? errors.first('place_en') : ''"></span>
                        </div>

                    </div>
                    <div class="form-group m-form__group row top_row">
                        <div class="col-sm-6">
                            <label>{{trans('admin.facebook')}}</label>
                            <input type="text" v-model="settings.facebook"
                                   name="facebook"
                                   v-validate="'required'"
                                   :class="errors.has('facebook') ? 'vue_border_error': ''"
                                   class="form-control m-input"

                                   placeholder="{{trans('admin.facebook')}}">

                            <span class="m-form__help"
                                  :class="errors.has('facebook') ? 'vue_error': ''"
                                  v-text="errors.has('facebook') ? errors.first('facebook') : ''"></span>
                        </div>
                        <div class="col-sm-6">
                            <label>{{trans('admin.twitter')}}</label>
                            <input type="text" v-model="settings.twitter"
                                   name="twitter"
                                   v-validate="'required'"
                                   :class="errors.has('twitter') ? 'vue_border_error': ''"
                                   class="form-control m-input"

                                   placeholder="{{trans('admin.twitter')}}">

                            <span class="m-form__help"
                                  :class="errors.has('twitter') ? 'vue_error': ''"
                                  v-text="errors.has('twitter') ? errors.first('phone') : ''"></span>
                        </div>
                        <div class="col-sm-6">
                            <label>{{trans('admin.snapchat')}}</label>
                            <input type="text" v-model="settings.snapchat"
                                   name="snapchat"
                                   v-validate="'required'"
                                   :class="errors.has('snapchat') ? 'vue_border_error': ''"
                                   class="form-control m-input"

                                   placeholder="{{trans('admin.snapchat')}}">

                            <span class="m-form__help"
                                  :class="errors.has('snapchat') ? 'vue_error': ''"
                                  v-text="errors.has('snapchat') ? errors.first('snapchat') : ''"></span>
                        </div>
                        <div class="col-sm-6">
                            <label>{{trans('admin.instagram')}}</label>
                            <input type="text" v-model="settings.instagram"
                                   name="instagram"
                                   v-validate="'required'"
                                   :class="errors.has('instagram') ? 'vue_border_error': ''"
                                   class="form-control m-input"

                                   placeholder="{{trans('admin.instagram')}}">

                            <span class="m-form__help"
                                  :class="errors.has('instagram') ? 'vue_error': ''"
                                  v-text="errors.has('instagram') ? errors.first('instagram') : ''"></span>
                        </div>
                        <div class="col-sm-6">
                            <label>{{trans('admin.youtube')}}</label>
                            <input type="text" v-model="settings.youtube"
                                   name="youtube"
                                   v-validate="'required'"
                                   :class="errors.has('youtube') ? 'vue_border_error': ''"
                                   class="form-control m-input"

                                   placeholder="{{trans('admin.youtube')}}">

                            <span class="m-form__help"
                                  :class="errors.has('youtube') ? 'vue_error': ''"
                                  v-text="errors.has('youtube') ? errors.first('youtube') : ''"></span>
                        </div>

                        <div class="col-sm-6">
                            <label>{{trans('admin.telegram')}}</label>
                            <input type="text" v-model="settings.telegram"
                                   name="telegram"
                                   v-validate="'required'"
                                   :class="errors.has('telegram') ? 'vue_border_error': ''"
                                   class="form-control m-input"

                                   placeholder="{{trans('admin.telegram')}}">

                            <span class="m-form__help"
                                  :class="errors.has('telegram') ? 'vue_error': ''"
                                  v-text="errors.has('telegram') ? errors.first('telegram') : ''"></span>
                        </div>


                    </div>
                    {{--<div class="form-group m-form__group row">--}}
                        {{--<div class="col-sm-4">--}}
                            {{--<label>{{trans('admin.cash_note_ar')}}</label>--}}
                            {{--<textarea class="form-control" v-model="settings.cash_note_ar"></textarea>--}}

                        {{--</div>--}}
                        {{--<div class="col-sm-4">--}}
                            {{--<label>{{trans('admin.cash_note_en')}}</label>--}}
                            {{--<textarea class="form-control" v-model="settings.cash_note_en"></textarea>--}}

                        {{--</div>--}}

                        {{--<div class="col-sm-4">--}}
                            {{--<label>{{trans('admin.bank_note_ar')}}</label>--}}
                            {{--<textarea class="form-control" v-model="settings.bank_note_ar"></textarea>--}}

                        {{--</div>--}}
                        {{--<div class="col-sm-4">--}}
                            {{--<label>{{trans('admin.bank_note_en')}}</label>--}}
                            {{--<textarea class="form-control" v-model="settings.bank_note_en"></textarea>--}}

                        {{--</div>--}}


                        {{--<div class="col-sm-4">--}}
                            {{--<label>{{trans('admin.visa_note_ar')}}</label>--}}
                            {{--<textarea class="form-control" v-model="settings.visa_note_ar"></textarea>--}}
                        {{--</div>--}}
                        {{--<div class="col-sm-4">--}}
                            {{--<label>{{trans('admin.visa_note_en')}}</label>--}}
                            {{--<textarea class="form-control" v-model="settings.visa_note_en"></textarea>--}}
                        {{--</div>--}}


                    {{--</div>--}}

                    <div class="form-group m-form__group row">
                        <div class="col-lg-6">
                            <label>{{trans('admin.about_us_ar')}}</label>
                            <textarea
                                    class="summernote about_ar"
                                    name="about_us_ar"
                                    placeholder="{{trans('admin.about_us_ar')}}"
                            ></textarea>

                        </div>
                        <div class="col-lg-6">
                            <label>{{trans('admin.about_us_en')}}</label>
                            <textarea
                                    class="summernote about_en"
                                    name="about_us_en"
                                    placeholder="{{trans('admin.about_us_en')}}"
                            ></textarea>


                        </div>

                        <div class="col-lg-6">
                            <label>{{trans('admin.policy_replacement_ar')}}</label>
                            <textarea
                                    class="summernote policy_ar"
                                    name="policy_replacement_ar"
                                    placeholder="{{trans('admin.policy_replacement_ar')}}"
                            ></textarea>
                        </div>
                        <div class="col-lg-6">
                            <label>{{trans('admin.policy_replacement_en')}}</label>
                            <textarea
                                    class="summernote policy_en"
                                    name="policy_replacement_en"
                                    placeholder="{{trans('admin.policy_replacement_en')}}"
                            ></textarea>
                        </div>
                    </div>
                    <div class="form-group m-form__group row top_row">
                        <div class="col-lg-6">
                            <label>{{trans('admin.privacy_policy_ar')}}</label>
                            <textarea
                                    class="summernote privacy_policy_ar"
                                    name="privacy_policy_ar"
                                    placeholder="{{trans('admin.privacy_policy_ar')}}"
                            ></textarea>


                        </div>
                        <div class="col-lg-6">
                            <label>{{trans('admin.privacy_policy_en')}}</label>
                            <textarea
                                    class="summernote privacy_policy_en"
                                    name="privacy_policy_en"
                                    placeholder="{{trans('admin.privacy_policy_en')}}"
                            ></textarea>


                        </div>

                        <div class="col-lg-6">
                            <label>{{trans('admin.terms_ar')}}</label>
                            <textarea
                                    class="summernote terms_ar"
                                    name="terms_ar"
                                    placeholder="{{trans('admin.terms_ar')}}"
                            ></textarea>
                        </div>
                        <div class="col-lg-6">
                            <label>{{trans('admin.terms_en')}}</label>
                            <textarea
                                    class="summernote terms_en"
                                    name="terms_en"
                                    placeholder="{{trans('admin.terms')}}"
                            ></textarea>

                        </div>

                    </div>

                    <div class="form-group m-form__group row top_row">
                        <div class="col-lg-6">
                            <label>{{trans('admin.shipping_and_delivery_ar')}}</label>
                            <textarea
                                    class="summernote shipping_and_delivery_ar"
                                    name="shipping_and_delivery_ar"
                                    placeholder="{{trans('admin.shipping_and_delivery_ar')}}"
                            ></textarea>


                        </div>
                        <div class="col-lg-6">
                            <label>{{trans('admin.shipping_and_delivery_en')}}</label>
                            <textarea
                                    class="summernote shipping_and_delivery_en"
                                    name="shipping_and_delivery_en"
                                    placeholder="{{trans('admin.shipping_and_delivery_en')}}"
                            ></textarea>


                        </div>
                    </div>

                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row top_row">
                                <div class="col-lg-4"></div>
                                <div class="col-lg-4">
                                    <button style="width: 215px;margin-bottom: 15px;" type="button" :disabled="loading"
                                            @click="validateForm"
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

    <script src="{{url('')}}/admin_assets/assets/demo/default/custom/crud/forms/widgets/summernote.js"
            type="text/javascript"></script>

    <script>
        var tax = {!! $tax !!};
        var shipping = {!! $shipping !!};
        var cancel_order_time = {!! $cancel_order_time !!};
        var first_order_discount = {!! $first_order_discount !!};

        var place = {!! $place !!};
        var policy = {!! $policy !!};
        var about = {!! $about !!};
        var privacy_policy = {!! $privacy_policy !!};
        var terms = {!! $terms !!};
        var shipping_and_delivery = {!! $shipping_and_delivery !!};


        var phone = {!! $phone !!};
        var email = {!! $email !!};
        var facebook = {!! $facebook !!};
        var twitter = {!! $twitter !!};
        var snapchat = {!! $snapchat !!};
        var instagram = {!! $instagram !!};
        var youtube = {!! $youtube !!};
        var telegram = {!! $telegram !!};


        {{--var cash_note = {!! $cash_note !!};--}}
        {{--var bank_note = {!! $bank_note !!};--}}
        {{--var visa_note = {!! $visa_note !!};--}}

        var point_price = {!! $point_price !!};

        var package_discount_type = {!! $package_discount_type !!};

        var failed_order_bank_time = {!! $failed_order_bank_time !!};

        var price_tax_in_products = {!! $price_tax_in_products !!};
        var price_tax_in_cart = {!! $price_tax_in_cart !!};

        var product_details_note1 = {!! $product_details_note1 !!};
        var product_details_note2 = {!! $product_details_note2 !!};
        var product_details_note_image = {!! $product_details_note_image !!};

        var close_app = {!! $close_app !!};
        var close_website = {!! $close_website !!};

        var return_order_time = {!! $return_order_time !!};
        var note_discount_product_details = {!! $note_discount_product_details !!};
        var checkout_label = {!! $checkout_label !!};


    </script>
    <script src="{{url('')}}/admin_assets/assets/general/js/tree.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/nested_sortable/jquery.nestable.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/website/website-nested_sortable.js"
            type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/settings/service.js"
            type="text/javascript"></script>

    <script>
        $(document).ready(function () {
            $('.dd').nestable({/* config options */});
        });
    </script>
@endpush

