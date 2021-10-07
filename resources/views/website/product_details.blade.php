@extends('website.layout')
@section('title') {{show_website_title(@$title)}} @endsection
@push('css')

    <script type="69922411f7fe29c3c8b1355c-text/javascript"
            src='{{url('')}}/website/wp-content/plugins/woocommerce-additional-variation-images/assets/js/variation-images-frontend.js?ver=5.4.1'></script>
    <script type="69922411f7fe29c3c8b1355c-text/javascript"
            src='{{url('')}}/website/wp-content/plugins/duracelltomi-google-tag-manager/js/gtm4wp-form-move-tracker.js?ver=1.11.4'></script>

@endpush
@section('content')

    <!-- SECTION-NAV -->
    <div class="container-fluid">
        <div class="row">

            <div class="container " id="product_details_vue">
                <div class="single-page ">
                    <div class="row ">
                        <div class="col-md-12 margin-t-b ">

                            <div class="hidden alert alert-success woocommerce-info"></div>
                            <div class="hidden alert alert-danger woocommerce-error"></div>


                            <div class="woocommerce-notices-wrapper"></div>
                            <div id="product-59771"
                                 class="mt__40 post-59771 product type-product status-publish has-post-thumbnail product_cat-132 product_cat-379 product_cat-343 product_cat-360 pa_size-356 pa_size-385 pa_size-395 pa_size-397 first instock sale shipping-taxable purchasable product-type-variable has-default-attributes">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="badge tu tc fs__12 ls__2">
                                            <div class="badge badge-onsale tc fs__12"><i class="onsale pa right">عرض</i>
                                            </div>
                                        </div>

                                        <!-- Container for the image gallery -->
                                        <div class="gallary_container">
                                            <!-- Thumbnail images -->
                                            <div class="thumbnail_row">
                                                {{--<div class="column">--}}
                                                    {{--<img class="demo cursor" :src="product.image" style="width:100%" @click="currentSlide(1)" alt="The Woods">--}}
                                                {{--</div>--}}
                                                <div class="column" v-for="(image , index) in product.images">
                                                    <img class="demo cursor" :src="image" style="width:100%" @click="currentSlide(index+1)" alt="Cinque Terre">
                                                </div>

                                            </div>
                                            <!-- Full-width images with number text -->
                                            {{--<div class="mySlides">--}}
                                                {{--<div class="numbertext">1 / 2</div>--}}
                                                {{--<img :src="product.image" style="width:100%">--}}
                                            {{--</div>--}}
                                            <div class="mySlides" v-for="(image , index) in product.images">
                                                {{--<div class="numbertext">2 / 2</div>--}}
                                                <img :src="image" style="width:100%">
                                            </div>


                                        </div>

                                    </div>
                                    <div class="col-md-6" >
                                        <div class="summary entry-summary">
                                            <h1 class="product_title entry-title" v-text="product.name"></h1>
                                            <p class="price">

                                                <del v-if="product.is_discount"><span
                                                            class="woocommerce-Price-amount amount">@{{ product.price }}&nbsp;<span
                                                                class="woocommerce-Price-currencySymbol">@{{ product.currency }}</span></span>
                                                </del>
                                                <ins><span class="woocommerce-Price-amount amount">@{{ product.price_after }}&nbsp;<span
                                                                class="woocommerce-Price-currencySymbol">@{{ product.currency }}</span></span>
                                                </ins>
                                            </p>

                                            <div>
                                                @foreach($guide_images as $guide_image)
                                                   <span ><img src="{{$guide_image}}" width="50" height="50"></span>
                                                @endforeach
                                            </div>
                                            <div id="product_variation_load" class="blockUI blockOverlay hidden"
                                                 style="z-index: 1000; border: none; margin: 0px; padding: 0px; width: 100%; height: 100%; top: 0px; left: 0px; background: rgb(255, 255, 255); opacity: 0.6; cursor: wait; position: absolute;"></div>

                                            <form class="variations_form cart" method="post"
                                                  enctype='multipart/form-data' data-product_id="59771"
                                            >
                                                <table class="variations" cellspacing="0">
                                                    <tbody>
                                                    <tr v-for="attribute in product_attributes">

                                                        <td v-if="attribute.key == 'color'" class="label"><label
                                                                    for="pa_color"
                                                                    v-text="attribute.name"></label>
                                                        </td>
                                                        <td v-if="attribute.key == 'color'" class="value">
                                                            <div class="variation-selector variation-select-color hidden">
                                                                <select v-model="attribute.selected"
                                                                        id="pa_color" class=""
                                                                        :name="'attribute_pa_color_'+attribute.id"
                                                                        :data-attribute_name="'attribute_pa_color_'+attribute.id"
                                                                        data-show_option_none="yes"
                                                                        data-default_value="">
                                                                    <option value="">حدد أحد الخيارات</option>
                                                                    <option v-for="attribute_value in attribute.attribute_values"
                                                                            :value="attribute_value.id"
                                                                            v-text="attribute_value.name"></option>

                                                                </select></div>
                                                            <div class="tawcvs-swatches"
                                                                 :data-attribute_name="'attribute_pa_color_'+attribute.id">
                                                    <span v-for="attribute_value_ in attribute.attribute_values"
                                                          @click="setSelected(attribute_value_.id , attribute.id)"
                                                          class="swatch swatch-color swatch-white"
                                                          :class="['set_color_'+attribute.id , attribute_value_.id == attribute.selected ? 'selected' : '']"
                                                          :style="'background-color:' + attribute_value_.value + ';'"
                                                          :title="attribute_value_.name"
                                                          :data-value="attribute_value_.id"
                                                          v-text="attribute_value_.name"></span>

                                                            </div>
                                                        </td>


                                                        <td v-if="attribute.key == 'label'"
                                                            class="label">
                                                            <label for="pa_size-dress" v-text="attribute.name"></label>
                                                        </td>
                                                        <td v-if="attribute.key == 'label'"
                                                            class="value">
                                                            <div class="variation-selector variation-select-label hidden">
                                                                <select v-model="attribute.selected"
                                                                        id="pa_size-dress" class="yith_wccl_custom"
                                                                        :name="'attribute_pa_size-dress_'+attribute.id"
                                                                        data-attribute_name="attribute_pa_size-dress"
                                                                        data-show_option_none="yes"
                                                                        data-default_value=""
                                                                        style="display: none;">
                                                                    <option value="">حدد أحد الخيارات</option>
                                                                    <option v-for="attribute_value in attribute.attribute_values"
                                                                            :value="attribute_value.id"
                                                                            v-text="attribute_value.name"></option>
                                                                </select>
                                                                <div class="select_box_label select_box attribute_pa_size-dress">
                                                                    <div v-for="attribute_value in attribute.attribute_values"
                                                                         class="select_option_label select_option "
                                                                         :class="attribute_value.id == attribute.selected ? 'selected':''"
                                                                         :data-value="attribute_value.value"><span
                                                                                class="yith_wccl_value"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tawcvs-swatches"
                                                                 :data-attribute_name="'attribute_pa_size-dress_'+attribute.id">
                                                    <span v-for="attribute_value in attribute.attribute_values"
                                                          @click="setSelected(attribute_value.id , attribute.id)"
                                                          class="swatch swatch-label  "
                                                          {{--   --}}
                                                          :class="['swatch-'+attribute_value.id , attribute_value.id == attribute.selected ? 'selected':'']"
                                                          :title="attribute_value.value"
                                                          :data-value="attribute_value.id"
                                                          v-text="attribute_value.value"></span>


                                                            </div>

                                                        </td>

                                                        <td v-if="attribute.key == 'image'" class="label"><label
                                                                    for="pa_colors"
                                                                    v-text="attribute.name"></label>
                                                        </td>
                                                        <td v-if="attribute.key == 'image'" class="value">
                                                            <div class="variation-selector variation-select-image hidden">
                                                                <select v-model="attribute.selected"
                                                                        id="pa_colors" class="yith_wccl_custom"
                                                                        :name="'attribute_pa_colors_'+attribute.id"
                                                                        data-attribute_name="attribute_pa_colors"
                                                                        data-show_option_none="yes"
                                                                        data-default_value=""
                                                                        style="display: none;">
                                                                    <option value="">حدد أحد الخيارات</option>
                                                                    <option v-for="attribute_value in attribute.attribute_values"
                                                                            :value="attribute_value.id"
                                                                            v-text="attribute_value.name"></option>

                                                                </select>
                                                                <div class="select_box_image select_box attribute_pa_colors">

                                                                    <div v-for="attribute_value in attribute.attribute_values"
                                                                         class="select_option_image select_option"
                                                                         :data-value="attribute_value.value"><img
                                                                                class="yith_wccl_value"
                                                                                :class="attribute_value.id == attribute.selected ? 'selected' : ''"
                                                                                :src="attribute_value.value">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <div class="tawcvs-swatches"
                                                                 :data-attribute_name="'attribute_pa_colors_'+attribute.id">
                                                    <span v-for="attribute_value in attribute.attribute_values"
                                                          @click="setSelected(attribute_value.id , attribute.id)"
                                                          class="swatch swatch-image swatch-white" title="ابيض مقلم"
                                                          data-value="white"><img
                                                                :src="attribute_value.value"
                                                                :alt="attribute_value.name"
                                                                v-text="attribute_value.name"></span>

                                                            </div>
                                                        </td>

                                                        <td v-if="attribute.key == 'select'" class="label">
                                                            <label for="pa_size-and-tiger"
                                                                   v-text="attribute.name"></label></td>
                                                        <td v-if="attribute.key == 'select'" class="value">
                                                            <select id="pa_size-and-tiger" class=""
                                                                    v-model="attribute.selected"
                                                                    @change="setSelected(-1 , attribute.id)"
                                                                    :name="'attribute_pa_size-and-tiger_'+attribute.id"
                                                                    :data-attribute_name="'attribute_pa_size-and-tiger_'+attribute.id"
                                                                    data-show_option_none="yes" data-default_value="">
                                                                <option value="">حدد أحد الخيارات</option>

                                                                <option v-for="attribute_value in attribute.attribute_values"
                                                                        :value="attribute_value.id"
                                                                        class="attached enabled"
                                                                        v-text="attribute_value.value"></option>

                                                            </select>
                                                        </td>

                                                    </tr>


                                                    </tbody>
                                                </table>


                                                <div class="single_variation_wrap">
                                                    <div class="woocommerce-variation single_variation"
                                                         style="display: block;">
                                                        <div v-if="product.description_text != ''"
                                                             class="woocommerce-variation-description"
                                                             v-html="product.description"></div>
                                                        <div class="woocommerce-variation-availability"><p class="stock"
                                                                                                           :class="[product.in_stock && !product.is_finish_quantity  ? 'in-stock': 'out-of-stock' , 'show_stock_text'+product.id]"
                                                                                                           v-text="product.available_text"></p>
                                                        </div>
                                                    </div>
                                                    <div class="woocommerce-variation-add-to-cart variations_button">
                                                        <div class="quantity pr fl mr__10">
                                                            <input type="number" step="1" min="1" max="12"
                                                                   name="quantity" value="1" title="Qty"
                                                                   class="input-text qty tc "
                                                                   :class="'get_quantity'+(product.id)" size="4"/>
                                                            <div class="qty tc">
                                                                <a class="plus db cb pa" href="javascript:void(0);">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                                <a class="minus db cb pa" href="javascript:void(0);">
                                                                    <i class="fa fa-minus"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <a href="javascript:;" @click="add_to_cart_vue(product.id , -1)"
                                                           class="button red_btn" :class="'add_to_cart_'+product.id">
                                                            <i :class="'add_to_cart_loader_'+(product.id)"
                                                               class="hidden fa fa-spin fa-spinner"></i>
                                                            <span class="product_in_cart_text   d-none d-sm-block
                                                             d-md-block d-lg-block d-xl-block"
                                                                  :class="product.in_cart ? 'hidden' : ''">
                                                                {{trans('website.add_to_cart')}}</span>
                                                            <span class="product_not_in_cart_text   d-none
                                                            d-sm-block d-md-block d-lg-block d-xl-block"
                                                                  :class="product.in_cart ? '' : 'hidden'">
                                                                {{trans('website.product_in_cart')}}</span>

                                                        </a>
                                                        <input type="hidden" name="add-to-cart" value="59771"/>
                                                        <input type="hidden" name="product_id" value="59771"/>
                                                        <input type="hidden" name="variation_id" class="variation_id"
                                                               value="0"/>
                                                    </div>
                                                </div>
                                                <div class="yith-wcwl-add-to-wishlist ts__03 mg__0 pa add-to-wishlist-59771">
                                                    <div class="yith-wcwl-add-button hide" style="display:none;"><a
                                                                href="https://mamnonfashion.com/wishlist/"
                                                                data-product-id="59771" data-product-type="variable"
                                                                class="add_to_wishlist cw"><i class="fa fa-heart-o"></i></a><i
                                                                class="fa fa-spinner fa-pulse ajax-loading pa"
                                                                style="visibility:hidden"></i></div>
                                                    <div class="yith-wcwl-wishlistaddedbrowse hide"
                                                         style="display:none;"><a class="chp"
                                                                                  href="https://mamnonfashion.com/wishlist/"><i
                                                                    class="fa fa-heart"></i></a></div>
                                                    <div class="yith-wcwl-wishlistexistsbrowse show"
                                                         style="display:block"><a
                                                                href="https://mamnonfashion.com/wishlist/"
                                                                class="chp"><i class="fa fa-heart"></i></a></div>
                                                </div>
                                            </form>

                                            <div class="product_meta">

                                            </div>
                                            <div v-for="sub_product in sub_products"
                                                 class="p-t-row child_product__  clearfix">
                                                <div class="right--img">
                                                    <div class="img--sm"><img width="108" height="150"
                                                                              src="https://mamnonfashion.com/wp-content/uploads/2020/03/shoes7-108x150.jpg"
                                                                              class=" wp-post-image" alt=""
                                                                              srcset="https://mamnonfashion.com/wp-content/uploads/2020/03/shoes7-108x150.jpg 108w, https://mamnonfashion.com/wp-content/uploads/2020/03/shoes7-217x300.jpg 217w, https://mamnonfashion.com/wp-content/uploads/2020/03/shoes7-500x692.jpg 500w, https://mamnonfashion.com/wp-content/uploads/2020/03/shoes7.jpg 560w"
                                                                              sizes="(max-width: 108px) 100vw, 108px"/>
                                                    </div>
                                                </div>
                                                <div class="left--componet ">
                                                    <h2 class="product-name" v-text="sub_product.name"></h2>
                                                    <p class="pt-salary">
                                                    <p class="price" style="font-size: 16px;">

                                                        <del v-if="sub_product.is_discount"><span
                                                                    style="font-weight: 200"
                                                                    class="woocommerce-Price-amount amount">
                                                                @{{ sub_product.price }}&nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">
                                                                    @{{ sub_product.currency }}</span></span>
                                                        </del>
                                                        <ins><span style="font-weight: 200"
                                                                   class="woocommerce-Price-amount amount">
                                                                @{{ sub_product.price_after }}&nbsp;<span
                                                                        class="woocommerce-Price-currencySymbol">
                                                                    @{{ sub_product.currency }}</span></span>
                                                        </ins>
                                                    </p>

                                                    <form class="variations_form cart" method="post"
                                                          enctype='multipart/form-data' data-product_id="39841">
                                                        <table class="variations" cellspacing="0">
                                                            <tbody>
                                                            <tr v-for="attribute in sub_product.attributes">

                                                                <td v-if="attribute.key == 'color'" class="label"><label
                                                                            for="pa_color"
                                                                            v-text="attribute.name"></label>
                                                                </td>
                                                                <td v-if="attribute.key == 'color'" class="value">
                                                                    <div class="variation-selector variation-select-color hidden">
                                                                        <select v-model="attribute.selected"
                                                                                id="pa_color" class=""
                                                                                :name="'attribute_pa_color_'+attribute.id"
                                                                                :data-attribute_name="'attribute_pa_color_'+attribute.id"
                                                                                data-show_option_none="yes"
                                                                                data-default_value="">
                                                                            <option value="">حدد أحد الخيارات</option>
                                                                            <option v-for="attribute_value in attribute.attribute_values"
                                                                                    :value="attribute_value.id"
                                                                                    v-text="attribute_value.name"></option>

                                                                        </select></div>
                                                                    <div class="tawcvs-swatches"
                                                                         :data-attribute_name="'attribute_pa_color_'+attribute.id">
                                                    <span v-for="attribute_value_ in attribute.attribute_values"
                                                          @click="setSelected(attribute_value_.id , attribute.id , sub_product.id)"
                                                          class="swatch swatch-color swatch-white"
                                                          :class="['set_color_'+attribute.id , attribute_value_.id == attribute.selected ? 'selected' : '']"
                                                          :style="'background-color:' + attribute_value_.value + ';'"
                                                          :title="attribute_value_.name"
                                                          :data-value="attribute_value_.id"
                                                          v-text="attribute_value_.name"></span>

                                                                    </div>
                                                                </td>


                                                                <td v-if="attribute.key == 'label'"
                                                                    class="label">
                                                                    <label for="pa_size-dress"
                                                                           v-text="attribute.name"></label>
                                                                </td>
                                                                <td v-if="attribute.key == 'label'"
                                                                    class="value">
                                                                    <div class="variation-selector variation-select-label hidden">
                                                                        <select v-model="attribute.selected"
                                                                                id="pa_size-dress"
                                                                                class="yith_wccl_custom"
                                                                                :name="'attribute_pa_size-dress_'+attribute.id"
                                                                                data-attribute_name="attribute_pa_size-dress"
                                                                                data-show_option_none="yes"
                                                                                data-default_value=""
                                                                                style="display: none;">
                                                                            <option value="">حدد أحد الخيارات</option>
                                                                            <option v-for="attribute_value in attribute.attribute_values"
                                                                                    :value="attribute_value.id"
                                                                                    v-text="attribute_value.name"></option>
                                                                        </select>
                                                                        <div class="select_box_label select_box attribute_pa_size-dress">
                                                                            <div v-for="attribute_value in attribute.attribute_values"
                                                                                 class="select_option_label select_option "
                                                                                 :class="attribute_value.id == attribute.selected ? 'selected':''"
                                                                                 :data-value="attribute_value.value"><span
                                                                                        class="yith_wccl_value"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="tawcvs-swatches"
                                                                         :data-attribute_name="'attribute_pa_size-dress_'+attribute.id">
                                                    <span v-for="attribute_value in attribute.attribute_values"
                                                          @click="setSelected(attribute_value.id , attribute.id, sub_product.id)"
                                                          class="swatch swatch-label  "
                                                          {{--   --}}
                                                          :class="['swatch-'+attribute_value.id , attribute_value.id == attribute.selected ? 'selected':'']"
                                                          :title="attribute_value.value"
                                                          :data-value="attribute_value.id"
                                                          v-text="attribute_value.value"></span>


                                                                    </div>

                                                                </td>

                                                                <td v-if="attribute.key == 'image'" class="label"><label
                                                                            for="pa_colors"
                                                                            v-text="attribute.name"></label>
                                                                </td>
                                                                <td v-if="attribute.key == 'image'" class="value">
                                                                    <div class="variation-selector variation-select-image hidden">
                                                                        <select v-model="attribute.selected"
                                                                                id="pa_colors" class="yith_wccl_custom"
                                                                                :name="'attribute_pa_colors_'+attribute.id"
                                                                                data-attribute_name="attribute_pa_colors"
                                                                                data-show_option_none="yes"
                                                                                data-default_value=""
                                                                                style="display: none;">
                                                                            <option value="">حدد أحد الخيارات</option>
                                                                            <option v-for="attribute_value in attribute.attribute_values"
                                                                                    :value="attribute_value.id"
                                                                                    v-text="attribute_value.name"></option>

                                                                        </select>
                                                                        <div class="select_box_image select_box attribute_pa_colors">

                                                                            <div v-for="attribute_value in attribute.attribute_values"
                                                                                 class="select_option_image select_option"
                                                                                 :data-value="attribute_value.value">
                                                                                <img
                                                                                        class="yith_wccl_value"
                                                                                        :class="attribute_value.id == attribute.selected ? 'selected' : ''"
                                                                                        :src="attribute_value.value">
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="tawcvs-swatches"
                                                                         :data-attribute_name="'attribute_pa_colors_'+attribute.id">
                                                    <span v-for="attribute_value in attribute.attribute_values"
                                                          @click="setSelected(attribute_value.id , attribute.id , sub_product.id)"
                                                          class="swatch swatch-image swatch-white" title="ابيض مقلم"
                                                          data-value="white"><img
                                                                :src="attribute_value.value"
                                                                :alt="attribute_value.name"
                                                                v-text="attribute_value.name"></span>

                                                                    </div>
                                                                </td>

                                                                <td v-if="attribute.key == 'select'" class="label">
                                                                    <label for="pa_size-and-tiger"
                                                                           v-text="attribute.name"></label></td>
                                                                <td v-if="attribute.key == 'select'" class="value">
                                                                    <select id="pa_size-and-tiger" class=""
                                                                            v-model="attribute.selected"
                                                                            @change="setSelected(-1 , attribute.id , sub_product.id)"
                                                                            :name="'attribute_pa_size-and-tiger_'+attribute.id"
                                                                            :data-attribute_name="'attribute_pa_size-and-tiger_'+attribute.id"
                                                                            data-show_option_none="yes"
                                                                            data-default_value="">
                                                                        <option value="">حدد أحد الخيارات</option>

                                                                        <option v-for="attribute_value in attribute.attribute_values"
                                                                                :value="attribute_value.id"
                                                                                class="attached enabled"
                                                                                v-text="attribute_value.value"></option>

                                                                    </select>
                                                                </td>

                                                            </tr>


                                                            </tbody>
                                                        </table>
                                                        <div class="single_variation_wrap">
                                                            <div class="woocommerce-variation single_variation">
                                                                <div class="woocommerce-variation-availability"><p
                                                                            class="stock"
                                                                            :class="[sub_product.in_stock && !sub_product.is_finish_quantity  ? 'in-stock': 'out-of-stock' , 'show_stock_text'+sub_product.id]"
                                                                            v-text="sub_product.available_text"></p>
                                                                </div>
                                                            </div>
                                                            <div class="woocommerce-variation-add-to-cart variations_button">
                                                                <div class="quantity pr fl mr__10">
                                                                    <input type="number" step="1" min="1" max="15"
                                                                           name="quantity"
                                                                           :class="'get_quantity'+(sub_product.id)"
                                                                           value="1" title="Qty"
                                                                           class="input-text qty tc" size="4"/>
                                                                    <div class="qty tc">
                                                                        <a class="plus db cb pa"
                                                                           href="javascript:void(0);">
                                                                            <i class="fa fa-plus"></i>
                                                                        </a>
                                                                        <a class="minus db cb pa"
                                                                           href="javascript:void(0);">
                                                                            <i class="fa fa-minus"></i>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <a href="javascript:;"
                                                                   @click="add_to_cart_vue(sub_product.id , 1)"
                                                                   class="button red_btn"
                                                                   :class="'add_to_cart_'+sub_product.id">
                                                                    <i :class="'add_to_cart_loader_'+(sub_product.id)"
                                                                       class="hidden fa fa-spin fa-spinner"></i>
                                                                    <span class="product_in_cart_text   d-none d-sm-block d-md-block d-lg-block d-xl-block"
                                                                          :class="sub_product.in_cart ? 'hidden' : ''">{{trans('website.add_to_cart')}}</span>
                                                                    <span class="product_not_in_cart_text   d-none d-sm-block d-md-block d-lg-block d-xl-block"
                                                                          :class="sub_product.in_cart ? '' : 'hidden'">{{trans('website.product_in_cart')}}</span>

                                                                </a>
                                                                <input type="hidden" name="add-to-cart" value="39841"/>
                                                                <input type="hidden" name="product_id" value="39841"/>
                                                                <input type="hidden" name="variation_id"
                                                                       class="variation_id" value="0"/>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                                <div class="aqq">
                                                </div>
                                            </div>
                                            <div class="p-t-row clearfix">
                                                <div class="pt-r-right">
                                                    <h3 class="pt-label">شارك</h3>
                                                    <ul class="pt-scribe clearfix">
                                                        <li class="facebook">
                                                            <a href="{{$footer_data['facebook']}}"
                                                               target="_blank"><i class="fa fa-facebook"
                                                                                  aria-hidden="true"></i></a>
                                                        </li>
                                                        <li class="twitter">
                                                            <a href="{{$footer_data['twitter']}}"
                                                               target="_blank"><i class="fa fa-twitter"
                                                                                  aria-hidden="true"></i></a>
                                                        </li>
                                                        <li class="pinterest">
                                                            <a href="{{$footer_data['snapchat']}}" style="background-color: yellow"
                                                               target="_blank"><i class="fa fa-snapchat-ghost"
                                                                                  aria-hidden="true"></i></a>
                                                        </li>
                                                        <li class="pinterest">
                                                            <a href="{{$footer_data['instagram']}}" style="background-color: "
                                                               target="_blank"><i class="fa fa-instagram"
                                                                                  aria-hidden="true"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="jas-service tr">
                                                <div class="icon medium cp" style="color: #9e9e9e;"><i
                                                            class="pe-7s-car"></i></div>
                                                <div class="content">
                                                    <h3 class="title cp tu fs__14 mg__0 mb__5" style="color: #222222;">
                                                        شحن مجاني: </h3>
                                                    <p class=""> عند الشراء بأكثر من 499 ريال داخل المملكه العربية
                                                        السعودية</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="container">
                                    <div class="row">
                                        <section class="related products ">
                                            <h2>منتجات ذات علاقة</h2>
                                            <ul class="products columns-2">
                                                <div class="owl-carousel owl-products2 owl-theme owl-rtl owl-loaded">


                                                    <div class="owl-stage-outer">
                                                        <div class="owl-stage"
                                                             style="transition: all 0s ease 0s; width: 3549px;">

                                                            @foreach($similar_products as $similar_product)
                                                                <div class="owl-item cloned"
                                                                     style="width: 221.6px; margin-left: 15px;">
                                                                    <div class="item">
                                                                        <div class="jas-col-md- jas-col-sm-4 jas-col-xs-6 mt__30 post-42664 product type-product status-publish has-post-thumbnail product_cat-132 product_cat-379 product_cat-358 product_cat-343 pa_size-395 pa_size-397 pa_size-399 pa_size-385 first instock sale shipping-taxable purchasable product-type-variable has-default-attributes">
                                                                            @include('website.includes.product' , ['product' => $similar_product])
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach


                                                        </div>
                                                    </div>
                                                    <div class="owl-controls">
                                                        <div class="owl-nav">
                                                            <div class="owl-prev" style=""><i
                                                                        class="fa fa-angle-right"></i></div>
                                                            <div class="owl-next" style=""><i
                                                                        class="fa fa-angle-left"></i></div>
                                                        </div>
                                                        <div class="owl-dots" style="">
                                                            <div class="owl-dot active"><span></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </ul>
                                        </section>
                                    </div>
                                    <div class="row">
                                        <section class="related products ">
                                            <h2>منتجات مرتبطة</h2>
                                            <ul class="products columns-2">
                                                <div class="owl-carousel owl-products2 owl-theme owl-rtl owl-loaded">


                                                    <div class="owl-stage-outer">
                                                        <div class="owl-stage"
                                                             style="transition: all 0s ease 0s; width: 3549px;">

                                                            @foreach($similar_products as $similar_product)
                                                                <div class="owl-item cloned"
                                                                     style="width: 221.6px; margin-left: 15px;">
                                                                    <div class="item">
                                                                        <div class="jas-col-md- jas-col-sm-4 jas-col-xs-6 mt__30 post-42664 product type-product status-publish has-post-thumbnail product_cat-132 product_cat-379 product_cat-358 product_cat-343 pa_size-395 pa_size-397 pa_size-399 pa_size-385 first instock sale shipping-taxable purchasable product-type-variable has-default-attributes">
                                                                            @include('website.includes.product' , ['product' => $similar_product])
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach


                                                        </div>
                                                    </div>
                                                    <div class="owl-controls">
                                                        <div class="owl-nav">
                                                            <div class="owl-prev" style=""><i
                                                                        class="fa fa-angle-right"></i></div>
                                                            <div class="owl-next" style=""><i
                                                                        class="fa fa-angle-left"></i></div>
                                                        </div>
                                                        <div class="owl-dots" style="">
                                                            <div class="owl-dot active"><span></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </ul>
                                        </section>
                                    </div>
                                    <div class="row">
                                        <section class="related products ">
                                            <h2>منتجات ذات صلة</h2>
                                            <ul class="products columns-2">
                                                <div class="owl-carousel owl-products2 owl-theme owl-rtl owl-loaded">


                                                    <div class="owl-stage-outer">
                                                        <div class="owl-stage"
                                                             style="transition: all 0s ease 0s; width: 3549px;">

                                                            @foreach($similar_products as $similar_product)
                                                                <div class="owl-item cloned"
                                                                     style="width: 221.6px; margin-left: 15px;">
                                                                    <div class="item">
                                                                        <div class="jas-col-md- jas-col-sm-4 jas-col-xs-6 mt__30 post-42664 product type-product status-publish has-post-thumbnail product_cat-132 product_cat-379 product_cat-358 product_cat-343 pa_size-395 pa_size-397 pa_size-399 pa_size-385 first instock sale shipping-taxable purchasable product-type-variable has-default-attributes">
                                                                            @include('website.includes.product' , ['product' => $similar_product])
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach


                                                        </div>
                                                    </div>
                                                    <div class="owl-controls">
                                                        <div class="owl-nav">
                                                            <div class="owl-prev" style=""><i
                                                                        class="fa fa-angle-right"></i></div>
                                                            <div class="owl-next" style=""><i
                                                                        class="fa fa-angle-left"></i></div>
                                                        </div>
                                                        <div class="owl-dots" style="">
                                                            <div class="owl-dot active"><span></span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </ul>
                                        </section>
                                    </div>
                                </div>
                                <meta itemprop="url"
                                      content="https://mamnonfashion.com/product/%d8%aa%d9%8a%d9%88%d8%b1-%d8%a7%d8%b3%d9%88%d8%af-%d9%88%d8%a7%d8%a8%d9%8a%d8%b6-2/"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')


    <script>
        var product = {!! $get_product !!};
        var product_categories = {!! $product_categories !!};
        var cart_product_id = {!! $cart_product_id !!};
        var sub_products = {!! $sub_products !!};

    </script>


    <script type="5013ee8377c39f820b3541f0-text/javascript"
            src='{{url('')}}/website/wp-content/plugins/yith-woocommerce-wishlist/assets/js/jquery.yith-wcwl.js?ver=3.0.9'></script>
    <script type="5013ee8377c39f820b3541f0-text/javascript"
            src='{{url('')}}/website/wp-content/plugins/woocommerce/assets/js/zoom/jquery.zoom.min.js?ver=1.7.21'></script>
    <script type="5013ee8377c39f820b3541f0-text/javascript"
            src='{{url('')}}/website/wp-content/plugins/js_composer/assets/lib/bower/flexslider/jquery.flexslider-min.js?ver=5.6'></script>
    <script type="5013ee8377c39f820b3541f0-text/javascript"
            src='{{url('')}}/website/wp-content/plugins/woocommerce/assets/js/photoswipe/photoswipe.min.js?ver=4.1.1'></script>
    <script type="5013ee8377c39f820b3541f0-text/javascript"
            src='{{url('')}}/website/wp-content/plugins/woocommerce/assets/js/photoswipe/photoswipe-ui-default.min.js?ver=4.1.1'>



    <script type="5013ee8377c39f820b3541f0-text/javascript"
            src='{{url('')}}/website/wp-content/plugins/woocommerce/assets/js/zoom/jquery.zoom.min.js?ver=1.7.21'>






    </script>
    <script type="5013ee8377c39f820b3541f0-text/javascript"
            src='{{url('')}}/website/wp-content/plugins/js_composer/assets/lib/bower/flexslider/jquery.flexslider-min.js?ver=5.6'></script>
    <script type="5013ee8377c39f820b3541f0-text/javascript"
            src='{{url('')}}/website/wp-content/plugins/woocommerce/assets/js/photoswipe/photoswipe.min.js?ver=4.1.1'></script>
    <script type="5013ee8377c39f820b3541f0-text/javascript"
            src='{{url('')}}/website/wp-content/plugins/woocommerce/assets/js/photoswipe/photoswipe-ui-default.min.js?ver=4.1.1'></script>
    <script type="5013ee8377c39f820b3541f0-text/javascript">
