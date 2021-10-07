<template>
    <div class="image-input image-input-outline mt-3">
        <div class="image-input-wrapper">
            <img  :id="selector_id_image" style="width: 150px;height: 150px" :src="check_image(default_image) ? default_image : ''"/>

            <video :id="'vid-'+selector_id_image"
                   width="200" height="150" controls>
                <source class="source1" :src="!check_image(default_image) ? default_image : '' " type="video/mp4">
                <source class="source2" :src="!check_image(default_image) ? default_image : '' "  type="video/ogg">
            </video>
        </div>
        <span  data-action="cancel" data-toggle="tooltip" title="" style="display: block!important;"
               data-original-title="Cancel avatar"
               class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow">
            <i @click="setDefaultImage" class="fa fa-window-close" style="font-size: 22px;margin-top: -14%"></i>
        </span>

    </div>
</template>

<script>
    export default {
        props : ['attr_name','selector_id_image','default_image' , 'shock_event' , 'obj'],
        data : function () {
            return {}
        },
        created : function () {
            this.setImage();
        },
        methods : {
            setDefaultImage : function () {
                this.setImage();
                this.$emit('clear-emit-file' , this.obj ,this.attr_name);
            },
            setImage : function () {
                if(this.check_image(this.default_image)) {
                    $('#'+this.selector_id_image).prop('src' , this.default_image);
                    $('#'+this.selector_id_image).removeClass('hidden');
                    $('#vid-'+this.selector_id_image).addClass('hidden');
                }else {
                    var vid = document.getElementById('vid-'+this.selector_id_image);
                    if(vid) {
                        vid.src = this.default_image;
                        vid.load();
                    }
                    
                    $('#'+this.selector_id_image).addClass('hidden');
                    $('#vid-'+this.selector_id_image).removeClass('hidden');
                }
            },

        },
        watch : {
            shock_event : function () {
                this.setImage();
            }
        }
    }
</script>