<div class="row" id="vue_select_product">
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title"><h3 class="m-portlet__head-text">
                        كل المنتجات
                    </h3></div>
            </div>
        </div>


        <div class="m-portlet m-portlet--mobile success_error_all_product">
            <div class="m-portlet__body">
                <!--begin: Datatable -->
                <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>
                <div class="row" style="margin-bottom: 15px">
                    <div class="col-sm-12">
                        <button :disabled="loading_add" type="button" class="btn btn-primary btn-block" :class="loading_add ? 'm-loader m-loader--light m-loader--left' : ''" @click="add_or_remove_product(1)"> اضافة   </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-sm-3">{{trans('admin.select_category')}}</label>
                            <div class="col-sm-8" data-select2-id="80" id="m_select_product_form_div">
                                <select class="form-control m-select2 " id="m_select_main" name="param"
                                        data-select2-id="m_select_main" tabindex="-1" aria-hidden="true">
                                    <option value="-1">{{trans('admin.all_status')}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" > {{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-sm-3">{{trans('admin.select_category')}}</label>
                            <div class=" col-sm-8" data-select2-id="80" id="m_select_product_form_div_2">
                                <select class="form-control m-select2 " id="m_select_sub" name="param"
                                        data-select2-id="m_select_sub" tabindex="-1" aria-hidden="true">
                                    <option value="-1">{{trans('admin.all_status')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <table class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap"
                       id="product-table">
                    <thead>
                    <tr>
                        <th>
                            <label class="m-checkbox">
                                <input type="checkbox" class="check_all_product">
                                <span ></span>
                            </label>
                        </th>
                        <th>{{trans('admin.image')}}</th>
                        <th>{{trans('admin.name_en')}}</th>
                        <th>{{trans('admin.name_ar')}}</th>


                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title"><h3 class="m-portlet__head-text">
                        المنتجات المختارة
                    </h3></div>
            </div>
        </div>
        <div class="m-portlet m-portlet--mobile success_error_selected_product">
            <div class="m-portlet__body">
                <!--begin: Datatable -->

                <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>
                <div class="row" style="margin-bottom: 15px">
                    <div class="col-sm-12">
                        <button :disabled="loading_delete" type="button" class="btn btn-danger btn-block" :class="loading_delete ? 'm-loader m-loader--light m-loader--left' : ''" @click="add_or_remove_product(0)" > حذف </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-sm-3">{{trans('admin.select_category')}}</label>
                            <div class="col-sm-8" data-select2-id="80" id="m_select_product_offer_form_div">
                                <select class="form-control m-select2 " id="m_select_main_offer" name="param"
                                        data-select2-id="m_select_main_offer" tabindex="-1" aria-hidden="true">
                                    <option value="-1">{{trans('admin.all_status')}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" > {{$category->name}}</option>
                                    @endforeach                                                            </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group m-form__group row">
                            <label class="col-form-label col-sm-3">{{trans('admin.select_category')}}</label>
                            <div class=" col-sm-8" data-select2-id="80" id="m_select_product_offer_form_div_2">
                                <select class="form-control m-select2 " id="m_select_sub_offer" name="param"
                                        data-select2-id="m_select_sub_offer" tabindex="-1" aria-hidden="true">
                                    <option value="-1">{{trans('admin.all_status')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <table class="table table-striped- table-bordered table-hover table-checkable responsive no-wrap"
                       id="product-table-selected">
                    <thead>
                    <tr>
                        <th>
                            <label class="m-checkbox">
                                <input type="checkbox" class="check_all_select_product">
                                <span ></span>
                            </label>
                        </th>
                        <th>{{trans('admin.image')}}</th>
                        <th>{{trans('admin.name_en')}}</th>
                        <th>{{trans('admin.name_ar')}}</th>


                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>