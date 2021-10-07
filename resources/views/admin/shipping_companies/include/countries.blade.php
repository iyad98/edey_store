<div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">  عرض الدول :
                    @{{ shipping_company.name_ar }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">


                <div class="row">
                    <div class="col-sm-12">
                        <table class="table">
                            <tr>
                                <th>الدولة</th>
                                <th>اعدادات المدن</th>
                            </tr>

                            <tr v-for="country in select_countries">
                                <td v-text="country.name"></td>
                                <td>
                                    {{-- country.shipping_company_country_id--}}
                                    <a :href="'{{url('admin/shipping-company-cities')}}/'+(country.shipping_company_country_id)"
                                       class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Cities">
                                        <i class="fa fa-cogs"></i>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>


