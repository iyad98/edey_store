<header id="header">

    @if( $header_note_text_first )
        <div class="msg_header" style="background-color:{{$header_note_text_first->background_color}} ; ">
            @if( $header_note_text_first->url_pointer )
                <div class="container">
                    <a href="{{$header_note_text_first->url_pointer}}">
                        <p class="msg_top"
                           style="color: {{$header_note_text_first->text_color}};">{{$header_note_text_first->text}}</p>
                    </a>
                </div>
            @else
                <div class="container">
                    <p class="msg_top"
                       style="color: {{$header_note_text_first->text_color}};">{{$header_note_text_first->text}}</p>
                </div>

            @endif
        </div>

    @endif
        @if( $header_note_text_second )
            <div class="msg_header" style="background-color:{{$header_note_text_second->background_color}} ; ">
                @if( $header_note_text_second->url_pointer )
                    <div class="container">
                        <a href="{{$header_note_text_second->url_pointer}}">
                            <p class="msg_top"
                               style="color: {{$header_note_text_second->text_color}};">{{$header_note_text_second->text}}</p>
                        </a>
                    </div>
                @else
                    <div class="container">
                        <p class="msg_top"
                           style="color: {{$header_note_text_second->text_color}};">{{$header_note_text_second->text}}</p>
                    </div>

                @endif
            </div>

        @endif

    <div class="top_header">
        <div class="container d-flex align-items-center">
            <ul class="tools_site clearfix">
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <img src="/website_v2/images/flag.svg" alt="">
                    </a>
                    <ul class="dropdown-menu dropdown_st2">
                        <li><a href=""><img src="/website_v2/images/flag.svg" alt=""></a></li>
                    </ul>
                </li>
                <li>
                    <a href="">
                        <img src="/website_v2/images/currncy.svg" alt="">
                        <span>د.ك</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">
                        <img src="/website_v2/images/globe.svg" alt="">
                        <span>AR</span>
                    </a>
                    <ul class="dropdown-menu dropdown_st2">
                        <li><a href="">AR</a></li>

                    </ul>

                </li>
                <li id="get-cart-data">
                    <a href="{{LaravelLocalization::localizeUrl('wishlist') }}">
                        <img src="/website_v2/images/hearts.svg" alt="">
                        <span><span class="num_element">@{{ count_favorites }}</span>عنصر</span>
                    </a>
                </li>
            </ul>
            <div class="note_middle mr-auto">
                <p>اطلب من الصين الى الكويت بجودة عالية وأسعار خيالية</p>
            </div>
        </div>
    </div>
    <div class="middle_header">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="logo_site">
                    <a href="{{url('')}}"><img src="/website_v2/images/logo.png" alt=""></a>
                </div>
                <div class="search_head">
                    <form class="form_search_head" action="/shop/">
                        <input type="text" class="form-control" id="search_product_input" name="search"
                               placeholder="ابحث عن منتج">
                        <span class="search_icon"><i class="far fa-search"></i></span>
                        <button type="submit" class="btn btn_search">بحث الآن</button>
                    </form>
                </div>
                <div class="clearfix">
                    <div class="user_action_head clearfix">
                        <div class="itm_us gru_search">
                            <div class="header_search-button"></div>
                        </div>
                        <div class="itm_us gru_profile dropdown">
                            <a href="#" class="btn_user_profile dropdown-toggle" data-toggle="dropdown"
                               aria-haspopup="true" aria-expanded="false">
                                <img src="/website_v2/images/feather-user.svg">
                                <span>الملف الشخصي</span>
                            </a>
                            <ul class="dropdown-menu dropdown_profile">
                                @if(auth()->check())
                                    <li><a href="{{LaravelLocalization::localizeUrl('my-account') }}"><i
                                                    class="fas fa-user"></i>حسابي </a></li>
                                @else
                                    <li><a href="{{LaravelLocalization::localizeUrl('sign-in') }}"><i
                                                    class="far fa-sign-in"></i>تسجيل دخول</a></li>
                                    <li><a href="{{LaravelLocalization::localizeUrl('sign-up') }}"><i
                                                    class="fas fa-user"></i>حساب جديد</a></li>
                                @endif

                                <li><a href="{{LaravelLocalization::localizeUrl('my-account/orders') }}"><i
                                                class="fas fa-clipboard-list"></i>قائمة الطلبات</a></li>
                                @if(auth()->check())
                                    <li><a href="{{LaravelLocalization::localizeUrl('website/logout') }}"><i
                                                    class="fas fa-sign-out"></i>تسجيل الخروج </a></li>

                                @endif
                            </ul>
                        </div>
                        <div class="itm_us gru_cart">
                            <a href="{{LaravelLocalization::localizeUrl('cart')}}" class="btn_cart">
                                <span>عربة التسوق</span>
                                <span class="cart_icon" id="get-cart-simple-data">
											<img src="/website_v2/images/cart.svg" alt="">
											<div class="budge_cart" v-text="count_quantity">0</div>
										</span>
                            </a>
                        </div>
                        <div class="itm_us menu_trigger_btn">
                            <a class="menu-trigger">
                                <span>Menu</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_header">
        <div class="container d-flex align-items-center">
            <div class="category_menu dropdown">
                <a href="#" class="category_drop dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                   aria-expanded="false"><i class="fas fa-bars"></i><span>جميع الأقسام</span></a>


                <ul class="dropdown-menu dropdown_category">
                    @foreach($main_categories as $main_category)
                        <?php

                        $href = LaravelLocalization::localizeUrl('shop') . "?category=" . $main_category->id;

                        ?>
                        @if(count($main_category->website_children) > 0)
                            <li class="dropdown-submenu">
                                <a href="{{$href}}" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                   aria-expanded="false">{{$main_category->name}}</a>
                                <ul class="submenu dropdown-menu">
                                    @foreach($main_category->website_children as $children)
                                        <?php

                                        $href = LaravelLocalization::localizeUrl('shop') . "?category=" . $children->id;

                                        ?>
                                        <li><a href="{{$href}}">{{$children->name}}</a></li>

                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li><a href="{{$href}}">{{$main_category->name}}</a></li>
                        @endif

                    @endforeach
                </ul>
            </div>
            <ul class="main_menu clearfix mr-auto">
                <li><a href="{{url('')}}">الرئيسية </a></li>
                <li><a href="{{LaravelLocalization::localizeUrl('shop') . "?orderby=date"}}">أحدث المنتجات </a></li>
                @foreach($main_categories as $k => $cat_shop)
                    @if($k < 4)
                        <?php
                        $slug = get_slug_data_by_lang(get_category_slug_data_from_id($all_categories, $cat_shop->id));
                        $href = LaravelLocalization::localizeUrl('shop') . "?category=" . $cat_shop->id;
                        ?>
                        <li><a href="{{$href}}"> {{$cat_shop->$category_name}}</a></li>
                    @endif


                @endforeach


            </ul>
        </div>
    </div>



</header><!--header-->
