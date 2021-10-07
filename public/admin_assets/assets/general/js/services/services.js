var vm = new Vue({
    el: '#app',
    data: {

        attr_name: 'image',
        selector_id_image: 'image1',
        default_image: JSON.parse(JSON.stringify(default_image)),
        shock_event: '',

        services: {
            title_ar: '',
            title_en: '',
            description_ar:'',
            description_en:'',
            image: ''

        },

        msg: {
            success: '',
            error: ''
        },
        add: false,
        edit_id: '',
        loading: false,
        edit_row: '',


    },

    created: function () {

    },
    methods: {

        setData: function (add, data) {
            this.default_image = add ? JSON.parse(JSON.stringify(default_image)) : data.image;
            this.shock_event = makeid(32);
        },

        validateForm: function (event) {
            vm.$validator.validateAll().then(function (valid) {
                if (valid) {
                    if (vm.add) {
                        vm.add_services();
                    } else {

                        vm.update_services();
                    }

                }
            });
        },

        empty_services: function () {
            this.add = true;
            var empty_services = {
                title_ar: '',
                title_en: '',
                description_ar: '',
                description_en: '',
                image: ''
            };

            this.services = empty_services;
        },
        edit_services: function (data) {
            this.add = false;
            this.edit_id = data.id;
            this.services.title_ar = data.title_ar;
            this.services.title_en = data.title_en;
            this.services.description_ar = data.description_ar;
            this.services.description_en = data.description_en;
            this.services.image = data.image;

        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_services: function () {
            var formData = new FormData();

            this.loading = true;
            
            Object.keys(this.services).forEach(function (key) {
                formData.append(key, vm.services[key]);
            });
            
            axios.post(get_url + "/admin/services/add", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);

                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, 1200);
                    table.ajax.reload();
                    vm.$validator.reset();
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        update_services: function () {
            var formData = new FormData();

            this.loading = true;


            Object.keys(this.services).forEach(function (key) {
                formData.append(key, vm.services[key]);
            });
            formData.append('id', this.edit_id);

            axios.post(get_url + "/admin/services/update", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, time_to_hide_success_msg);

                    table.ajax.reload(null, false);
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        delete_services: function (category) {
            axios.post(get_url + "/admin/services/delete",
                {
                    id: category.id
                }
            ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    table.ajax.reload();
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
                this.services['image'] = file;
                read_url(event.target, selector);
            } else {
                this.services['image'] = '';
            }

        }


    },
    watch: {}
});

$(document).ready(function () {

    // init


    /////
    $('#add_new_services').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_services();
        vm.reset_validation();
        vm.setData(true, '');
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_services();
        vm.reset_validation();
    });

    table.on('click', '.edit', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        var row_data = table.row(row).data();
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.edit_services(row_data);
        vm.setData(false, row_data);
    });
    table.on('click', '.delete', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        vm.edit_row = row;
        swal({
            title: translations['sure_delete'],
            text: "",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: translations['yes_delete'],
            cancelButtonText: translations['no_delete'],
            reverseButtons: !0
        }).then(function (e) {
            if (e.value) {
                vm.delete_services(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });


});

