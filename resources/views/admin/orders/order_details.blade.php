@extends('admin.layout')


@push('css')

    <link href="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.rtl.css" rel="stylesheet"
          type="text/css"/>

    <link href="{{url('')}}/admin_assets/assets/general/css/orders/style.css" rel="stylesheet"
          type="text/css"/>

    <style>
        .vue_error_random {
            background-color: #ffb1a673;
        }

        .table thead th {
            padding: 10px !important;
        }

        .success_text {
            color: green !important;
        }

        .danger_text {
            color: red !important;
        }

        #select_cities_div .select2-container {
            width: 100% !important;
        }
        .is-returned-product {
            background-color: #f0f2f0;
        }
    </style>
@endpush


@section('content')
    <!-- BEGIN: Subheader -->
        {{--<div class="m-subheader ">--}}
            {{--<div class="d-flex align-items-center">--}}
                {{--<div class="mr-auto">--}}
                    {{--<h3 class="m-subheader__title m-subheader__title--separator">{{trans('admin.orders')}}</h3>--}}
                    {{--<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">--}}
                        {{--<li class="m-nav__item m-nav__item--home">--}}
                            {{--<a href="{{route('admin.index')}}" class="m-nav__link m-nav__link--icon">--}}
                                {{--<i class="m-nav__link-icon la la-home"></i>--}}
                            {{--</a>--}}
                        {{--</li>--}}

                        {{--<li class="m-nav__separator">-</li>--}}
                        {{--<li class="m-nav__item">--}}
                            {{--<a href="{{route('admin.products.index')}}" class="m-nav__link">--}}
                                {{--<span class="m-nav__link-text">{{trans('admin.orders')}}</span>--}}
                            {{--</a>--}}

                        {{--</li>--}}

                        {{--<li class="m-nav__separator">-</li>--}}

                        {{--<li class="m-nav__item">--}}

                            {{--<a href="{{url('admin/order/print?id='.$order->id)}}" target="_blank">--}}
                                {{--<i id="download_" class="fa fa-print"--}}
                                   {{--style="color: #000000ab;font-size: 25px;cursor: pointer"></i>--}}
                            {{--</a>--}}

                            {{--<i class="load_pdf hidden fa fa-spin fa-spinner"></i>--}}

                        {{--</li>--}}


                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}


    <!-- END: Subheader -->
    <div class="m-content" id="order_details">


        <div class="m-portlet add_form hidden">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">

                </div>
            </div>

            <!--begin::Form-->
            <!--end::Form-->
        </div>

        @include('admin.orders.update_order_form')
        @include('admin.orders.parts.add_product')

        <div class="row top_row">
            <div class="col-lg-12 custom_col">
                <div class="m-portlet">
                    <div class="m-portlet__body m-portlet__body--no-padding">
                        <div class="m-invoice-2">
                            <div class="m-invoice__wrapper">
                                <div class="m-invoice__head">
                                    <div class="m-invoice__container m-invoice__container--centered"
                                         id="order_details_1">
                                        <div class="m-invoice__logo" style="padding: 1rem 2rem;">
                                            <a href="#" style="vertical-align: middle !important;">
                                                <h1>{{trans('admin.order_details')}} : <span v-text="order.id"></span>
                                                </h1>
                                            </a>
                                            <a href="" class="m-brand__logo-wrapper">
                                                <img alt="" style="width: 310px;height: 100px;"
                                                     src="{{url('')}}/admin_assets/assets/demo/default/media/img/logo/logo-1.png"/>
                                            </a>
                                        </div>
                                        {{--
                                        <span class="m-invoice__desc">
															<span v-text="order.location.address"></span>
															<span v-text="order.location.name"></span>
										</span>
                                        --}}

                                        <div style="background-color: #f2f3f8;height: .5rem"></div>
                                        <div style="height: auto;border: .1rem solid #c3c4c9">
                                            <div style="border-bottom: .1rem solid #c3c4c9;font-size: 1.4em;color: black;padding: .2rem .5rem;">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        {{trans('admin.order_details_data')}}
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <button @click="show_edit_order"
                                                                style="width: 155px;float: left"
                                                                type="button"
                                                                class="btn btn-primary btn-block">
                                                            {{trans('admin.edit_order')}}
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                            <div style="padding: 3rem 2rem;">
                                                <table class="table" id="orderDetailsTable">
                                                    <tr>
                                                        <td>{{trans('admin.order_date')}}</td>
                                                        <td>{{$order->created_at}}</td>

                                                        <td>{{trans('admin.order_user_type')}}</td>
                                                        <td>
                                                            {{$order->is_guest == 1 ? trans('admin.order_guest') : trans('admin.order_user')}}
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>{{trans('admin.user')}}</td>
                                                        <td v-text="order.user_name"></td>

                                                        <td>{{trans('admin.email')}}</td>
                                                        <td v-text="order.user_email"></td>

                                                    </tr>
                                                    <tr>
                                                        <td>{{trans('admin.shipping_company')}}</td>
                                                        <td v-text="order.company_shipping && order.company_shipping.shipping_company ?order.company_shipping.shipping_company.name : '' "></td>


                                                        <td>{{trans('admin.note')}}</td>
                                                        <td>
                                                            <span class="m-badge  m-badge--wide m-badge--rounded"
                                                                  :class="order.confirm_cod_at ? 'm-badge--success' : 'm-badge--danger' "
                                                                  style="margin: 5px;color: white!important;"
                                                                  v-text="order.confirm_cod_at ? '{{trans('admin.confirmed_cod')}}' : '{{trans('admin.not_confirmed_cod')}}'"></span>
                                                        </td>


                                                    </tr>
                                                    <tr>
                                                        <td>{{trans('admin.platform')}}</td>
                                                        <td>{{$order->platform}}</td>

                                                        <td>{{trans('admin.order_status')}}</td>
                                                        <td v-text="order.status_text"></td>


                                                    </tr>
                                                    {{--<tr>--}}
                                                        {{--<td>{{trans('admin.remain_replace_time_counter')}}</td>--}}
                                                        {{--<td v-text="order.remain_replace_time"></td>--}}
                                                        {{--<td>{{trans('admin.order_processing_date')}}</td>--}}
                                                        {{--<td v-text="order.processing_at"></td>--}}
                                                    {{--</tr>--}}
                                                    {{--<tr>--}}
                                                        {{--<td>{{trans('admin.order_shipment_date')}}</td>--}}
                                                        {{--<td v-text="order.shipment_at"></td>--}}
                                                        {{--<td>{{trans('admin.order_pending_date')}}</td>--}}
                                                        {{--<td v-text="order.pending_at"></td>--}}
                                                    {{--</tr>--}}
                                                    {{--<tr>--}}
                                                        {{--<td>{{trans('admin.order_finished_date')}}</td>--}}
                                                        {{--<td v-text="order.finished_at"></td>--}}
                                                        {{--<td>{{trans('admin.order_replaced_date')}}</td>--}}
                                                        {{--<td v-text="order.replaced_at"></td>--}}
                                                    {{--</tr>--}}
                                                    {{--<tr>--}}
                                                        {{--<td>{{trans('admin.order_canceled_date')}}</td>--}}
                                                        {{--<td v-text="order.canceled_at"></td>--}}
                                                        {{--<td>{{trans('admin.order_returned_date')}}</td>--}}
                                                        {{--<td v-text="order.returned_at"></td>--}}
                                                    {{--</tr>--}}
                                                    <tr>
                                                        {{--<td>{{trans('admin.order_failed_date')}}</td>--}}
                                                        {{--<td v-text="order.failed_at"></td>--}}

                                                        <td>{{trans('admin.recipient_name')}}</td>
                                                        <td v-text="order.order_user_shipping.first_name+' '+order.order_user_shipping.last_name"></td>
                                                        <td>{{trans('admin.phone')}}</td>
                                                        <td v-text="order.order_user_shipping ? order.order_user_shipping.phone: ''"></td>
                                                    </tr>

                                                    <tr>
                                                        <td>{{trans('admin.country')}}</td>
                                                        <td v-text="order.order_user_shipping && order.order_user_shipping.shipping_city && order.order_user_shipping.shipping_city.country ? order.order_user_shipping.shipping_city.country.name : ''"></td>
                                                        <td>{{trans('admin.city')}}</td>
                                                        <td v-text="order.order_user_shipping && order.order_user_shipping.shipping_city ? order.order_user_shipping.shipping_city.name : ''"></td>
                                                    </tr>


                                                    <tr>
                                                        <td>القطعه</td>
                                                        <td v-text="order.order_user_shipping  ? order.order_user_shipping.state : ''"></td>
                                                        <td>الشارع</td>
                                                        <td v-text="order.order_user_shipping  ? order.order_user_shipping.street : ''"></td>
                                                    </tr>


                                                    <tr>
                                                        <td>الجادة</td>
                                                        <td v-text="order.order_user_shipping  ? order.order_user_shipping.avenue : ''"></td>
                                                        <td>رقم المبنى</td>
                                                        <td v-text="order.order_user_shipping  ? order.order_user_shipping.building_number : ''"></td>
                                                    </tr>

                                                    <tr>
                                                        <td>رقم الطابق</td>
                                                        <td v-text="order.order_user_shipping  ? order.order_user_shipping.floor_number : ''"></td>
                                                        <td>رقم الشقة</td>
                                                        <td v-text="order.order_user_shipping  ? order.order_user_shipping.apartment_number : ''"></td>
                                                    </tr>





                                                    <tr>
                                                        <td>{{trans('admin.place')}}</td>
                                                        <td colspan="3">
                                                            <a target="_blank"
                                                               href="http://maps.google.com/maps?q={{$order->lat .",". $order->lng}}">
                                                                {{"http://maps.google.com/maps?q=$order->lat".","."$order->lng"}}
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    {{--<tr>--}}
                                                        {{--<td>{{trans('admin.billing_building_number')}}</td>--}}
                                                        {{--<td v-text="order.order_user_shipping ? order.order_user_shipping.billing_building_number : ''"></td>--}}
                                                        {{--<td>{{trans('admin.billing_postalcode_number')}}</td>--}}
                                                        {{--<td v-text="order.order_user_shipping ? order.order_user_shipping.billing_postalcode_number : ''"></td>--}}
                                                    {{--</tr>--}}
                                                    {{--<tr>--}}
                                                        {{--<td>{{trans('admin.billing_unit_number')}}</td>--}}
                                                        {{--<td v-text="order.order_user_shipping ? order.order_user_shipping.billing_unit_number : ''"></td>--}}
                                                        {{--<td>{{trans('admin.billing_extra_number')}}</td>--}}
                                                        {{--<td v-text="order.order_user_shipping ? order.order_user_shipping.billing_extra_number : ''"></td>--}}
                                                    {{--</tr>--}}
                                                    <tr>

                                                        <td>{{trans('admin.change_order_status')}}</td>
                                                        <td>
                                                            <div v-show="!change_status_loading">
                                                                <select id="select_order_status"
                                                                        class="form-control">
                                                                    @foreach(trans_orignal_order_status() as $key=>$value)
                                                                        <option value="{{$key}}">{{$value}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <i v-show="change_status_loading" style="font-size: 25px;"
                                                               class="fa fa-spin fa-spinner"></i>
                                                        </td>

                                                        {{--<td>{{trans('admin.shipping_policy')}}</td>--}}
                                                        {{--<td>--}}
                                                            {{--<div v-show="!shipping_policy_loading">--}}
                                                                {{--<input class="form-control"--}}
                                                                       {{--type="text" @keyup.enter="shipping_policy(1)"--}}
                                                                       {{--id="shipping_policy_input"--}}
                                                                       {{--value="{{$order->shipping_policy}}"--}}
                                                                {{-->--}}
                                                                {{--<div v-show="order && order.company_shipping && order.company_shipping.shipping_company_id == 1"--}}
                                                                     {{--class="mt-2 mb-2">--}}
                                                                    {{--<button class="btn btn-success"--}}
                                                                            {{--@click="shipping_policy(2)">جلب بوليصة الشحن--}}
                                                                    {{--</button>--}}
                                                                    {{--<button id="print_shipping_policy"--}}
                                                                            {{--@click="print_shipping_policy(0)"--}}
                                                                            {{--class="btn btn-primary">طباعة بوليصة الشحن--}}
                                                                    {{--</button>--}}
                                                                    {{--<br>--}}
                                                                    {{--<button @click="show_cancel_shipping_policy(0)"--}}
                                                                            {{--class="mt-2 btn btn-danger">الغاء الطلبية--}}
                                                                    {{--</button>--}}
                                                                {{--</div>--}}
                                                            {{--</div>--}}
                                                            {{--<i v-show="shipping_policy_loading" style="font-size: 25px;"--}}
                                                               {{--class="fa fa-spin fa-spinner"></i>--}}
                                                        {{--</td>--}}


                                                    </tr>
                                                    {{--<tr>--}}
                                                        {{--<td>{{trans('admin.invoice_number_aswaq')}}</td>--}}
                                                        {{--<td>--}}
                                                            {{--<div v-show="!invoice_number_loading">--}}
                                                                {{--<input class="form-control"--}}
                                                                       {{--type="text" @keyup.enter="add_invoice_number"--}}
                                                                       {{--id="invoice_number_input"--}}
                                                                       {{--value="{{$order->invoice_number}}"--}}
                                                                {{-->--}}
                                                            {{--</div>--}}
                                                            {{--<i v-show="invoice_number_loading" style="font-size: 25px;"--}}
                                                               {{--class="fa fa-spin fa-spinner"></i>--}}

                                                        {{--</td>--}}
                                                    {{--</tr>--}}
                                                    <tr v-show="[6,9,10].includes(order.status)">
                                                        <td>{{trans('admin.returned_status')}}</td>
                                                        <td class="hidden show_hidden">
                                                            <span v-show="return_order_loading"> <i class="fa fa-spin fa-spinner" style="font-size: 20px;"></i></span>
                                                            <label v-show="!return_order_loading">
                                                                <span v-show="[6,9,10].includes(order.status) && order.returned_status == 1">{{trans('admin.approved')}}</span>
                                                                <span v-show="[6,9,10].includes(order.status) &&order.returned_status == 2">{{trans('admin.rejected')}}</span>
                                                            </label>
                                                            <div v-show="!return_order_loading" v-if="[6,9,10].includes(order.status) && order.returned_status == 0">
                                                                <button @click="show_approve_return_order" class="btn btn-success">{{trans('admin.approve_')}}</button>
                                                                <button @click="show_reject_return_order" class="btn btn-danger">{{trans('admin.reject_')}}</button>
                                                            </div>

                                                            <br>
                                                            <input type="text" v-model="return_order_note_text" class="form-control" id="return_order_note_text" placeholder="ملاحظه ارجاع الطلب" name="return_order_note_text">
                                                            <br>

                                                            <input type="file" @change="get_file($event , '#return_order_note_file' , 'return_order_note_file')"
                                                                   class="form-control m-input"
                                                                   >

                                                            <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <img id="return_order_note_file" width="100" height="100"
                                             :src="return_order_note_file == ''? '{{get_general_path_default_image('settings')}}' : '{{add_full_path($order->return_order_note_file , 'ads')}}'">
                                    </span>
                                                            </div>
                                                            <br>

                                                            <button @click="send_return_note" class="btn btn-success">{{trans('admin.send')}}</button>

                                                        </td>

                                                        <td>{{trans('admin.shipping_policy_for_return_order')}}</td>
                                                        <td>
                                                            <div v-show="!shipping_policy_return_loading">
                                                                <input class="form-control"
                                                                       type="text" @keyup.enter="shipping_policy(1 , 1)"
                                                                       id="shipping_policy_return_input"
                                                                       value="{{$order->shipping_policy_return}}"
                                                                >
                                                                <div v-show="order && order.company_shipping && order.company_shipping.shipping_company_id == 1"
                                                                     class="mt-2 mb-2">
                                                                    <button class="btn btn-success"
                                                                            @click="shipping_policy(2 , 1)">جلب بوليصة الشحن
                                                                    </button>
                                                                    <button id="print_shipping_policy"
                                                                            @click="print_shipping_policy(1)"
                                                                            class="btn btn-primary">طباعة بوليصة الشحن
                                                                    </button>
                                                                    <br>
                                                                    <button @click="show_cancel_shipping_policy(1)"
                                                                            class="mt-2 btn btn-danger">الغاء الطلبية
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <i v-show="shipping_policy_return_loading" style="font-size: 25px;"
                                                               class="fa fa-spin fa-spinner"></i>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <button style="margin-top: 48%;width: 100px; display: none"
                                                        @click="change_status"
                                                        :disabled="loading" type="button"
                                                        class="btn btn-primary btn-block"
                                                        :class="loading ? 'm-loader m-loader--light m-loader--left' : ''"
                                                        id="shipping_policy_td_button">
                                                    {{trans('admin.save')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>


                                </div>

                                <div style="background-color: rgb(242, 243, 248);height: 1rem;"></div>

                                <div id="products-block"
                                     class="m-invoice__body m-invoice__body--centered custom_invoice_body">
                                    <div class="table-responsive" dir="rtl">
                                        <div class="m-invoice__items">
                                            <div class="m-invoice__item" style="float: right">
                                                <select class="form-control" style="width: 200px;"
                                                        v-model="currency_type">
                                                    <option value="1">{{trans('admin.currecny_sold')}}</option>
{{--                                                    <option value="2">{{trans('admin.currecny_sar')}}</option>--}}
                                                </select>
                                            </div>
                                        </div>

                                        <button :disabled="order.can_edit == 0" style="width: 155px;float: left"
                                                @click="show_add_products_to_order"
                                                type="button"
                                                class="btn btn-primary btn-block">
                                            {{trans('admin.add_products')}}
                                        </button>
                                        <table class="table" id="orderDetailsTable">
                                            <thead>
                                            <tr>
                                                <th>{{trans('admin.image')}}</th>
                                                <th>{{trans('admin.product_name')}}</th>
                                                <th>{{trans('admin.status')}}</th>
                                                <th>{{trans('admin.sku')}}</th>
                                                <th>{{trans('admin.price')}}</th>
                                                <th>{{trans('admin.quantity')}}</th>
                                                <th>{{trans('admin.tax')}}</th>
                                                <th>{{trans('admin.total_price_without_tax')}}</th>
                                                <th>{{trans('admin.note')}}</th>
                                                <th>{{trans('admin.actions')}}</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="order_product in order.order_products" :class="[6,9,10].includes(order.status) && order_product.is_returned == 1 ? 'is-returned-product' : ''">
                                                <td><img :src="order_product.product.image" width="50" height="50"></td>
                                                <td style="width: 250px;">
                                                    <span style="margin-right: 8px;white-space: normal"
                                                          v-text="order_product.product.name"></span>
                                                    <br>
                                                    <span style="margin: 5px;"
                                                          v-for="attribute_value in order_product.product_attribute_values__"
                                                          class="m-badge m-badge--default m-badge--wide m-badge--rounded"
                                                          v-text="attribute_value.name"></span>
                                                    {{-- <span class="m-badge m-badge--default m-badge--wide m-badge--rounded"
                                                           v-text="set_attribute_value(order_product.product_attribute_values__)"></span>
                                                    --}}
                                                    {{--
                                                    <span v-for="attribute_value in order_product.product_attribute_values__">

                                                        <span v-if="attribute_value.attribute.attribute_type.key == 'image'">
                                                            <img width="30" height="30" :src="'{{url('')}}/uploads/attribute_values/'+attribute_value.value">
                                                        </span>
                                                        <span v-else-if="attribute_value.attribute.attribute_type.key == 'color'">
                                                            <div  :style="'background-color:'+attribute_value.value+';width: 30px;height: 30px;margin-top: 5px;'"></div>
                                                        </span>
                                                         <span v-else v-text="attribute_value.value"></span>

                                                    </span>
                                                     --}}
                                                </td>



                                                <td v-text="order_product.product_variation.order_status_text" >   </td>

                                                <td v-text="order_product.product_variation ? order_product.product_variation.sku : '' "></td>
                                                <td v-text="order_product.price"></td>
                                                <td>
                                                    <span style="width: 75px" class="show_quantity"
                                                          v-text="order_product.quantity"></span>
                                                    <input type="number" style="width: 75px"
                                                           @keypress.enter="save_order($event , order_product.id)"
                                                           class="form-control quantity hidden"
                                                           :value="order_product.quantity">
                                                </td>
                                                <td v-text="order_product.tax"></td>
                                                <td class="m--font-danger"
                                                    v-text="order_product.total_price"></td>
                                                <td>
                                                    <span v-show="order_product.is_gift == 1">{{trans('admin.gift')}}</span>
                                                </td>
                                                <td>
                                                    <span class="edit_or_remove">
                                                         <a :disabled="order.can_edit == 0" href="javascript:;"
                                                            @click="edit_order($event)"
                                                            class="edit m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                                            title="تعديل">
                                                        <i class="la la-edit"></i>
                                                    </a>
                                                    <a :disabled="order.can_edit == 0" href="javascript:;"
                                                       @click="show_delete_order_product(order_product)"
                                                       class="delete m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
                                                       title="حذف">
                                                        <i class="la la-remove"></i>
                                                    </a>
                                                    </span>
                                                    <span :disabled="order.can_edit == 0" class="save_or_cancel hidden">
                                                          <a href="javascript:;"
                                                             @click="save_order($event , order_product.id)"
                                                             class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                                             title="حفظ">
                                                        <i class="la la-save"></i>
                                                          </a>

                                                         <a :disabled="order.can_edit == 0" href="javascript:;"
                                                            @click="cancel_edit($event)"
                                                            class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
                                                            title="رجوع">
                                                        <i class="la la-caret-left"></i>
                                                          </a>
                                                    </span>

                                                </td>
                                            </tr>

                                            </tbody>

                                            <tfoot>

                                            {{--
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center" v-text="order.discount"></td>
                                                <td class="text-center" style="font-weight: 600"
                                                    v-text="order.price"></td>
                                            </tr>
                                            --}}

                                            </tfoot>
                                        </table>
                                    </div>

                                </div>

                                <div style="background-color: rgb(242, 243, 248);height: 1rem;"></div>

                                <div class="m-invoice__footer custom_footer">
                                    <div class="m-portlet">
                                        <div class="m-portlet__body m-portlet__body--no-padding">
                                            <div class="row m-row--no-padding m-row--col-separator-xl">
                                                <div class="col-md-12 col-lg-12 col-xl-3">
                                                    <div class="m-widget1">
                                                        <div class="m-widget1__item">
                                                            <div class="row m-row--no-padding align-items-center">
                                                                <div class="col"><h3
                                                                            class="m-widget1__title">{{trans('admin.payment_way')}}</h3>
                                                                </div>
                                                                <div class="col m--align-right"><span
                                                                            class="m-widget1__number m--font-brand"
                                                                            v-text="order.payment_method.name"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="m-widget1__item">
                                                            <div class="row m-row--no-padding align-items-center">
                                                                <div class="col"><h3
                                                                            class="m-widget1__title">{{trans('admin.currency_type')}}</h3>
                                                                </div>
                                                                <div class="col m--align-right"><span
                                                                            class="m-widget1__number m--font-brand"
                                                                            v-text="order.currency_text"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-12 col-xl-4">
                                                    <div class="m-widget1">
                                                        <div class="m-widget1__item">
                                                            <div class="row m-row--no-padding align-items-center">
                                                                <div class="col-sm-10"><h3
                                                                            class="m-widget1__title">{{trans('admin.order_price_before_discount')}}</h3>
                                                                </div>
                                                                <div class="col m--align-right"><span
                                                                            class="m-widget1__number m--font-info"
                                                                            v-text="order.price"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{--
                                                        <div class="m-widget1__item">
                                                            <div class="row m-row--no-padding align-items-center">
                                                                <div class="col"><h3
                                                                            class="m-widget1__title">{{trans('admin.discount_value')}}</h3>
                                                                </div>
                                                                <div class="col m--align-right"><span
                                                                            class="m-widget1__number m--font-info"
                                                                            v-text="order.discount_price"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        --}}

                                                        <div class="m-widget1__item"
                                                             v-show="order.first_order_discount > 0">
                                                            <div class="row m-row--no-padding align-items-center">
                                                                <div class="col-sm-10"><h3
                                                                            class="m-widget1__title">{{trans('admin.first_order_discount')}}</h3>
                                                                </div>
                                                                <div class="col m--align-right"><span
                                                                            class="m-widget1__number m--font-info"
                                                                            v-text="order.first_order_discount"></span>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="m-widget1__item"
                                                             v-for="admin_discount in order.admin_discounts"
                                                             v-show="admin_discount.price > 0">
                                                            <div class="row m-row--no-padding align-items-center">
                                                                <div class="col-sm-10"><h3 style="direction: ltr"
                                                                                           class="m-widget1__title"
                                                                                           v-text="'{{trans('api.admin_discount_')}}'+ ' (%'+ admin_discount.discount_rate + ' ) '">
                                                                    </h3>
                                                                </div>
                                                                <div class="col m--align-right"><span
                                                                            class="m-widget1__number m--font-info"
                                                                            v-text="admin_discount.price"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="m-widget1__item"
                                                             v-show="order.package_discount_price > 0">
                                                            <div class="row m-row--no-padding align-items-center">
                                                                <div class="col-sm-10"><h3
                                                                            class="m-widget1__title"
                                                                            v-text="'{{trans('admin.package_discount')}}' +' ( '+ (order.package && order.package.package ? order.package.package.name : '') +' ) '"></h3>
                                                                    <br>
                                                                    <span v-show="order.package && order.package.free_shipping">{{trans('admin.package_free_shipping')}}</span>
                                                                </div>
                                                                <div class="col m--align-right"><span
                                                                            class="m-widget1__number m--font-info"
                                                                            v-text="order.package_discount_price"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="m-widget1__item" v-for="coupon in order.coupon">
                                                            <div class="row m-row--no-padding align-items-center">
                                                                <div class="col-sm-10"><h3
                                                                            class="m-widget1__title">{{trans('admin.coupon_value')}}
                                                                        (<span v-text="coupon.coupon_code"></span>)
                                                                    </h3>
                                                                </div>
                                                                <div class="col m--align-right"><span
                                                                            class="m-widget1__number m--font-info"
                                                                            v-text="coupon.coupon_price"></span>
                                                                </div>
                                                            </div>
                                                        </div>


                                                        <div class="m-widget1__item">
                                                            <div class="row m-row--no-padding align-items-center">
                                                                <div class="col-sm-10"><h3
                                                                            class="m-widget1__title">{{trans('admin.price_after_discount_coupon')}}</h3>
                                                                </div>
                                                                <div class="col m--align-right"><span
                                                                            class="m-widget1__number m--font-info"
                                                                            v-text="order.price_after_discount_coupon"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-lg-12 col-xl-5">
                                                    <div class="m-widget1">
                                                        <div class="m-widget1__item">
                                                            <div class="row m-row--no-padding align-items-center">
                                                                <div class="col-sm-10"><h3
                                                                            class="m-widget1__title">{{trans('admin.cash_fees')}}</h3>
                                                                </div>
                                                                <div class="col m--align-right"><span
                                                                            class="m-widget1__number m--font-warning"
                                                                            v-text="order.cash_fees"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="m-widget1__item">
                                                            <div class="row m-row--no-padding align-items-center">
                                                                <div class="col-sm-10"><h3
                                                                            class="m-widget1__title"> {{trans('admin.shipping')}}
                                                                        <span v-text="'( '+order.shipping_text+' )'"></span>
                                                                    </h3>
                                                                </div>
                                                                <div class="col m--align-right"><span
                                                                            class="m-widget1__number m--font-danger"
                                                                            v-text="order.shipping == 0 ? '{{trans('admin.free_shipping')}}' : order.shipping"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="m-widget1__item">
                                                            <div class="row m-row--no-padding align-items-center">
                                                                <div class="col-sm-10"><h3
                                                                            class="m-widget1__title"> {{trans('admin.price_before_tax')}}</h3>
                                                                </div>
                                                                <div class="col m--align-right"><span
                                                                            class="m-widget1__number m--font-danger"
                                                                            v-text="order.price_before_tax"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="m-widget1__item">
                                                            <div class="row m-row--no-padding align-items-center">
                                                                <div class="col-sm-10"><h3 style="direction: ltr"
                                                                                           class="m-widget1__title">{{trans('api.tax_text' , ['tax' => $order->tax_percentage])}}</h3>
                                                                </div>
                                                                <div class="col m--align-right"><span
                                                                            class="m-widget1__number m--font-danger"
                                                                            v-text="order.tax"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="m-widget1__item">
                                                            <div class="row m-row--no-padding align-items-center">
                                                                <div class="col-sm-10"><h3
                                                                            class="m-widget1__title">{{trans('admin.total_price')}}</h3>
                                                                </div>
                                                                <div class="col m--align-right"><span
                                                                            class="m-widget1__number m--font-primary"
                                                                            v-text="order.total_price"></span>
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
                </div>
            </div>
        </div>
    </div>
@endsection





@push('js')
    <script>

        {{--var return_order_note_text = {!! $order->return_order_note_text !!};--}}

        var order = {!! $order !!};

        var countries = {!! $countries !!};
        var cities = {!! $cities !!};
        var shipping_companies = {!! $shipping_companies !!};
        var payment_methods = {!! $payment_methods !!};


    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>


    <script src="{{url('')}}/admin_assets/assets/demo/default/custom/crud/forms/widgets/clipboard.js"
            type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/vendors/custom/datatables/datatables.bundle.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/general/js/orders/order_details.js"
            type="text/javascript"></script>

    <script src="{{url('')}}/admin_assets/assets/demo/default/custom/components/base/toastr.js"
            type="text/javascript"></script>


    <script>

    </script>


    <script>
        function myFunction() {
            window.print();
        }

        function savePDF() {
            $('.load_pdf').removeClass('hidden');
            $('#download').addClass('hidden');
            //  var order_id = $('.get_order_id').text();
            const content = $('#order_details_4').html();
            var filename = "order details";
            const opt = {
                margin: 1,
                filename: filename,
                image: {type: 'jpeg', quality: 4},
                html2canvas: {scale: 5},
                jsPDF: {unit: 'in', format: 'a3', orientation: 'portrait'}
            };

            // Save the PDF
            html2pdf().set(opt).from(content).outputPdf().then(function (pdf) {
                $('.load_pdf').addClass('hidden');
                $('#download').removeClass('hidden');
            }).save();
        }

        $('#download').click(function () {
            //savePDF();
            myFunction();
        });

        $("#shipping_policy_td").keyup(function (event) {
            var code;

            if (event.key !== undefined) {
                code = event.key;
            } else if (event.keyIdentifier !== undefined) {
                code = event.keyIdentifier;
            } else if (event.keyCode !== undefined) {
                code = event.keyCode;
            }

            if (code == "Enter") {
                $("#shipping_policy_td_button").click();
            }
        });
        var firsttime = true
        $('#select_order_status').on('change', function () {
            if (firsttime) {
                firsttime = false
            } else {
                $("#shipping_policy_td_button").click()
            }
        });


    </script>


@endpush

