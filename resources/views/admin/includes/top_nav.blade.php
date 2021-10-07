<header id="m_header" class="m-grid__item    m-header " m-minimize-offset="200" m-minimize-mobile-offset="200">
    <div class="m-container m-container--fluid m-container--full-height">
        <div class="m-stack m-stack--ver m-stack--desktop">

            <!-- BEGIN: Brand -->
            <div class="m-stack__item m-brand  m-brand--skin-dark ">
                <div class="m-stack m-stack--ver m-stack--general">
                    {{--
                    <div class="m-stack__item m-stack__item--middle m-brand__logo">
                        <a href="" class="m-brand__logo-wrapper" >
                            <img alt="" style="width: 155px;"
                                 src="{{url('')}}/admin_assets/assets/demo/default/media/img/logo/logo-2.png"/>
                        </a>
                    </div>
                    --}}
                    <div class="m-stack__item m-stack__item--middle m-brand__tools">

                        <!-- BEGIN: Left Aside Minimize Toggle -->
                        <a href="javascript:;" id="m_aside_left_minimize_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-desktop-inline-block  ">
                            <span></span>
                        </a>

                        <!-- END -->

                        <!-- BEGIN: Responsive Aside Left Menu Toggler -->
                        <a href="javascript:;" id="m_aside_left_offcanvas_toggle"
                           class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>

                        <!-- END -->

                        <!-- BEGIN: Responsive Header Menu Toggler -->
                        <a id="m_aside_header_menu_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m-brand__toggler m--visible-tablet-and-mobile-inline-block">
                            <span></span>
                        </a>

                        <!-- END -->

                        <!-- BEGIN: Topbar Toggler -->
                        <a id="m_aside_header_topbar_mobile_toggle" href="javascript:;"
                           class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
                            <i class="flaticon-more"></i>
                        </a>

                        <!-- BEGIN: Topbar Toggler -->
                    </div>
                </div>
            </div>

            <!-- END: Brand -->
            <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">



                <!-- END: Horizontal Menu -->

                <!-- BEGIN: Topbar -->
                <!-- BEGIN: Subheader -->
                <div class="m-stack__item m-topbar__nav-wrapper" style="float: right;margin-right: 1ex;">
                    <div class="d-flex align-items-center"
                            {{--                             style="@isset($route_name) @if(strlen($route_name) > 20 ) margin-left: 55ex;@else margin-left: 60ex; @endif @endisset"--}}
                    >
                        <h4 class="m-subheader__title m-subheader__title--separator" style="margin-left: 1rem">{{isset($route_name) ? $route_name:""}}</h4>
                        <ul class="m-topbar__nav m-nav m-nav--inline">
                            <li class="m-nav__item m-nav__item--home">
                                <a href="{{route('admin.index')}}" class="m-nav__link m-nav__link--icon">
                                    <i class="m-nav__link-icon la la-home"></i>
                                </a>
                            </li>

                            <li class="m-nav__separator">-</li>
                            <li class="m-nav__item">
                                <a href="{{isset($route_uri) ? $route_uri:""}}" class="m-nav__link">

                                    <span class="m-nav__link-text">{{isset($route_name) ? $route_name:""}}</span>
                                </a>
                            </li>
                            @if (substr(Route::currentRouteAction(), strpos(Route::currentRouteAction(), "@") + 1) == "order_details")
                                <li class="m-nav__separator">-</li>

                                <li class="m-nav__item">

                                    <a href="{{url('admin/order/print?id='.$order->id)}}" target="_blank">
                                        <i id="download_" class="fa fa-print"
                                           style="color: #000000ab;font-size: 25px;cursor: pointer"></i>
                                    </a>
                                    {{--
                                    <i class="load_pdf hidden fa fa-spin fa-spinner"></i>
                                    --}}
                                </li>
                            @endif

                            @isset($route_name)
                                @if ($route_name == "اللوحة الرئيسية")
                                    <div style="display: inline;margin-right: 10ex;">
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
                                @endif
                            @endisset

                        </ul>
                    </div>
                </div>
                <!-- END: Subheader -->
                <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general m-stack--fluid">
                    <div class="m-stack__item m-topbar__nav-wrapper">
                        <ul class="m-topbar__nav m-nav m-nav--inline">

                            <li id="notification" class="m-nav__item m-topbar__notifications m-topbar__notifications--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-center 	m-dropdown--mobile-full-width"
                                m-dropdown-toggle="click"
                                m-dropdown-persistent="1">
                                <a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
