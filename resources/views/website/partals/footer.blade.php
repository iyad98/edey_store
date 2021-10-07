    <!--Footer section start-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-3">
                    <div class="about-us">
                        <div class="title">
                            عن ممنون
                        </div>
                        <p>هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص
                            العربى،
                            حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى
                            يولدها
                            التطبيق.
                        </p>
                        <div class="social-links">

                            <a target="_blank" href="{{$footer_data['instagram']}}">
                                <button class="btn btn-link">
                                    <i class="fab fa-instagram"></i>
                                </button>
                            </a>
                            <a target="_blank" href="{{$footer_data['snapchat']}}">
                                <button class="btn btn-link">
                                    <i class="fab fa-snapchat-ghost"></i>
                                </button>
                            </a>
                            <a target="_blank" href="{{$footer_data['twitter']}}">
                                <button class="btn btn-link">
                                    <i class="fab fa-twitter"></i>
                                </button>
                            </a>
                            <a target="_blank" href="{{$footer_data['facebook']}}">
                                <button class="btn btn-link">
                                    <i class="fab fa-facebook-f"></i>
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="about-us">
                        <div class="title">
                            معلومات
                        </div>
                        <ul>
                            <a href="">
                                <li style="font-size: 13px !important;">{{$footer_data['place']}}</li>
                            </a>
                            <a target="_blank" href="mailto:{{$footer_data['email']}}">
                                <li>   {{$footer_data['email']}}</li>
                            </a>

                            <a target="_blank" href="tel:{{$footer_data['phone']}}">
                                <li>{{$footer_data['phone']}}
                                </li>
                            </a>


                        </ul>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="about-us">
                        <div class="title">
                            خدمة العملاء
                        </div>
                        <ul>
                            <a href="{{LaravelLocalization::localizeUrl('about-us')}}">
                                <li>{{trans('website.about_us')}}</li>
                            </a>

                            <a href="{{LaravelLocalization::localizeUrl('terms')}}">
                                <li>{{trans('website.terms')}}</li>
                            </a>

                            <a href="{{LaravelLocalization::localizeUrl('privacy-policy')}}">
                                <li>{{trans('website.privacy_policy')}}</li>
                            </a>

                            <a href="{{LaravelLocalization::localizeUrl('contact-us')}}">
                                <li>{{trans('website.contact_us')}}</li>
                            </a>
                        </ul>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="about-us">
                        <div class="title">
                            روابط مساعدة
                        </div>
                        <ul>
                            <a href="{{LaravelLocalization::localizeUrl('return-policy')}}">
                                <li>{{trans('website.return_policy')}}</li>
                            </a>
                            <a href="{{LaravelLocalization::localizeUrl('shipping-and-delivery')}}">
                                <li>{{trans('website.shipping_and_delivery')}}</li>
                            </a>
                        </ul>



                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="about-us">
                        <div class="title">
                            حمل التطبيق الآن
                        </div>
                        <div class="app-btn">
                            <button class="btn">
                                <div class="text">
                                    <span>Download on the</span>
                                    <h6>App Store</h6>
                                </div>
                                <div class="icon">
                                    <i class="fab fa-apple"></i>
                                </div>
                            </button>
                        </div>
                        <div class="google-btn">
                            <button class="btn">
                                <div class="text">
                                    <span>Get it on</span>
                                    <h6>Google Play</h6>
                                </div>
                                <div class="icon">
                                    <i class="fab fa-google-play"></i>
                                </div>
                            </button>
                        </div>
                        <div class="cards">
                            <img src="/website/img/Group 9948.png" alt="card">
                            <img src="/website/img/Paypal.png" alt="card">
                            <img src="/website/img/Group 19.png" alt="card">
                            <img src="/website/img/Western-union.png" alt="card">

                        </div>
                    </div>
                </div>

            </div>
            <hr>
            <div class="rights">
                جميع الحقوق محفوظة © 2020
            </div>
        </div>
    </footer>
    <!--Footer section start-->