<template>
    <div>
        <div class="alert alert-success success_msg hidden" style="margin: 10px;">
            {{ success }}
        </div>
        <div class="alert alert-danger error_msg hidden" style="margin: 10px;">
            {{ error }}
        </div>
    </div>
</template>


<script>
    export default {
        props : ['success' , 'error'],
        data : function () {
            return {

            }
        },
        methods : {

        }
    }
</script>