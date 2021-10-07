<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
    <div class="container" id="shipping">
        <div class="head">
            معلومات المستلم
        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <input type="text" placeholder="الاسم الأول"  v-model="user_shipping.first_name"
                       name="billing_first_name"
                       id="billing_first_name"
                       autocomplete="given-name"
                >
            </div>
            <div class="col-12 col-md-4">
                <input type="text" placeholder="الاسم الثاني"
                       v-model="user_shipping.last_name"
                       name="billing_last_name"
                       id="billing_last_name"
                      autocomplete="family-name"

                >
            </div>
            <div class="col-12 col-md-4">
                <input type="email" placeholder="البريد الالكتروني"
                       v-model="user_shipping.email"
                       name="billing_email" id="billing_email"
                       autocomplete="email username"
                >
            </div>
            <div class="col-12 col-md-4">
                <input type="tel" placeholder="رقم الجوال"
                       v-model="user_shipping.phone"

                       name="billing_phone" id="billing_phone"
                        value="" autocomplete="tel"
                >
            </div>
        </div>
        <div class="head">
            معلومات الموقع وشركة الشحن
        </div>
        <div class="row">
            <div class="col-12 col-md-4">




                <select class="custom-select select_country" name="country" id="country" v-model="user_shipping.country" >
                    @foreach($countries as $country)
                        <option value="{{$country->iso2}}"  >{{$country->name}} </option>
                    @endforeach

                </select>
            </div>
            <div class="col-12 col-md-4">

                <select class="custom-select select_city" name="state"  v-model="user_shipping.city" id="state"
                >
                    <option value="">{{trans('website.choose_your_city')}}</option>
                </select>



            </div>
            <div class="col-12 col-md-4">
                <input type="text" placeholder="العنوان"  v-model="user_shipping.address"

                       name="billing_address_1"

                       autocomplete="address-line1">
            </div>
            <div class="col-12 col-md-4">
                <input type="text" placeholder="أقرب معلم (اختياري)"
                       v-model="user_shipping.state"
                      name="billing_state"
                       autocomplete="address-level1"
                >
            </div>
            <div class="col-12 col-md-4">
                <select class="custom-select select_shipping_company"  name="state" id="shipped" >
                    <option value="">{{trans('website.select_shipping_company')}}</option>

                </select>
            </div>
        </div>
        <button class="btn save" @click="update_shipping" >حفظ التغييرات</button>
    </div>
</div>
