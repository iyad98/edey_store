var vm = new Vue({
    el: '#app',
    data: {

        offer: {
            name_en: '',
            name_ar: '',
            image: '',
            discount_rate : '' ,

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


        validateForm: function (event) {
            vm.$validator.validateAll().then(function (valid) {
                if (valid) {
                    if (vm.add) {
                        vm.add_offer();
                    } else {

                        vm.update_offer();
                    }

                }
            });
        },

        empty_offer: function () {
            this.add = true;
            var empty_offer = {
                name_en: '',
                name_ar: '',
                image: '',
                discount_rate : '' ,


            };

        },
        edit_offer: function (offer) {
            this.add = false;
            this.edit_id = offer.id;
            this.offer.name_en = offer.name_en;
            this.offer.name_ar = offer.name_ar;
            this.offer.discount_rate = offer.discount_rate;
            this.offer.image = offer.image;

        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_offer: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.offer).forEach(function (key) {
                formData.append(key, vm.offer[key]);
            });


            axios.post(get_url + "/admin/offers/add", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);

                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, 1200);
                    table_offer.ajax.reload();
                    vm.$validator.reset();
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        update_offer: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.offer).forEach(function (key) {
                formData.append(key, vm.offer[key]);
            });
            formData.append('id', this.edit_id);

            axios.post(get_url + "/admin/offers/update", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, time_to_hide_success_msg);

                    table_offer.ajax.reload();
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        delete_offer: function (category) {
            axios.post(get_url + "/admin/offers/delete",
                {
                    id: category.id
                }
            ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    table_offer.ajax.reload();
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },
        change_status: function (user) {

            axios.post(get_url + "/admin/offers/changeStatus",
                {
                    id: user.id
                }
            ).then(function (res) {
                table_offer.ajax.reload();
            }).catch(function (err) {
                vm.loading = false;
            });

        },
        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.offer['image'] = file;
                read_url(event.target, selector);
            } else {
                this.offer['image'] = '';
            }

        },


    },
    watch: {

    }
});

$(document).ready(function () {

    // init

    $('#add_new_offer').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_offer();
        vm.reset_validation();
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_offer();
        vm.reset_validation();
    });

    table_offer.on('click', '.edit', function () {
        var row = $(this).closest('tr');
        if (row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        var row_data = table_offer.row(row).data();
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');

        vm.edit_offer(row_data);
    });
    table_offer.on('click', '.delete', function () {
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
                vm.delete_offer(table_offer.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });
    table_offer.on('click', '.change_status', function () {
        var row = $(this).closest('tr');
        if(row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        vm.edit_row = row;
        row.find('.loading').removeClass('hidden');
        row.find('.get_status').addClass('hidden');
        vm.change_status(table_offer.row(row).data());

    });


});

