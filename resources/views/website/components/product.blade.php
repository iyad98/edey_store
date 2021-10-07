<template id="product-component">
    <div class="product-list">
        <!-- PRODUCT -->
        <div class="list-item">
        <!-- ACTIONS -->
            <div class="actions">
                <figure class="liquid">
                    <img :src="product.image" alt="product1">
                </figure>
            </div>
            <!-- /ACTIONS -->

            <!-- DESCRIPTION -->
            <div class="description">

                <div class="clearfix">
                    <a href="#"><h6 v-text="product.name"></h6></a>
                </div>
                <div class="clearfix prices">


                </div>
                <div class="clearfix">
                    <a href="#" class="addcart">أضف للسلة</a>
                </div>
            </div>
            <!-- /DESCRIPTION -->
        </div>
        <!-- /PRODUCT -->
    </div>
</template>

<script>
    var myComp = Vue.component('product-component', {
        template: '#product-component',
        props: ['product'],
        created: function () {
        },
        data: function () {
            return {
                add_to_cart_loading: false,
                remove_from_cart_loading: false,

            }
        },
        methods: {

            /*
            add_to_cart: function (product_id, quantity) {
                var self = this;
                var params = {
                    product_id: product_id,
                    quantity: quantity
                };

                this.add_to_cart_loading = true;
                axios.get(get_url + "wb-add-product-to-cart",
                    {
                        params: params
                    }
                ).then(function (res) {

                    self.add_to_cart_loading = false;
                    if (res.data['status']) {
                        self.product.cart_products_count = 1;
                        header.wish_list_count = res.data['data']['wish_list_count'];
                        header.cart_count = res.data['data']['cart_count'];
                        header.cart_price = res.data['data']['cart_price'];
                    }
                    handle_response(res.data, true, true, 'top-center');
                }).catch(function (err) {

                });
            },
            remove_from_cart: function (product_id) {
                var self = this;
                var params = {
                    product_id: product_id,
                };

                this.remove_from_cart_loading = true;
                axios.get(get_url + "wb-remove-product-from-cart",
                    {
                        params: params
                    }
                ).then(function (res) {

                    self.remove_from_cart_loading = false;
                    if (res.data['status']) {
                        self.product.cart_products_count = 0;
                        header.wish_list_count = res.data['data']['wish_list_count'];
                        header.cart_count = res.data['data']['cart_count'];
                        header.cart_price = res.data['data']['cart_price'];
                    }
                    handle_response(res.data, true, true, 'top-center');
                }).catch(function (err) {

                });
            }
            */
        }
    });
</script>