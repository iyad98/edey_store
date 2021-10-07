<script type="text/x-handlebars-template" id="success_error_template">
   <div>
       <div class="alert alert-success success_msg hidden" style="margin: 10px;">
           @{{ success }}
       </div>
       <div class="alert alert-danger error_msg hidden" style="margin: 10px;">
           @{{ error }}
       </div>
   </div>
</script>



<script>
    Vue.component('success_error_template' ,{
        template: '#success_error_template',
        props : ['success' , 'error'],
        data : function () {
            return {

            }
        },
        methods : {

        }
    });
</script>