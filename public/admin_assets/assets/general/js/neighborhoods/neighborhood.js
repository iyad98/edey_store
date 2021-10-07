var vm = new Vue({
    el: '#app',
    data: {

        neighborhood: {
            name_ar: '',
            name_en: '',
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
                        vm.add_neighborhood();
                    } else {

                        vm.update_neighborhood();
                    }

                }
            });
        },

        empty_neighborhood: function () {
            this.add = true;
            var empty_neighborhood = {
                name_ar: '',
                name_en: '',
            };

            this.neighborhood = empty_neighborhood;
        },
        edit_neighborhood: function (data) {
            this.add = false;
            this.edit_id = data.id;
            this.neighborhood.name_ar = data.name_ar;
            this.neighborhood.name_en = data.name_en;
            this.neighborhood.city_id = data.city_id;


        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_neighborhood: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.neighborhood).forEach(function (key) {
                formData.append(key, vm.neighborhood[key]);
            });


            axios.post(get_url + "/admin/neighborhoods/add", formData).then(function (res) {
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
        update_neighborhood: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.neighborhood).forEach(function (key) {
                formData.append(key, vm.neighborhood[key]);
            });
            formData.append('id', this.edit_id);

            axios.post(get_url + "/admin/neighborhoods/update", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, time_to_hide_success_msg);

                    table.ajax.reload(null , false);
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        delete_neighborhood : function (category) {
            axios.post(get_url + "/admin/neighborhoods/delete",
                {
                    id: category.id
                }
            ).then(function (res) {

                var get_res = handle_response(res.data);
                if (get_res) {
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    table.ajax.reload();
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },
        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.neighborhood['image'] = file;
                read_url(event.target, selector);
            } else {
                this.neighborhood['image'] = '';
            }

        }


    },
    watch: {

    }
});

$(document).ready(function () {

    // init

    $("#m_select_city_form").select2({placeholder: "Select a city"});
    $("#m_select_city_form2").select2({placeholder: "Select a city"});
    $("#m_select_city_form").change(function () {
        vm.neighborhood.city_id = $(this).val();
    });

    /////
    $('#add_new_neighborhood').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_neighborhood();
        vm.reset_validation();
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_neighborhood();
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
        vm.edit_neighborhood(row_data);
        $('#m_select_city_form').val(row_data.city_id).trigger('change');
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
                vm.delete_neighborhood(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });



});

