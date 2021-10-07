var vm = new Vue({
    el: '#app',
    data: {

        store: {
            phone : '',
            name_en: '',
            name_ar: '',
            address_en : '' ,
            address_ar : '' ,
            lat : '' ,
            lng : '' ,
            image: '',

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
                        vm.add_store();
                    } else {

                        vm.update_store();
                    }

                }
            });
        },

        empty_store: function () {
            this.add = true;
            var empty_store = {
                phone : '',
                name_en: '',
                name_ar: '',
                address_en : '' ,
                address_ar : '' ,
                lat : '' ,
                lng : '' ,
                image: '',


            };
            this.store = empty_store;

        },
        edit_store: function (store) {
            this.add = false;
            this.edit_id = store.id;
            this.store.phone = store.phone;
            this.store.name_en = store.name_en;
            this.store.name_ar = store.name_ar;
            this.store.address_en = store.address_en;
            this.store.address_ar = store.address_ar;
            this.store.lat = store.lat;
            this.store.lng = store.lng;
            this.store.image = store.image;

        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_store: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.store).forEach(function (key) {
                formData.append(key, vm.store[key]);
            });
            formData.append('city_id' , $("#m_select_city_form").val());

            axios.post(get_url + "/admin/stores", formData).then(function (res) {
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
        update_store: function () {
            var formData = new FormData();

            this.loading = true;
            Object.keys(this.store).forEach(function (key) {
                formData.append(key, vm.store[key]);
            });
            formData.append('id', this.edit_id);
            formData.append('_method', "PUT");
            formData.append('city_id' , $("#m_select_city_form").val());


            axios.post(get_url + "/admin/stores/"+this.edit_id, formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    setTimeout(function () {
                        $('.add_form').addClass('hidden');
                        $('.show_data').removeClass('hidden');
                    }, time_to_hide_success_msg);

                    table.ajax.reload();
                }
            }).catch(function (err) {
                vm.loading = false;
            });


        },
        delete_store: function (store) {
            axios.delete(get_url + "/admin/stores/"+store.id,
                {
                    id: store.id
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
        change_status: function (user) {

            axios.post(get_url + "/admin/stores/changeStatus",
                {
                    id: user.id
                }
            ).then(function (res) {
                table.ajax.reload();
            }).catch(function (err) {
                vm.loading = false;
            });

        },
        get_file: function (event, selector) {
            var file = event.target.files[0];
            if (file) {
                this.store['image'] = file;
                read_url(event.target, selector);
            } else {
                this.store['image'] = '';
            }

        },


    },
    watch: {

    }
});

$(document).ready(function () {

    // init
    $("#m_select_city_form").select2({placeholder: "اختار المدينة"});

    $('#add_new_store').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        $("#m_select_city_form").val('').trigger('chnage');
        vm.empty_store();
        vm.reset_validation();
        get_current_location();
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_store();
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

        var uluru = {lat:row_data.lat, lng: row_data.lng};
        marker.setPosition(uluru);
        map.setCenter(uluru);

        vm.edit_store(row_data);
        $("#m_select_city_form").val(row_data.city_id).trigger('change');

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
                vm.delete_store(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });
    table.on('click', '.change_status', function () {
        var row = $(this).closest('tr');
        if(row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }
        vm.edit_row = row;
        row.find('.loading').removeClass('hidden');
        row.find('.get_status').addClass('hidden');
        vm.change_status(table.row(row).data());

    });


});

