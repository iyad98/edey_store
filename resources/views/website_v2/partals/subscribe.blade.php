<div class="sec_block_subscribe" id="sec_block_subscribe">
    <div class="container">
        <div class="head_subscribe">
            <h2><img src="/website_v2/images/em.svg" alt="">اشترك بالقائمة البريدية</h2>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-lg-6 col-md-8">
                <div class="alert alert-danger dan_alert_mailing_list hidden" role="alert">

                </div>
                <div class="alert alert-success suc_alert_mailing_list hidden" role="alert ">

                </div>
                <form class="form_subscribe" action="#">
                    <input type="email" v-model="email" class="form-control" placeholder="بريدك الالكتروني ....">
                    <button type="button" @click="store_mailing_list" class="btn btn_subscribe">اشتراك</button>
                </form>
            </div>
        </div>
    </div>
</div>
