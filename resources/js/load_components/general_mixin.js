module.exports = {
    data: function () {
        return {
            msg: {
                success: '',
                error: ''
            },
            loading: false,
        }
    },
    methods: {
        /**
         * Translate the given key.
         */


        show_loading: function () {
            this.loading = true;
        },
        hide_loading: function () {
            this.loading = false;
        },

        ///////////////// image  ////////////////////////
        getEmitFile: function (file, attr_name) {
            this.obj_data[attr_name] = file;
            this.obj_data['name_ar'] = file.name;
            this.obj_data['name_en'] = file.name;
            $('.get_file_name').val(file.name);
        },
        getAdvanceEmitFile: function (obj, file, attr_name) {
            this.$data[obj][attr_name] = file.file != null ? file.file : file.id;
        },
        getAdvanceEmitMultiFile : function (obj, file, attr_name) {
            let this_=  this;
            if(obj != "") {
                let index = this.attribute_value_variations.indexOf(obj);
                file.forEach(function (t) {
                    this_.attribute_value_variations[index].product_variation[attr_name].push(t);
                });
            }else {
                file.forEach(function (t) {
                    this_.$data[attr_name].push(t);
                });
            }
        },
        clearEmitFile: function (obj, attr_name) {
            this.$data[obj][attr_name] = null;
        },
        SelectImageFromGallery: function (attr_name, selector_id_image) {
            this.attr_name = attr_name;
            this.selector_id_image = selector_id_image;
            $('#GalleryImages').modal('show');
        },
        SelectMultiImageFromGallery: function (obj ,attr_name, selector_id_image) {
            this.obj = obj;
            this.attr_name = attr_name;
            this.selector_id_image = selector_id_image;
            this.shock_multi_image_event = makeid(32);
            $('#MultiGalleryImages').modal('show');
        },
        pluck: function (array, key) {
            return array.map(function (obj) {
                return obj[key];
            });
        },
        check_image : function (file) {
            return ['png','jpg','jpeg','gif'].includes(file.split('.').pop());
        },
        /////////////////////////////////////////////////

        blockUI: function (attr) {
            mApp.block(attr, {})
        },
        UnblockUI: function (attr) {
            mApp.unblock(attr)
        }
    },
}