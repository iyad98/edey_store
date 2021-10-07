var profile = new Vue({
    el: '#profile',
    data: {

        user: {
            first_name: user.first_name,
            last_name: user.last_name,
            email : user.email,
            phone : user.phone,
            old_password : '',
            password : '' ,
            password_confirmation : ''
        },
        loading : false ,
        success_msg: '',
        error_msg: '',

    },
    created : function () {
        // console.log(this.user);
    },
    methods: {
        update_profile : function () {
            var data = this.user;

            this.loading = true;
            axios.post(get_url+"/update-profile" , data).then(function (res) {

                if(res.data['status']) {


                    $('.suc_alert').removeClass('hidden');
                    $('.dan_alert').addClass('hidden');
                    $('.suc_alert').text(res.data['message']);

                    profile.user.password = "";
                    profile.user.old_password = "";
                    profile.user.password_confirmation = "";

                }else {


                    $('.dan_alert').removeClass('hidden');
                    $('.suc_alert').addClass('hidden');
                    $('.dan_alert').text(res.data['message']);

                }
                scroll_to_div('.send-form-page');
                profile.loading = false;

            }).catch(function (err) {

            });
        }
    }
});

$(document).ready(function () {


    $('.woocommerce-error').removeClass('hidden');
    $('.woocommerce-info').removeClass('hidden');

});