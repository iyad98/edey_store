@extends('website.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection

@section('content-page')

    @if( $header_image )

        <div class="header-bnr">
            <button type="button" class="btn btn-light closeBnr"><i class="fas fa-times"></i></button>
            <a target="_blank" href="{{$pointer_header_image}}"><img src="{{$header_image}}"></a>
        </div>


    @endif


    @include('website.partals.header')

    @include('website.partals.nav')
    @include('website.partals.slider')
    @foreach($home_data['data']['cat_slider'] as $cat_slider)

        <?php
        $url = LaravelLocalization::localizeUrl('shop');
        switch ($cat_slider['type']) {
            case 1 :
                $category_slug = get_category_slug_data_from_id($all_categories, $cat_slider['data']['id']);
                $url .= "?category=" . get_slug_data_by_lang($category_slug);
                break;
            case 5 :
                $url .= "?orderby=date";
                break;
            case 6 :
                $url .= "?orderby=most_sales";
                break;
        }
        ?>



        @if(in_array($cat_slider['type'] , [4]) && count($cat_slider['data']['products']) > 0)
            @include('website.partals.category' , ['products' => $cat_slider['data']['products'],'title'=>$cat_slider['data']['name']])
        @endif


        @if(in_array($cat_slider['type'] , [5 , 6]) && count($cat_slider['data']['products']) > 0)
            @include('website.partals.most' , ['products' => $cat_slider['data']['products'] , 'title'=>$cat_slider['data']['name']])
        @endif

        @if(in_array($cat_slider['type'] , [1]) && count($cat_slider['data']['products']) > 0  && $cat_slider['widget_type'] == 1 )
            @include('website.partals.6left' , ['products' => $cat_slider['data']['products'] , 'title'=>$cat_slider['data']['name'] , 'bannar'=>$cat_slider['widget_image_ads'] , 'bannar_mobile'=>$cat_slider['widget_image_ads_mobile']] )
        @endif

        @if(in_array($cat_slider['type'] , [1]) && count($cat_slider['data']['products']) > 0  && $cat_slider['widget_type'] == 2 )
            @include('website.partals.6right' , ['products' => $cat_slider['data']['products'] , 'title'=>$cat_slider['data']['name'] , 'bannar'=>$cat_slider['widget_image_ads'], 'bannar_mobile'=>$cat_slider['widget_image_ads_mobile']] )
        @endif

        @if(in_array($cat_slider['type'] , [1]) && count($cat_slider['data']['products']) > 0  && $cat_slider['widget_type'] == 3 )
            @include('website.partals.3left' , ['products' => $cat_slider['data']['products'] , 'title'=>$cat_slider['data']['name'] , 'bannar'=>$cat_slider['widget_image_ads']])
        @endif

        @if(in_array($cat_slider['type'] , [1]) && count($cat_slider['data']['products']) > 0  && $cat_slider['widget_type'] == 4 )
            @include('website.partals.3right' , ['products' => $cat_slider['data']['products'] , 'title'=>$cat_slider['data']['name'] , 'bannar'=>$cat_slider['widget_image_ads']])
        @endif


    @endforeach



    @include('website.partals.services')
    @include('website.partals.subscribe')
    @include('website.partals.footer')
@stop()

