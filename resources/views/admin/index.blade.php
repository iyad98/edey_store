@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet"
          type="text/css"/>

@endpush



@section('content')
    <!-- BEGIN: Subheader -->

    <!-- END: Subheader -->
    <div class="m-content">



        <div class="m-portlet" style="margin-bottom: 0">
            <div class="m-portlet__body  custom_m_portal_body m-portlet__body--no-padding">
                <div class="row top_row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::Total Profit-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">

                                <h4 class="m-widget24__title">
                                    العملاء
                                </h4><br>
                                <span class="m-widget24__desc">
													عدد العملاء
												</span>
                                <span class="m-widget24__stats m--font-brand">
													{{$general_data['users_count']}}
												</span>

                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-brand" role="progressbar"
                                         style="width: {{$general_data['user_count_percentage']}};" aria-valuenow="50"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
													النسبة من الكل
												</span>
                                <span class="m-widget24__number">
													{{$general_data['user_count_percentage']}}
												</span>
                            </div>
                        </div>

                        <!--end::Total Profit-->
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Feedbacks-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    المنتجات
                                </h4><br>
                                <span class="m-widget24__desc">
													عدد المنتجات المضافة
												</span>
                                <span class="m-widget24__stats m--font-info">
													{{$general_data['products_count']}}
												</span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-info" role="progressbar"
                                         style="width: {{$general_data['products_count_percentage']}};"
                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
													النسبة من الكل
												</span>
                                <span class="m-widget24__number">
													{{$general_data['products_count_percentage']}}
												</span>
                            </div>
                        </div>

                        <!--end::New Feedbacks-->
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Orders-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    الطلبات
                                </h4><br>
                                <span class="m-widget24__desc">
													عدد الطلبات
												</span>
                                <span class="m-widget24__stats m--font-danger">
												{{$general_data['orders_count']}}
												</span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-danger" role="progressbar"
                                         style="width: {{$general_data['orders_count_percentage']}};" aria-valuenow="50"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
													النسبة من الكل
												</span>
                                <span class="m-widget24__number">
													{{$general_data['orders_count_percentage']}}
												</span>
                            </div>
                        </div>

                        <!--end::New Orders-->
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Users-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    الطلبات المكتملة
                                </h4><br>
                                <span class="m-widget24__desc">
													عدد الطلبات المكتملة
												</span>
                                <span class="m-widget24__stats m--font-success">
													{{$general_data['orders_finished_count']}}
												</span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-success" role="progressbar"
                                         style="width: {{$general_data['orders_finished_count_percentage']}};"
                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
													النسبة من الكل
												</span>
                                <span class="m-widget24__number">
													{{$general_data['orders_finished_count_percentage']}}
												</span>
                            </div>
                        </div>

                        <!--end::New Users-->
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Users-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    الطلبات الجديدة
                                </h4><br>
                                <span class="m-widget24__desc">
													عدد الطلبات الجديدة
												</span>
                                <span class="m-widget24__stats m--font-success">
													{{$general_data['orders_new_count']}}
												</span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-success" role="progressbar"
                                         style="width: {{$general_data['orders_new_count_percentage']}};"
                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
													النسبة من الكل
												</span>
                                <span class="m-widget24__number">
													{{$general_data['orders_new_count_percentage']}}
												</span>
                            </div>
                        </div>

                        <!--end::New Users-->
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Users-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    الطلبات قيد المعالجة
                                </h4><br>
                                <span class="m-widget24__desc">
													عدد الطلبات قيد المعالجة
												</span>
                                <span class="m-widget24__stats m--font-success">
													{{$general_data['orders_processing_count']}}
												</span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-success" role="progressbar"
                                         style="width: {{$general_data['orders_processing_count_percentage']}};"
                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
													النسبة من الكل
												</span>
                                <span class="m-widget24__number">
													{{$general_data['orders_processing_count_percentage']}}
												</span>
                            </div>
                        </div>

                        <!--end::New Users-->
                    </div>


                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Users-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    الطلبات الفاشلة
                                </h4><br>
                                <span class="m-widget24__desc">
													عدد الطلبات الفاشلة
												</span>
                                <span class="m-widget24__stats m--font-success">
													{{$general_data['orders_failed_count']}}
												</span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-success" role="progressbar"
                                         style="width: {{$general_data['orders_failed_count_percentage']}};"
                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
													النسبة من الكل
												</span>
                                <span class="m-widget24__number">
													{{$general_data['orders_failed_count_percentage']}}
												</span>
                            </div>
                        </div>

                        <!--end::New Users-->
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::New Users-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    الطلبات الملغية
                                </h4><br>
                                <span class="m-widget24__desc">
													عدد الطلبات الملغية
												</span>
                                <span class="m-widget24__stats m--font-success">
													{{$general_data['orders_canceled_count']}}
												</span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-success" role="progressbar"
                                         style="width: {{$general_data['orders_canceled_count_percentage']}};"
                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
													النسبة من الكل
												</span>
                                <span class="m-widget24__number">
													{{$general_data['orders_canceled_count_percentage']}}
												</span>
                            </div>
                        </div>

                        <!--end::New Users-->
                    </div>

                </div>

            </div>
        </div>
        <div class="m-portlet custom_m_portal" id="vue_counter">
            <div class="m-portlet__body  custom_m_portal_body m-portlet__body--no-padding">
                <div class="row top_row m-row--no-padding m-row--col-separator-xl">
                    <div v-for="coupon in coupons" class="col-sm-3" >

                        <!--begin::Total Profit-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">

                                <h4 class="m-widget24__title">
                                    عداد الكوبون
                                </h4><br>

                                <span class="m-widget24__desc">
													رمز الكوبون
												</span>
                                <span class="m-widget24__stats m--font-brand" v-text="coupon.coupon"></span>

                                <br>
                                <span class="mt-2 mb-2 m-widget24__stats m--font-brand" style="direction: ltr" :id="'countdown'+(coupon.id)"></span>
                            </div>
                        </div>

                        <!--end::Total Profit-->
                    </div>
                </div>

            </div>
        </div>
        <div class="m-portlet custom_m_portal">
            <div class="m-portlet__body m-portlet__body--no-padding">
                <div class="row top_row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-md-12 col-lg-12 col-xl-6">

                        <!--begin:: Widgets/Stats2-1 -->
                        <div class="m-widget1">
                            <div class="m-widget1__item">
                                <div class="row top_row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">منتجات {{trans('api.in_manufacturing')}} </h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">
                                            {{optional($general_data['product_status'])->prodact_in_manufacturing}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row top_row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">منتجات  {{trans('api.charged_up')}} </h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">
                                            {{optional($general_data['product_status'])->prodact_charged_up}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row top_row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">منتجات  {{trans('api.charged_at_sea')}}</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">
                                            {{optional($general_data['product_status'])->prodact_charged_at_sea}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--end:: Widgets/Stats2-1 -->
                    </div>
                    <div class="col-md-12 col-lg-12 col-xl-6">

                        <!--begin:: Widgets/Stats2-2 -->
                        <div class="m-widget1">
                            <div class="m-widget1__item">
                                <div class="row top_row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">منتجات  {{trans('api.at_the_harbour')}}</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">
                                            {{optional($general_data['product_status'])->prodact_at_the_harbour}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row top_row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">منتجات  {{trans('api.in_the_warehouse')}}</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-danger">
                                            {{optional($general_data['product_status'])->prodact_in_the_warehouse}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">منتجات  {{trans('api.delivered')}}</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-danger">
                                            {{optional($general_data['product_status'])->prodact_delivered}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--begin:: Widgets/Stats2-2 -->
                    </div>

                </div>
            </div>
        </div>
        <div class="m-portlet custom_m_portal">
            <div class="m-portlet__body  custom_m_portal_body m-portlet__body--no-padding">
                <div class="row top_row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-xl-4">

                        <!--begin:: Widgets/Stats2-1 -->
                        <div class="m-widget1">
                            <div class="m-widget1__item">
                                <div class="row top_row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">المبيعات</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">{{$all_total_price . " ".get_currency()}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row top_row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">تكلفة شحن الطلبات</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-warning">{{$all_shipping . " ".get_currency()}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row  top_row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">تكلفة الضرائب</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-success">{{$all_tax . " ".get_currency()}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="m-widget1__item">
                                <div class="row  top_row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">قيمة القسائم الشرائية</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-danger">{{$all_coupon_price . " ".get_currency()}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--end:: Widgets/Stats2-1 -->
                    </div>
                    <div class="col-xl-8">
                        <canvas id="chart_area"></canvas>
                        <!--end:: Widgets/Daily Sales-->
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet custom_m_portal">
            <div class="m-portlet__body  custom_m_portal_body m-portlet__body--no-padding">
                <div class="row  top_row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-xl-4">
                        <div class="m-widget1">
                            <div class="m-widget1__item">
                                <div class="row  top_row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">عدد العملاء</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">{{$all_count_users}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <canvas id="count_users_type"></canvas>
                    </div>
                    <div class="col-xl-8">

                        <canvas id="users_statistic"></canvas>

                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet custom_m_portal">
            <div class="m-portlet__body  custom_m_portal_body m-portlet__body--no-padding">
                <div class="row  top_row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-xl-4">
                        <div class="m-widget1">
                            <div class="m-widget1__item">
                                <div class="row  top_row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">إجمالي عدد الطلبات</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">{{$all_orders_count}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <canvas id="chart-pie-order-type"></canvas>
                    </div>
                    <div class="col-xl-8">
                        <canvas id="chart_area-order-count"></canvas>
                    </div>

                </div>
            </div>
        </div>


        <div class="m-portlet custom_m_portal">
            <div class="m-portlet__body  custom_m_portal_body m-portlet__body--no-padding">
                <div class="row top_row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-xl-6">
                        <canvas id="count_all_order_payment_types"></canvas>
                    </div>
                    <div class="col-xl-6">
                        <canvas id="count_all_order_shipping_types"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row top_row ">
            <div class="col-xl-4">

                <!--begin:: Widgets/New Users-->
                <div class="m-portlet custom_m_portal_body m-portlet--full-height ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    أجدد العملاء
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="m_widget4_tab1_content">

                                <!--begin::Widget 14-->
                                <div class="m-widget4">
                                    @foreach($general_latest_data['users'] as $user)
                                        <div class="m-widget4__item">
                                            <div class="m-widget4__img m-widget4__img--pic">
                                                <img width="50" height="50"
                                                     src="{{$user->getOriginal('image') ? $user->image : url('uploads/users/defullt.png')}}"
                                                     alt="">
                                            </div>
                                            <div class="m-widget4__info">
															<span class="m-widget4__title">
																{{$user->first_name ." ".$user->last_name}}
															</span><br>
                                                <span class="m-widget4__sub">
																{{$user->email}}
															</span>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <a href="{{url('admin/users')}}" class="btn m-btn--pill btn-primary"
                           style="width: 100px;height: 31px;padding: 6px;">{{trans('admin.show_more')}}</a>

                    </div>
                </div>

                <!--end:: Widgets/New Users-->
            </div>
            <div class="col-xl-4">

                <!--begin:: Widgets/Last Updates-->
                <div class="m-portlet custom_m_portal_body m-portlet--full-height ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    أخر الطلبات
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">

                        <!--begin::widget 12-->
                        <div class="m-widget4">
                            @foreach($general_latest_data['orders'] as $order)
                                <div class="m-widget4__item">
                                    <div class="m-widget4__ext">
													<span class="m-widget4__icon m--font-brand">
														<i class="flaticon-interface-3"></i>
													</span>
                                    </div>

                                    <div class="m-widget4__info">
                                        <a href="{{url('admin/orders/'.$order->id)}}">
													<span class="m-widget4__text">
														 طلب رقم :{{$order->id}}
													</span>
                                        </a>
                                    </div>


                                    <div class="m-widget4__ext">
													<span class="m-widget4__number m--font-info">
														{{$order->total_price ." ".get_currency()}}
													</span>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <a href="{{url('admin/orders')}}" class="btn m-btn--pill btn-primary"
                           style="width: 100px;height: 31px;padding: 6px;">{{trans('admin.show_more')}}</a>

                        <!--end::Widget 12-->
                    </div>
                </div>

                <!--end:: Widgets/Last Updates-->
            </div>
            <div class="col-xl-4">

                <!--begin:: Widgets/New Users-->
                <div class="m-portlet custom_m_portal_body m-portlet--full-height ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    المنتجات الأكثر طلبا
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="m_widget4_tab1_content">

                                <!--begin::Widget 14-->
                                <div class="m-widget4">
                                    @foreach($general_latest_data['most_purchase_product']  as $order_product)
                                        <div class="m-widget4__item">

                                            <div class="m-widget4__img m-widget4__img--pic">
                                                <img width="50" height="50"
                                                     src="{{$order_product->product->image}}"
                                                     alt="">
                                            </div>

                                            <div class="m-widget4__info">
															<span class="m-widget4__title">
																{{$order_product->product->name}}
															</span><br>

                                            </div>

                                        </div>
                                    @endforeach
                                </div>

                                <!--end::Widget 14-->
                            </div>

                        </div>
                        <a href="{{url('admin/products?sort_by=3')}}" class="btn m-btn--pill btn-primary"
                           style="width: 100px;height: 31px;padding: 6px;">{{trans('admin.show_more')}}</a>

                    </div>
                </div>

                <!--end:: Widgets/New Users-->
            </div>

        </div>
    </div>
@endsection





@push('js')

    <script>
        var financial = {!! $financial !!};
        var users_statistic = {!! $users_statistic !!};
        var orders_type_data = {!! $orders_type_data !!};
        var get_orders_payment_types_data = {!! $get_orders_payment_types_data !!};
        var get_orders_shipping_types_data = {!! $get_orders_shipping_types_data !!};
        var orders_count_data = {!! $orders_count_data !!};
        var coupons = {!! $coupons !!};


    </script>
    <script src="{{url('')}}/admin_assets/assets/vendors/custom/fullcalendar/fullcalendar.bundle.js"
            type="text/javascript"></script>
    <script src="{{url('')}}/admin_assets/assets/app/js/dashboard.js" type="text/javascript"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/home/chart.js" type="text/javascript"></script>
    <script src="{{url('')}}/admin_assets/assets/general/js/home/test/utils.js"></script>


    <script src="{{url('')}}/admin_assets/assets/general/js/home/chart_data.js" type="text/javascript"></script>

    <script>

        function set_start_end_date(start_at, end_at) {
            window.location = "?start_at=" + start_at + "&end_at=" + end_at;
        }

        $(document).ready(function () {
            $("#m_dashboard_daterangepicker_2").daterangepicker({
                buttonClasses: "m-btn btn",
                applyClass: "btn-primary",
                cancelClass: "btn-secondary",
                direction: mUtil.isRTL(),
                startDate: $('#start_at').val(),
                endDate: $('#end_at').val(),
                locale: {
                    "customRangeLabel": "تحديد تاريخ",
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'رجوع',
                    applyLabel: 'تطبيق',
                },
                ranges: {
                    "اليوم": [moment(), moment()],
                    "البارحة": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "أخر 7 أيام": [moment().subtract(6, "days"), moment()],
                    "أخر 30 يوم": [moment().subtract(29, "days"), moment()],
                    "هذا الشهر": [moment().startOf("month"), moment().endOf("month")],
                    "الشهر الماضي": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                }
            }, function (a, t, n) {
                console.log(a.format("YYYY-MM-DD") + " " + t.format("YYYY-MM-DD"));
                set_start_end_date(a.format("YYYY-MM-DD"), t.format("YYYY-MM-DD"));
                $("#m_dashboard_daterangepicker_2 .m-subheader__daterange-label").text(a.format("YYYY-MM-DD") + " / " + t.format("YYYY-MM-DD"));
            });
        });


    </script>



    <script>

        var vue_counter = new Vue({
            el: '#vue_counter',
            data: {
                coupons: []
            }
        });

        var seconds = [];
        coupons.forEach(function (t) {
            seconds.push(
                {
                    id: t.id,
                    html_id: "countdown" + t.id,
                    seconds: t.count_down
                }
            );
            vue_counter.coupons.push({
                id: t.id,
                coupon: t.coupon
            });
        });


        function timer() {


            seconds.forEach(function (t) {
                if(t.seconds != 0 ){
                    var days = Math.floor(t.seconds / 24 / 60 / 60);
                    var hoursLeft = Math.floor((t.seconds) - (days * 86400));
                    var hours = Math.floor(hoursLeft / 3600);
                    var minutesLeft = Math.floor((hoursLeft) - (hours * 3600));
                    var minutes = Math.floor(minutesLeft / 60);
                    var remainingSeconds = t.seconds % 60;

                    function pad(n) {
                        return (n < 10 ? "0" + n : n);
                    }

                    document.getElementById(t.html_id).innerHTML = pad(days) + " " + pad(hours) + ":" + pad(minutes) + ":" + pad(remainingSeconds);
                    if (t.seconds == 0) {
                        clearInterval(countdownTimer);
                        document.getElementById(t.html_id).innerHTML = "انتهى الوقت";
                    } else {
                        t.seconds = t.seconds - 1;
                    }
                }else {
                    document.getElementById(t.html_id).innerHTML = "انتهى الوقت";
                }

            });

        }
        var countdownTimer = setInterval('timer()', 1000);

    </script>

@endpush

