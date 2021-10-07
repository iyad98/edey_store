<div class="col-lg-3 col-md-4">


        <?php
    $cat_slider =   $home_data['data']['category_slider'][0];

    $products = $cat_slider['data']['products'];
?>
            <div class="row">
            @foreach($products as $product)


                    <div class="col-md-12 col-sm-6 col-6 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.1s">
                        <a href=" @if(get_pointer_url($product) != ""){{get_pointer_url($product)}} @else javascript:; @endif" class="banner_hm_sm hover-effect">
                            <img src="{{$product['image_website']}}" alt="">
                        </a>
                    </div>

            @endforeach




    </div>
</div>