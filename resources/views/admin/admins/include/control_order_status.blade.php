<div class="modal fade" id="control_order_status" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;"
     aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('admin.control_order_status')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <success-error-msg-component :success="control_status_msg.success"
                                             :error="control_status_msg.error"></success-error-msg-component>

                <div class="row mb-3">
                    <div class="col-sm-12">
                        <p style="font-size: 14px;color: blue">{{trans('admin.admin_order_status_note')}}</p>
                    </div>
                </div>
                <div class="row" style="height: 400px;overflow-y: auto;">
                    <div class="col-sm-5">
                        <table class="table table-bordered m-table table-sm">
                            <tr>
                                <td style="font-weight: bold;font-size: 13px">{{trans('admin.order_status_from')}}</td>
                                <td style="font-weight: bold;font-size: 13px">{{trans('admin.order_status_to')}}</td>
                            </tr>
                            <tr v-for="(order_status , index) in order_statuses">
                                <td >
                                    <div class="m-form__group form-group">
                                        <div class="m-radio-list">
                                            <label class="m-radio" >
                                                <input type="radio" :checked="index == 0" name="order_status_from" :value="index"> @{{ order_status }}
                                                <span></span>
                                            </label>

                                        </div>
                                    </div>
                                </td>
                                <td >
                                    <div class="m-form__group form-group">
                                        <div class="m-radio-list">
                                            <label class="m-radio">
                                                <input type="radio" :checked="index == 0" name="order_status_to" :value="index"> @{{ order_status }}
                                                <span></span>
                                            </label>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>

                    </div>
                    <div class="col-sm-2">
                        <a href="javascript:;" @click="add_status_to_order_status()" class="btn btn-success">
                            {{trans('admin.add')}}
                        </a>
                    </div>
                    <div class="col-sm-5">
                        <table class="table">
                            <tr>
                                <td style="font-weight: bold;font-size: 14px">{{trans('admin.allowed_order_status')}}</td>
                            </tr>
                            <tr v-for="(admin_order_status , index) in admin_order_statuses" :key="admin_order_status.key">
                                <td v-text="admin_order_status.text"></td>
                                <td>
                                    <a href="javascript:;" @click="delete_order_status(index)" class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">
                                        <i class="la la-remove"></i>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button style="width: 90px;float: left" @click="add_order_status"
                        :disabled="control_status_loading" type="button"
                        class="btn btn-primary btn-block"
                        :class="control_status_loading ? 'm-loader m-loader--light m-loader--left' : ''">
                    {{trans('admin.add')}}
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>

            </div>
        </div>
    </div>
</div>


