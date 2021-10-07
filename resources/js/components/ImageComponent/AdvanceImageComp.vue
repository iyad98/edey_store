<template>
    <div class="image-input image-input-outline" >
        <input class="mt-3" type="file" @change="getFile($event , '#'+selector_id_image)" name="profile_avatar">
        <div class="image-input-wrapper mt-3">
            <img :id="selector_id_image" style="width: 50%;height: 50%" :src="selected_image"/>
        </div>
        <!--<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change"-->
        <!--data-toggle="tooltip" title="" data-original-title="">-->
        <!--<i class="fa fa-pen icon-sm text-muted"></i>-->
        <!---->
        <!--</label>-->
        <!--<span @click="setDefaultImage" data-action="cancel" data-toggle="tooltip" title="" style="display: block!important;"-->
        <!--data-original-title=""-->
        <!--class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow">-->
        <!--<i class="fa fa-window-close" style="font-size: 22px;margin-top: -105%;margin-left: -31%;"></i>-->
        <!--</span>-->

    </div>
</template>


<script>
    export default {

        props: ['attr_name','original_image', 'shock_event', 'default_image', 'selector_id_image', 'image_name'],
        data: function () {
            return {
                selected_image: '',
            }
        },
        created: function () {
            this.setImage();
        },

        methods: {
            getFile: function (event, selector) {
                var file = event.target.files[0];
                if (file) {
                    read_url(event.target, selector);
                    this.$emit('getEmitFile', file , this.attr_name);
                }
            },
            setImage: function () {
                this.selected_image = this.original_image != '' ? JSON.parse(JSON.stringify(this.original_image)) : this.default_image;
                $('#'+this.selector_id_image).prop('src' ,this.selected_image);
            },
            setDefaultImage : function () {
                this.setImage();
                this.$emit('getEmitFile' , null , this.attr_name);
            }
        },
        watch: {
            shock_event: function (value) {
                this.setImage();
            },

        }
    }
</script>