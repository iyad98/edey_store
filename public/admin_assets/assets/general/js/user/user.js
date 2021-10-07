var vm = new Vue({
    el: '#app',
    data: {

        user: {
            first_name: '',
            last_name: '',
            password: '',
            phone: '',
            email: '',
            image: '',
        },

        msg: {
            success: '',
            error: ''
        },
        add: false,
        edit_id: '',
        loading: false,
        edit_row : '',
    },

    methods: {


        validateForm: function (event) {
            vm.$validator.validateAll().then(function (valid) {

                if (valid) {
                    if (vm.add) {
                        vm.add_user();
                    } else {
                        vm.update_user();
                    }

                }
            });
        },

        empty_user: function () {
            this.add = true;
            var empty_user = {
                f_name: '',
                l_name: '',
                password: '',
                email: '',
                phone: '',
                image: '',
            };
            this.user = empty_user;
        },
        edit_user: function (user) {
            this.add = false;
            this.edit_id = user.id;
            this.user.first_name = user.first_name;
            this.user.last_name = user.last_name;
            this.user.email = user.email;
            this.user.phone = user.phone;
            this.user.image = user.image;

        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_user: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.user).forEach(function (key) {
                formData.append(key, vm.user[key]);
            });

            axios.post(get_url + "/admin/users/add", formData).then(function (res) {

                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {
                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_users').removeClass('hidden');
                    }, 700);
                    table_user.ajax.reload();
                    vm.$validator.reset();
                }
            }).catch(function (err) {
                vm.loading = false;
            });

        },
        update_user: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.user).forEach(function (key) {
                formData.append(key, vm.user[key]);
            });
            formData.append('id', this.edit_id);
            axios.post(get_url + "/admin/users/update", formData).then(function (res) {

                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {
                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_users').removeClass('hidden');
                    }, time_to_hide_success_msg);
                    table_user.ajax.reload();

                }
            }).catch(function (err) {
                vm.loading = false;
            });

        },
        change_status: function (user) {

            axios.post(get_url + "/admin/users/changeStatus",
                {
                    id: user.id
                }
            ).then(function (res) {
               // table_user.row(vm.edit_row).data(res.data['data']);
                table_user.ajax.reload();
            }).catch(function (err) {
                vm.loading = false;
            });

        },
        delete_user: function (user) {
            axios.post(get_url + "/admin/users/delete",
                {
                    id: user.id
                }
            ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    table_user.ajax.reload();
                }else {
                    swal("خطأ", res.data['error_msg'], "error");
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },
        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.user['image'] = file;
                read_url(event.target, selector);
            } else {
                this.user['image'] = '';
            }

        }
    }
});

$(document).ready(function () {

    $('#add_new_user').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_users').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_user();
        vm.reset_validation();
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_users').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_user();
        vm.reset_validation();
    });

    table_user.on('click', '.edit', function () {
        var row = $(this).closest('tr');
        if(row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        $('.add_form').removeClass('hidden');
        $('.show_users').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');


        vm.edit_user(table_user.row(row).data());
    });
    table_user.on('click', '.change_status', function () {
        var row = $(this).closest('tr');
        if(row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        vm.edit_row = row;
        row.find('.loading').removeClass('hidden');
        row.find('.get_status').addClass('hidden');
        vm.change_status(table_user.row(row).data());

    });
    table_user.on('click', '.delete', function () {
        var row = $(this).closest('tr');
        if(row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        vm.edit_row = row;
        swal({
            title: translations['sure_delete'],
            text: "",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: translations['yes_delete'],
            cancelButtonText:translations['no_delete'],
            reverseButtons: !0
        }).then(function (e) {
            if(e.value) {
                vm.delete_user(table_user.row(row).data());
            }else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });

});

