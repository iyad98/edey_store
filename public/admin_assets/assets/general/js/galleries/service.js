var vm = new Vue({
    el: '#app',
    data : {
        default_image: JSON.parse(JSON.stringify(default_image)),
        types : types ,
        add: true,
        data: '',
        shock_event: '',
    },
    methods : {
        setDefaultImage(image) {
            this.default_image = image == '' ? JSON.parse(JSON.stringify(default_image)) : image;

        },
        setData: function (add, data, image) {
            vm.setDefaultImage(image);
            vm.add = add;
            vm.data = data;
            vm.shock_event = makeid(32);
        },
        editGallery : function (image) {
            this.setData(false ,image , image.src );
            $('#galleryImageForm').modal('show');
        },
        delete: function (data) {
            let this_ = this;


            axios.delete(get_url+"/admin/galleries" + "/" + data.id).then(function (res) {
                if (res.data.status) {
                    swal(translations['success_delete'], translations['done_delete'], "success");
                    this_.$root.$emit('delete-gallery-event' , data);
                }else {
                    swal("خطأ", res.data['error_msg'], "error");
                }

            }).catch(function (err) {
                console.log(err);
                vm.loading = false;
            });

        },
        deleteGallery : function (image) {
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
                    vm.delete(image);
                } else {
                    e.dismiss && swal(translations['cancelled_delete'], translations['didnt_delete'], "error")
                }

            });
        },
    }
});

$(document).ready(function () {
    $('.add-button').on('click', function () {
        vm.setData(true, '', '');
        $('#galleryImageForm').modal('show');
    });
});