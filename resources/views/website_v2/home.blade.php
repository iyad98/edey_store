@extends('website_v2.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection


@section('content')

    <div class="sec_block_content_home">
        <div class="container">
            <div class="sec_block_home">
                <div class="row">
                    @include('website_v2.partals.slider')
                    @include('website_v2.partals.slider_banner')
                </div>
            </div><!--sec_block_home-->

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
                        @include('website_v2.partals.banners', ['products' => $cat_slider['data']['products'],'title'=>$cat_slider['data']['name'] , 'type'=>$cat_slider['type']])
                    @endif

                    @if(in_array($cat_slider['type'] , [6,5,1]) && count($cat_slider['data']['products']) > 0)

                        @include('website_v2.partals.product_slider', ['products' => $cat_slider['data']['products'],'title'=>$cat_slider['data']['name'] , 'url'=>$url])
                    @endif



            @endforeach

        </div>
    </div>


@endsection


@push('css')
@endpush

@push('js')
@endpush
