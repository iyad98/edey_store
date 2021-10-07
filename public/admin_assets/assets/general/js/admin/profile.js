var vm = new Vue({
    el: '#app',
    data: {

        user: {
            name: '',
            username: '',
            password: '',
            email: '',
            image: '',
        },

        user_password : {
          new_password : '',
          re_new_password : ''
        },
        msg: {
            success: '',
            error: ''
        },
        loading: false,
    },

    created : function () {
        this.edit_user(current_admin);
    },
    methods: {


        reset_validation: function () {
            vm.$validator.reset();
        },
        update_user: function () {

            var formData = new FormData();
            this.loading = true;
            Object.keys(this.user).forEach(function (key) {
                formData.append(key, vm.user[key]);
            });
            axios.post(get_url + "/admin/profile/update", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-subheader');
                setTimeout(function () {
                    hide_success_message('.success_msg');

                } , 2000);
            }).catch(function (err) {
                vm.loading = false;
            });

        },
        edit_user: function (user) {
            this.user.name = user.admin_name;
            this.user.username = user.admin_username;
            this.user.email = user.admin_email;
            this.user.phone = user.admin_phone;
            this.user.image = user.admin_image;
        },
        change_password : function () {
            var formData = new FormData();
            this.loading = true;
            Object.keys(this.user_password).forEach(function (key) {
                formData.append(key, vm.user_password[key]);
            });
            axios.post(get_url + "/admin/profile/changePassword", formData).then(function (res) {
                vm.loading = false;
                var get_res = general_handle_response(res.data , '.success_msg2' , '.error_msg2');
                scroll_to_div('.m-subheader');
                setTimeout(function () {
                    hide_success_message('.success_msg2');
                    vm.empty_user_password();
                } , 2000);
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

        },
        empty_user_password : function () {
            this.user_password = {
                new_password : '',
                re_new_password : ''
            };
        }

    }
});