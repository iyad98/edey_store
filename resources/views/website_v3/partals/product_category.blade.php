



<div class="col-lg-2 col-md-3 col-sm-4 col-6">
    <div class="product_item">
        <div class="cn_product_thumb">

            <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['id']}}" class="thumb_pro img-hover">
                <img src="{{$product['image']}}" alt="">
            </a>
            <div class="label_pro">50%</div>
        </div>
        <div class="cn_product_txt">

            {{--add by kareem--}}  <h2><a href="{{LaravelLocalization::localizeUrl('products')}}/{{$product['id']}}">{{$product['name']}} </a></h2>

            <div class="seller_info">
                <img src="{{asset('website_v3/img/seller.svg')}}" alt="...">
                <span class="seller_name">اسم التاجر</span>
            </div>
            <div class="d-flex justify-content-between">
                <div class="pro_evaluate">

                    <div class="pro_evaluate">
                        @for ($i = 5; $i > 0; $i--)
                            @if ($i <= $product['rate'])
                                <i class="fas fa-star checked"></i>
                            @else
                                <i class="fas fa-star"></i>
                            @endif
                        @endfor

                    </div>
                </div>
                <div class="sale_pro d-flex justify-content-between">

                    @if($product['is_discount'])

                        <div class="sale_old"><p><span>{{$product['price']}}</span>{{$product['currency']}}</p></div>

                    @endif
                        <div class="sale_new"><p><span>{{$product['price_after']}}</span>{{$product['currency']}}</p></div>


                </div>
            </div>
        </div>
    </div>
</div>
