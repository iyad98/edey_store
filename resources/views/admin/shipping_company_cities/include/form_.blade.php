<form class="add_form m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed hidden">
    {{csrf_field()}}
    <div class="m-portlet__body">

        <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>

        <div class="form-group m-form__group row top_row">


            <div class="col-lg-7" >
                <label class="col-form-label col-sm-3">{{trans('admin.city')}}</label>
                <div class="col-lg-9 col-md-9 col-sm-9" data-select2-id="80" id="m_select_city_form_div">
                    <select  dir="rtl" class="form-control m-select2" multiple id="m_select_city_form" name="param"
                             data-select2-id="m_select_city_form_div" tabindex="-1" aria-hidden="true"
                             autocomplete="false">
                        <option v-for="city in cities" :disabled="!city_ids_not_in_shipping_company.includes(city.id)" :value="city.id" v-text="city.name"></option>

                    </select>
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row top_row">


            <div class="col-lg-2" style="padding: 0;">
                <div class="m-form__group form-group">
                    <label for="">{{trans('admin.cash')}}</label>
                    <div class="m-radio-inline">
                        <label class="m-radio">
                            <input type="radio" name="cash" checked value="1"> {{trans('admin.yes')}}
                            <span></span>
                        </label>
                        <label class="m-radio">
                            <input type="radio" name="cash" value="2"> {{trans('admin.no')}}
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-lg-10 shipping_cash_value" style="margin-top: 20px;">
                <div class="row top_row mt-3" v-for="(shipping_cash_price ,index) in shipping_cash_prices" >
                    <div class="col-sm-2">
                        <input type="text" class="form-control" v-model="shipping_cash_price.from"
                               placeholder="{{trans('admin.from')}}">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" v-model="shipping_cash_price.to"
                               placeholder="{{trans('admin.to')}}">
                    </div>

                    <div class="col-sm-2">
                        <input type="text" class="form-control" v-model="shipping_cash_price.price"
                               placeholder="{{trans('admin.price')}}">
                    </div>


                    <div class="col-sm-4">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <select id="select_type_form" v-model="shipping_cash_price.type"
                                    class="form-control">
                                <option value="fixed">{{trans('admin.fixed')}}</option>
                                <option value="percent">{{trans('admin.percent')}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="col-sm-2">
                            <button type="button" @click="remove_shipping_cash_price_row(index)"
                                    class="btn btn-danger m-btn m-btn--icon m-btn--icon-only">
                                <i class="la la-remove"></i>
                            </button>

                        </div>
                    </div>
                </div>
                <div class="row top_row">
                    <div class="col-sm-3">
                        <label style="visibility: hidden">Add</label>
                        <div class="row top_row">
                            <div class="col-sm-12">
                                <button type="button" @click="add_new_shipping_cash_price_row" class="btn btn-success m-btn m-btn--icon">
															<span>
																<i class="la la-plus-circle"></i>
																<span>
																	{{trans('admin.new_shipping_price')}}
																</span>
															</span>
                                </button>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="form-group m-form__group row top_row">
            <div class="col-lg-2" style="padding: 0;">
                <div class="m-form__group form-group">
                    <label for="">{{trans('admin.calculation_type')}}</label>
                    <div class="m-radio-inline">
                        <label class="m-radio">
                            <input type="radio" name="calculation_type" checked value="piece">{{trans('admin.calculation_type_piece')}}<span></span>
                        </label>
                        <label class="m-radio">
                            <input type="radio" name="calculation_type" value="price">{{trans('admin.calculation_type_price')}}<span></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row ">
                <div class="col-sm-12">
                    <label>{{trans('admin.shipping_price')}}:</label>
                    <div class="row top_row mt-4 shipping_price_value " v-for="(shipping_price ,index) in shipping_prices">
                        <div class="col-sm-2">
                            <input type="text" class="form-control" v-model="shipping_price.from"
                                   placeholder="{{trans('admin.from')}}">
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" v-model="shipping_price.to"
                                   placeholder="{{trans('admin.to')}}">
                        </div>

                        <div class="col-sm-2">
                            <input type="text" class="form-control" v-model="shipping_price.price"
                                   placeholder="{{trans('admin.price')}}">
                        </div>

                        <div class="col-sm-3">
                            <input type="text" class="form-control" v-model="shipping_price.name_ar"
                                   placeholder="{{trans('admin.text_ar')}}">
                        </div>

                        <div class="col-sm-3">
                            <input type="text" class="form-control" v-model="shipping_price.name_en"
                                   placeholder="{{trans('admin.text_en')}}">
                        </div>

                        <div class="col-sm-2 mt-2">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <select id="select_type_form" v-model="shipping_price.type"
                                        class="form-control">
                                    <option value="fixed">{{trans('admin.fixed')}}</option>
                                    <option value="percent">{{trans('admin.percent')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-1 mt-2">
                            <div class="col-sm-2">
                                <button type="button" @click="remove_row(index)"
                                        class="btn btn-danger m-btn m-btn--icon m-btn--icon-only">
                                    <i class="la la-remove"></i>
                                </button>

                            </div>
                        </div>
                    </div>

                    <div class="row top_row mt-4 shipping_piece_value " v-for="(shipping_prices_piece ,index) in shipping_prices_piece">

                        <div class="col-sm-4">
                            <input type="text" class="form-control"
                                   placeholder="{{trans('admin.price')}}"  v-model="shipping_prices_piece.price">
                        </div>

                        <div class="col-sm-4">
                            <input type="text" class="form-control"
                                   placeholder="{{trans('admin.text_ar')}}" v-model="shipping_prices_piece.name_ar">
                        </div>

                        <div class="col-sm-4">
                            <input type="text" class="form-control"
                                   placeholder="{{trans('admin.text_en')}}" v-model="shipping_prices_piece.name_en">
                        </div>



                    </div>

                </div>
            </div>
            <div class="row top_row add_new_row">
                <div class="col-sm-3">
                    <label style="visibility: hidden">Add</label>
                    <div class="row top_row">
                        <div class="col-sm-12">
                            <button type="button" @click="add_new_row" class="btn btn-success m-btn m-btn--icon">
															<span>
																<i class="la la-plus-circle"></i>
																<span>
																	{{trans('admin.new_shipping_price')}}
																</span>
															</span>
                            </button>

                        </div>
                    </div>

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
