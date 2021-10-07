var profile = new Vue({
    el: '#order_el',
    data: {

        cancel_reasons : '-1',



        ticket_title : '',
        ticket_email : '',
        ticket_description : '',
        ticket_files :[],
    },
    created : function () {

    },
    methods: {

        order_cancel_api : function () {
            $('.spinner_ccancel_order').removeClass('hidden')
            $('.order_cancel').prop('disabled' , true);

            let data = {
                cancel_reasons : this.cancel_reasons,
                order_id : $('#get_order_id_hidden').val()
            };
            axios.post(get_url+"/cancel-order" , data).then(function (res) {

                if(res.data['status'] === true) {

                    $('.suc_alert1').removeClass('hidden');
                    $('.suc_alert1').text(res.data['message']);
                    $('.dan_alert1').addClass('hidden');

                    setInterval(function(){ $('#order_cancel').modal('hide'); }, 1000);

                    $('#order_cancel_div').addClass('hidden');
                    $('.tr_collapse').addClass('hidden');
                    $('.spinner_ccancel_order').addClass('hidden')
                    $('.order_cancel').prop('disabled' , false);




                }else {
                    $('.dan_alert1').removeClass('hidden');
                    $('.suc_alert1').addClass('hidden');
                    $('.dan_alert1').text(res.data['message']);
                    $('.spinner_ccancel_order').addClass('hidden')
                    $('.order_cancel').prop('disabled' , false);


                }




            }).catch(function (err) {
                $('.dan_alert1').removeClass('hidden');
                $('.suc_alert1').addClass('hidden');
                $('.dan_alert1').text(res.data['message']);
                $('.spinner_ccancel_order').addClass('hidden')
            });
        },

        send_ticket :function () {


            $('#add_ticket_loader').removeClass('hidden')
            $('.add_ticket').prop('disabled' , true);



            var formData = new FormData();
            formData.append('ticket_title', this.ticket_title);
            formData.append('ticket_email', this.ticket_email);
            formData.append('ticket_description', this.ticket_description);
            // formData.append('ticket_files', this.ticket_files);

            $.each(  this.ticket_files, function( key, value ) {
                formData.append('ticket_files[' + key + ']', value);
            });
            formData.append('ticket_order_id', $('#ticket_order_id').val());
            axios.post(get_url+"/ticket-order" , formData,{
            headers: {
                'Content-Type': 'multipart/form-data;',
            }
        }).then(function (res) {

                if(res.data['status'] === true) {


                    $('.suc_alert').removeClass('hidden');
                    $('.suc_alert').text(res.data['message']);
                    $('.dan_alert').addClass('hidden');
                    $(".box_file_upload p").html('صورة من الحوالة');
                    profile.ticket_title = '';
                    profile.ticket_email = '';
                    profile.ticket_description = '';
                    profile.ticket_files = [];
                    $('.dz-complete').remove();


                }else {
                    $('.dan_alert').removeClass('hidden');
                    $('.suc_alert').addClass('hidden');
                    $('.dan_alert').text(res.data['message']);
                }

                $('#add_ticket_loader').addClass('hidden')
                $('.add_ticket').prop('disabled' , false);



            }).catch(function (err) {
                $('.dan_alert').removeClass('hidden');
                $('.suc_alert').addClass('hidden');
                $('.dan_alert').text(res.data['message']);
                $('#add_ticket_loader').addClass('hidden')
                $('.add_ticket').prop('disabled' , false);
            });


        },
        onFileChange(e) {
            for (let file of e.target.files) {
                try {
                    this.ticket_files.push(file) ;
                } catch {}
            }



        }
    }
});
$(document).ready(function () {



});