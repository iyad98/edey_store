<footer id="footer">
    <div class="top_footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-4">
                    <div class="head_info_store">
                        <h2>نحن دائماً جاهزون لمساعدتك</h2>
                        <p>تواصل معنا من خلال أي من قنوات الدعم التالية :</p>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="info_group">
                        <div class="row">
                            <div class="col-md-3 col-6">
                                <div class="info_itm clearfix">
                                    <div class="icon_info"><img src="/website_v2/images/email.svg" alt=""></div>
                                    <div class="txt_info">
                                        <h3>البريد الالكتروني</h3>
                                        <p><a href="mailto:{{$footer_data['email']}}" target="_blank">{{$footer_data['email']}}</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="info_itm clearfix">
                                    <div class="icon_info"><img src="/website_v2/images/call.svg" alt=""></div>
                                    <div class="txt_info">
                                        <h3>الاتصال المباشر</h3>
                                        <p><a href="tel:{{$footer_data['phone']}}" target="_blank">{{$footer_data['phone']}}</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="info_itm clearfix">
                                    <div class="icon_info"><img src="/website_v2/images/support.svg" alt=""></div>
                                    <div class="txt_info">
                                        <h3>الدعم عبر</h3>
                                        <p><a onclick="open_chat()" target="_blank">المحادثة الحية</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="info_itm clearfix">
                                    <div class="icon_info"><img src="/website_v2/images/whats.svg" alt=""></div>
                                    <div class="txt_info">
                                        <h3>الدعم عبر</h3>
                                        <p><a href="https://wa.me/{{$footer_data['phone']}}" target="_blank">الواتساب</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="middle_footer">
        <div class="container">
            <div class="row">
                <div class="col-xl-2 d-sm-none">
                    <div class="ft_logo">

                        <a href="{{asset('/')}}"><img src="/website_v2/images/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-xl-2  d-lg-block d-none ">
                    <div class="ft_logo">
                        <a href="{{asset('/')}}"><img src="/website_v2/images/ft_logo.svg" alt=""></a>
                    </div>
                </div>


                <div class="col-xl-10">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12 d-none d-sm-block">
                            <div class="f_box">
                                <h2 class="ft_title">أشهر التصنيفات</h2>
                                <ul class="ft_category clearfix">
                                    @foreach($main_categories_shop as $k => $category)
                                        @if($k < 10)
                                            <li><a href="{{LaravelLocalization::localizeUrl('shop') . "?category=" . $category->id}}"> {{$category->name}} , </a></li>
                                        @endif
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-6">
                            <div class="f_box">
                                <h2 class="ft_title">الكويتية ستور</h2>
                                <ul class="ft_menu clearfix">
                                    <li><a href="{{LaravelLocalization::localizeUrl('about-us')}}">
                                        {{trans('website.about_us')}}
                                    </a>
                                    </li>
                                    <li>
                                    <a href="{{LaravelLocalization::localizeUrl('terms')}}">
                                       {{trans('website.terms')}}
                                    </a>
                                    </li>
                                    <li>
                                    <a href="{{LaravelLocalization::localizeUrl('privacy-policy')}}">
                                        {{trans('website.privacy_policy')}}
                                    </a>
                                    </li>

                                    <li><a href="{{LaravelLocalization::localizeUrl('return-policy')}}">
                                        {{trans('website.return_policy')}}
                                    </a>
                                    </li>
                                    <li>
                                    <a href="{{LaravelLocalization::localizeUrl('shipping-and-delivery')}}">
                                       {{trans('website.shipping_and_delivery')}}
                                    </a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-6">
                            <div class="f_box">
                                <h2 class="ft_title">حسابي</h2>
                                <ul class="ft_menu clearfix">
                                    <li><a href="{{LaravelLocalization::localizeUrl('my-account')}}">حسابي</a></li>
                                    <li><a href="{{LaravelLocalization::localizeUrl('my-account/orders') }}">طلباتي</a></li>
                                    <li><a href="{{LaravelLocalization::localizeUrl('wishlist') }}">مفضلتي</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-6 col-sm-6">
                            <div class="f_box">
                                <h2 class="ft_title">تابع تغطياتنا وتواصل معنا</h2>
                                <ul class="ft_social clearfix">
                                    <li><a href="{{$footer_data['facebook']}}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="{{$footer_data['youtube']}}" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                    <li><a href="{{$footer_data['instagram']}}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                    <li><a href="{{$footer_data['snapchat']}}" target="_blank"><i class="fab fa-snapchat-ghost"></i></a></li>
                                    <li><a href="{{$footer_data['twitter']}}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="{{$footer_data['twitter']}}" target="_blank"><i class="fas fa-paper-plane"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6">
                            <div class="f_box">
                                <h2 class="ft_title">حمل التطبيق</h2>
                                <ul class="app_menu clearfix">
                                    <li>
                                        <a href="https://apps.apple.com/us/app/الكويتيه-ستور/id1556395578" target="_blank"><img src="/website_v2/images/app_store.svg" alt=""></a>
                                    </li>
                                    <li>
                                        <a href="https://play.google.com/store/apps/details?id=com.ict.alkuwaitiyastore" target="_blank"><img src="/website_v2/images/google_play.svg" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_footer">
        <div class="container d-flex align-items-center">
            <ul class="payment_method clearfix">
                <li><img src="/website_v2/images/visa.png"></li>
                <li><img src="/website_v2/images/knet.png"></li>
                <li><img src="/website_v2/images/master.png"></li>
            </ul>
            <div class="copy_right mr-auto"><p>جميع الحقوق محفوظة للكويتية ستور © 2021</p><img src="/website_v2/images/logo_icon.png" alt=""></div>
        </div>
    </div>
</footer><!--footer-->