
var bank_transfer = new Vue({
    el : '#bank_transfer' ,
    data : {

        order : order ,
        error_msg : '',
        success_msg : '' ,

        bank : {
            name : '' ,
            bank_id : '' ,
            account_number : '' ,
            order_id : order.id ,
            price : order.total_price,
            file : '',
        },
        loading : false,
    },
    created : function () {

    },
    methods : {


        send_bank_transfer : function () {

            this.bank.order_id = order.id;
            this.bank.price = order.total_price;
            var formData = new FormData();

            Object.keys(this.bank).forEach(function (key) {
                formData.append(key, bank_transfer.bank[key]);
            });
            formData.append('web', 1);

            this.show_loading();

            axios.post(get_source_url+"/api/user/send-bank-transfer" ,formData,{
                headers : {
                    'Accept-Language' : get_lang,
                }
            }).then(function (res) {
                bank_transfer.hide_loading();
                if(res.data['status']) {

                    $('.suc_alert').removeClass('hidden');
                    $('.suc_alert').text(res.data['message']);
                    $("html, body").animate({ scrollTop: 0 }, "slow");

                    bank_transfer.bank = {
                        name : '' ,
                        bank_id : '' ,
                        account_number : '' ,
                        order_id : '' ,
                        price : ''
                    }
                }else {

                    $('.dan_alert').removeClass('hidden');
                    $('.suc_alert').addClass('hidden');
                    $('.dan_alert').text(res.data['message']);
                    $("html, body").animate({ scrollTop: 0 }, "slow");


                }
                $("html, body").animate({ scrollTop: 0 }, "slow");
            }).catch(function (err) {

            });
        },
        show_loading : function () {
            this.loading = true;
        },
        hide_loading : function () {
            this.loading = false;
        },
        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.bank['file'] = file;
                // read_url(event.target, selector);
            } else {
                this.bank['file'] = '';
            }

        }
    }
});

$(document).ready(function () {
    $('.msg').removeClass('hidden');
});