/* <![CDATA[ */
var wc_single_product_params = {"i18n_required_rating_text":"\u0627\u0644\u0631\u062c\u0627\u0621 \u0625\u062e\u062a\u064a\u0627\u0631 \u062a\u0642\u064a\u064a\u0645 \u0644\u0644\u0645\u0646\u062a\u062c","review_rating_required":"yes","flexslider":{"rtl":true,"animation":"slide","smoothHeight":true,"directionNav":false,"controlNav":"thumbnails","slideshow":false,"animationSpeed":500,"animationLoop":false,"allowOneSlide":false},"zoom_enabled":"1","zoom_options":[],"photoswipe_enabled":"1","photoswipe_options":{"shareEl":false,"closeOnScroll":false,"history":false,"hideAnimationDuration":0,"showAnimationDuration":0},"flexslider_enabled":"1"};
/* ]]> */








    </script>
    <script type="5013ee8377c39f820b3541f0-text/javascript"
            src='{{url('')}}/website/wp-content/plugins/woocommerce/assets/js/frontend/single-product.min.js?ver=3.5.7'></script>
    <script type="5013ee8377c39f820b3541f0-text/javascript"
            src='{{url('')}}/website/wp-content/plugins/woocommerce/assets/js/js-cookie/js.cookie.min.js?ver=2.1.4'></script>



    <script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js"
            data-cf-settings="5013ee8377c39f820b3541f0-|49" defer=""></script>

    <script type="c2f3a75456e97d73a7ddc2b5-text/javascript"
            src='{{url('')}}/website/wp-content/plugins/woocommerce/assets/js/frontend/cart-fragments.min.js?ver=3.5.7'></script>

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('.quantity').on('click', '.plus', function (e) {

                $input = $(this).parent().parent().find('input[type=number].qty');
                var val = parseInt($input.val());
                console.log($input);
                $input.val(val + 1).change();
            });
            $('.quantity').on('click', '.minus', function (e) {
                $input = $(this).parent().parent().find('input[type=number].qty');
                var val = parseInt($input.val());
                if (val > 1) {
                    $input.val(val - 1).change();
                }
            });
        });

    </script>
    <script type="text/javascript">
        jQuery('input[type=number].qty').change(function () {
            var maxx = jQuery('input[type=number].qty').attr('max');
            if (!maxx) {
                jQuery('input[type=number].qty').attr('max', 1);
            }

        });


    </script>


    <script src="{{url('')}}/website/general/js/product/product_details.js" type="text/javascript"></script>

@endpush
