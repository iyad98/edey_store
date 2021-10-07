

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="footer-block">
                    <h4 class="footer-title">{{trans('website.customers_service')}}</h4>
                    <ul id="menu-%d8%ae%d8%af%d9%85%d8%a9-%d8%a7%d9%84%d8%b9%d9%85%d9%84%d8%a7%d8%a1" class="footer-menu">
                        <li id="menu-item-110"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-110"><a
                                    href="{{LaravelLocalization::localizeUrl('about-us')}}">{{trans('website.about_us')}}</a></li>
                        <li id="menu-item-108"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-108"><a
                                    href="{{LaravelLocalization::localizeUrl('terms')}}">{{trans('website.terms')}}</a></li>
                        <li id="menu-item-107"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-107"><a
                                    href="{{LaravelLocalization::localizeUrl('privacy-policy')}}">{{trans('website.privacy_policy')}}</a></li>

                        <li id="menu-item-107"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-107"><a
                                    href="{{LaravelLocalization::localizeUrl('contact-us')}}">{{trans('website.contact_us')}}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-block">
                    <h4 class="footer-title">{{trans('website.information')}}</h4>
                    <ul id="menu-%d9%85%d8%b9%d9%84%d9%88%d9%85%d8%a7%d8%aa" class="footer-menu">
                        <li id="menu-item-128"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-128"><a
                                    href="{{LaravelLocalization::localizeUrl('return-policy')}}">{{trans('website.return_policy')}}</a></li>
                        <li id="menu-item-129"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-129"><a
                                    href="{{LaravelLocalization::localizeUrl('shipping-and-delivery')}}">{{trans('website.shipping_and_delivery')}}</a></li>
                        <li id="menu-item-129"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-129"><a
                                    href="{{LaravelLocalization::localizeUrl('check-return-order')}}">{{trans('website.return_order')}}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="footer-block">
                    <h4 class="footer-title">{{trans('website.contact_us')}}</h4>
                    <ul id="menu-%d9%85%d8%b9%d9%84%d9%88%d9%85%d8%a7%d8%aa" class="footer-menu">
                        <li style="color: black">
                            {{$footer_data['place']}}
                        </li>
                        <li style="color: black"><a href="mailto:{{$footer_data['email']}}"></a><a
                                    href="{{LaravelLocalization::localizeUrl('/')}}" class="__cf_email__"
                                    data-cfemail="64271117100b09011607051601240508020b131e050a4a070b09">{{$footer_data['email']}}</a>
                        </li>
                        <li style="color: black" dir="ltr"><a href="tel:{{$footer_data['phone']}}"></a>{{$footer_data['phone']}}</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <p class="copy-right">© 2020. جميع الحقوق محفوظة</p>
                </div>
                <div class="col-md-7">
                    <a class="payment" target="_blank" title="payment-ways1">
                        <img src="{{url('')}}/website/wp-content/upload/payment-1.png" alt="{{trans('website.site_name')}}" class="img-responsive">
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>