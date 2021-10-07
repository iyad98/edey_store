var vm = new Vue({
    el: '#app',
    data: {

        banner: {
            name_ar: '',
            name_en: '',

        },
       // parent_banners : parent_banners,
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
                        vm.add_banner();
                    } else {

                        vm.update_banner();
                    }

                }
            });
        },

        empty_banner: function () {
            this.add = true;
            var empty_banner = {
                name_ar: '',
                name_en: '',

            };

            this.banner = empty_banner;
        },
        edit_banner: function (data) {
            this.add = false;
            this.edit_id = data.id;
            this.banner.name_ar = data.name_ar;
            this.banner.name_en = data.name_en;


        },
        reset_validation: function () {
            vm.$validator.reset();
        },

        add_banner: function () {
            var formData = new FormData();
            this.banner.category_id = $('#m_select_category_form').val();
            this.banner.parent_id = $('#m_select_banner_form').val();
            this.loading = true;
            Object.keys(this.banner).forEach(function (key) {
                formData.append(key, vm.banner[key]);
            });


            axios.post(get_url + "/admin/banners/add", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);

                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {
                    vm.parent_banners = res.data['data']['banners'];

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
        update_banner: function () {
            var formData = new FormData();
            this.banner.category_id = $('#m_select_category_form').val();
            this.banner.parent_id = $('#m_select_banner_form').val();
            this.loading = true;
            Object.keys(this.banner).forEach(function (key) {
                formData.append(key, vm.banner[key]);
            });
            formData.append('id', this.edit_id);

            axios.post(get_url + "/admin/banners/update", formData).then(function (res) {
                vm.loading = false;
                var get_res = handle_response(res.data);
                scroll_to_div('.m-dropdown__wrapper');
                if (get_res) {

                    vm.parent_banners = res.data['data']['banners'];
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
        delete_banner : function (category) {

            axios.post(get_url + "/admin/banners/delete",
                {
                    id: category.id
                }
            ).then(function (res) {
                var get_res = handle_response(res.data);
                if (get_res) {
                    vm.parent_banners = res.data['data']['banners'];
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    table.ajax.reload();
                }

            }).catch(function (err) {
                vm.loading = false;
            });

        },
        change_status: function (banner) {

            axios.post(get_url + "/admin/banners/change-status",
                {
                    id: banner.id
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
                this.banner['image'] = file;
                read_url(event.target, selector);
            } else {
                this.banner['image'] = '';
            }

        }


    },
    watch: {

    }
});

$(document).ready(function () {

    // init

    $("#m_select_category_form").select2({placeholder: "اختار الصنف"});
    $("#m_select_category_form2").select2({placeholder: "اختار الصنف"});
    $("#m_select_category_form").change(function () {
        vm.banner.city_id = $(this).val();
    });
    $("#m_select_banner_form").select2({placeholder: "اختار السلايدر الرئيسي"});
    $("#m_select_banner_form2").select2({placeholder: "اختار السلايدر الرئيسي"});
    
    $('#m_select_banner_form').change(function () {
        let value = $(this).val();
        if(value == -1) {
            $('.show_select_category').addClass('hidden');
        }else {
            $('.show_select_category').removeClass('hidden');
        }
    });
    /////
    $('#add_new_banner').click(function () {
        $('.add_form').removeClass('hidden');
        $('.show_data').addClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        $('#m_select_banner_form').val($('#m_select_banner_form2').val()).trigger('change');
        vm.empty_banner();
        vm.reset_validation();
    });
    $('#cancel').click(function () {
        $('.add_form').addClass('hidden');
        $('.show_data').removeClass('hidden');
        $('.success_msg').addClass('hidden');
        $('.error_msg').addClass('hidden');
        vm.empty_banner();
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
        vm.edit_banner(row_data);
        $('#m_select_banner_form').val(row_data.parent_id ?row_data.parent_id : -1).trigger('change');
        $('#m_select_category_form').val(row_data.category_id).trigger('change');
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
                vm.delete_banner(table.row(row).data());
            } else {
                e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
            }

        });
    });
    table.on('change', '.change_status', function () {
        var row = $(this).closest('tr');
        if(row.attr('role') == undefined) {
            row = $(this).parent('tr'['role=row']);
        }

        vm.edit_row = row;
        row.find('.loading').removeClass('hidden');
        row.find('.get_status').addClass('hidden');
        vm.change_status(table.row(row).data());
    });
    table.on('click', '.show_children_banners', function () {
        var id = $(this).find('.banner_id_hidden').val();
        $('#m_select_banner_form2').val(id).trigger('change');
    });


});

