<div class="modal fade" id="m_modal_1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('admin.add_products')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <success-error-msg-component :success="msg.success"
                                             :error="msg.error"></success-error-msg-component>

                <div class="row">
                    <div class="col-sm-8">
                        <label class="col-sm-3">{{trans('admin.select_products')}}</label>
                        <div class="col-sm-9" id="m_select_remote_products_div">
                            <select class="form-control m-select2" id="m_select_remote_products"
                                    name="param"
                                    data-select2-id="m_select_remote_marketing_products">

                            </select>
                        </div>
                    </div>

                </div>

                <div class="row mt-5">
                    <div class="col-sm-12">
                        <table class="table m-table m-table--head-bg-brand">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>المنتج</th>
                                <th>الكمية</th>
                                <th>التحكم</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(product , index) in products" :key="product.random_id"
                                :class="error_product_random_id == product.random_id ? 'vue_error_random' : ''"
                            >
                                <th scope="row" v-text="index+1"></th>
                                <td>
                                    <span> <img width="50" height="50" :src="product.image"></span>
                                    <span :class="error_product_random_id == product.random_id ? 'vue_error' : ''"
                                          v-text="product.name"></span>
                                    <span>
                                        <div v-for="attribute in product.attributes" class="m-form__group form-group">
																<label for="" v-text="attribute.name"></label>
																<div class="m-radio-inline">
																	<label v-for="attribute_value in attribute.attribute_values"
                                                                           class="m-radio">
																		<input type="radio" v-model="attribute.selected"
                                                                               :value="attribute_value.id"
                                                                               :name="'attribute_value_'+attribute.id+'_'+product.random_id"> @{{ attribute_value.name }}
																		<span></span>
																	</label>
																</div>
										</div>

                                    </span>
                                </td>
                                <td>
                                    <input type="number" style="width: 80px" v-model="product.quantity" min="1"
                                           class="form-control">
                                </td>
                                <td>
                                    <a href="javascript:;"
                                       @click="delete_attribute_product(index)"
                                       class="delete m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                       title="حذف">
                                        <i class="la la-remove"></i>
                                    </a>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button style="width: 90px;float: left" @click="add_products_to_order"
                        :disabled="add_loading" type="button"
                         class="btn btn-primary btn-block"
                        :class="add_loading ? 'm-loader m-loader--light m-loader--left' : ''">
                    {{trans('admin.add')}}
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>

            </div>
        </div>
    </div>
</div>


