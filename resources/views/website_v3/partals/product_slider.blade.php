



<div class="sec_block_products">
    <div class="container">
        <div class="head_sec_pro d-flex align-items-center clearfix wow fadeInUp" data-wow-duration="1000ms"
             data-wow-delay="0.1s">
            <h2 class="title_block_pro"> {{$title}} </h2>

        </div>
        <div class="sc_warpper wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="0.2s">
            <div class="owl-carousel dots_owl owl_products">
                @foreach($products as $product)
                    @include('website_v3.partals.product' , ['product' => $product])
                @endforeach

            </div>
        </div>
    </div>
</div>





