<form class="add_form m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed hidden">
    {{csrf_field()}}
    <div class="m-portlet__body">

        <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>

        <div class="form-group m-form__group row top_row">

            <div class="col-lg-2">
                <label>{{trans('admin.coupon')}}:</label>
                <input type="text" class="form-control m-input" v-model="coupon.coupon"
                       v-validate="'required'"
                       :class="errors.has('coupon') ? 'vue_border_error': ''"
                       name="coupon"
                       placeholder="{{trans('admin.coupon')}}">

                <span class="m-form__help"
                      :class="errors.has('coupon') ? 'vue_error': ''"
                      v-text="errors.has('coupon') ? errors.first('coupon') : ''"></span>
            </div>
            <div class="col-lg-2" v-show="free_shipping_coupon">
                <label>{{trans('admin.value')}}:</label>
                <input type="text" class="form-control m-input" v-model="coupon.value"
                       v-validate="'required'"
                       :class="errors.has('value') ? 'vue_border_error': ''"
                       name="value"
                       placeholder="{{trans('admin.value')}}">

                <span class="m-form__help"
                      :class="errors.has('value') ? 'vue_error': ''"
                      v-text="errors.has('value') ? errors.first('value') : ''"></span>
            </div>
            <div class="col-lg-2">
                <label>{{trans('admin.min_price')}}:</label>
                <input type="text" class="form-control m-input" v-model="coupon.min_price"
                       v-validate="'required'"
                       :class="errors.has('min_price') ? 'vue_border_error': ''"
                       name="min_price"
                       placeholder="{{trans('admin.min_price')}}">

                <span class="m-form__help"
                      :class="errors.has('min_price') ? 'vue_error': ''"
                      v-text="errors.has('min_price') ? errors.first('min_price') : ''"></span>
            </div>
            <div class="col-lg-3">
                <label>{{trans('admin.coupon_type')}}:</label>
                <br>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <select id="select_type_form"
                            class="form-control m-bootstrap-select m_selectpicker" tabindex="-98">
                        <option v-for="coupon_type in coupon_types" :value="coupon_type.id"
                                v-text="coupon_type.name"></option>


                    </select>
                </div>

            </div>
            <div class="col-lg-3">
                <div class="m-form__group form-group">
                    <div class="m-checkbox-inline">
                        <label class="m-checkbox">
                            <input type="checkbox" id="is_automatic"> {{trans('admin.set_as_automatic')}}
                            <span></span>
                        </label>

                        {{--<label class="m-checkbox">--}}
                            {{--<input type="checkbox" id="show_in_home"> {{trans('admin.show_in_home')}}--}}
                            {{--<span></span>--}}
                        {{--</label>--}}

                        <label class="m-checkbox show_apply_for_discount_product">
                            <input type="checkbox" id="apply_for_discount_product"> {{trans('admin.apply_for_discount_coupon')}}
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row top_row">


            <div class="col-lg-2">
                <label>{{trans('admin.max_used')}}:</label>
                <input type="text" class="form-control m-input" v-model="coupon.max_used"
                       v-validate="'required'"
                       :class="errors.has('max_used') ? 'vue_border_error': ''"
                       name="max_used"
                       placeholder="{{trans('admin.max_used')}}">

                <span class="m-form__help"
                      :class="errors.has('max_used') ? 'vue_error': ''"
                      v-text="errors.has('max_used') ? errors.first('max_used') : ''"></span>
            </div>
            <div class="col-lg-4">
                <label>{{trans('admin.date')}}:</label>
                <br>
                <div class="col-lg-12 col-md-12 col-sm-12">

                    <div class="input-group" id="m_daterangepicker_coupon_date">
                        <input type="text" class="form-control m-input" style="direction: ltr" readonly=""
                               placeholder="Select date range">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                        </div>
                    </div>

                </div>

            </div>
            {{--<div class="col-lg-4 coupon_famous ">--}}
                {{--<label>{{trans('admin.user_famous')}}:</label>--}}
                {{--<div class="col-lg-12 col-md-12 col-sm-12" id="m_select_remote_user_name_div">--}}
                    {{--<select class="form-control m-select2" id="m_select_remote_user_name" name="param"--}}
                            {{--data-select2-id="m_select_remote_user_name">--}}

                    {{--</select>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="col-lg-2 coupon_famous ">--}}
                {{--<label>{{trans('admin.user_famous_rate')}}:</label>--}}
                {{--<input type="text" class="form-control m-input" v-model="coupon.user_famous_rate"--}}
                       {{--:class="errors.has('user_famous_rate') ? 'vue_border_error': ''"--}}
                       {{--name="user_famous_rate"--}}
                       {{--placeholder="{{trans('admin.user_famous_rate')}}">--}}

                {{--<span class="m-form__help"--}}
                      {{--:class="errors.has('user_famous_rate') ? 'vue_error': ''"--}}
                      {{--v-text="errors.has('user_famous_rate') ? errors.first('user_famous_rate') : ''"></span>--}}
            {{--</div>--}}
        </div>

        <div class="form-group m-form__group row top_row select_products" v-show="free_shipping_coupon">

            <div class="col-lg-6">
                <label>{{trans('admin.products')}}:</label>
                <div class="col-lg-12 col-md-12 col-sm-12" id="m_select_remote_product_div">
                    <select class="form-control m-select2" multiple id="m_select_remote_product_name" name="param"
                            data-select2-id="m_select_remote_product_name">

                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <label>{{trans('admin.excluded_products')}}:</label>
                <div class="col-lg-12 col-md-12 col-sm-12" data-select2-id="80"
                     id="m_select_remote_excluded_product_div">
                    <select class="form-control m-select2" multiple id="m_select_remote_excluded_product_name"
                            name="param"
                            data-select2-id="m_select_remote_excluded_product_name">
                    </select>
                </div>
            </div>

        </div>
        <div class="form-group m-form__group row top_row select_categories" v-show="free_shipping_coupon">

            <div class="col-lg-6">
                <label>{{trans('admin.categories')}}:</label>
                <div class="col-lg-12 col-md-12 col-sm-12" data-select2-id="80" id="m_select_remote_category_name_div">
                    <select class="form-control m-select2" multiple id="m_select_remote_category_name" name="param"
                            data-select2-id="m_select_remote_category_name">

                    </select>
                </div>
            </div>
            <div class="col-lg-6">
                <label>{{trans('admin.excluded_categories')}}:</label>
                <div class="col-lg-12 col-md-12 col-sm-12" data-select2-id="80"
                     id="m_select_remote_excluded_category_name_div">
                    <select class="form-control m-select2" multiple id="m_select_remote_excluded_category_name"
                            name="param"
                            data-select2-id="m_select_remote_excluded_category_name">
                    </select>
                </div>
            </div>

        </div>

    </div>


    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
        <div class="m-form__actions m-form__actions--solid">
            <div class="row top_row">
                <div class="col-lg-4"></div>
                <div class="col-lg-8">
                    <button type="button" :disabled="loading" @click="validateForm" class="btn m-btn btn-primary"
                            v-text="add ? '{{trans('admin.add')}}' : '{{trans('admin.save')}}'"
                            :class="loading ? 'm-loader m-loader--light m-loader--left' : ''">
                    </button>

                    <button type="reset" id="cancel" class="btn btn-secondary"> {{trans('admin.cancel')}}</button>
                </div>
            </div>
        </div>
    </div>
</form>
