<div class="modal fade" id="update_order_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="min-width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل تفاصيل الطلب
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <success-error-msg-component :success="msg.success"
                                             :error="msg.error"></success-error-msg-component>

                <div class="form-group m-form__group row ">
                    <div class="col-sm-6">
                        <label>{{trans('admin.first_name')}}</label>
                        <input type="text" class="form-control m-input"
                               v-model="edit_order_data.order_user_shipping.first_name"
                               placeholder="{{trans('admin.first_name')}}">
                    </div>

                    <div class="col-sm-6">
                        <label>{{trans('admin.last_name')}}</label>
                        <input type="text" class="form-control m-input"
                               v-model="edit_order_data.order_user_shipping.last_name"
                               placeholder="{{trans('admin.last_name')}}">
                    </div>


                </div>
                <div class="form-group m-form__group row ">

                    <div class="col-sm-6">
                        <label>{{trans('admin.phone')}}</label>
                        <input type="text" class="form-control m-input"
                               v-model="edit_order_data.user_phone"
                               placeholder="{{trans('admin.phone')}}">
                    </div>

                    <div class="col-sm-6">
                        <label>{{trans('admin.email')}}</label>
                        <input type="text" class="form-control m-input"
                               v-model="edit_order_data.user_email"
                               placeholder="{{trans('admin.email')}}">
                    </div>


                </div>


                <div class="form-group m-form__group row ">
                    <div class="col-sm-6">
                        <label>{{trans('admin.address')}}</label>
                        <input type="text" class="form-control m-input"
                               v-model="edit_order_data.order_user_shipping.address"
                               placeholder="{{trans('admin.address')}}">
                    </div>

                    <div class="col-sm-6">
                        <label>{{trans('admin.billing_national_address')}}</label>
                        <input type="text" class="form-control m-input"
                               v-model="edit_order_data.order_user_shipping.billing_national_address"
                               placeholder="{{trans('admin.billing_national_address')}}">
                    </div>
                </div>
                <div class="form-group m-form__group row ">
                    <div class="col-sm-6">
                        <label>{{trans('admin.billing_building_number')}}</label>
                        <input type="text" class="form-control m-input"
                               v-model="edit_order_data.order_user_shipping.billing_building_number"
                               placeholder="{{trans('admin.billing_building_number')}}">
                    </div>

                    <div class="col-sm-6">
                        <label>{{trans('admin.billing_postalcode_number')}}</label>
                        <input type="text" class="form-control m-input"
                               v-model="edit_order_data.order_user_shipping.billing_postalcode_number"
                               placeholder="{{trans('admin.billing_postalcode_number')}}">
                    </div>
                </div>
                <div class="form-group m-form__group row ">
                    <div class="col-sm-6">
                        <label>{{trans('admin.billing_extra_number')}}</label>
                        <input type="text" class="form-control m-input"
                               v-model="edit_order_data.order_user_shipping.billing_extra_number"
                               placeholder="{{trans('admin.billing_extra_number')}}">
                    </div>

                    <div class="col-sm-6">
                        <label>{{trans('admin.billing_unit_number')}}</label>
                        <input type="text" class="form-control m-input"
                               v-model="edit_order_data.order_user_shipping.billing_unit_number"
                               placeholder="{{trans('admin.billing_unit_number')}}">
                    </div>
                </div>

                <div class="form-group m-form__group row ">
                    <div class="col-sm-6">
                        <input type="checkbox" v-model="is_gift" id="is_gift">
                        <label for="is_gift">{{trans('website.is_gift')}}</label>

                    </div>
                    <div class="col-sm-6" v-show="is_gift">
                        <label>{{trans('website.gift_target_phone')}}</label>
                        <input type="text" class="form-control m-input"
                               v-model="edit_order_data.order_user_shipping.gift_target_phone"
                               placeholder="{{trans('website.gift_target_phone')}}">
                    </div>
                </div>

                <div class="form-group m-form__group row ">

                    <div class="col-sm-6" v-show="is_gift">
                        <label>{{trans('website.gift_first_name')}}</label>
                        <input type="text" class="form-control m-input"
                               v-model="edit_order_data.order_user_shipping.gift_first_name"
                               placeholder="{{trans('website.gift_first_name')}}">
                    </div>
                    <div class="col-sm-6" v-show="is_gift">
                        <label>{{trans('website.gift_last_name')}}</label>
                        <input type="text" class="form-control m-input"
                               v-model="edit_order_data.order_user_shipping.gift_last_name"
                               placeholder="{{trans('website.gift_last_name')}}">
                    </div>
                </div>

                <div class="form-group m-form__group row ">
                    <div class="col-sm-6" v-show="is_gift">
                        <label>{{trans('website.gift_target_email')}}</label>
                        <input type="text" class="form-control m-input"
                               v-model="edit_order_data.order_user_shipping.gift_target_email"
                               placeholder="{{trans('website.gift_target_email')}}">
                    </div>
                    <div class="col-sm-6" v-show="is_gift">
                        <label>{{trans('website.gift_text')}}</label>
                        <input type="text" class="form-control m-input"
                               v-model="edit_order_data.order_user_shipping.gift_text"
                               placeholder="{{trans('website.gift_text')}}">
                    </div>
                </div>

                <div class="m-form__group form-group mt-4">

                    <div class="m-checkbox-inline">
                        <label class="m-checkbox"><input type="checkbox" id="extra_data" value="1">
                            خيارات ضافية
                            <span>

                            </span>
                        </label>
                    </div>
                    <label style="font-weight: 700;color: blue!important;" for="">ملاحظة : عند اختيار التعديل على الخيارات الاضافية قد يتغير سعر رسوم الدفع عند الاستلام وسعر الشحن</label>
                </div>
                <div class="form-group m-form__group row show_extra_data hidden">
                    <div class="col-sm-6">
                        <label>{{trans('admin.country')}}</label>
                        <select class="form-control" id="select_country">
                            <option v-for="country in countries"
                                    :selected="country.id == order.country_id_selected"
                                    :value="country.id" v-text="country.name"></option>
                        </select>
                    </div>

                    <div class="col-sm-6">
                        <label>{{trans('admin.city')}}</label>
                        <div class="col-sm-12" id="select_cities_div">
                            <select class="form-control m-select2" id="select_cities">
                                <option v-for="city in cities"
                                        :selected="city.id == order.city_id_selected"
                                        :value="city.id" v-text="city.name"></option>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="form-group m-form__group row show_extra_data hidden">
                    <div class="col-sm-6">
                        <label>{{trans('admin.shipping_company')}}</label>
                        <select class="form-control" id="select_companies">
                            <option v-for="shipping_company in shipping_companies"
                                    :selected="shipping_company.id == order.shipping_company_id_selected"
                                    :value="shipping_company.id" v-text="shipping_company.name"></option>
                        </select>
                    </div>

                    <div class="col-sm-6">
                        <label>{{trans('admin.payment_method')}}</label>
                        <select class="form-control" id="get_payment_methods">
                            <option v-for="payment_method in payment_methods"
                                    :selected="payment_method.id == order.payment_method_id"
                                    :value="payment_method.id" v-text="payment_method.name"></option>
                        </select>

                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <button style="width: 90px;float: left" @click="update_order_form_data"
                        :disabled="loading" type="button"
                        class="btn btn-primary btn-block"
                        :class="loading ? 'm-loader m-loader--light m-loader--left' : ''">
                    {{trans('admin.save')}}
                </button>

                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>


