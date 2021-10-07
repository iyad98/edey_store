<div class="sec_block_clients">
    <div class="container">
        <div class="owl-carousel dots_owl" id="clients_slider">
            @foreach($brands as $brand)
            <div class="item">
                <div class="item_client">
                    <img src="{{$brand->image}}" alt="">
                </div>
            </div>
                @endforeach

        </div>
    </div>
</div><!--sec_block_clients-->