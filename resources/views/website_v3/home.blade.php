@extends('website_v3.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@section('content')


    {{--    start slider--}}
    <div class="sec_block_content_home">


        @include('website_v3.partals.slider2')

        @foreach($home_data['data']['category_slider'] as $k => $cat_slider)
            @if($k == 0)
                @continue
            @endif
            <?php
            $url = LaravelLocalization::localizeUrl('shop');
            switch ($cat_slider['type']) {
                case 1 :
                    $url .= "?category=" . $cat_slider['data']['id'];
                    break;
                case 5 :
                    $url .= "?orderby=date";
                    break;
                case 6 :
                    $url .= "?orderby=most_sales";
                    break;
            }
            ?>
        @if(in_array($cat_slider['type'] , [2 ,3]) && count($cat_slider['data']['products']) > 0)
            @include('website_v3.partals.banners', ['products' => $cat_slider['data']['products'],'title'=>$cat_slider['data']['name'] , 'type'=>$cat_slider['type']])
        @endif

                @if(in_array($cat_slider['type'] , [6,5,1]) && count($cat_slider['data']['products']) > 0)

                    @include('website_v3.partals.product_slider',['products' => $cat_slider['data']['products'],'title'=>$cat_slider['data']['name'] , 'url'=>$url])

                @endif

        @endforeach

    </div>
    @include('website_v3.partals.special_product')

    <div class="special_slider">
        @include('website_v3.partals.ads2')

        @include('website_v3.partals.slider4')
    </div>




@endsection


@push('css')
@endpush

@push('js')
@endpush








