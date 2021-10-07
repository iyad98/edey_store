var my_account = new Vue({
    el : '#my_account' ,
    data : {

        login : {
            email : '' ,
            password : '' ,
        },
        register : {
            first_name : '' ,
            last_name : '' ,
            email : '' ,
            password : '' ,
            'password_confirmation':'',
        },
        email_forget_password :'',

        login_loading : false ,
        register_loading : false ,

        success_msg : '' ,
        error_msg : '',

    },
    methods : {

        login_user : function () {

            var email = this.login.email;
            var password = this.login.password;

            this.login_loading = true;
            axios.post(get_url + "/website/login" , {
                email : email ,
                password : password
            } ).then(function (res) {

                if(res.data['status']) {

                    $('.dan_alert').addClass('hidden');
                    $('.suc_alert').removeClass('hidden');
                    $('.suc_alert').text(res.data['success_msg']);
                    $("html, body").animate({ scrollTop: 0 }, "slow");

                    setTimeout(function () {
                        window.location = "/";
                    } , 1000);

                }else {

                    $('.dan_alert').removeClass('hidden');
                    $('.suc_alert').addClass('hidden');
                    $('.dan_alert').text(res.data['error_msg']);
                    $("html, body").animate({ scrollTop: 0 }, "slow");

                }

                my_account.login_loading = false;


            }).catch(function (err) {
                my_account.login_loading = false;
            });
        } ,
        register_user : function () {

            var is_accept_terms = $('#accept_terms').prop('checked');

            if (is_accept_terms){
                var first_name = this.register.first_name;
                var last_name = this.register.last_name;
                var email = this.register.email;
                var password = this.register.password;
                var password_confirmation = this.register.password_confirmation;



                this.register_loading = true;
                axios.post(get_url + "/website/register" , {
                    first_name : first_name ,
                    last_name : last_name ,
                    email : email ,
                    password : password,
                    password_confirmation : password_confirmation
                } ).then(function (res) {

                    if(res.data['status']) {

                        $('.dan_alert').addClass('hidden');
                        $('.suc_alert').removeClass('hidden');
                        $('.suc_alert').text(res.data['success_msg']);
                        scroll_to_div('#my_account');


                        setTimeout(function () {
                            window.location = "/";
                        } , 1000);

                    }else {
                        $('.dan_alert').removeClass('hidden');
                        $('.suc_alert').addClass('hidden');
                        $('.dan_alert').text(res.data['error_msg']);

                    }
                    scroll_to_div('#my_account');
                    my_account.register_loading = false;


                }).catch(function (err) {
                    my_account.register_loading = false;
                });
            }else {
                $('.dan_alert').removeClass('hidden');
                $('.suc_alert').addClass('hidden');
                $('.dan_alert').text("يجب الموافقة على شروط وأحكام الكويتية ستور");

                scroll_to_div('#my_account');
            }

        },
        send_email_for_forget_passeord(){
            $('#send_email_loader').removeClass('hidden')
            $('.send_email').prop('disabled' , true);
            var email = this.email_forget_password;
            this.login_loading = true;
            axios.post("/password/email" , {
                email : email ,

            } ).then(function (res) {
                $('.dan_alert1').addClass('hidden');
                $('.suc_alert1').removeClass('hidden');
                $('.suc_alert1').text('تم ارسال ايميل تغيير كلمة المرور بنجاح');

                $('#send_email_loader').addClass('hidden')
                $('.send_email').prop('disabled' , false);



            }).catch(function (err) {
                $('.dan_alert1').removeClass('hidden');
                $('.suc_alert1').addClass('hidden');
                $('.dan_alert1').text('الرجاء التاكد من الايميل المدخل');

                $('#send_email_loader').addClass('hidden')
                $('.send_email').prop('disabled' , false);



            });
        }
    }
});

$(document).ready(function () {



});