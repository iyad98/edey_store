
var contact = new Vue({
    el : '#details_page' ,
    data : {

        error_msg : '',
        success_msg : '' ,
        loading : false ,
        contact : {
            name : '' ,
            email : '' ,
            message : '' ,
            phone : '',

        }
    },
    created : function () {

    },
    methods : {


        send_contact : function () {

            let data = this.contact;
            data['web'] = 1;

            this.loading = true;
            axios.post(get_url+"/send-contact" ,data).then(function (res) {

                contact.loading = false;

                if(res.data['status']) {
                    contact.error_msg = "";
                    contact.success_msg = res.data['success_msg'];


                    $('.suc_alert').removeClass('hidden');
                    $('.dan_alert').addClass('hidden');

                    $('.suc_alert').text(res.data['success_msg']);


                    contact.contact = {
                        name : '' ,
                        email : '' ,
                        message : '' ,
                        phone : ''
                    }
                }else {

                    $('.dan_alert').removeClass('hidden');
                    $('.suc_alert').addClass('hidden');

                    $('.dan_alert').text(res.data['error_msg']);

                    contact.success_msg = "";
                }
                // $("html, body").animate({ scrollTop: 0 }, "slow");
            }).catch(function (err) {

            });
        },


    }
});

$(document).ready(function () {

});