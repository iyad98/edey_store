    <div class="item">
        <div class="product_item">
            <div class="cn_product_thumb">
                <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['id']}}" class="thumb_pro img-hover">
                    <img src="{{$product['image']}}" alt="">
                </a>
                <div class="label_pro">50%</div>
            </div>
            <div class="cn_product_txt">
                <h2><a href="#">{{$product['name']}}</a></h2>
                <div class="seller_info">
                    <img src="{{asset('website_v3/img/seller.svg')}}" alt="...">
                    <span class="seller_name">اسم التاجر</span>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="pro_evaluate">

                        <i class="fas fa-star checked"></i>
                        <p class="ev_rate">4.7</p>
                    </div>
                    <div class="sale_pro d-flex justify-content-between">

                        @if($product['is_discount'])
                            <div class="old-price">
                                <div class="sale_old"><p><span>{{$product['price']}}</span>{{$product['currency']}}</p></div>
                            </div>
                        @endif
                        <div class="sale_new"><p><span>{{$product['price_after']}}</span>{{$product['currency']}}</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
