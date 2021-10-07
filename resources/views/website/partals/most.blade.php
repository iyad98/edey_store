
<div class="category-page">
    <div class="product-details-page ">
        <div class="container"  id="product_details_vue">
            <div class="row">
    <div class="col-12">
        <div class="related-products">
            <div class="title">
{{$title}}
            </div>
            <div class="owl-carousel">
                @foreach($products as $product)
                    @include('website.partals.product' , ['product' => $product])

                @endforeach
            </div>

        </div>
    </div>
            </div></div></div>
</div>