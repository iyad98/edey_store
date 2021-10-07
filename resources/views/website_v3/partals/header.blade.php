<header id="header">
    @if( $header_note_text_first )
        <div class="msg_header" style="background-color:{{$header_note_text_first->background_color}};">
            @if( $header_note_text_first->url_pointer )
                <div class="container">
                    <a href="{{$header_note_text_first->url_pointer}}">
                        <p class="msg_top"
                           style="color: {{$header_note_text_first->text_color}};">{{$header_note_text_first->text}}</p>
                    </a>
                </div>
            @else
                <div class="msg_header">
                    <div class="container">
                        <p class="msg_top"
                           style="color: {{$header_note_text_first->text_color}};">{{$header_note_text_first->text}}</p>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <div class="middle_header">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="logo_site">
                    <a href="{{url('')}}"><img src="{{asset('website_v3/img/logo.png')}}" alt="إيدي ستور"></a>
                </div>
                <div class="haeder_widget">
                    <div class="search_head">
                        <form class="form_search_head" action="#" id="form_search_category" method="get">
                            @csrf
                            <input type="text" name="name" id="category_name" class="form-control"
                                   placeholder="ابحث هنا عن المنتج أو التاجر">
                            <span class="search_icon" id="kareem"><i class="far fa-search"></i></span>
                            <div class="itm_us search_drop dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                   aria-expanded="false">
                                    <span>التصنيف</span>
                                </a>
                                <ul class="dropdown-menu dropdown_profile cat">
                                    @foreach($categories as $category)
                                        <li id="category_name" value="{{$category->id}}"><a>{{$category->name_ar}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix">
                        <div class="user_action_head clearfix">
                            <div class="itm_us gru_search">
                                <div class="header_search-button"></div>
                            </div>
                            <div class="itm_us fav dropdown notifications_list">
                                <a href="#" class="btn_user_profile " data-toggle="dropdown" aria-haspopup="true"
                                   aria-expanded="false">
                                    <img src="{{asset('website_v3/img/noti_icon.svg')}}" alt="notifications">
                                    <span class="budge_cart">2</span>
                                </a>
                                <ul class="dropdown-menu dropdown_profile">
                                    <li>
                                        <div class="single_noti">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="noti_icon">
                                                        <img src="{{asset('website_v3/img/noti.svg')}}" alt="..">
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="noti_content">
                                                        <h5><span>طلب جديد ,</span> هناك حقيقة مثبتة منذ زمن طويل وهي أن
                                                            المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز على الشكل
                                                            الخارجي للنص</h5>
                                                        <span><img src="{{asset('website_v3/img/noti3.svg')}}'" alt=""> 12/21/2020 </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="single_noti">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="noti_icon">
                                                        <img src="{{asset('website_v3/img/noti2.svg')}}" alt="..">
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="noti_content">
                                                        <h5><span>رسالة من الإدارة ,</span> هناك حقيقة مثبتة منذ زمن
                                                            طويل وهي أن المحتوى المقروء لصفحة ما سيلهي القارئ عن التركيز
                                                            على الشكل الخارجي للنص</h5>
                                                        <span><img src="{{asset('website_v3/img/noti3.svg')}}" alt=""> 12/21/2020 </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <a href="notifications.html">شاهد كل الاشعارات</a>
                                </ul>
                            </div>
                            <div class="itm_us gru_cart">
                                <a href="{{LaravelLocalization::localizeUrl('cart')}}" class="btn_cart"
                                   id="get-cart-simple-data">
                                    <img src="{{asset('website_v3/img/cart.svg')}}" alt="السلة">
                                    <span class="budge_cart" v-text="count_quantity">0</span>
                                </a>
                            </div>
                            <div class="itm_us gru_cart" id="get-cart-data">
                                <a href="{{LaravelLocalization::localizeUrl('wishlist') }}" class="btn_cart"
                                   id="get-cart-simple-data">
                                    <img src="{{asset('website_v3/img/hearts.svg')}}" alt="السلة">
                                    {{--                                    <span class="budge_cart"></span>--}}
                                    <h1> @{{ count_favorites }}</h1>
                                </a>
                            </div>


                            <div class="itm_us gru_profile_mobile dropdown">
                                @if(auth()->check())
                                    <a href="#" class="btn_user_profile dropdown-toggle" data-toggle="dropdown"
                                       aria-haspopup="true" aria-expanded="false">
                                        <img src="{{asset('website_v3/img/feather-user.svg')}}" alt="بروفايل">
                                        <span>الملف الشخصي</span>
                                    </a>
                                @else

                                    <ul class="dropdown-menu dropdown_profile">
                                        <li><a href="{{LaravelLocalization::localizeUrl('sign-in')}}"><i
                                                    class="far fa-sign-in"></i>تسجيل دخول</a></li>
                                        <li><a href="{{LaravelLocalization::localizeUrl('sign-up')}}"><i
                                                    class="fas fa-user"></i>حساب جديد</a></li>
                                        @if(auth()->check())
                                            <li><a href="orders.html"><i class="fas fa-clipboard-list"></i>قائمة الطلبات</a>
                                            </li>
                                        @endif
                                    </ul>
                                @endif
                            </div>
                            <div class="itm_us gru_profile dropdown">
                                <a href="#" class="btn_user_profile dropdown-toggle" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    @if(auth()->check())
                                        <img src="{{asset('website_v3/img/profilePicture.svg')}}" alt="بروفايل">
                                        <div class="gru_profile_sec">
                                            <h6>{{auth()->user()->first_name}} {{auth()->user()->last_name}} </h6>
                                            <span>{{auth()->user()->email}}</span>
                                        </div>
                                    @else
                                        <div class="gru_profile_sec">
                                            <h6>تسجيل الدخول </h6>
                                        </div>
                                    @endif
                                </a>
                                <ul class="dropdown-menu dropdown_profile">


                                    @if(auth()->check())
                                        <li><a href="orders.html"><i class="fas fa-clipboard-list"></i>قائمة الطلبات</a>
                                        </li>
                                        <li><a href="{{LaravelLocalization::localizeUrl('website/logout') }}"><i
                                                    class="fas fa-sign-out"></i>تسجيل الخروج </a></li>

                                        @if( !\App\Models\Merchant::query()->where('email',auth()->user()->email)->first())
                                            <li><a href="{{LaravelLocalization::localizeUrl('/upgrade-account') }}"><i
                                                        class="fas fa-sign-out"></i>ترقية الحساب </a></li>
                                        @endif


                                    @else
                                        <li><a href="{{LaravelLocalization::localizeUrl('sign-in') }}"><i
                                                    class="far fa-sign-in"></i>تسجيل دخول</a></li>
                                        <li><a href="{{LaravelLocalization::localizeUrl('sign-up') }}"><i
                                                    class="fas fa-user"></i>حساب جديد</a></li>
                                    @endif

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if( $header_note_text_second )
        <div class="msg_header2" style="background-color:{{$header_note_text_second->background_color}} ; ">
            @if( $header_note_text_second->url_pointer )
                <div class="container">
                    <a href="{{$header_note_text_second->url_pointer}}">
                        <p class="msg_top"
                           style="color: {{$header_note_text_second->text_color}};">{{$header_note_text_second->text}}</p>
                    </a>
                </div>
            @else
                <div class="msg_header2">
                    <div class="container">
                        <p class="msg_top"
                           style="color: {{$header_note_text_second->text_color}};">{{$header_note_text_second->text}}</p>
                    </div>
                </div>
            @endif
        </div>

    @endif


</header>

<div class="block_search_mobile">
    <div class="container">
        <div class="search_head">
            <form class="form_search_head" action="/shop/">
                <input type="text" class="form-control" id="search_product_input" name="search"
                       placeholder="ابحث عن منتج">
                <span class="search_icon"><i class="far fa-search"></i></span>
                <button type="submit" class="btn btn_search">بحث الآن</button>
            </form>
        </div>
    </div>
</div>



