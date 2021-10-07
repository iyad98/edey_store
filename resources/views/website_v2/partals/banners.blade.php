<div class="sec_block_banners">
    <div class="row">
        @foreach($products as $product)
@if($type == 3)
                <div class="col-md-6 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.2s">
                    <a href="" class="banner_fiqure hover-effect">
                        <img src="{{$product['image_website']}}" alt="">
                    </a>
                </div>

    @else
                <div class="col-md-12 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.2s">
                    <a href="{{get_pointer_url($product)}}" class="banner_fiqure hover-effect">
                        <img src="{{$product['image_website']}}" alt="">
                    </a>
                </div>
@endif

        @endforeach

    </div>
</div><!--sec_block_banners-->