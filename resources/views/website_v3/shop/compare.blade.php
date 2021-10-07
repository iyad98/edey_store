@extends('website_v2.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection


@section('content')


    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">الرئيسية</a></li>
                <li class="breadcrumb-item active" aria-current="page">قارن المنتجات</li>
            </ol>
        </div>
    </div>
    <div class="content_innerPage skin_bg">
        <div class="container">
            <div class="tb_compare">
                <div class="table-responsive">
                    <table class="table table_compare">
                        <tbody>
                        <tr>
                            <td>
                                <div class="label_compre">صورة المنتج</div>
                            </td>
                            <td>
                                <div class="comp_thumn">
                                    <img src="{{$first_product->image}}" alt="صورة المنتج">
                                </div>
                            </td>
                            <td>
                                <div class="comp_thumn">
                                    <img src="{{$second_product->image}}" alt="صورة المنتج">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label_compre">اسم المنتج</div>
                            </td>
                            <td>
                                <h3 class="comp_title">
                                    <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$second_product->id}}">{{$first_product->name}}</a>
                                </h3>
                            </td>
                            <td>
                                <h3 class="comp_title">
                                    <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$second_product->id}}">{{$second_product->name}}</a>
                                </h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label_compre">الماركة</div>
                            </td>
                            <td>
                                <div class="comp_logo">
                                    <img src="{{$first_product->brand['image']}}" alt="">
                                    <p>{{$first_product->brand['name']}}</p>
                                </div>
                            </td>
                            <td>
                                <div class="comp_logo">
                                    <img src="{{$second_product->brand['image']}}" alt="">
                                    <p>{{$second_product->brand['name']}}</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label_compre">التصنيف </div>
                            </td>
                            <td>
                                <p>@foreach($first_product->categories as $cat) {{$cat['name']}} @endforeach</p>
                            </td>
                            <td>
                                <p>@foreach($second_product->categories as $cat) {{$cat['name']}} @endforeach</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label_compre">التقييم</div>
                            </td>
                            <td>
                                <div class="comp_evalute">
                                    <div class="stars_cmp">
                                        @for ($i = 5; $i > 0; $i--)
                                            @if ($i <=$first_product->rate)
                                                <i class="fas fa-star checked"></i>
                                            @else
                                                <i class="fas fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="cmp_lvl">4.5</div>
                                </div>
                            </td>
                            <td>
                                <div class="comp_evalute">
                                    <div class="stars_cmp">
                                        @for ($i = 5; $i > 0; $i--)
                                            @if ($i <=$second_product->rate)
                                                <i class="fas fa-star checked"></i>
                                            @else
                                                <i class="fas fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <div class="cmp_lvl">4.5</div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label_compre">الكمية المتوفرة</div>
                            </td>
                            <td>
                                <p><strong>{{$first_product->variation['stock_quantity']}}</strong></p>
                            </td>
                            <td>
                                <p><strong>{{$second_product->variation['stock_quantity']}}</strong></p>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="label_compre">الألوان المتوفرة</div>
                            </td>
                            <td>
                                <ul class="aviliable_list">
                                    @foreach($first_product->attributes as $attribute_value)
                                        @foreach($attribute_value->attribute_values as $value)
                                            <li>{{$value->attribute_value['name']}}</li>
                                        @endforeach
                                        @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul class="aviliable_list">
                                    @foreach($second_product->attributes as $attribute_value)
                                        @foreach($attribute_value->attribute_values as $value)
                                            <li>{{$value->attribute_value['name']}}</li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="label_compre">السعر</div>
                            </td>
                            <td>
                                <div class="mproduct_sale">
                                    <p>{{$first_product->variation['regular_price']}} د.ك </p>
                                    <p class="mold_sale">{{$first_product->variation['discount_price']}}</p>
                                </div>
                            </td>
                            <td>
                                <div class="mproduct_sale">
                                    <p>{{$second_product->variation['regular_price']}}   د.ك </p>
                                    <p class="mold_sale">{{$second_product->variation['discount_price']}}</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <div class="compare_action">
                                    <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$first_product->id}}" class="btn btn-block m_pro_addCart"><i class="fal fa-shopping-cart"></i>أضف لعربة التسوق</a>
                                    <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$first_product->id}}" class="btn btn_add_fav"><i class="far fa-heart"></i></a>
                                </div>
                            </td>
                            <td>
                                <div class="compare_action">
                                    <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$second_product->id}}" class="btn btn-block m_pro_addCart"><i class="fal fa-shopping-cart"></i>أضف لعربة التسوق</a>
                                    <a href="{{LaravelLocalization::localizeUrl('products')}}/{{$second_product->id}}" class="btn btn_add_fav"><i class="far fa-heart"></i></a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('css')
@stop()

@section('js')


@stop()
