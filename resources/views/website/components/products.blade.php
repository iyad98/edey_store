@include('website.components.product')

<template id="products-component">
    <div>
        <div class="container">
            <div class="row">
                <div :class="class_col" v-for="product in products">
                    <product-component :product="product"></product-component>
                </div>

            </div>
        </div>

    </div>

</template>

<script>

    var myComp = Vue.component('products-component', {
        template: '#products-component',
        props: ['products' , 'class_col'],
        data: function () {
            return {}
        },
        methods: {}
    });
</script>

