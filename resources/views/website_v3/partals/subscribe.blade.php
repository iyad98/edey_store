<div class="subscribe" id="sec_block_subscribe">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="join">
                    <i class="far fa-envelope"></i>
                    <h3>اشترك بالقائمة البريدية</h3>
                </div>
                <div class="sub_p">
                    <p>اشترك في النشرة البريدية لدينا للحصول على آخر تحديثات المنتجات</p>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="mb-3">
                    <form class="form_subscribe" action="#">
                        <input type="email" v-model="email" class="form-control" placeholder="بريدك الالكتروني ....">
                        <button type="button" @click="store_mailing_list" class="btn btn_subscribe" id="button-addon1">
                            اشتراك
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="alert alert-danger dan_alert_mailing_list hidden" role="alert">
            </div>
            <div class="alert alert-success suc_alert_mailing_list hidden" role="alert ">
            </div>
        </div>
    </div>
</div>
