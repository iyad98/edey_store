<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
    <div class="container" id="profile">
        <div class="row">
            <div class="col-12 col-md-4">
                <input type="text" v-model="user.first_name" placeholder="الاسم الأول">
            </div>
            <div class="col-12 col-md-4">
                <input type="text" v-model="user.last_name" placeholder="الاسم الثاني">
            </div>
            <div class="col-12 col-md-4">
                <input type="email" v-model="user.email" placeholder="البريد الالكتروني">
            </div>
            <div class="col-12 col-md-4">
                <input type="tel" v-model="user.phone" placeholder="رقم الجوال">
            </div>
        </div>

        <button class="btn save" @click="update_profile">حفظ التغييرات</button>

       <a href="{{LaravelLocalization::localizeUrl('website/logout')}}">
           <button class="btn save" >تسجيل الخروج</button>
       </a>

    </div>
</div>