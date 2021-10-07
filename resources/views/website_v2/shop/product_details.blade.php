@extends('website_v2.app.layout')
@section('title') {{show_website_title(@$title)}} @endsection


@section('content')

    <div class="block_breadcrumb">
        <div class="container">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{asset('/')}}">الرئيسية</a></li>
                <li class="breadcrumb-item"><a href="{{LaravelLocalization::localizeUrl('shop')}}?category=">كافة الأقسام</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">{{$breadcrumb_last_item}}</a></li>
            </ol>
        </div>
    </div>

    <?php
    $product = json_decode($get_product);
    ?>
    <div id="product_details_vue" class="content_innerPage" >
        <div class="container" >
            <div class="alert alert-success suc_alert hidden" role="alert">

            </div>
            <div class="alert alert-danger dan_alert hidden" role="alert">
            </div>
            <div class="row">

                <div class="col-md-5">
                    <div class="block_mb_product_fiqure">
                        <div class="mb_product_mfiqure">
                            <div class="slider slider-for" dir="rtl">



                                <div v-for="(image , index) in product.images" class="item">
                                    <div class="pro_bThumb zoom">
                                        <img :src="image"  alt="" >
                                        <a data-fancybox="images" :href="image" class="pro_bThumb_fancy"><i class="far fa-expand-arrows-alt"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="mb_products_thumbs">
                            <div class="slider slider-nav"  dir="rtl">
                                <div v-for="(image , index) in product.images"  class="thumb-item">
                                    <div class="itm_tm">
                                        <img :src="image" alt="">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="details_mproduct">
                        <div class="mcategory_type">
                            <img v-if="product.brand != null" :src="product.brand.image" alt="">
                            <h3>@{{ product.categories }} </h3>
                        </div>
                        <div class="mproduct_head">
                            <h2>  @{{ product.name }} </h2>
                            <div class="mproduct_evaluate">
                                <div class="sn_eva"><i class="fas fa-star"></i>@{{ product.rate }}</div>
                                <div class="mn_eva">
                                    <p> @{{ product.rate_sum }}   التقييمات  </p>
                                    <div class="box_eva">

                                            <div class="srate rate-input">
					                                 <span class="rating">
					                                     <input type="radio" name="rating" id="star5" value="5">
					                                     <label for="star5"><span class="fas fa-star"></span></label>

					                                     <input type="radio" name="rating" id="star4" value="4">
					                                     <label for="star4"><span class="fas fa-star"></span></label>

					                                     <input type="radio" name="rating" id="star3" value="3" checked>
					                                     <label for="star3"><span class="fas fa-star"></span></label>

					                                     <input type="radio" name="rating" id="star2" value="2">
					                                     <label for="star2"><span class="fas fa-star"></span></label>

					                                     <input type="radio" name="rating" id="star1" value="1">
					                                     <label for="star1"><span class="fas fa-star"></span></label>
					                                 </span>
                                            </div>
                                            <button @click="rate(product.id)" class="btn_submit_evaluate">قيم الآن</button>

                                    </div>
                                </div>
                            </div>
                            <div class="rw_sale_sku d-flex align-items-center">
                                <div class="mproduct_sale">
                                    <p> @{{ product.price_after  }} @{{ product.currency  }}</p>
                                    <p v-if="product.is_discount" class="mold_sale">@{{ product.price  }} @{{ product.currency  }}</p>

                                </div>
                                <div class="mp_sku mr-auto">SKU : @{{ product.sku }}</div>
                            </div>
                            <div class="mproduct_description">
                                <h3>وصف المنتج :</h3>
                                <p v-html="product.description">
                                </p>
                            </div>

                            <span v-for="attribute in product_attributes">
                            <div class="mproduct_check">
                                <div v-if="attribute.key == 'color'" class="rw_check_list">
                                    <h3>@{{ attribute.name }} :</h3>
                                    <div v-if="attribute.key == 'color'" class="list_type_check checks_group">
                                        <div v-for="attribute_value in attribute.attribute_values" class="itm_check_tp">

                                            <input type="radio" class="radio_sty"
                                                   v-model="attribute.selected"
                                                   :value="attribute_value.id"
                                                   :name="'attribute_pa_size-and-tiger_'+attribute.id"
                                                   :data-attribute_name="'attribute_pa_size-and-tiger_'+attribute.id"
                                                   data-show_option_none="yes" data-default_value=""
                                                   :id="'myCheckboxColor'+attribute_value.id"
                                                   name="color_pro"
                                                   @click="setSelected(attribute_value.id , attribute.id)" >
                                            <div class="label_title_ch ch_color" :for="'myCheckboxColor'+attribute_value.id"    v-text="attribute_value.name" ></div>
                                        </div>
                                    </div>
                                </div>


                                <div v-if="attribute.key == 'label'" class="rw_check_list">
                                     <h3>@{{ attribute.name }} :</h3>
                                    <div v-if="attribute.key == 'label'" class="list_type_check checks_group">
                                        <div v-for="attribute_value in attribute.attribute_values" class="itm_check_tp">



                                            <input type="radio" class="radio_sty"
                                                   v-model="attribute.selected"
                                                   :value="attribute_value.id"

                                                   :name="'attribute_pa_size-and-tiger_'+attribute.id"
                                                   :data-attribute_name="'attribute_pa_size-and-tiger_'+attribute.id"
                                                   data-show_option_none="yes" data-default_value=""
                                                   :id="'myCheckboxSize'+attribute_value.id"
                                                   name="size_pro"  @click="setSelected(attribute_value.id , attribute.id)" >
                                            <div class="label_title_ch ch_size" :for="'myCheckboxSize'+attribute_value.id"    v-text="attribute_value.name" ></div>
                                        </div>
                                    </div>
                                </div>

                                <div v-if="attribute.key == 'select'" class="rw_check_list">
                                    <h3>اختر المقاس :</h3>
                                    <div class="list_type_check checks_group">
                                        <div class="itm_check_tp">
                                            <input type="radio" class="radio_sty" name="size_pro">
                                            <div class="label_title_ch ch_size">XS</div>
                                        </div>
                                        <div class="itm_check_tp">
                                            <input type="radio" class="radio_sty" name="size_pro" checked>
                                            <div class="label_title_ch ch_size">S</div>
                                        </div>
                                        <div class="itm_check_tp">
                                            <input type="radio" class="radio_sty" name="size_pro">
                                            <div class="label_title_ch ch_size">M</div>
                                        </div>
                                    </div>
                                </div>


                                <div v-if="attribute.key == 'image'" class="rw_check_list">
                                    <h3>@{{ attribute.name }} :</h3>
                                    <div class="inscriptions_list checks_group">

                                        <div  v-for="attribute_value in attribute.attribute_values"  class="inscriptions_itm">
                                            <input  v-model="attribute.selected"
                                                    :value="attribute_value.id"
                                                    :name="'attribute_pa_size-and-tiger_'+attribute.id"
                                                    :data-attribute_name="'attribute_pa_size-and-tiger_'+attribute.id"
                                                    data-show_option_none="yes" data-default_value=""
                                                    :id="'myImage'+attribute_value.id"
                                                    type="radio" class="radio_sty" name="inscription" checked=""
                                                    @click="setSelected(attribute_value.id , attribute.id)" >
                                            <div class="inscription_label">
                                                <img :for="'myImage'+attribute_value.id"     :src="attribute_value.value" alt="">

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            </span>


                            <div class="mproduct_action">
                                {{--<div class="quantity_avalible">الكمية المتوفرة : @{{ product.stock_quantity }}</div>--}}

                                <div class="m_product_action_list clearfix">
                                    <div class="ac_itm quantity_acp">
                                        <div class="quantity">
                                            <input type="text" name="count-quat1" :value="product.quantity_cart" class="jsQuantity count-quat "   :class="'get_quantity'+(product.id)">
                                            <div class="btn button-count inc jsQuantityIncrease">
                                                <i class="far fa-plus"></i>
                                            </div>
                                            <div class="btn button-count dec jsQuantityDecrease disabled" minimum="1">
                                                <i class="far fa-minus"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="!product.in_cart" class="ac_itm addCart_acp" @click="add_to_cart_vue(product.id , -1)">
                                        <button class="btn m_pro_addCart " :class="'add_to_cart_'+(product.id)" ><i class="fal fa-shopping-cart"></i>

                                            {{trans('website.add_to_cart')}}

                                        </button>
                                    </div>

                                    <div v-if="product.in_cart" class="ac_itm addCart_acp" >
                                        <button class="btn m_pro_addCart  " :class="'add_to_cart_'+(product.id)" ><i class="fal fa-shopping-cart"></i>
                                            {{trans('website.product_in_cart')}}
                                        </button>
                                    </div>
                                    <div class="grro_xs ac_itm">
                                        <div class="ac_itm compare_acp">
                                            <a href="javascript:;" class="btn compare_btn " :class="'add_to_compare_'+(product.id)" @click="add_to_compare(product.id)"><i class="fas fa-exchange-alt"></i>مقارنة</a>
                                        </div>
                                        <div class="ac_itm add_fav_acp" >
                                            <a v-if="product.in_favorite" onclick="add_to_wishlist(product.id , product.in_favorite)"  :class="'wishlist_comp_'+product.id"  class="btn btn_add_fav btn_added_fav"><i class="far fa-heart"></i></a>
                                            <a  v-if="!product.in_favorite" onclick="add_to_wishlist(product.id , product.in_favorite)"  :class="'wishlist_comp_'+product.id"  class="btn btn_add_fav"><i class="far fa-heart"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="cn_related_block bg_skin">
        <div class="container">

            @include('website_v2.partals.product_slider', ['products' =>$similar_products,'title'=>' منتجات ذات علاقة ' , 'url'=>''])
            @include('website_v2.partals.product_slider', ['products' =>$marketing_products,'title'=>'  منتجات مرتبطة  ' , 'url'=>''])

        </div>
    </div>
@endsection


@section('css')
@stop()

@section('js')

    <script>
        var product = {!! $get_product !!};
        var product_categories = {!! $product_categories !!};
        var cart_product_id = {!! $cart_product_id !!};
        var sub_products = {!! $sub_products !!};
    </script>

    <script>
        $(document).ready(function(){
            $('.slider-for').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                dots: false,
                fade: true,
                rtl:true,
                asNavFor: '.slider-nav'
            });
            $('.slider-nav').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                asNavFor: '.slider-for',
                dots: true,
                arrows: false,
                centerMode: false,
                rtl:true,
                focusOnSelect: true,
                responsive: [
                    {
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 4,
                            infinite: true,
                        }
                    },
                    {
                        breakpoint: 991,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 767,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 575,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    }
                ]
            });

            $('.zoom').zoom();
        });
    </script>

    <script src="{{url('')}}/website/general/js/product/product_details.js" type="text/javascript"></script>

@stop()
