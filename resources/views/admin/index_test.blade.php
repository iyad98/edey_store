@extends('admin.layout')


@push('css')
    <link href="{{url('')}}/admin_assets/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet"
          type="text/css"/>

@endpush



@section('content')
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title ">{{trans('admin.dashboard')}}</h3>
            </div>

            <div>
                <input type="hidden" value="{{$start_at}}" id="start_at">
                <input type="hidden" value="{{$end_at}}" id="end_at">

                <span class="m-subheader__daterange" id="m_dashboard_daterangepicker_2">
									<span class="m-subheader__daterange-label">
										<span class="m-subheader__daterange-title">{{$end_at ." - ".$start_at}}</span>
										<span class="m-subheader__daterange-date m--font-brand"></span>
									</span>
									<a href="#"
                                       class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
										<i class="la la-angle-down"></i>
									</a>
								</span>
            </div>

        </div>
    </div>

    <!-- END: Subheader -->
    <div class="m-content">

        <div class="m-portlet ">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-md-12 col-lg-6 col-xl-3">

                        <!--begin::Total Profit-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">

                                <h4 class="m-widget24__title">
                                    المستخدمين
                                </h4><br>
                                <span class="m-widget24__desc">
													عدد المستخدمين
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
                                    الطلبات
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
                </div>

            </div>
        </div>
        <div class="m-portlet">
            <div class="m-portlet__body m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-md-12 col-lg-12 col-xl-4">

                        <!--begin:: Widgets/Stats2-1 -->
                        <div class="m-widget1">
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">طلبات بانتظار الدفع</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">
                                            {{$general_data['order_status']->payment_waiting_count}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">طلبات قيد المعالجة</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">
                                            {{$general_data['order_status']->processing_count}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">طلبات قيد الشحن</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">
                                            {{$general_data['order_status']->shipment_count}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--end:: Widgets/Stats2-1 -->
                    </div>
                    <div class="col-md-12 col-lg-12 col-xl-4">

                        <!--begin:: Widgets/Stats2-2 -->
                        <div class="m-widget1">
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">طلبات قيد الانتظار</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">
                                            {{$general_data['order_status']->pending_count}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">طلبات ملغية</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-danger">
                                            {{$general_data['order_status']->canceled_count}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">طلبات مستردة</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-danger">
                                            {{$general_data['order_status']->returned_count}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--begin:: Widgets/Stats2-2 -->
                    </div>
                    <div class="col-md-12 col-lg-12 col-xl-4">

                        <!--begin:: Widgets/Stats2-3 -->
                        <div class="m-widget1">
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">طلبات فاشلة</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-danger">
                                            {{$general_data['order_status']->failed_count}}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">طلبات مكتلمة</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">
                                            {{$general_data['order_status']->finished_count}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--begin:: Widgets/Stats2-3 -->
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-xl-4">

                        <!--begin:: Widgets/Stats2-1 -->
                        <div class="m-widget1">
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">المبيعات</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-brand">{{$all_total_price . " ".get_currency()}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">تكلفة شحن الطلبات</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-wearing">{{$all_shipping . " ".get_currency()}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">تكلفة الضرائب</h3>
                                    </div>
                                    <div class="col m--align-right">
                                        <span class="m-widget1__number m--font-success">{{$all_tax . " ".get_currency()}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
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
        <div class="m-portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-xl-4">
                        <div class="m-widget1">
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">عدد المستخدمين</h3>
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
        <div class="m-portlet">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-xl-4">
                        <div class="m-widget1">
                            <div class="m-widget1__item">
                                <div class="row m-row--no-padding align-items-center">
                                    <div class="col">
                                        <h3 class="m-widget1__title">عدد الطلبات</h3>
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

        <div class="row">
            <div class="col-xl-4">

                <!--begin:: Widgets/New Users-->
                <div class="m-portlet m-portlet--full-height ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    اجدد مستخدمين
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
                        <a href="{{url('admin/users')}}" class="btn m-btn--pill btn-primary" style="width: 100px;height: 31px;padding: 6px;" >{{trans('admin.show_more')}}</a>

                    </div>
                </div>

                <!--end:: Widgets/New Users-->
            </div>
            <div class="col-xl-4">

                <!--begin:: Widgets/Last Updates-->
                <div class="m-portlet m-portlet--full-height ">
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
                        <a href="{{url('admin/orders')}}" class="btn m-btn--pill btn-primary" style="width: 100px;height: 31px;padding: 6px;" >{{trans('admin.show_more')}}</a>

                        <!--end::Widget 12-->
                    </div>
                </div>

                <!--end:: Widgets/Last Updates-->
            </div>
            <div class="col-xl-4">

                <!--begin:: Widgets/New Users-->
                <div class="m-portlet m-portlet--full-height ">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    المنتجات الاكثر طلبا
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
                        <a href="{{url('admin/products?sort_by=3')}}" class="btn m-btn--pill btn-primary" style="width: 100px;height: 31px;padding: 6px;" >{{trans('admin.show_more')}}</a>

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
        var orders_count_data = {!! $orders_count_data !!};


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

@endpush

