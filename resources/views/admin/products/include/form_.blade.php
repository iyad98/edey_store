<form class="add_form m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
    {{csrf_field()}}
    <success-error-msg-component :success="msg.success" :error="msg.error"></success-error-msg-component>

    <gallery-comp @get-advance-emit-file="getAdvanceEmitFile" :default_image="default_image"
                  :attr_name="attr_name" :selector_id_image="selector_id_image" obj="product">
    </gallery-comp>

    <multi-gallery-comp @get-advance-emit-multi-file="getAdvanceEmitMultiFile" :default_image="default_image"
                        :obj="obj" attr_name="images" selector_id_image="images_1" :shock_multi_image_event="shock_multi_image_event">
    </multi-gallery-comp>

    <div class="m-portlet m-portlet--full-height m-portlet--tabs  " id="product-block">
        <div class="m-portlet__head">
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs m-tabs-line   m-tabs-line--left m-tabs-line--primary" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active show" id="a_product_tab_1" data-toggle="tab" href="#m_product_tab_1"
                           role="tab" aria-selected="true">
                            <i class="flaticon-share m--hide"></i>
                            {{trans('admin.public')}}
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item" >
                        <a class="nav-link m-tabs__link" id="a_product_tab_2" data-toggle="tab" href="#m_product_tab_2" role="tab"
                           aria-selected="false">
                            {{trans('admin.stock')}}
                        </a>
                    </li>
                    {{--<li class="nav-item m-tabs__item">--}}
                        {{--<a class="nav-link m-tabs__link" id="a_product_tab_3" data-toggle="tab" href="#m_product_tab_3" role="tab"--}}
                           {{--aria-selected="false">--}}
                            {{--{{trans('admin.shipping_add_product')}}--}}
                        {{--</a>--}}
                    {{--</li>--}}
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" id="a_product_tab_4" data-toggle="tab" href="#m_product_tab_4" role="tab"
                           aria-selected="false">
                            {{trans('admin.categories_and_brands')}}
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" id="a_product_tab_5" data-toggle="tab" href="#m_product_tab_5" role="tab"
                           aria-selected="false">
                            {{trans('admin.related_products')}}
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item" v-show="product_type == 2">
                        <a class="nav-link m-tabs__link" id="a_product_tab_6" data-toggle="tab" href="#m_product_tab_6" role="tab"
                           aria-selected="false">
                            {{trans('admin.attributes')}}
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" id="a_product_tab_7" data-toggle="tab" href="#m_product_tab_7" role="tab"
                           aria-selected="false">
                            {{trans('admin.product_images')}}
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item product-variation" v-show="product_type == 2" >
                        <a class="nav-link m-tabs__link" id="a_product_tab_8" data-toggle="tab" @click="get_attribute_variations" href="#m_product_tab_8" role="tab"
                           aria-selected="false">
                            {{trans('admin.types_add_product')}}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane active show" id="m_product_tab_1">

                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.name_ar')}}:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control m-input" v-model="product.name_ar"
                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                               name="name_ar"
                               placeholder="{{trans('admin.name_ar')}}">
                    </div>
                </div>
                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.name_en')}}:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control m-input" v-model="product.name_en"
                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                               name="name_ar"
                               placeholder="{{trans('admin.name_en')}}">
                    </div>

                </div>
                <div class="m-form__group form-group">
                    <label for="">{{trans('admin.product_options')}}</label>
                    <div class="m-checkbox-inline">
                        <label class="m-checkbox">
                            <input type="checkbox" id="in_day_deal"> {{trans('admin.in_day_deal')}}
                            <span></span>
                        </label>
                        <label class="m-checkbox">
                            <input type="checkbox" id="is_exclusive"> {{trans('admin.is_exclusive')}}
                            <span></span>
                        </label>
                        <label class="m-checkbox">
                            <input type="checkbox" id="in_offer"> {{trans('admin.in_offer')}}
                            <span></span>
                        </label>

                        <label class="m-checkbox">
                            <input type="checkbox" id="can_returned"> {{trans('admin.can_returned')}}
                            <span></span>
                        </label>

                        <label class="m-checkbox">
                            <input type="checkbox" id="can_gift"> {{trans('admin.can_gift')}}
                            <span></span>
                        </label>

                        <label class="m-checkbox">
                            <input type="checkbox" id="in_archive"> {{trans('admin.in_archive')}}
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="form-group m-form__group row top_row" >
                    <label class="col-sm-3 col-form-label">{{trans('admin.price')}}:</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control m-input" v-model.trim="product.regular_price"
                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                               name="name_ar"
                               placeholder="{{trans('admin.price')}}">
                    </div>

                </div>
                <div class="form-group m-form__group row top_row" >
                    <label class="col-sm-3 col-form-label">{{trans('admin.price_after_discount')}}:</label>
                    <div class="col-sm-3" style="margin-right: -4%">
                        <input type="number" class="form-control m-input" v-model="product.discount_price"
                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                               name="name_ar"
                               placeholder="{{trans('admin.price_after_discount')}}">
                    </div>
                    <div class="col-sm-1" >
                        <a href="javascript:;"  style="margin-right: -100%">{{trans('admin.scheduling')}}</a>
                    </div>
                    <div class="col-sm-1">
                        <a href="javascript:;"  @click="disable_general_init_date_range_picker()" style="margin-right: -138%">{{trans('admin.disable_scheduling')}}</a>
                    </div>
                    <div class="col-sm-4">

                        <div class="input-group" id="m_daterangepicker_general">
                            <input type="text" class="form-control m-input" style="direction: ltr" readonly=""
                                   placeholder="اختار التاريخ">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                            </div>
                        </div>

                    </div>
                </div>
                @check_role('cost_price')
                <div class="form-group m-form__group row top_row" v-show="hide_variation">
                    <label class="col-sm-3 col-form-label">{{trans('admin.cost_price')}}:</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control m-input" v-model.trim="product.cost_price"
                               :class="errors.has('cost_price') ? 'vue_border_error': ''"
                               name="cost_price"
                               placeholder="{{trans('admin.cost_price')}}">
                    </div>

                </div>
                @endcheck_role
                <div class="form-group m-form__group row top_row" >
                    <label class="col-sm-3 col-form-label">{{trans('admin.tax_status')}}:</label>
                    <div class="col-sm-6">
                        <select v-model="product.tax_status_id"
                                class="form-control" tabindex="-98">
                            <option v-for="tax in tax_status" :value="tax.id" v-text="tax.name"></option>

                        </select>
                    </div>

                </div>
                <div class="form-group m-form__group row top_row" v-show="hide_variation">
                    <label class="col-sm-3 col-form-label">{{trans('admin.min_quantity')}}:</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control m-input" v-model="product.min_quantity"
                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                               name="name_ar"
                               placeholder="{{trans('admin.min_quantity')}}">
                    </div>

                </div>
                <div class="form-group m-form__group row top_row" v-show="hide_variation">
                    <label class="col-sm-3 col-form-label">{{trans('admin.max_quantity')}}:</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control m-input"  v-model="product.max_quantity"
                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                               name="name_ar"

                               placeholder="{{trans('admin.max_quantity')}}">
                    </div>

                </div>
                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.description_ar')}}:</label>
                    <div class="col-sm-9" style="margin-right: -12%">
                       <textarea class="summernote" id="description_ar"
                               placeholder="{{trans('admin.description_ar')}}"
                       ></textarea>
                    </div>

                </div>
                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.description_en')}}:</label>
                    <div class="col-sm-9" style="margin-right: -12%">
                       <textarea class="summernote" id="description_en"
                                 placeholder="{{trans('admin.description_en')}}"
                       ></textarea>
                    </div>

                </div>
            </div>
            <div class="tab-pane" id="m_product_tab_2">
                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.sku')}}:</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control m-input" v-model="product.sku"
                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                               name="name_ar"
                               placeholder="{{trans('admin.sku')}}">
                    </div>
                </div>
                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.stock_status')}}:</label>
                    <div class="col-sm-6">
                        <select v-model="product.stock_status_id"
                                class="form-control" tabindex="-98">
                            <option v-for="stock in stock_status" :value="stock.id" v-text="stock.name"></option>

                        </select>
                    </div>

                </div>
                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.sku_quantity')}}:</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control m-input"  v-model="product.stock_quantity"
                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                               name="name_ar"
                               placeholder="{{trans('admin.sku_quantity')}}">
                    </div>

                </div>
                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.sku_low_quantity')}}:</label>
                    <div class="col-sm-6">
                        <input type="number" class="form-control m-input"  v-model="product.remain_product_count_in_low_stock"
                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                               name="name_ar"
                               placeholder="{{trans('admin.sku_low_quantity')}}">
                    </div>

                </div>
            </div>
            <div class="tab-pane" id="m_product_tab_3">
                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label"> {{trans('admin.weight')}} ({{trans('admin.unit_weight')}}
                        ):</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control m-input" v-model="product.weight"
                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                               name="name_ar"
                               placeholder="{{trans('admin.weight')}}">
                    </div>
                </div>
                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-2 col-form-label">{{trans('admin.dimensions')}}:</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control m-input" v-model="product.length"
                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                               name="name_ar"
                               placeholder="{{trans('admin.length')}}">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control m-input" v-model="product.width"
                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                               name="name_ar"
                               placeholder="{{trans('admin.width')}}">
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control m-input" v-model="product.height"
                               :class="errors.has('height') ? 'vue_border_error': ''"
                               name="name_ar"
                               placeholder="{{trans('admin.height')}}">
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="m_product_tab_4">
                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.categories')}}:</label>

                    <div class="col-sm-4 hidden" >
                        <select class="form-control" v-model="main_category" style="margin-right: -37%!important;">
                            <option v-for="category in main_categories"  :value="category.id" v-text="category.name"></option>
                        </select>
                    </div>
                    <div class="col-sm-4" id="select_categories_div">
                        <select class="form-control m-select2" id="select_categories" multiple>
                            <option v-for="category in categories" :value="category.id" v-text="category.category_with_parents_text"></option>
                        </select>
                    </div>

                </div>
                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.brands')}}:</label>
                    <div class="col-sm-6" id="select_brands_div">
                        <select class="form-control m-select2" id="select_brands">
                            <option value=""></option>
                            <option v-for="brand in brands" :value="brand.id" v-text="brand.name"></option>

                        </select>
                    </div>
                </div>

                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.merchants')}}:</label>
                    <div class="col-sm-6" id="select_merchants_div">
                        <select class="form-control m-select2" id="select_merchants">
                            <option value=""></option>
                            <option v-for="merchants in merchants" :value="merchants.id" v-text="merchants.store_name"></option>

                        </select>
                    </div>
                </div>



                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.select_countries')}}:</label>
                    <div class="col-sm-6 select_country_data" id="select_countries_div" >
                        <select class="form-control m-select2" id="select_countries" multiple>
                            <option v-for="country in countries" :value="country.id" v-text="country.name"></option>

                        </select>
                    </div>
                </div>
                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.excluded_countries')}}:</label>
                    <div class="col-sm-6 select_country_data" id="select_excluded_countries_div" >
                        <select class="form-control m-select2" id="select_excluded_countries" multiple>
                            <option v-for="country in countries" :value="country.id" v-text="country.name"></option>

                        </select>
                    </div>
                </div>

                <small class="ml-5" style="font-size:14px;color: red">{{trans('admin.no_countries_selected_note')}}</small>
            </div>
            <div class="tab-pane" id="m_product_tab_5">
                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.recommended_products')}}:</label>
                    <div class="col-sm-6" id="m_select_remote_recommended_products_div">
                        <select class="form-control m-select2" multiple id="m_select_remote_recommended_products"
                                name="param"
                                data-select2-id="m_select_remote_recommended_products">

                        </select>
                    </div>
                </div>
                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.marketing_products')}}:</label>
                    <div class="col-sm-6" id="m_select_remote_marketing_products_div">
                        <select class="form-control m-select2" multiple id="m_select_remote_marketing_products"
                                name="param"
                                data-select2-id="m_select_remote_marketing_products">

                        </select>
                    </div>
                </div>

                <div class="form-group m-form__group row top_row ">
                    <label class="col-sm-3 col-form-label">{{trans('admin.sub_products')}}:</label>
                    <div class="col-sm-6" id="m_select_remote_sub_products_div">
                        <select class="form-control m-select2" multiple id="m_select_remote_sub_products"
                                name="param"
                                data-select2-id="m_select_remote_sub_products">

                        </select>
                    </div>
                </div>

            </div>
            <div class="tab-pane" id="m_product_tab_6">
                <div class="form-group m-form__group row top_row">
                    <label class="col-sm-3 col-form-label">{{trans('admin.attributes')}}:</label>
                    <div class="col-sm-5">
                        <select id="select_attribute"
                                class="form-control m-bootstrap-select m_selectpicker" tabindex="-98">
                            <option v-for="attribute in attributes" :disabled="check_attributes_used(attribute.id)"
                                    :value="attribute.id" v-text="attribute.name"></option>

                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button type="button" @click="add_new_attribute"
                                class="btn m-btn btn-primary">{{trans('admin.add')}}</button>
                    </div>

                </div>

                <div class="row top_row" v-show="product_attributes.length > 0">
                    <div class="col-sm-12">
                        <h3 style="margin: 20px 30px 10px 0;">السمات المختارة</h3>
                    </div>

                </div>
                {{-- style="background-color: rgba(27, 29, 31, 0.1);margin: 10px;"--}}
                <div v-for="(product_attribute , index) in product_attributes">
                    <div class="form-group m-form__group row top_row">
                        <input type="hidden" :value="product_attribute.id" class="attribute_id">
                        <label class="col-sm-3 col-form-label">{{trans('admin.name')}}: <span
                                    v-text="product_attribute.name"></span></label>
                        <div class="col-sm-5 m_select_attribute_values_form_div">

                            <select class="form-control m-select2 m-select2-my-style"
                                    :class="'m_select_attribute_values_form_'+product_attribute.id" multiple>
                            </select>

                        </div>
                        <div class="col-sm-2">
                            <div class="col-sm-2">
                                <button type="button" @click="delete_product_attribute(index , product_attribute.id)"
                                        class="btn btn-danger m-btn m-btn--icon m-btn--icon-only">
                                    <i class="la la-remove"></i>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="m_product_tab_7">

                <div class="form-group m-form__group row top_row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-primary" style="margin-top: 25px;"
                                        @click="SelectImageFromGallery('image' , 'image')">
                                    {{__('admin.select_image')}}
                                </button>
                            </div>
                            <div class="col-sm-8">
                                <show-image-comp @clear-emit-file="clearEmitFile" attr_name="image"
                                                 selector_id_image="image"
                                                 :shock_event="shock_event" :default_image="default_image"
                                                 obj="product">

                                </show-image-comp>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="padding: 10px">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-primary" style="margin-top: 25px;"
                                @click="SelectMultiImageFromGallery('','images' , 'images_1')">
                            {{__('admin.select_multi_image')}}
                        </button>
                    </div>
                </div>
                <div class="row mt-3" style="padding: 10px">
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-2" v-for="(image , index) in images" >
                                <img :src="image.src ? image.src : image.image" width="100" height="100">
                                <a @click="remove_image_from_images(index , image)" href="javascript:;">حذف</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="form-group m-form__group row top_row hidden"
                     v-show="product_type == 1 || product_type == 2">

                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="m-dropzone dropzone m-dropzone--primary dz-clickable"
                             action="{{url('api/upload_empty')}}" id="mDropzoneProductImages">
                            <div class="m-dropzone__msg dz-message needsclick">
                                <h3 class="m-dropzone__msg-title">{{trans('admin.drop_files')}}</h3>
                                <span class="m-dropzone__msg-desc">{{trans('admin.max_upload')}}</span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="tab-pane" v-show="product_type == 2" id="m_product_tab_8" >

                <div class="form-group m-form__group row top_row">
                   <div class="col-sm-8">
                       <div class="m-form__group form-group">
                           <label for="">{{trans('admin.choose_attributes_for_types')}}</label>
                           <div class="m-checkbox-inline m-selected-attribute" >

                               <label class="m-checkbox m-selected-attribute"  v-for="attribute in selected_attributes">
                                   <input type="checkbox" class="check_selected_attributes" :class="'check_selected_attributes__'+attribute.id" name="selected_attributes" :value="attribute.id"> @{{ attribute.name }}
                                   <span></span>
                               </label>


                           </div>
                       </div>
                   </div>
                    {{--
                    <div class="col-sm-4">
                        <button type="button" @click="get_variations" class="btn m-btn btn-success">{{trans('admin.apply')}}</button>
                    </div>
                    --}}

                </div>

                <div v-for="(attribute_value_variation , index) in attribute_value_variations">
                    <div class="m-accordion m-accordion--default m-accordion--toggle-arrow top_row" style="margin: 20px;"
                         :id="'m_accordion_5'+index" role="tablist">

                        <!--begin::Item-->
                        <div class="m-accordion__item m-accordion__item--brand " :class="'get_m_accordion'+attribute_value_variation.random_id">
                            <div class="m-accordion__item-head collapsed" role="tab" :id="'m_accordion_5_item_3_head_'+index"
                                 data-toggle="collapse" :href="'#m_accordion_5_item_3_body_'+index" aria-expanded="false">
                                <span class="m-accordion__item-icon"><i class="fa fa-clipboard-list"></i></span>
                                <span class="m-accordion__item-title"> <span>{{trans('admin.type')}}</span> : @{{ attribute_value_variation.values_text }}</span>
                                <span class="m-accordion__item-mode"></span>
                            </div>
                            <div class="m-accordion__item-body collapse" :id="'m_accordion_5_item_3_body_'+index" role="tabpanel"
                                 :aria-labelledby="'m_accordion_5_item_3_head_'+index" :data-parent="'#m_accordion_5'+index" style="">

                                <div class="form-group m-form__group row top_row">
                                    <label class="col-sm-2 col-form-label">{{trans('admin.price')}}:</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control m-input" v-model.trim="attribute_value_variation.product_variation.regular_price"
                                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                                               name="name_ar"
                                               placeholder="{{trans('admin.price')}}">
                                    </div>


                                </div>
                                <div class="form-group m-form__group row top_row">
                                    <label class="col-sm-2 col-form-label">{{trans('admin.discount_price')}}:</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control m-input" v-model="attribute_value_variation.product_variation.discount_price"
                                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                                               name="name_ar"
                                               placeholder="{{trans('admin.discount_price')}}">
                                    </div>
                                    <div class="col-sm-1">
                                        <a href="javascript:;" :id="'ButtonScheduling'+(attribute_value_variation.random_id)" @click="init_date_range_picker(attribute_value_variation.random_id)" style="margin-right: -100%">{{trans('admin.scheduling')}}</a>
                                    </div>
                                    <div class="col-sm-1">
                                        <a href="javascript:;" :id="'ButtonSchedulingDisable'+(attribute_value_variation.random_id)" @click="disable_init_date_range_picker(attribute_value_variation.random_id)" style="margin-right: -138%">{{trans('admin.disable_scheduling')}}</a>
                                    </div>
                                    {{--
                                    <div class="col-sm-1">
                                        <a href="javascript:;" :id="'ButtonSchedulingDisable'+(attribute_value_variation.random_id)" @click="disable_init_date_range_picker(attribute_value_variation.random_id)" style="margin-right: -100%">{{trans('admin.disable_scheduling')}}</a>
                                    </div>
                                    --}}
                                    <div class="col-sm-4">

                                        <div class="input-group m_daterangepicker_class hidden " :id="'m_daterangepicker_variations'+attribute_value_variation.random_id">
                                            <input type="text" class="form-control m-input" style="direction: ltr" readonly=""
                                                   placeholder="اختار التاريخ">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="la la-calendar-check-o"></i></span>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                @check_role('cost_price')
                                <div class="form-group m-form__group row top_row">
                                    <label class="col-sm-2 col-form-label">{{trans('admin.cost_price')}}:</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control m-input" v-model.trim="attribute_value_variation.product_variation.cost_price"
                                               :class="errors.has('cost_price') ? 'vue_border_error': ''"
                                               name="cost_price"
                                               placeholder="{{trans('admin.cost_price')}}">
                                    </div>


                                </div>
                                @endcheck_role
                                <div class="form-group m-form__group row top_row">
                                    <label class="col-sm-2 col-form-label">{{trans('admin.stock_status')}}:</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" tabindex="-98" v-model="attribute_value_variation.product_variation.stock_status_id">
                                            <option v-for="stock in stock_status" :value="stock.id" v-text="stock.name"></option>

                                        </select>
                                    </div>

                                </div>
                                <div class="form-group m-form__group row top_row">
                                    <label class="col-sm-2 col-form-label">{{trans('admin.sku')}}:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control m-input" v-model="attribute_value_variation.product_variation.sku"
                                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                                               name="name_ar"
                                               placeholder="{{trans('admin.sku')}}">
                                    </div>

                                    <label class="col-sm-2 col-form-label">{{trans('admin.sku_quantity')}}:</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control m-input" v-model="attribute_value_variation.product_variation.stock_quantity"
                                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                                               name="name_ar"
                                               placeholder="{{trans('admin.sku_quantity')}}">
                                    </div>

                                </div>
                                {{--<div class="form-group m-form__group row top_row">--}}
                                    {{--<label class="col-sm-2 col-form-label"> {{trans('admin.weight')}} ({{trans('admin.unit_weight')}}--}}
                                        {{--):</label>--}}
                                    {{--<div class="col-sm-4">--}}
                                        {{--<input type="text" class="form-control m-input" v-model="attribute_value_variation.product_variation.weight"--}}
                                               {{--:class="errors.has('name_ar') ? 'vue_border_error': ''"--}}
                                               {{--name="name_ar"--}}
                                               {{--placeholder="{{trans('admin.weight')}}">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="form-group m-form__group row top_row">--}}
                                    {{--<label class="col-sm-2 col-form-label">{{trans('admin.dimensions')}}:</label>--}}
                                    {{--<div class="col-sm-2" style="margin-right: -4%;margin-left: 20px">--}}
                                        {{--<input type="text" class="form-control m-input" v-model="attribute_value_variation.product_variation.length"--}}
                                               {{--:class="errors.has('name_ar') ? 'vue_border_error': ''"--}}
                                               {{--name="name_ar"--}}
                                               {{--placeholder="{{trans('admin.length')}}">--}}
                                    {{--</div>--}}
                                    {{--<div class="col-sm-2" style="margin-right: -4%;margin-left: 20px">--}}
                                        {{--<input type="text" class="form-control m-input" v-model="attribute_value_variation.product_variation.width"--}}
                                               {{--:class="errors.has('name_ar') ? 'vue_border_error': ''"--}}
                                               {{--name="name_ar"--}}
                                               {{--placeholder="{{trans('admin.width')}}">--}}
                                    {{--</div>--}}
                                    {{--<div class="col-sm-2" style="margin-right: -4%;margin-left: 20px">--}}
                                        {{--<input type="text" class="form-control m-input" v-model="attribute_value_variation.product_variation.height"--}}
                                               {{--:class="errors.has('name_ar') ? 'vue_border_error': ''"--}}
                                               {{--name="name_ar"--}}
                                               {{--placeholder="{{trans('admin.height')}}">--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="form-group m-form__group row top_row">
                                    <label class="col-sm-3 col-form-label">{{trans('admin.min_quantity')}}:</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control m-input" v-model="attribute_value_variation.product_variation.min_quantity"
                                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                                               name="name_ar"
                                               placeholder="{{trans('admin.min_quantity')}}">
                                    </div>

                                </div>
                                <div class="form-group m-form__group row top_row">
                                    <label class="col-sm-3 col-form-label">{{trans('admin.max_quantity')}}:</label>
                                    <div class="col-sm-6">
                                        <input type="number" class="form-control m-input" v-model="attribute_value_variation.product_variation.max_quantity"
                                               :class="errors.has('name_ar') ? 'vue_border_error': ''"
                                               name="name_ar"
                                               placeholder="{{trans('admin.max_quantity')}}">
                                    </div>

                                </div>
                                {{--<div class="form-group m-form__group row top_row">--}}
                                    {{--<label class="col-sm-3 col-form-label">{{trans('admin.description_ar')}}:</label>--}}
                                    {{--<div class="col-sm-6" >--}}
                                        {{--<textarea class="form-control m-input" v-model="attribute_value_variation.product_variation.description_ar"--}}
                                                  {{--placeholder="{{trans('admin.description_ar')}}">--}}

                                        {{--</textarea>--}}

                                    {{--</div>--}}

                                {{--</div>--}}
                                {{--<div class="form-group m-form__group row top_row">--}}
                                    {{--<label class="col-sm-3 col-form-label">{{trans('admin.description_en')}}:</label>--}}
                                    {{--<div class="col-sm-6" >--}}
                                        {{--<textarea class="form-control m-input" v-model="attribute_value_variation.product_variation.description_en"--}}
                                                  {{--placeholder="{{trans('admin.description_en')}}">--}}

                                        {{--</textarea>--}}

                                    {{--</div>--}}

                                {{--</div>--}}
                                <div class="form-group m-form__group row top_row hidden">
                                    <div class="col-sm-12">

                                        <button type="button" :id="'buttonmDropzoneProductImagesV'+attribute_value_variation.random_id" @click="init_dropzone(attribute_value_variation.random_id)" class="btn btn-brand" v-text="add ? '{{trans('admin.add_images')}}' :'{{trans('admin.display_images')}}'"></button>

                                        <div class="m-dropzone dropzone m-dropzone--primary dz-clickable hidden" style="margin: 20px;"
                                             action="{{url('api/upload_empty')}}" :id="'mDropzoneProductImagesV'+attribute_value_variation.random_id">
                                            <div class="m-dropzone__msg dz-message needsclick">
                                                <h3 class="m-dropzone__msg-title">{{trans('admin.drop_files')}}</h3>
                                                <span class="m-dropzone__msg-desc">{{trans('admin.max_upload')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="padding: 10px">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-primary" style="margin-top: 25px;"
                                                @click="SelectMultiImageFromGallery(attribute_value_variation,attribute_value_variation.product_variation.images , 'images_2')">
                                            {{__('admin.select_multi_image')}}
                                        </button>
                                    </div>
                                </div>
                                <div class="row mt-3" style="padding: 10px">
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-2" v-for="(image , index_2) in attribute_value_variation.product_variation.images" >
                                                <img :src="image.src ? image.src : image.image" width="100" height="100">
                                                <a @click="remove_image_from_product_variation_images(index , index_2 , image)" href="javascript:;">حذف</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <!--end::Item-->
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row top_row" style="padding: 18px;">
        <div class="col-lg-4"></div>
        <div class="col-lg-8">
            <button type="button" :disabled="loading" @click="validateForm" class="btn m-btn btn-primary"
                    v-text="add ? '{{trans('admin.add')}}' : '{{trans('admin.save')}}'"
                    :class="loading ? 'm-loader m-loader--light m-loader--left' : ''">
            </button>

            {{--
            <button type="reset" id="cancel" class="btn btn-secondary"> {{trans('admin.cancel')}}</button>
            --}}
        </div>
    </div>
</form>


