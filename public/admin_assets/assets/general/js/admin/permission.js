var vm = new Vue({
    el: '#app',
    data: {

        loading: false,
        control_status_loading: false,
        msg: {
            success: '',
            error: ''
        },
        control_status_msg: {
            success: '',
            error: ''
        },
        order_statuses: order_statuses,
        admin_order_statuses: admin_order_statuses,
    },
    methods: {
        update_permissions: function () {
            var checked = [];
            $('.ch_').each(function () {
                if ($(this).is(":checked")) {
                    checked.push($(this).val());
                }
            });

            var admin_id = $('#admin_id').val();
            var permissions = JSON.stringify(checked);
            this.loading = true;
            axios.post(get_url + "/admin/update-permissions", {
                admin_id: admin_id,
                permissions: permissions
            }).then(function (res) {

                var get_res = handle_response(res.data);
                scroll_to_div('.m-portlet__head');
                vm.loading = false;

            }).catch(function (err) {

            });
        },

        // admin order status
        add_status_to_order_status: function () {
            let order_status_from = $('input[name="order_status_from"]:checked').val();
            let order_status_to   = $('input[name="order_status_to"]:checked').val();
            if(order_status_from == order_status_to) {
                alert("لا يمكنك اضافة نفس الحالات");
                return;
            }

            let check_admin_order_status_exists = this.admin_order_statuses.find(el => el.index == order_status_from+"-"+order_status_to);
            if(!check_admin_order_status_exists) {
                this.admin_order_statuses.push({
                    key : order_status_from+"-"+order_status_to,
                    from : order_status_from ,
                    to   : order_status_to ,
                    text : this.order_statuses[order_status_from] + " - "+ this.order_statuses[order_status_to]
                });
            }
        },
        delete_order_status : function (index) {
            this.admin_order_statuses.splice(index , 1);
        },
        show_control_order_status: function () {
            $('#control_order_status').modal('show');
        },
        add_order_status: function () {

            this.control_status_loading = true;
            var admin_id = $('#admin_id').val();
            let data = JSON.stringify(this.admin_order_statuses);
            axios.post(get_url+"/admin/update-admin-order-status" , {admin_id : admin_id ,order_statuses : data}).then(function (res) {
                if(res.data['status'] ) {
                    $('.success_msg').removeClass('hidden');
                    $('.error_msg').addClass('hidden');
                    vm.control_status_msg.success = res.data['success_msg'];
                    vm.control_status_msg.error = "";
                }else {
                    $('.success_msg').addClass('hidden');
                    $('.error_msg').removeClass('hidden');
                    vm.control_status_msg.success = "";
                    vm.control_status_msg.error = res.data['error_msg'];
                }
                $('#control_order_status').animate({ scrollTop: 0 }, 'slow');
                vm.control_status_loading = false;
            }).catch(function (err) {
                vm.control_status_loading = false;
            });
        },
    }
});


function check_all() {

}

$(document).ready(function () {
    //set initial state.

    $('.btn-ch').click(function () {
        if ($(this).find('input').is(":checked")) {
            $(this).find('input').prop('checked', false);
        } else {
            $(this).find('input').prop('checked', true);
        }
        $('.ch_').change();


    });
    $('.btn-ch-all').click(function () {
        if ($(this).find('input').is(":checked")) {
            $(this).find('input').prop('checked', false);
        } else {
            $(this).find('input').prop('checked', true);
        }
        $('#ch_all').change();
    });

    /*********************** check if check all ************************/
    var parent_count = 0;
    var count_ = 0;
    $('.ch_').each(function () {
        parent_count++;
        if ($(this).is(":checked")) {
            count_++;
        }
    });
    if (parent_count != count_) {
        $('#ch_all').prop('checked', false);
    } else {
        $('#ch_all').prop('checked', true);
    }

    /******************************************/
    $('.ch_').change(function () {
        var count = 0;

        $('.ch_').each(function () {
            if ($(this).is(":checked")) {
                count++;
            }
        });

        if (parent_count != count) {
            $('#ch_all').prop('checked', false);
        } else {
            $('#ch_all').prop('checked', true);
        }


    });

    $('#ch_all').change(function () {

        if ($(this).is(":checked")) {
            $('.ch_').each(function () {
                $(this).prop("checked", true);
            });

        } else {
            $('.ch_').each(function () {
                $(this).prop("checked", false);
            });
        }

    });
});
