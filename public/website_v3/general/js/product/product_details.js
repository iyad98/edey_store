var product_details = new Vue({
    el: '#product_details_vue',
    data: {
        product: product,
        product_categories: product_categories,
        product_attributes: [],
        sub_products : sub_products,

        src_set: '',
        cart_product_id: cart_product_id,

        add_to_cart_loading: false,
        product_added_to_cart: '',
    },
    created: function () {

        this.product.quantity_cart = this.product.in_cart ? this.product.quantity_cart : this.product.min_quantity;
        var product_attributes = [];
        this.product.attributes.forEach(function (t) {
            var temp = t;
            temp['selected'] = t.attribute_values.find(el => el.is_selected == true).id;
            if (cart_product_id == -1) {
                temp['selected'] = 0;
            }
            product_attributes.push(temp);
        });
        this.product_attributes = product_attributes;
        this.src_set = this.product.images[0];


        if (cart_product_id != -1) {
            this.get_product_variation_data(this.product.id , this.product_attributes);
        }
        add_image_to_pro_slider(this.product.image, this.product.images);
     //   update_ol_thumb_images(this.product.image, this.product.images);
    },

    methods: {

        setSelected: function (attribute_value_id, attribute_id , product_id = -1) {

            if(product_id == -1) {
                if (attribute_value_id != -1) {
                    var get_product_attribute = this.product_attributes.find(el => el.id == attribute_id);
                    var get_product_attribute_index = this.product_attributes.indexOf(get_product_attribute);

                    get_product_attribute.selected = attribute_value_id;
                    this.product_attributes[get_product_attribute_index] = get_product_attribute;
                    //  Vue.set(this.product_attributes ,get_product_attribute_index  ,get_product_attribute );
                    this.get_product_variation_data(this.product.id , this.product_attributes , -1);
                }
            }else {
                let sub_product = this.sub_products.find(el => el.id == product_id);
                let sub_product_index = this.sub_products.indexOf(sub_product);

                var get_product_attribute = sub_product.attributes.find(el => el.id == attribute_id);
                var get_product_attribute_index = sub_product.attributes.indexOf(get_product_attribute);

                get_product_attribute.selected = attribute_value_id;
                sub_product.attributes[get_product_attribute_index] = get_product_attribute;

                this.sub_products[sub_product_index] = sub_product;

                this.get_product_variation_data(product_id , sub_product.attributes , 1);
            }

        },
        get_product_variation_data: function (product_id ,product_attributes , type = -1 ) {

            let get_selected = pluck_('selected');
            let get_attribute_values_selected = get_selected(product_attributes);

            let check_all = get_attribute_values_selected.every(function (t) {
                return t != 0 && t != "";
            });
            if (!check_all) return;
            $("#preloader").css("background-color", "#fefefebd");

            $("#preloader").toggle();
            axios.post(get_url + "/product-variation",
                {
                    product_id: product_id,
                    attribute_values: get_attribute_values_selected
                }).then(function (res) {


                 if (res.data['status']) {
                    product_details.set_product_variation_data(res.data['data'] , type);
                }
                $("#preloader").toggle();

            }).catch(function (err) {
                $("#preloader").toggle();
            });
        },
        set_product_variation_data: function ( data , type = -1) {
            let product = type == -1 ? this.product: this.sub_products.find(el => el.id == data.product_id);
            product.price = data.price;
            product.price_after = data.price_after;
            product.is_discount = data.is_discount;
            product.in_cart = data.in_cart;
            product.discount_rate = data.discount_rate;
            product.min_quantity = data.min_quantity;
            product.max_quantity = data.max_quantity;
            product.quantity_cart = data.quantity_cart;
            product.on_sale = data.on_sale;
            product.in_stock = data.in_stock;
            product.stock_status = data.stock_status;
            product.is_finish_quantity = data.is_finish_quantity;
            product.sku = data.sku;

            product.images = data.images;

            $('.zoomImg').attr('src',product.images[0]);
            product.available_text = data.available_text;

            if(data.in_cart) {

                $('.product_in_cart').removeClass('hidden');
                $('.add_to_cart').addClass('hidden');
            }else {

                $('.product_in_cart').addClass('hidden');
                $('.add_to_cart').removeClass('hidden');

            }

            $('.show_stock_text'+(data.product_id)).text(data.available_text);
            $('.get_quantity'+(data.product_id)).val(data.quantity_cart);

            if(type == -1) {
                // add_image_to_pro_slider(product.image, product.images);
                // update_ol_thumb_images(product.image, product.images);
            }else {

                this.sub_products[this.sub_products.findIndex(el => el.id == data.product_id)] = product;
            }


            product_details.$nextTick(function () {

            });
        },

        set_src_set: function (image = -1) {

            if (image == -1) {
                this.src_set = this.product.image;
            } else {
                this.src_set = image;
            }
        },

        add_to_wishlist: function (product_id, in_favorite) {
            add_to_wishlist(product_id, in_favorite);

        },

        add_to_cart_vue: function (product_id, type = -1) {

            $('.alert').addClass('hidden');

            let get_selected = pluck_('selected');
            let attribute_values = get_selected(type == -1 ? this.product_attributes : this.sub_products.find(el => el.id == product_id).attributes);

            let quantity = $('.get_quantity'+(product_id)).val();

            if (quantity <= 0) {
                $('.dan_alert').removeClass('hidden');
                $('.dan_alert').text("الرجاء اختيار الكمية اكبر من او يساوي 1");
                $("html, body").animate({ scrollTop: 0 }, "slow");
                return;
            };



            let check_all = attribute_values.every(function (t) {
                return t != 0 && t != "";
            });
            if (!check_all) {
                $('.dan_alert').removeClass('hidden');
                $('.dan_alert').text("الرجاء تحديد السمات");
                $("html, body").animate({ scrollTop: 0 }, "slow");
                return;
            };

            add_to_cart(product_id , quantity , attribute_values , true , false , 0);

        },

        add_to_compare:function (product_id) {
            let add_to_compare_id = '.add_to_compare_'+product_id;

            axios.post(get_url + "/compare-products", {
                product_id: product_id,
            }).then(function (res) {

                if (res.data['status']) {


                    $(add_to_compare_id).notify( res.data['success_msg'], { position:"top",className:'success' })
                    window.location = '/compare-products';


                } else {

                    $(add_to_compare_id).notify( res.data['success_msg'], { position:"top",className:'error' })



                }

            }).catch(function (err) {
            });
        },

        currentSlide : function (index) {
            currentSlide(index);
        },

        rate :function (product_id) {
        var rate =     $("input[name='rating']:checked").val();


            axios.get(get_url+"/products-rate" , {
                params : {
                    product_id : product_id,
                    rate : rate,
                }
            }).then(function (res) {

                if(res.data['status']) {


                    $('.suc_alert').removeClass('hidden');
                    $('.suc_alert').text(res.data['message']);
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    return;

                }else {

                    $('.dan_alert').removeClass('hidden');
                    $('.dan_alert').text(res.data['message']);
                    $("html, body").animate({ scrollTop: 0 }, "slow");
                    return;


                }


            }).catch(function (err) {
                $('.dan_alert').removeClass('hidden');
                $('.dan_alert').text(err.data['message']);
                $("html, body").animate({ scrollTop: 0 }, "slow");
                return;
            });

        }

    }
});

