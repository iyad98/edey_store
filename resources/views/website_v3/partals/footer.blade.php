<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-12">
                <div class="logo_sec">
                    <div class="ft_logo">
                        <a href="index.html"><img src="{{asset('website_v3/img/logo.png')}}" alt=""></a>
                    </div>
                    <div class="logo_p">
                        <p>نحن دائماً جاهزون لمساعدتك</p>
                        <p>تواصل معنا من خلال أي من قنوات الدعم التالية :</p>



                    </div>
                    <div class="logo_social">
                        <ul class="social_media clearfix">
                            <li><a href="{{$footer_data['instagram']}}" target="_blank"><img src="{{asset('website_v3/img/ins.svg')}}" alt="..."></a></li>
                            <li><a href="#" target="_blank"><img src="{{asset('website_v3/img/lin.svg')}}" alt="..."></a></li>
                            <li><a href="{{$footer_data['twitter']}}" target="_blank"><img src="{{asset('website_v3/img/tw.svg')}}" alt="..."></a></li>
                            <li><a href="{{$footer_data['youtube']}}" target="_blank"><img src="{{asset('website_v3/img/yo.svg')}}" alt="..."></a></li>
                            <li><a href="{{$footer_data['facebook']}}" target="_blank"><img src="{{asset('website_v3/img/f.svg')}}" alt="..."></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="f_box">
                    <h2 class="ft_title">إيدي ... أيدي سعودية</h2>
                    <ul class="ft_menu clearfix">
                        <li><a href="{{LaravelLocalization::localizeUrl('about-us')}}"> {{trans('website.about_us')}}</a></li>
                        <li><a href="{{LaravelLocalization::localizeUrl('terms')}}">{{trans('website.terms')}}</a></li>
                        <li><a href="{{LaravelLocalization::localizeUrl('privacy-policy')}}">{{trans('website.privacy_policy')}}</a></li>
                        <li><a href="{{LaravelLocalization::localizeUrl('return-policy')}}"> {{trans('website.return_policy')}} </a></li>
                        <li><a href="{{LaravelLocalization::localizeUrl('shipping-and-delivery')}}">{{trans('website.shipping_and_delivery')}}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="f_box contact">
                    <h2 class="ft_title">ابق على تواصل معنا</h2>
                    <ul class="ft_menu clearfix">
                        <li><a href="#"><i class="fas fa-map-marker-alt"></i> ومن هنا وجب على المصمم أن يضع نصوصا
                                مؤقتة على التصميم ليظهر للعميل</a></li>
                        <li><a href="tel:{{$footer_data['phone']}}" target="_blank"><i class="fas fa-phone"></i> {{$footer_data['phone']}}</a></li>
                        <li><a href="https://wa.me/{{$footer_data['phone']}}" target="_blank"><i class="fas fa-phone"></i> الواتساب</a></li>



                        <li><a href="mailto:{{$footer_data['email']}}" target="_blank"><i class="far fa-envelope"></i> {{$footer_data['email']}}</a></li>
                        <li><a onclick="open_chat()" target="_blank"><i class="far fa-envelope"></i> المحادثة الحية</a></li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_footer">
        <div class="container d-flex align-items-center">
            <div class="copy_right">
                <p>جميع الحقوق محفوظة لمتجر إيدي © 2020</p>
            </div>
            <div class="copy_right mr-auto"><p>تم تطويره بواسطة <span>فايبرز للحلول التقنية</span></p></div>
        </div>
    </div>
</footer>



