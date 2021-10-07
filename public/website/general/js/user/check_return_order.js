var my_account = new Vue({
    el : '#my_account' ,
    data : {

        order : {
            id : '' ,
            phone : '' ,
        },
        loading : false ,

        success_msg : '' ,
        error_msg : '',

    },
    methods : {

        send : function () {
            var id = this.order.id;
            var phone = this.order.phone;

            this.loading = true;
            axios.post(get_url + "/check-return-order" , {
                id : id ,
                phone : phone
            } ).then(function (res) {

                if(res.data['status']) {
                    my_account.success_msg = res.data['message'];
                    my_account.error_msg = "";

                }else {
                    my_account.success_msg = "";
                    my_account.error_msg = res.data['message'];

                }
                scroll_to_div('.woocommerce');
                my_account.loading = false;


            }).catch(function (err) {
                my_account.loading = false;
            });
        } ,
    }
});

$(document).ready(function () {
    $('.woocommerce-error').removeClass('hidden');
    $('.woocommerce-info').removeClass('hidden');

});