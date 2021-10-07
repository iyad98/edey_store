<div class="row">
    <div class="col-12 col-md-5">
        <div class="demo">
            <ul id="imageGallery">
                <li v-for="(image , index) in product.images" :data-thumb="image" :data-src="image">
                    <img :src="image" />
                </li>

            </ul>
        </div>
        <div class="share-btns">
            <?php
            $prod = json_decode($get_product);
            ?>
            <a target="_blank"
               href="https://www.facebook.com/sharer/sharer.php?u={{LaravelLocalization::localizeUrl('products')}}/{{$prod->id}}&text={{ $prod->name }}"
              class="btn share-twitter">
                <i class="fab fa-twitter"></i>
            </a>
            <a target="_blank"
               href="https://twitter.com/intent/tweet?text={{LaravelLocalization::localizeUrl('products')}}/{{$prod->id}}"
               class="btn share-facebook">
                <i class="fab fa-facebook-f"></i>
            </a>

            <a target="_blank"
               href="whatsapp://send?text={{LaravelLocalization::localizeUrl('products')}}/{{$prod->id}}"
               data-action="share/whatsapp/share"
               class="btn share-whatsapp">
                <i class="fab fa-whatsapp" aria-hidden="true"></i>
            </a>


        </div>

        <div @click="add_to_wishlist(product.id , product.in_favorite)"
             class=" wishlist_comp_{{$prod->id}} fav-fav @if($prod->in_favorite == true) infav @endif">
            <button class="btn">
                <i class="far fa-heart "></i>
            </button>
        </div>
    </div>
    <div class="col-12 col-md-7">
        <div class="product-details">
            <div class="name">
                @{{ product.name }}&nbsp; {{$prod->in_favorite}}
            </div>
            <div class="review">
                {{--<div class="stars">--}}
                    {{--<i class="fas fa-star"></i>--}}
                    {{--<i class="fas fa-star"></i>--}}
                    {{--<i class="fas fa-star"></i>--}}
                    {{--<i class="fas fa-star"></i>--}}
                    {{--<i class="fas fa-star"></i>--}}
                {{--</div>--}}
                {{--<span> 0 التقييمات</span>--}}
                {{--<button class="btn">قيم الآن</button>--}}
            </div>
            <div class="price">
                <h3>
                    <span v-if="product.is_discount" class="discount">
                        @{{ product.price }} @{{ product.currency }}
                    </span>
                    @{{ product.price_after }} @{{ product.currency }}
                </h3>
                <div class="code">SKU : @{{ product.sku }}</div>
            </div>

            <div class="available-table">
                <table>
                    <tbody>
                    <tr>
                        <td class="bold-text">متاح للاهداء:</td>
                        <td v-if="product.can_gift">متاح</td>
                        <td v-else>غير متاح</td>
                    </tr>
                    <tr>
                        <td class="bold-text">التصنيف:</td>
                        <td> @{{ product.categories }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>


            <div class="select-size">
                <span for="size">

                    <button class="btn size-modal" data-toggle="modal"
                            data-target="#exampleModal">شاهد جدول القياسات</button>
                </span>

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="fotorama"
                                 data-allowfullscreen="native">

                                @foreach($guide_images as $guide_image)
                                    <img src="{{$guide_image}}">
                                @endforeach

                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <span v-for="attribute in product_attributes">

                <div class="select-color" v-if="attribute.key == 'color'">

                                        <div class="colors ">
                                             <label for="size">@{{ attribute.name }} :</label>


                                             <td v-if="attribute.key == 'color'" class="value attached enabled">
                                                            <div class="variation-selector variation-select-color "
                                                                 style="display: none;">
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
                                                            <div class="radio-btns"
                                                                 :data-attribute_name="'attribute_pa_color_'+attribute.id">

                                                                <div class="circle"
                                                                     v-for="attribute_value_ in attribute.attribute_values"
                                                                     @click="setSelected(attribute_value_.id , attribute.id)"

                                                                     :class="['set_color_'+attribute.id , attribute_value_.id == attribute.selected ? 'selected' : '']"
                                                                     :title="attribute_value_.name"
                                                                     :data-value="attribute_value_.id"

                                                                >
                                                                    <input type="radio" name="color"
                                                                           :id="attribute_value_.name">
                                                                    <label :for="attribute_value_.name"
                                                                           class="blue-radio1"
                                                                           :style="'background-color:' + attribute_value_.value + ';'"></label>
                                                                </div>


                                                            </div>
                                                        </td>

                                        </div>
                                    </div>


                <div v-if="attribute.key == 'label'" class="select-size">


                     <div class="mamnon-form">
                                        <label class="category-title" style="color: rgb(226, 0, 72);">@{{ attribute.name }} :</label>

                                        <div class="westeros-form">
                                            <ul class="txtCheckbox imgCheckbox">
                                              <li v-for="attribute_value in attribute.attribute_values">
                                                <input v-model="attribute.selected"
                                                       :value="attribute_value.id"

                                                       :name="'attribute_pa_size-and-tiger_'+attribute.id"
                                                       :data-attribute_name="'attribute_pa_size-and-tiger_'+attribute.id"
                                                       data-show_option_none="yes" data-default_value=""
                                                       type="radio" class="myCheckbox"  :id="'myCheckboxSize'+attribute_value.id" name="الشكل" value="الشكل"/>
                                                <label :for="'myCheckboxSize'+attribute_value.id"  v-text="attribute_value.value">مقاس 1</label>
                                              </li>


                                            </ul>
                                        </div>
                                    </div>



                </div>


                <div v-if="attribute.key == 'select'" class="select-size">
                    <label for="size">@{{ attribute.name }} :

                    </label>
                    <select class="custom-select" name="size" id="size"
                            v-model="attribute.selected"
                            @change="setSelected(-1 , attribute.id)"
                            :name="'attribute_pa_size-and-tiger_'+attribute.id"
                            :data-attribute_name="'attribute_pa_size-and-tiger_'+attribute.id"
                            data-show_option_none="yes" data-default_value=""
                    >

                                            <option v-for="attribute_value in attribute.attribute_values"
                                                    :value="attribute_value.id"
                                                    class="attached enabled"
                                                    v-text="attribute_value.value">S</option>

                                        </select>
                </div>

                  <div v-if="attribute.key == 'image'" class="select-size">

                        <div class="mamnon-form">
                                        <label class="category-title" style="color: rgb(226, 0, 72);">@{{ attribute.name }} :</label>

                                        <div class="westeros-form">
                                            <ul class="imgCheckbox">
                                              <li v-for="attribute_value in attribute.attribute_values">
                                                <input type="radio" v-model="attribute.selected"
                                                       :value="attribute_value.id"
                                                       class="myCheckbox"
                                                       :id="'myCheckbox'+attribute_value.id"
                                                       :name="'attribute_pa_size-and-tiger_'+attribute.id"
                                                       :data-attribute_name="'attribute_pa_size-and-tiger_'+attribute.id"
                                                       data-show_option_none="yes" data-default_value=""
                                                       />
                                                <label :for="'myCheckbox'+attribute_value.id"><img :src="attribute_value.value" /></label>
                                              </li>

                                            </ul>
                                        </div>
                                    </div>

                </div>

            </span>


            <div class="counter-cart">
                <div class="input-group quantity-btns">
                    <button type="button" class="quantity-left-minus btn btn-number"
                            data-type="minus" data-field="">
                        <i class="fas fa-minus"></i>
                    </button>

                    <input type="number" name="quantity" step="1" size="4"
                           class="form-control quantity input-number"
                           :class="'get_quantity'+(product.id)"
                           value="1" min="1"
                           max="100"/>


                    <button type="button" class="quantity-right-plus btn btn-number"
                            data-type="plus" data-field="">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="add-to-cart">
                    <button class="btn" @click="add_to_cart_vue(product.id , -1)">
                        <i class="fas fa-shopping-cart"></i>
                        أضف للسلة
                    </button>
                </div>


                <!-- <div class="favourite">
                    <button class="btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div> -->
            </div>

            <div class="content" style="display: flex">
                <img src="{{$product_details_note_image}}" style="width: 70px;height: 70px;margin: 11px;">
                <span>
                <h4 class="title mt-3" style="color: #222222;">{{$product_details_note1}}</h4>
                <p class="">{{$product_details_note2}}</p>
                    </span>
            </div>


            <div class="counter-cart-mobile">
                <div class="input-group quantity-btns">
                    <button type="button" class="quantity-left-minus btn btn-number"
                            data-type="minus" data-field="">
                        <i class="fas fa-minus"></i>
                    </button>

                    <input type="number" name="quantity" step="1" size="4"
                           class="form-control quantity input-number"
                           :class="'get_quantity'+(product.id)"
                           value="1" min="1"
                           max="100"/>


                    <button type="button" class="quantity-right-plus btn btn-number"
                            data-type="plus" data-field="">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <div class="tax">
                    <img src="/website/img/share_logo.png" alt="">
                </div>
                <div class="add-to-cart">
                    <button class="btn" @click="add_to_cart_vue(product.id , -1)">
                        <svg class="svg-inline--fa fa-shopping-cart fa-w-18" aria-hidden="true" focusable="false"
                             data-prefix="fas" data-icon="shopping-cart" role="img" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 576 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                  d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"></path>
                        </svg><!-- <i class="fas fa-shopping-cart"></i> -->
                        أضف للسلة
                    </button>
                </div>
                <!-- <div class="favourite">
                    <button class="btn">
                        <svg class="svg-inline--fa fa-heart fa-w-16" aria-hidden="true" focusable="false" data-prefix="far" data-icon="heart" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M458.4 64.3C400.6 15.7 311.3 23 256 79.3 200.7 23 111.4 15.6 53.6 64.3-21.6 127.6-10.6 230.8 43 285.5l175.4 178.7c10 10.2 23.4 15.9 37.6 15.9 14.3 0 27.6-5.6 37.6-15.8L469 285.6c53.5-54.7 64.7-157.9-10.6-221.3zm-23.6 187.5L259.4 430.5c-2.4 2.4-4.4 2.4-6.8 0L77.2 251.8c-36.5-37.2-43.9-107.6 7.3-150.7 38.9-32.7 98.9-27.8 136.5 10.5l35 35.7 35-35.7c37.8-38.5 97.8-43.2 136.5-10.6 51.1 43.1 43.5 113.9 7.3 150.8z"></path></svg><i class="far fa-heart"></i>
                    </button>
                </div> -->
            </div>

        </div>
        {{--@if(count($sub_products))--}}
        {{--<div class="Suitable-products text-right">--}}
            {{--<div class="name text-right">--}}
                {{--<h6>منتجات مناسبة لهذا المنتج</h6>--}}
            {{--</div>--}}

            {{--@foreach($sub_products  as $k => $sub_produc)--}}

                {{--<div class="suitable-item row">--}}
                    {{--<div class="col-4">--}}
                        {{--<img src="{{$sub_produc['image']}}" class="" height="130" width="130">--}}
                    {{--</div>--}}
                    {{--<div class="col-8">--}}
                        {{--<div class="suitable-item-data">--}}
                            {{--<h6>{{$sub_produc['name']}}</h6>--}}
                            {{--<div class="price">--}}
                                {{--@if($sub_produc['is_discount'])--}}
                                    {{--<div class="old-price">--}}
                                        {{--{{$sub_produc['price']}}  {{$sub_produc['currency']}}--}}
                                    {{--</div>--}}
                                {{--@endif--}}
                                {{--<div class="new-price">--}}
                                    {{--{{$sub_produc['price_after']}}  {{$sub_produc['currency']}}--}}
                                {{--</div>--}}
                            {{--</div>--}}


                            {{--<div class="counter-cart">--}}

                                {{--<div class="add-to-cart">--}}
                                    {{--<a class="btn"--}}
                                       {{--href="{{LaravelLocalization::localizeUrl('products')}}/{{$sub_produc['id']}}"--}}
                                       {{--style="color:#fff; background: #000">--}}
                                        {{--<svg class="svg-inline--fa fa-shopping-cart fa-w-18" aria-hidden="true"--}}
                                             {{--focusable="false" data-prefix="fas" data-icon="shopping-cart"--}}
                                             {{--role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"--}}
                                             {{--data-fa-i2svg="">--}}
                                            {{--<path fill="currentColor"--}}
                                                  {{--d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"></path>--}}
                                        {{--</svg><!-- <i class="fas fa-shopping-cart"></i> -->--}}
                                        {{--أضف للسلة--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--@if($k > 2)--}}
                    {{--@break--}}
                {{--@endif--}}
            {{--@endforeach--}}


        {{--</div>--}}
            {{--@endif--}}
    </div>
</div>