<span class="m-menu__link-badge">
                                                <span class="m-badge m-badge--danger" style="position: absolute" v-text="unread_count"></span>
                                            </span>                                    <span class="m-nav__link-icon"><i class="flaticon-alarm"></i></span>
                                </a>
                                <div class="m-dropdown__wrapper" style="width: 353px;margin-right: -295px !important;">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center"
                                             style="background: #807ab1;">
                                            <span class="m-dropdown__header-title">@{{ unread_count }} {{trans('admin.unread')}}</span>
                                            <span class="m-dropdown__header-subtitle">{{trans('admin.notifications')}}</span>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="nav nav-tabs m-tabs m-tabs-line m-tabs-line--brand"
                                                    role="tablist">
                                                    <li class="nav-item m-tabs__item" @click="update_read_notification">
                                                        <a class="nav-link m-tabs__link active" data-toggle="tab"
                                                           href="#topbar_notifications_notifications" role="tab">
                                                            جميع الإشعارات كمقروءة
                                                        </a>
                                                    </li>

                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="topbar_notifications_notifications" role="tabpanel">
                                                        <div class="m-scrollable" data-scrollable="true" data-height="250" data-mobile-height="200">
                                                            <div class="m-list-timeline m-list-timeline--skin-light">
                                                                <div class="m-list-timeline__items">

                                                                    <div class="m-list-timeline__item" v-for="notification in notifications"
                                                                        :class="notification.read_at ?'m-list-timeline__item--read' : ''">
                                                                        <span class="m-list-timeline__badge"></span>
                                                                        <span class="m-list-timeline__text"><a
                                                                                    :href="notification.url"
                                                                                    class="m-link">
                                                                                @{{ notification.sub_title }}
                                                                            </a></span>
                                                                        <span class="m-list-timeline__time">@{{ notification.human_date }}</span>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                            <div class="row" style="margin-top: 20px;">
                                                                <div class="col-sm-4"></div>
                                                                <div class="col-sm-4">
                                                                    <button @click="next_page" :disabled="loading"
                                                                            class="btn m-btn btn-primary "
                                                                            :class="loading ? 'm-loader m-loader--light m-loader--left' : ''"
                                                                           >

                                                                        {{trans('admin.show_more')}}
                                                                    </button>
                                                                </div>
                                                                <div class="col-sm-4"></div>
                                                            </div>

                                                        </div>

                                                    </div>
                                                    <div class="tab-pane" id="topbar_notifications_events"
                                                         role="tabpanel">
                                                        <div class="m-scrollable" data-scrollable="true"
                                                             data-height="250" data-mobile-height="200">
                                                            <div class="m-list-timeline m-list-timeline--skin-light">
                                                                <div class="m-list-timeline__items">
                                                                    <div class="m-list-timeline__item">
                                                                        <span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
                                                                        <a href="" class="m-list-timeline__text">New
                                                                            order received</a>
                                                                        <span class="m-list-timeline__time">Just now</span>
                                                                    </div>
                                                                    <div class="m-list-timeline__item">
                                                                        <span class="m-list-timeline__badge m-list-timeline__badge--state1-danger"></span>
                                                                        <a href="" class="m-list-timeline__text">New
                                                                            invoice received</a>
                                                                        <span class="m-list-timeline__time">20 mins</span>
                                                                    </div>
                                                                    <div class="m-list-timeline__item">
                                                                        <span class="m-list-timeline__badge m-list-timeline__badge--state1-success"></span>
                                                                        <a href="" class="m-list-timeline__text">Production
                                                                            server up</a>
                                                                        <span class="m-list-timeline__time">5 hrs</span>
                                                                    </div>
                                                                    <div class="m-list-timeline__item">
                                                                        <span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
                                                                        <a href="" class="m-list-timeline__text">New
                                                                            order received</a>
                                                                        <span class="m-list-timeline__time">7 hrs</span>
                                                                    </div>
                                                                    <div class="m-list-timeline__item">
                                                                        <span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
                                                                        <a href="" class="m-list-timeline__text">System
                                                                            shutdown</a>
                                                                        <span class="m-list-timeline__time">11 mins</span>
                                                                    </div>
                                                                    <div class="m-list-timeline__item">
                                                                        <span class="m-list-timeline__badge m-list-timeline__badge--state1-info"></span>
                                                                        <a href="" class="m-list-timeline__text">Production
                                                                            server down</a>
                                                                        <span class="m-list-timeline__time">3 hrs</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="topbar_notifications_logs"
                                                         role="tabpanel">
                                                        <div class="m-stack m-stack--ver m-stack--general"
                                                             style="min-height: 180px;">
                                                            <div class="m-stack__item m-stack__item--center m-stack__item--middle">
                                                                <span class="">All caught up!<br>No new logs.</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @if(false)
                            <li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light	m-list-search m-list-search--skin-light"
                                m-dropdown-toggle="click" id="m_quicksearch"
                                m-quicksearch-mode="dropdown" m-dropdown-persistent="1">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
                                    <span class="m-nav__link-icon"><i class="flaticon-search-1"></i></span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                    <div class="m-dropdown__inner ">
                                        <div class="m-dropdown__header">
                                            <form class="m-list-search__form">
                                                <div class="m-list-search__form-wrapper">
																<span class="m-list-search__form-input-wrapper">
																	<input id="m_quicksearch_input" autocomplete="off"
                                                                           type="text" name="q"
                                                                           class="m-list-search__form-input" value=""
                                                                           placeholder="Search...">
																</span>
                                                    <span class="m-list-search__form-icon-close"
                                                          id="m_quicksearch_close">
																	<i class="la la-remove"></i>
																</span>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__scrollable m-scrollable" data-scrollable="true"
                                                 data-height="300" data-mobile-height="200">
                                                <div class="m-dropdown__content">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>


                                <li class="m-nav__item m-topbar__languages m-dropdown m-dropdown--small m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--mobile-full-width"
                                    m-dropdown-toggle="click">
                                    <a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-nav__link-text">
													<img class="m-topbar__language-selected-img"
                                                         src="{{url('')}}/admin_assets/assets/app/media/img/flags/020-flag.svg">
												</span>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__header m--align-center"
                                                 style="background: url({{url('')}}/admin_assets/assets/app/media/img/misc/quick_actions_bg.jpg); background-size: cover;">
                                                <span class="m-dropdown__header-subtitle">Select your language</span>
                                            </div>
                                            <div class="m-dropdown__body">
                                                <div class="m-dropdown__content">
                                                    <ul class="m-nav m-nav--skin-light">
                                                        <li class="m-nav__item m-nav__item--active">
                                                            <a href="#" class="m-nav__link m-nav__link--active">
                                                                <span class="m-nav__link-icon"><img
                                                                            class="m-topbar__language-img"
                                                                            src="{{url('')}}/admin_assets/assets/app/media/img/flags/020-flag.svg"></span>
                                                                <span class="m-nav__link-title m-topbar__language-text m-nav__link-text">USA</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="#" class="m-nav__link">
                                                                <span class="m-nav__link-icon"><img
                                                                            class="m-topbar__language-img"
                                                                            src="{{url('')}}/admin_assets/assets/app/media/img/flags/015-china.svg"></span>
                                                                <span class="m-nav__link-title m-topbar__language-text m-nav__link-text">China</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="#" class="m-nav__link">
                                                                <span class="m-nav__link-icon"><img
                                                                            class="m-topbar__language-img"
                                                                            src="{{url('')}}/admin_assets/assets/app/media/img/flags/016-spain.svg"></span>
                                                                <span class="m-nav__link-title m-topbar__language-text m-nav__link-text">Spain</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="#" class="m-nav__link">
                                                                <span class="m-nav__link-icon"><img
                                                                            class="m-topbar__language-img"
                                                                            src="{{url('')}}/admin_assets/assets/app/media/img/flags/014-japan.svg"></span>
                                                                <span class="m-nav__link-title m-topbar__language-text m-nav__link-text">Japan</span>
                                                            </a>
                                                        </li>
                                                        <li class="m-nav__item">
                                                            <a href="#" class="m-nav__link">
                                                                <span class="m-nav__link-icon"><img
                                                                            class="m-topbar__language-img"
                                                                            src="{{url('')}}/admin_assets/assets/app/media/img/flags/017-germany.svg"></span>
                                                                <span class="m-nav__link-title m-topbar__language-text m-nav__link-text">Germany</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <li class="m-nav__item m-topbar__quick-actions m-topbar__quick-actions--img m-dropdown m-dropdown--large m-dropdown--header-bg-fill m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push m-dropdown--mobile-full-width m-dropdown--skin-light"
                                    m-dropdown-toggle="click">
                                    <a href="#" class="m-nav__link m-dropdown__toggle">
                                        <span class="m-nav__link-badge m-badge m-badge--dot m-badge--info m--hide"></span>
                                        <span class="m-nav__link-icon"><i class="flaticon-share"></i></span>
                                    </a>
                                    <div class="m-dropdown__wrapper">
                                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                        <div class="m-dropdown__inner">
                                            <div class="m-dropdown__header m--align-center"
                                                 style="background: url({{url('')}}/admin_assets/assets/app/media/img/misc/quick_actions_bg.jpg); background-size: cover;">
                                                <span class="m-dropdown__header-title">Quick Actions</span>
                                                <span class="m-dropdown__header-subtitle">Shortcuts</span>
                                            </div>
                                            <div class="m-dropdown__body m-dropdown__body--paddingless">
                                                <div class="m-dropdown__content">
                                                    <div class="data" data="false" data-height="380"
                                                         data-mobile-height="200">
                                                        <div class="m-nav-grid m-nav-grid--skin-light">
                                                            <div class="m-nav-grid__row">
                                                                <a href="#" class="m-nav-grid__item">
                                                                    <i class="m-nav-grid__icon flaticon-file"></i>
                                                                    <span class="m-nav-grid__text">Generate Report</span>
                                                                </a>
                                                                <a href="#" class="m-nav-grid__item">
                                                                    <i class="m-nav-grid__icon flaticon-time"></i>
                                                                    <span class="m-nav-grid__text">Add New Event</span>
                                                                </a>
                                                            </div>
                                                            <div class="m-nav-grid__row">
                                                                <a href="#" class="m-nav-grid__item">
                                                                    <i class="m-nav-grid__icon flaticon-folder"></i>
                                                                    <span class="m-nav-grid__text">Create New Task</span>
                                                                </a>
                                                                <a href="#" class="m-nav-grid__item">
                                                                    <i class="m-nav-grid__icon flaticon-clipboard"></i>
                                                                    <span class="m-nav-grid__text">Completed Tasks</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                            @endif
                            <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                m-dropdown-toggle="click">
                                <a href="#" class="m-nav__link m-dropdown__toggle">
												<span class="m-topbar__userpic">
													<img src="{{Auth::guard('admin')->user()->admin_image}}"
                                                         class="m--img-rounded m--marginless" alt=""/>
												</span>
                                    <span class="m-topbar__username m--hide">Nick</span>
                                </a>
                                <div class="m-dropdown__wrapper">
                                    <span class="m-dropdown__arrow m-dropdown__arrow--left m-dropdown__arrow--adjust"></span>
                                    <div class="m-dropdown__inner">
                                        <div class="m-dropdown__header m--align-center"
                                             style="background: #807ab1;">
                                            <div class="m-card-user m-card-user--skin-dark">
                                                <div class="m-card-user__pic">
                                                    {{--{{Auth::guard('admin')->user()->admin_image}}--}}
                                                    <img src="/uploads/notifications/defullt.png"
                                                         class="m--img-rounded m--marginless" alt=""/>


                                                </div>
                                                <div class="m-card-user__details">
                                                    <span class="m-card-user__name m--font-weight-500">{{Auth::guard('admin')->user()->admin_name}}</span>
                                                    <a href=""
                                                       class="m-card-user__email m--font-weight-300 m-link">{{Auth::guard('admin')->user()->admin_email}}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="m-dropdown__body">
                                            <div class="m-dropdown__content">
                                                <ul class="m-nav m-nav--skin-light">
                                                    <li class="m-nav__section m--hide">
                                                        <span class="m-nav__section-text">Section</span>
                                                    </li>
                                                    <li class="m-nav__item">
                                                        <a href="{{url('')}}/admin/profile" class="m-nav__link">
                                                            <i class="m-nav__link-icon flaticon-profile-1"></i>
                                                            <span class="m-nav__link-title">
																			<span class="m-nav__link-wrap">
																				<span class="m-nav__link-text">الملف الشخصي</span>

																			</span>
																		</span>
                                                        </a>
                                                    </li>

                                                    <li class="m-nav__item">
                                                        <a href="{{url('admin/logout')}}" style="margin-right: 170px;"
                                                           class="btn m-btn--pill    btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">تسجيل الخروج</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @if(false)
                                <li id="m_quick_sidebar_toggle" class="m-nav__item">
                                    <a href="#" class="m-nav__link m-dropdown__toggle">
                                        <span class="m-nav__link-icon"><i class="flaticon-grid-menu"></i></span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- END: Topbar -->
            </div>
        </div>
    </div>
</header>