function add_image_to_pro_slider(main_image, images) {

     return;
  //  $('.woocommerce-product-gallery__wrapper').innerHTML = "";
  //  $('.woocommerce-product-gallery__wrapper').empty();
    $('.woocommerce-product-gallery__wrapper').append(get_sider_image(main_image));
    images.forEach(function (t) {
        $('.woocommerce-product-gallery__wrapper').append(get_sider_image(t));
    });

}

function get_sider_image(main_image) {

    return '<div data-thumb="' +
        main_image +
        '"' +
        'class="woocommerce-product-gallery__image"' +
        'style="width: 445px; float: left; display: block;"' +
        '>' +
        '<a href="' +
        main_image +
        '">' +
        '<img width="560" height="775"' +
        'src="' +
        main_image +
        '"' +
        'class="wp-post-image" alt="" data-caption=""' +
        'data-src="' +
        main_image +
        '"' +
        'data-large_image="' +
        main_image +
        '"' +
        'data-large_image_width="560" data-large_image_height="775"' +
        'sizes="(max-width: 560px) 100vw, 560px"' +
        'draggable="false"' +
        '/>' +
        '' +
        '</a>' +
        '</div>';
}

function update_ol_thumb_images(main_image, images) {

    return;
    $('.flex-control-nav').empty();
    $('.flex-control-nav').append('<li class="new-flex-control-nav"><img class="flex-active" src="' +
        main_image +
        '" ' +
        'draggable="false">' +
        '</li>');

    images.forEach(function (t) {
        $('.flex-control-nav').append('<li class="new-flex-control-nav"><img  src="' +
            t +
            '" ' +
            'draggable="false" >' +
            '</li>');
    });
    // $('.flex-control-nav li').each(function () {
    //     if(!$(this).hasClass('new-flex-control-nav')) {
    //         $(this).remove();
    //     }
    // });
}


var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
    showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("demo");
    var captionText = document.getElementById("caption");
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";
    dots[slideIndex-1].className += " active";
   // captionText.innerHTML = dots[slideIndex-1].alt;
}

