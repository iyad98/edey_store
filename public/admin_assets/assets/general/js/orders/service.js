
var order_vue = new Vue({
    el : '#order_vue' ,
    data : {

        order_ids : [],
        cities : [],
        loading : false ,
        search_loading : false,
    },
    methods : {
        execute_option : function () {
            
            let order_ids = this.order_ids;
            let option = $('#select_order_option').val();

            var formData = new FormData();
            formData.append('order_ids' , JSON.stringify(order_ids));
            formData.append('option' , option);

            this.loading = true;
            axios.post(get_url+"/admin/order/execute-option" ,formData).then(function (res) {

                order_vue.loading = false;
                if(res.data['status']) {
                    swal(res.data['data']['title'], res.data['success_msg'], "success");
                    order_vue.order_ids = [];
                    if (res.data['data']['type'] == -4){
                        window.open('/admin/order/print_multi?order_ids='+res.data['data']['order_ids'], '_blank');
                    }
                    table_order.ajax.reload();
                    $('#check_all').prop('checked', false);
                }else {
                    swal(res.data['data']['title'], res.data['error_msg'], "error");
                }

            }).catch(function (err) {
                order_vue.loading = false;
            });
        },
        search : function (e) {

            this.search_loading = true;

            let search_value = $('#searchValue').val();
            if( $('#select_search_type').val() == "1") {
                table_order.search(search_value).draw();
            }else {
                table_order.search("");
                table_order.ajax.reload();
            }
            
        },
        get_cities : function (country_id) {

            let country_code = countries.find(el => el.id == country_id ).iso2;
            $('#select_city').prop('disabled', true);
            axios.get(get_url + "/api/cities/" + country_code, {
                headers: {
                    'Accept-Language': 'ar'
                }
            }).then(function (res) {
                $('#select_city').prop('disabled', false);
                var cities = res.data['data'];

                order_vue.cities = cities;
                order_vue.$nextTick(function () {
                    $('#select_city').selectpicker('refresh');
                });

            }).catch(function (err) {
                $('#select_city').prop('disabled', false);
            });
        },
    }
});

$(document).ready(function () {
    $('#select_country').change(function () {

        order_vue.get_cities($(this).val());
    });
    $('.selectSearch').change(function () {
        table_order.search("");
        table_order.ajax.reload();
    });



});