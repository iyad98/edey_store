@extends('website_v2.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection


@section('content')

    <div class="banner_inner_bg" style="background-image: url({{$category_image}});">
        <div class="container">
            <h2 class="banner_title">{{$category_name_title ?$category_name_title : 'كافة الأقسام'}}</h2>
        </div>
    </div>
    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{asset('/')}}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{LaravelLocalization::localizeUrl('shop')}}?category=">كافة الأقسام</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$category_name_title}}</li>
            </ol>
        </div>
    </div>
    <div class="content_innerPage bg_skin">
        <div class="container">
            <div class="row">
                @include('website_v2.shop.partals.sidebar')
                <div class="col-lg-9 col-md-8">
                    @include('website_v2.shop.partals.box_filter_cate')
                    <div class="product_list">
                        <div class="row justify-content-center">
                            @foreach($products as $product)
                                @include('website_v2.partals.product_category' , ['product' => $product])
                            @endforeach
                        </div>


                        <ul class="pagination clearfix">
                            <nav>
                                {{$links}}
                            </nav>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@stop()

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{url('')}}/website/general/js/shop/shop.js"></script>
<script>
    $(function() {
        if(!$.fn.slider) return;

        $( ".price-range-selector" ).each(function(){
            var $price_label = $(this).siblings('.wgpf-label').find('.price-range-label');
            var cur_sign = $price_label.data('currency-sign');
            var cursign_before = $price_label.data('cursign-before');
            $(this).slider({
                isRTL: true,
                range: true,
                min: $(this).data('min'),
                max: $(this).data('max'),
                values: [ 0, $(this).data('max') ],
                slide: function( event, ui ) {
                    set_range_label(ui.values[ 0 ], ui.values[ 1 ]);
                }
            });

            function set_range_label(value1, value2){
                if(cursign_before)
                    $price_label.html( cur_sign + value1 + " <span>" + cur_sign + value2 + "</span> " );
                else
                    $price_label.html( value1 + cur_sign + " <span>" + value2 + cur_sign + "</span> " );
            }

            set_range_label($(this).data('min'), $(this).data('max'));
        });
    });
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            minimumResultsForSearch: -1
        });
    });
</script>


@stop()
