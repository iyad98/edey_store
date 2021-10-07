


<div class="sec_block_banners">
    <div class="container">
        <div class="row">
            @foreach($products as $product)
                @if($type == 3)
            <div class="col-md-12 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.2s">
                <a href="#" class="banner_fiqure hover-effect">
                    <img src="{{asset('website_v3/img/banner1.png')}}" alt="">
                </a>
            </div>
                @else
                    <div class="col-md-12 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.2s">
                        <a href="#" class="banner_fiqure hover-effect">
                            <img src="{{asset('website_v3/img/banner1.png')}}" alt="">
                        </a>
                    </div>
                @endif

            @endforeach

        </div>
    </div>
</div>

