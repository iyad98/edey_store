<button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i
            class="la la-close"></i></button>
<div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark "
         m-menu-vertical="1" m-menu-scrollable="1" m-menu-dropdown-timeout="500" style="position: relative;">

        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item {{$active_menu == 'dashoard' ? 'm-menu__item--active': ''}}" aria-haspopup="true">
                <a href="{{route('admin.index')}}" class="m-menu__link "><i
                            class="m-menu__link-icon flaticon-home-1"></i><span class="m-menu__link-title"> <span
                                class="m-menu__link-wrap"> <span
                                    class="m-menu__link-text">{{trans('admin.dashboard')}}</span>
											 </span></span></a>
            </li>

            <li class="m-menu__item m-menu__item--submenu {{ $active_menu == 'products' || $active_menu == 'attributes' || $active_menu=='coupons'|| $active_menu=='brands' || $active_menu=='order_status' || $active_menu=='categories'? 'm-menu__item--active m-menu__item--open': ''}}"
                aria-haspopup="true" m-menu-submenu-toggle="hover"><a
                        href="javascript:;" class="m-menu__link m-menu__toggle"><i
                            class="m-menu__link-icon fab fa-product-hunt"></i><span
                            class="m-menu__link-text">{{trans('admin.products')}}</span><i
                            class="m-menu__ver-arrow la la-angle-left"></i></a>
                <div class="m-menu__submenu " m-hidden-height="40"
                     style="{{isset($active_menu) && $active_menu == 'products' || $active_menu == 'attributes' || $active_menu=='coupons' || $active_menu=='brands' || $active_menu=='order_status' || $active_menu=='categories'? '': 'display: none;'}} overflow: hidden;"><span
                            class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                                    class="m-menu__link"><span
                                        class="m-menu__link-text">{{trans('admin.products')}}</span></span></li>



                        @check_role('view_products|add_products|edit_products|delete_products')
                        <li class="m-menu__item {{$active_menu == 'products' ? 'm-menu__item--active': ''}}" aria-haspopup="true">

                            <a href="{{route('admin.products.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fab fa-product-hunt"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.products')}}</span>
										 </span></span></a>
                        </li>
                        @endcheck_role


                        @check_role('view_categories|add_categories|edit_categories|delete_categories')
                        <li class="m-menu__item {{$active_menu == 'categories' ? 'm-menu__item--active': ''}}" aria-haspopup="true">

                            <a href="{{route('admin.categories.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-clipboard-list"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.categories')}}</span>
										 </span></span></a>
                        </li>
                        @endcheck_role

                        @check_role('view_attributes|add_attributes|edit_attributes|delete_attributes')
                        <li class="m-menu__item {{$active_menu == 'attributes' ? 'm-menu__item--active': ''}}" aria-haspopup="true">

                            <a href="{{route('admin.attributes.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-clipboard-list"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.attributes')}}</span>
										 </span></span></a>
                        </li>
                        @endcheck_role



                        @check_role('view_coupons|add_coupons|edit_coupons|delete_coupons')
                        <li class="m-menu__item {{$active_menu == 'coupons' ? 'm-menu__item--active': ''}}" aria-haspopup="true">

                            <a href="{{route('admin.coupons.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-gift"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.coupons')}}</span>
										 </span></span></a>
                        </li>
                        @endcheck_role

                        @check_role('view_brands|add_brands|edit_brands|delete_brands')
                        <li class="m-menu__item {{$active_menu == 'brands' ? 'm-menu__item--active': ''}}" aria-haspopup="true">

                            <a href="{{route('admin.brands.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-trademark"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.brands')}}</span>
										 </span></span></a>
                        </li>
                        @endcheck_role

                        @check_role('view_products|add_products|edit_products|delete_products')
                        <li class="m-menu__item {{$active_menu == 'order_status' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.order_status.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fab fa-product-hunt"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.order_status')}}</span>
										 </span></span></a>
                        </li>
                        @endcheck_role


                    </ul>
                </div>
            </li>
            @check_role('view_orders')
            <li class="m-menu__item m-menu__item--submenu {{ $active_menu == 'orders' ||isset($sub_menu) && $sub_menu == 'cancel_reasons' ? 'm-menu__item--active m-menu__item--open': ''}}"
                aria-haspopup="true" m-menu-submenu-toggle="hover"><a
                        href="javascript:;" class="m-menu__link m-menu__toggle"><i
                            class="m-menu__link-icon fa fa-shopping-cart"></i><span
                            class="m-menu__link-text">{{trans('admin.orders')}}</span><i
                            class="m-menu__ver-arrow la la-angle-left"></i></a>
                <div class="m-menu__submenu " m-hidden-height="40"
                     style="{{isset($active_menu) && $active_menu == 'orders' ||isset($sub_menu) && $sub_menu == 'cancel_reasons' ? '': 'display: none;'}} overflow: hidden;"><span
                            class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                                    class="m-menu__link"><span
                                        class="m-menu__link-text">{{trans('admin.shipping_payment')}}</span></span></li>

                        <li class="m-menu__item {{$active_menu == 'orders' ? 'm-menu__item--active': ''}}" aria-haspopup="true">

                            <a href="{{route('admin.orders.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-shopping-cart"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.orders')}}</span>
										 </span></span></a>
                        </li>


                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'cancel_reasons' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.cancel_reasons.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-window-close"></i><span
                                        class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.cancel_reasons')}}</span>
											 </span></span></a>
                        </li>


                    </ul>
                </div>
            </li>
            @endcheck_role
            @check_role('view_users|add_users|edit_users|delete_users')
            <li class="m-menu__item {{$active_menu == 'users' ? 'm-menu__item--active': ''}}" aria-haspopup="true">

                <a href="{{route('admin.users.index')}}" class="m-menu__link "><i
                            class="m-menu__link-icon fa fa-user"></i><span class="m-menu__link-title"> <span
                                class="m-menu__link-wrap"> <span
                                    class="m-menu__link-text">{{trans('admin.users')}}</span>
											 </span></span></a>
            </li>
            @endcheck_role
            @check_role('store_statistics|store_bill|invoice|invoice2|coupon')
            <li class="m-menu__item m-menu__item--submenu {{ $active_menu == 'statistics' ? 'm-menu__item--active m-menu__item--open': ''}}"
                aria-haspopup="true" m-menu-submenu-toggle="hover"><a
                        href="javascript:;" class="m-menu__link m-menu__toggle"><i
                            class="m-menu__link-icon fa fa-chart-bar"></i><span
                            class="m-menu__link-text">{{trans('admin.statistics')}}</span><i
                            class="m-menu__ver-arrow la la-angle-left"></i></a>
                <div class="m-menu__submenu " m-hidden-height="40"
                     style="{{isset($active_menu) && $active_menu == 'statistics' ? '': 'display: none;'}} overflow: hidden;"><span
                            class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                                    class="m-menu__link"><span
                                        class="m-menu__link-text">{{trans('admin.statistics')}}</span></span></li>

                        @check_role('store_statistics')
                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'store_statistics' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">
                            <a href="{{route('admin.store_statistics.index')}}" class="m-menu__link confirmation">
                                <i class="m-menu__link-icon fa fa-chart-bar "></i>
                                <span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.store_statistics')}}</span>
											 </span></span></a>
                        </li>
                        @endcheck_role


                        @check_role('store_bill')
                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'store_bill' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.store_bill.index')}}" class="m-menu__link confirmation">
                                <i class="m-menu__link-icon fa fa-chart-bar"></i>
                                <span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.store_bill')}}</span>
											 </span></span></a>
                        </li>
                        @endcheck_role

                        @check_role('order_product_reports')
                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'order_product' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.order_product_report.index')}}" class="m-menu__link confirmation">
                                <i class="m-menu__link-icon fa fa-chart-bar"></i>
                                <span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.order_product_reports')}}</span>
											 </span></span></a>
                        </li>
                        @endcheck_role

                        @check_role('sku_reports')
                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'report_sku' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.sku_report.index')}}" class="m-menu__link confirmation">
                                <i class="m-menu__link-icon fa fa-chart-bar"></i>
                                <span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.sku_reports')}}</span>
											 </span></span></a>
                        </li>
                        @endcheck_role

                        {{--
                                                @check_role('invoice')
                                                <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'invoice' ? 'm-menu__item--active': ''}}"
                                                    aria-haspopup="true">

                                                    <a href="{{route('admin.invoice.index')}}" class="m-menu__link confirmation">
                                                        <i class="m-menu__link-icon fa fa-chart-bar"></i>
                                                        <span class="m-menu__link-title"> <span
                                                                    class="m-menu__link-wrap"> <span
                                                                        class="m-menu__link-text">{{trans('admin.invoice')}}</span>
                                                                     </span></span></a>
                                                </li>
                                                @endcheck_role



                                                @check_role('invoice2')
                                                <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'invoice2' ? 'm-menu__item--active': ''}}"
                                                    aria-haspopup="true">

                                                    <a href="{{route('admin.invoice2.index')}}" class="m-menu__link confirmation">
                                                        <i class="m-menu__link-icon fa fa-chart-bar"></i>
                                                        <span class="m-menu__link-title"> <span
                                                                    class="m-menu__link-wrap"> <span
                                                                        class="m-menu__link-text">{{trans('admin.invoice2')}}</span>
                                                                     </span></span></a>
                                                </li>
                                                @endcheck_role

                                                --}}


                        @check_role('coupon')
                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'coupon_bill' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.coupon_bill.index')}}" class="m-menu__link confirmation">
                                <i class="m-menu__link-icon fa fa-chart-bar"></i>
                                <span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.coupon_bill')}}</span>
											 </span></span></a>
                        </li>
                        @endcheck_role

                    </ul>
                </div>
            </li>
            @endcheck_role
            <li class="m-menu__item m-menu__item--submenu {{ $active_menu == 'shipping_companies' ||isset($sub_menu) && $sub_menu == 'cities' || isset($sub_menu) && $sub_menu == 'countries'||isset($sub_menu) && $sub_menu == 'payment_methods' ? 'm-menu__item--active m-menu__item--open': ''}}"
                aria-haspopup="true" m-menu-submenu-toggle="hover"><a
                        href="javascript:;" class="m-menu__link m-menu__toggle"><i
                            class="m-menu__link-icon fa fa-chart-bar"></i><span
                            class="m-menu__link-text">{{trans('admin.shipping_payment')}}</span><i
                            class="m-menu__ver-arrow la la-angle-left"></i></a>
                <div class="m-menu__submenu " m-hidden-height="40"
                     style="{{isset($active_menu) && $active_menu == 'shipping_companies'||isset($sub_menu) && $sub_menu == 'cities' || isset($sub_menu) && $sub_menu == 'countries'||isset($sub_menu) && $sub_menu == 'payment_methods' ? '': 'display: none;'}} overflow: hidden;"><span
                            class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                                    class="m-menu__link"><span
                                        class="m-menu__link-text">{{trans('admin.shipping_payment')}}</span></span></li>

                        @check_role('view_shipping_companies|add_shipping_companies|edit_shipping_companies|delete_shipping_companies')
                        <li class="m-menu__item {{$active_menu == 'shipping_companies' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.shipping_companies.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-ambulance"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.shipping_companies')}}</span>
										 </span></span></a>
                        </li>
                        @endcheck_role

                        @check_role('view_cities|add_cities|edit_cities|delete_cities')
                        <li class="m-menu__item  {{isset($sub_menu) && $sub_menu == 'cities' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.cities.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-flag"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.cities')}}</span>
											 </span></span></a>
                        </li>
                        @endcheck_role

                        @check_role('view_countries|add_countries|edit_countries|delete_countries')
                        <li class="m-menu__item  {{isset($sub_menu) && $sub_menu == 'countries' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.countries.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-flag"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.countries')}}</span>
											 </span></span></a>
                        </li>
                        @endcheck_role

                        @check_role('view_payment_methods|add_payment_methods|edit_payment_methods|delete_payment_methods')
                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'payment_methods' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.payment_methods.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-cogs"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.payment_methods')}}</span>
											 </span></span></a>
                        </li>
                        @endcheck_role





                    </ul>
                </div>
            </li>

            @check_role('view_application')
            <li class="m-menu__item m-menu__item--submenu {{  isset($sub_menu) && $sub_menu == 'advertisements' ||  isset($sub_menu) && $sub_menu == 'sliders' ||   $active_menu == 'banners' ? 'm-menu__item--active m-menu__item--open': ''}}"
                aria-haspopup="true" m-menu-submenu-toggle="hover"><a
                        href="javascript:;" class="m-menu__link m-menu__toggle"><i
                            class="m-menu__link-icon fa fa-chart-bar"></i><span
                            class="m-menu__link-text">{{trans('admin.ads_and_banner')}}</span><i
                            class="m-menu__ver-arrow la la-angle-left"></i></a>
                <div class="m-menu__submenu " m-hidden-height="40"
                     style="{{ isset($sub_menu) && $sub_menu == 'advertisements' ||  isset($sub_menu) && $sub_menu == 'sliders' ||   $active_menu == 'banners' ? '': 'display: none;'}} overflow: hidden;"><span
                            class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                                    class="m-menu__link"><span
                                        class="m-menu__link-text">{{trans('admin.ads_and_banner')}}</span></span></li>


                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'advertisements' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.advertisements.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-clipboard-list"></i><span
                                        class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.advertisements')}}</span>
										 </span></span></a>
                        </li>



                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'sliders' ? 'm-menu__item--active': ''}} "
                            aria-haspopup="true">

                            <a href="{{route('admin.sliders.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fab fa-product-hunt"></i><span
                                        class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.sliders')}}</span>
										 </span></span></a>
                        </li>

                        @check_role('view_banners|add_banners|edit_banners|delete_banners')
                        <li class="m-menu__item {{$active_menu == 'banners' ? 'm-menu__item--active': ''}}" aria-haspopup="true">

                            <a href="{{route('admin.banners.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fab fa-product-hunt"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.banners')}}</span>
										 </span></span></a>
                        </li>
                        @endcheck_role



                    </ul>
                </div>
            </li>
            @endcheck_role
            @check_role('view_website')
            <li class="m-menu__item m-menu__item--submenu {{ $active_menu == 'website' ? 'm-menu__item--active m-menu__item--open': ''}}"
                aria-haspopup="true" m-menu-submenu-toggle="hover"><a
                        href="javascript:;" class="m-menu__link m-menu__toggle"><i
                            class="m-menu__link-icon fa fa-chart-bar"></i><span
                            class="m-menu__link-text">{{trans('admin.website')}}</span><i
                            class="m-menu__ver-arrow la la-angle-left"></i></a>
                <div class="m-menu__submenu " m-hidden-height="40"
                     style="{{isset($active_menu) && $active_menu == 'website' ? '': 'display: none;'}} overflow: hidden;"><span
                            class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                                    class="m-menu__link"><span
                                        class="m-menu__link-text">{{trans('admin.website')}}</span></span></li>


                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'website_home' ? 'm-menu__item--active': ''}} "
                            aria-haspopup="true">

                            <a href="{{route('admin.website-home.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fab fa-product-hunt"></i><span
                                        class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.website_home')}}</span>
										 </span></span></a>
                        </li>

                        {{--<li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'widget' ? 'm-menu__item--active': ''}} " aria-haspopup="true">--}}

                        {{--<a href="{{route('admin.widget.index')}}" class="m-menu__link "><i--}}
                        {{--class="m-menu__link-icon fab fa-product-hunt"></i><span class="m-menu__link-title"> <span--}}
                        {{--class="m-menu__link-wrap"> <span--}}
                        {{--class="m-menu__link-text">{{trans('admin.widget')}}</span>--}}
                        {{--</span></span></a>--}}
                        {{--</li>--}}


                    </ul>
                </div>
            </li>
            @endcheck_role
            @check_role('view_application')
            <li class="m-menu__item m-menu__item--submenu {{ isset($sub_menu) && $sub_menu == 'app_categories' ? 'm-menu__item--active m-menu__item--open': ''}}"
                aria-haspopup="true" m-menu-submenu-toggle="hover"><a
                        href="javascript:;" class="m-menu__link m-menu__toggle"><i
                            class="m-menu__link-icon fa fa-chart-bar"></i><span
                            class="m-menu__link-text">{{trans('admin.app')}}</span><i
                            class="m-menu__ver-arrow la la-angle-left"></i></a>
                <div class="m-menu__submenu " m-hidden-height="40"
                     style="{{isset($active_menu) && $active_menu == 'app' ? '': 'display: none;'}} overflow: hidden;"><span
                            class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                                    class="m-menu__link"><span
                                        class="m-menu__link-text">{{trans('admin.app')}}</span></span></li>



                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'app_categories' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.app-categories.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-clipboard-list"></i><span
                                        class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.app_categories')}}</span>
										 </span></span></a>
                        </li>




                    </ul>
                </div>
            </li>
            @endcheck_role

            <li class="m-menu__item m-menu__item--submenu {{ $active_menu == 'points' ? 'm-menu__item--active m-menu__item--open': ''}}"
                aria-haspopup="true" m-menu-submenu-toggle="hover"><a
                        href="javascript:;" class="m-menu__link m-menu__toggle"><i
                            class="m-menu__link-icon fa fa-coins"></i><span
                            class="m-menu__link-text">{{trans('admin.points')}}</span><i
                            class="m-menu__ver-arrow la la-angle-left"></i></a>
                <div class="m-menu__submenu " m-hidden-height="40"
                     style="{{isset($active_menu) && $active_menu == 'points' ? '': 'display: none;'}} overflow: hidden;"><span
                            class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                                    class="m-menu__link"><span
                                        class="m-menu__link-text">{{trans('admin.points')}}</span></span></li>


                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'users_points' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.user_points.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-users"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.users_points')}}</span>
										 </span></span></a>
                        </li>



                    </ul>
                </div>
            </li>


            <li class="m-menu__item m-menu__item--submenu {{ $active_menu == 'admin_notifications' || isset($sub_menu) && $sub_menu == 'notifications'  ? 'm-menu__item--active m-menu__item--open': ''}}"
                aria-haspopup="true" m-menu-submenu-toggle="hover"><a
                        href="javascript:;" class="m-menu__link m-menu__toggle"><i
                            class="m-menu__link-icon fa fa-bell"></i><span
                            class="m-menu__link-text">{{trans('admin.notifacation')}}</span><i
                            class="m-menu__ver-arrow la la-angle-left"></i></a>
                <div class="m-menu__submenu " m-hidden-height="40"
                     style="{{isset($active_menu) && $active_menu == 'admin_notifications'  ||  isset($sub_menu) && $sub_menu == 'notifications'  ? '': 'display: none;'}} overflow: hidden;"><span
                            class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                                    class="m-menu__link"><span
                                        class="m-menu__link-text">{{trans('admin.notifacation')}}</span></span></li>

                        @check_role('view_admin_notifications')
                        <li class="m-menu__item {{$active_menu == 'admin_notifications' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.notifications.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-bell"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.admin_notifications')}}</span>
										 </span></span></a>
                        </li>
                        @endcheck_role

                        @check_role('view_application')
                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'notifications' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.notifications-user.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-bell"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.app_notifications')}}</span>
											 </span></span></a>
                        </li>
                        @endcheck_role


                    </ul>
                </div>
            </li>

            <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'galleries' ? 'm-menu__item--active': ''}}"
                aria-haspopup="true">

                <a href="{{route('admin.galleries.index')}}" class="m-menu__link "><i
                            class="m-menu__link-icon fa fa-images"></i><span
                            class="m-menu__link-title"> <span
                                class="m-menu__link-wrap"> <span
                                    class="m-menu__link-text">{{trans('admin.galleries')}}</span>
											 </span></span></a>
            </li>

            <li class="m-menu__item m-menu__item--submenu {{ $active_menu == 'admins' || $active_menu == 'action_logs' ? 'm-menu__item--active m-menu__item--open': ''}}"
                aria-haspopup="true" m-menu-submenu-toggle="hover"><a
                        href="javascript:;" class="m-menu__link m-menu__toggle"><i
                            class="m-menu__link-icon fab fa-product-hunt"></i><span
                            class="m-menu__link-text">{{trans('admin.admins')}}</span><i
                            class="m-menu__ver-arrow la la-angle-left"></i></a>
                <div class="m-menu__submenu " m-hidden-height="40"
                     style="{{isset($active_menu) && $active_menu == 'admins' || $active_menu == 'action_logs' ? '': 'display: none;'}} overflow: hidden;"><span
                            class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                                    class="m-menu__link"><span
                                        class="m-menu__link-text">{{trans('admin.admins')}}</span></span></li>


                        @check_role('')
                        <li class="m-menu__item {{$active_menu == 'admins' ? 'm-menu__item--active': ''}}" aria-haspopup="true">

                            <a href="{{route('admin.admins.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-user-tie"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.admins')}}</span>
										 </span></span></a>
                        </li>

                        @endcheck_role
                        @check_role('')
                        <li class="m-menu__item {{$active_menu == 'action_logs' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.action_logs.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-user-tie"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.action_logs')}}</span>
										 </span></span></a>
                        </li>

                        @endcheck_role





                    </ul>
                </div>
            </li>


            @check_role('view_mailing_list')
            <li class="m-menu__item {{$active_menu == 'mailing_list' ? 'm-menu__item--active': ''}}" aria-haspopup="true">

                <a href="{{route('admin.mailing_list.index')}}" class="m-menu__link "><i
                            class="m-menu__link-icon fa fa-user"></i><span class="m-menu__link-title"> <span
                                class="m-menu__link-wrap"> <span
                                    class="m-menu__link-text">{{trans('admin.mailing_list')}}</span>
											 </span></span></a>
            </li>
            @endcheck_role




            @check_role('view_settings|view_cities|add_cities|edit_cities|delete_cities|view_countries|add_countries|edit_countries|delete_countries|view_banks|add_banks|edit_banks|delete_banks
            |view_packages|add_packages|edit_packages|delete_packages|view_payment_methods|add_payment_methods|edit_payment_methods|delete_payment_methods|view_services|add_services|edit_services|delete_services')
            <li class="m-menu__item m-menu__item--submenu {{ $active_menu == 'settings' ? 'm-menu__item--active m-menu__item--open': ''}}"
                aria-haspopup="true" m-menu-submenu-toggle="hover"><a
                        href="javascript:;" class="m-menu__link m-menu__toggle"><i
                            class="m-menu__link-icon fa fa-chart-bar"></i><span
                            class="m-menu__link-text">{{trans('admin.settings')}}</span><i
                            class="m-menu__ver-arrow la la-angle-left"></i></a>
                <div class="m-menu__submenu " m-hidden-height="40"
                     style="{{isset($active_menu) && $active_menu == 'settings' ? '': 'display: none;'}} overflow: hidden;"><span
                            class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                                    class="m-menu__link"><span
                                        class="m-menu__link-text">{{trans('admin.statistics')}}</span></span></li>


                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'settings' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.settings.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-cogs"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.general_settings')}}</span>
											 </span></span></a>
                        </li>

                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'setting_messages' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.setting-messages.index')}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-cogs"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.setting_messages')}}</span>
											 </span></span></a>
                        </li>


                    </ul>
                </div>
            </li>
            @endcheck_role




            {{--@check_role('view_comments|add_comments|edit_comments|delete_comments')--}}
            {{--<li class="m-menu__item {{$active_menu == 'comments' ? 'm-menu__item--active': ''}}" aria-haspopup="true">--}}

            {{--<a href="{{route('admin.comments.index')}}" class="m-menu__link "><i--}}
            {{--class="m-menu__link-icon fa fa-comments"></i><span class="m-menu__link-title"> <span--}}
            {{--class="m-menu__link-wrap"> <span--}}
            {{--class="m-menu__link-text">{{trans('admin.comments')}}</span>--}}
            {{--</span></span></a>--}}
            {{--</li>--}}
            {{--@endcheck_role--}}



            {{--
            <li class="m-menu__item {{$active_menu == 'ads' ? 'm-menu__item--active': ''}}" aria-haspopup="true">

                <a href="{{route('admin.ads.index')}}" class="m-menu__link "><i
                            class="m-menu__link-icon flaticon-list-3"></i><span class="m-menu__link-title"> <span
                                class="m-menu__link-wrap"> <span class="m-menu__link-text">{{trans('admin.ads')}}</span>
										 </span></span></a>
            </li>

             <li class="m-menu__item {{$active_menu == 'neighborhoods' ? 'm-menu__item--active': ''}}" aria-haspopup="true">

                <a href="{{route('admin.neighborhoods.index')}}" class="m-menu__link "><i
                            class="m-menu__link-icon la la-flag-o"></i><span class="m-menu__link-title"> <span
                                class="m-menu__link-wrap"> <span class="m-menu__link-text">{{trans('admin.neighborhoods')}}</span>
											 </span></span></a>
            </li>

            --}}










            @check_role('view_orders')
            <li class="m-menu__item m-menu__item--submenu {{ $active_menu == 'trash' ? 'm-menu__item--active m-menu__item--open': ''}}"
                aria-haspopup="true" m-menu-submenu-toggle="hover"><a
                        href="javascript:;" class="m-menu__link m-menu__toggle"><i
                            class="m-menu__link-icon fa fa-trash-alt"></i><span
                            class="m-menu__link-text">{{trans('admin.trash')}}</span><i
                            class="m-menu__ver-arrow la la-angle-left"></i></a>
                <div class="m-menu__submenu " m-hidden-height="40"
                     style="{{isset($active_menu) && $active_menu == 'trash' ? '': 'display: none;'}} overflow: hidden;"><span
                            class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                                    class="m-menu__link"><span
                                        class="m-menu__link-text">{{trans('admin.trash')}}</span></span></li>

                        @check_role('view_orders')
                        <li class="m-menu__item {{isset($sub_menu) && $sub_menu == 'deleted_orders' ? 'm-menu__item--active': ''}}"
                            aria-haspopup="true">

                            <a href="{{route('admin.orders.index' , ['deleted' => 1])}}" class="m-menu__link "><i
                                        class="m-menu__link-icon fa fa-trash-alt"></i><span class="m-menu__link-title"> <span
                                            class="m-menu__link-wrap"> <span
                                                class="m-menu__link-text">{{trans('admin.orders')}}</span>
										 </span></span></a>
                        </li>
                        @endcheck_role

                    </ul>
                </div>
            </li>
            @endcheck_role

            {{--@check_role('view_contacts')--}}
            {{--<li class=" m-menu__item {{$active_menu == 'contacts' ? 'm-menu__item--active': ''}}" aria-haspopup="true">--}}

            {{--<a href="{{route('admin.contacts.index')}}" class="m-menu__link "><i--}}
            {{--class="m-menu__link-icon fa fa-list"></i><span class="m-menu__link-title"> <span--}}
            {{--class="m-menu__link-wrap"> <span--}}
            {{--class="m-menu__link-text">{{trans('admin.contacts')}}</span>--}}
            {{--</span></span></a>--}}
            {{--</li>--}}
            {{--@endcheck_role--}}

            {{--
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" m-menu-submenu-toggle="hover"><a
                        href="javascript:;" class="m-menu__link m-menu__toggle"><i
                            class="m-menu__link-icon flaticon-layers"></i><span class="m-menu__link-text">Base</span><i
                            class="m-menu__ver-arrow la la-angle-left"></i></a>
                <div class="m-menu__submenu "><span class="m-menu__arrow"></span>
                    <ul class="m-menu__subnav">
                        <li class="m-menu__item  m-menu__item--parent" aria-haspopup="true"><span
                                    class="m-menu__link"><span class="m-menu__link-text">Base</span></span></li>
                        <li class="m-menu__item " aria-haspopup="true"><a
                                    href="{{url('')}}/admin/components/base/state.html" class="m-menu__link "><i
                                        class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                                        class="m-menu__link-text">State Colors</span></a></li>
                    </ul>
                </div>
            </li>
            --}}
        </ul>
    </div>

    <!-- END: Aside Menu -->
</div>
