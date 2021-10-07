var vm = new Vue({
    el: '#app',
    data: {

        user: {
            name: '',
            username: '',
            password: '',
            email: '',
            image: '',
            role : 1 ,
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
                name: '',
                username: '',
                password: '',
                email: '',
                phone: '',
                image: '',
                role : 1,
            };
            this.user = empty_user;
        },
        edit_user: function (user) {
            this.add = false;
            this.edit_id = user.admin_id;
            this.user.name = user.admin_name;
            this.user.username = user.admin_username;
            this.user.email = user.admin_email;
            this.user.phone = user.admin_phone;
            this.user.image = user.admin_image;
            this.user.role = 1;

           // $('#select_role').val(this.user.role);
          //  $('#select_role').selectpicker('refresh');

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

            axios.post(get_url + "/admin/admins/add", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {
                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_users').removeClass('hidden');
                    }, 700);
                    table_admin.ajax.reload();
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
            axios.post(get_url + "/admin/admins/update", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {
                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_users').removeClass('hidden');
                    }, 700);
                    table_admin.ajax.reload();

                }
            }).catch(function (err) {
                vm.loading = false;
            });

        },
        change_status: function (user) {

            axios.post(get_url + "/admin/admins/changeStatus",
                {
                    id: user.admin_id
                }
            ).then(function (res) {
              //  table_admin.row(vm.edit_row).data(res.data['data']);
                table_admin.ajax.reload();
            }).catch(function (err) {
                vm.loading = false;
            });

        },
        delete_user: function (user) {
            axios.post(get_url + "/admin/admins/delete",
                {
                    id: user.admin_id
                }
            ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    table_admin.ajax.reload();
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

    table_admin.on('click', '.edit', function () {
        var row = $(this).closest('tr');
        if(row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        $('.add_form').removeClass('hidden');
        $('.show_users').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');

        vm.edit_user(table_admin.row(row).data());

    });
    table_admin.on('click', '.change_status', function () {
        var row = $(this).closest('tr');
        if(row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        vm.edit_row = row;
        row.find('.loading').removeClass('hidden');
        row.find('.get_status').addClass('hidden');
        vm.change_status(table_admin.row(row).data());
    });
    table_admin.on('click', '.delete', function () {
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
                vm.delete_user(table_admin.row(row).data());
            }else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });

});

