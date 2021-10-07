
    <!--Nav section start-->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav">
                <span class="navbar-toggler-icon">
                    <i class="fas fa-bars"></i>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="main_nav">
                <div class="res-slide">
                    <div class="main-logo">
                        <img class=" lazyloaded" data-src="/website/img/mainlogo.png" alt="" src="/website/img/mainlogo.pnggi">
                    </div>
                    <div class="social-media">
                        <a href="#">
                            <button class="btn account-btn btn-link">
                                <i class="far fa-user"></i>
                                حسابي
                            </button>
                        </a>
                        <a href="#">
                            <button class="btn btn-link">
                                <i class="fab fa-instagram"></i>
                            </button>
                        </a>
                        <a href="#">
                            <button class="btn btn-link">
                                <i class="fab fa-snapchat-ghost"></i>
                            </button>
                        </a>
                        <a href="#">
                            <button class="btn btn-link">
                                <i class="fab fa-twitter"></i>
                            </button>
                        </a>
                        <a href="#">
                            <button class="btn btn-link">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                        </a>
                    </div>
                    <span class="res-slide-caption">القائمة</span>
                    <ul class="navbar-nav">
                        <li class="nav-item"> <a class="nav-link" href="#"><img src="/website/img/home.svg" alt="..."> الرئيسية </a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#"><img src="/website/img/shopping-cart.svg" alt="..."> سلة المشتريات </a></li>
                        <li class="nav-item"> <a class="nav-link" href="#"><img src="/website/img/layer1.svg" alt="..."> المفضلة </a> </li>
                        <li class="nav-item"> <a class="nav-link" href="#"><img src="/website/img/Icon feather-box.svg" alt="..."> طلباتي  </a></li>
                    </ul>

                </div>
                <span class="res-slide-caption" >التصنيفات</span>
                <ul class="navbar-nav">
                    <li class="nav-item {{!isset($in_selected_category) || count($in_selected_category) <= 0 ? 'active': '' }}"> <a class="nav-link" href="{{LaravelLocalization::localizeUrl('/')}}">الرئيسية</a> </li>

                    @foreach($main_categories as $main_category)
                        <?php
                        $slug = get_slug_data_by_lang(get_category_slug_data_from_id($all_categories, $main_category->id));
                        $href = LaravelLocalization::localizeUrl('shop') . "?category=" . $main_category->id;
                        $website_children = json_encode($main_category->website_children) ;
                        ?>

                 @if(count($main_category->website_children) > 0 )

                            <li class="nav-item dropdown {{isset($in_selected_category) && ($main_category->id == $category  || $main_category->slug == $category ) ? 'active': ''}}">
                                <a href="{{$href}}" class="nav-link dropdown-toggle" data-toggle="dropdown" >
                                    {{$main_category->$category_name}}
                                </a>
                                <?php
                                echo build_menu_new($all_categories, $category_name, $all_categories, $main_category->id, isset($category) ? $category : null);
                                ?>
                            </li>
                     @else
                                <li class="nav-item {{isset($in_selected_category) && ($main_category->id == $category  || $main_category->slug == $category ) ? 'active': ''}}"> <a class="nav-link" href="{{$href}}">{{$main_category->$category_name}}</a> </li>


                            @endif



                    @endforeach

                </ul>
                <div class="purcahse-cart my-2 my-lg-0">
                    <a href="{{LaravelLocalization::localizeUrl('my-account/orders')}}">
                    <div class="my-order">
                        <button> <img src="/website/img/Icon feather-box.svg" alt="..."> طلباتي</button>
                    </div>
                    </a>
                    <a href="{{LaravelLocalization::localizeUrl('wishlist')}}">
                    <div class="favourite">

                        <button class="btn"><i class="far fa-heart"></i></button>
                    </div>
                    </a>
                    <a class="cart-button jas-icon-cart pr" href="{{LaravelLocalization::localizeUrl('cart')}}" id="get-cart-simple-data">
                        سلة المشتريات
                        <span class="notification" v-text="count_quantity"></span>
                    </a>



                </div>
            </div>
        </div>



    </nav>
    <!--Nav section end-->
    <!--Corona Header start-->

    @if( $header_note_text_second )
        @if( $header_note_text_second->url_pointer )
            <div class="warning-header"  style="background-color:{{$header_note_text_second->background_color}} ; ">
                <a href="{{$header_note_text_second->url_pointer}}"> <p style="color: {{$header_note_text_second->text_color}};">{{$header_note_text_second->text}}</p>
                </a>
            </div>
        @else

            <div class="warning-header"  style="background-color:{{$header_note_text_second->background_color}} ; ">
                <p style="color: {{$header_note_text_second->text_color}};">{{$header_note_text_second->text}}</p>
                </a>
            </div>
        @endif






    @endif





    <!--Corona Header end-->
