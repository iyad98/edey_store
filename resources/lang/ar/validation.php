<?php

return [

    /*
      |--------------------------------------------------------------------------
      | Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | The following language lines contain the default error messages used by
      | the validator class. Some of these rules have multiple versions such
      | as the size rules. Feel free to tweak each of these messages here.
      |
     */
    'source_id_required' => 'الرجاء تحديد مصدر الحدث',
    'applicant_subscription_required' => 'الرجاء كتابة رقم الاشتراك',
    'description_required' => 'الرجاء كتابة وصف الحدث',
    'accepted' => 'يجب قبول الحقل :attribute',
    'active_url' => 'الحقل :attribute لا يُمثّل رابطًا صحيحًا',
    'after' => 'يجب على الحقل :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal' => 'الحقل :attribute يجب أن يكون تاريخاً لاحقاً أو مطابقاً للتاريخ :date.',
    'alpha' => 'يجب أن لا يحتوي الحقل :attribute سوى على حروف',
    'alpha_dash' => 'يجب أن لا يحتوي الحقل :attribute على حروف، أرقام ومطّات.',
    'alpha_num' => 'يجب أن يحتوي :attribute على حروفٍ وأرقامٍ فقط',
    'array' => 'يجب أن يكون الحقل :attribute ًمصفوفة',
    'before' => 'يجب على الحقل :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal' => 'الحقل :attribute يجب أن يكون تاريخا سابقا أو مطابقا للتاريخ :date',
    'between' => [
        'numeric' => 'يجب أن تكون قيمة :attribute بين :min و :max.',
        'file' => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'string' => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max',
        'array' => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max',
    ],
    'boolean' => 'يجب أن تكون قيمة الحقل :attribute إما true أو false ',
    'confirmed' => 'حقل التأكيد غير مُطابق للحقل :attribute',
    'date' => 'الحقل :attribute ليس تاريخًا صحيحًا',
    'date_format' => 'لا يتوافق الحقل :attribute مع الشكل :format.',
    'different' => 'يجب أن يكون الحقلان :attribute و :other مُختلفان',
    'digits' => 'يجب أن يحتوي الحقل :attribute على :digits رقمًا/أرقام',
    'digits_between' => 'يجب أن يحتوي الحقل :attribute بين :min و :max رقمًا/أرقام ',
    'dimensions' => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'للحقل :attribute قيمة مُكرّرة.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح البُنية',
    'exists' => 'الحقل :attribute غير موجود',
    'file' => 'الـ :attribute يجب أن يكون من ملفا.',
    'filled' => 'الحقل :attribute إجباري',
    'image' => 'يجب أن يكون الحقل :attribute صورةً',
    'in' => 'الحقل :attribute لاغٍ',
    'in_array' => 'الحقل :attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون الحقل :attribute عددًا صحيحًا',
    'ip' => 'يجب أن يكون الحقل :attribute عنوان IP ذا بُنية صحيحة',
    'ipv4' => 'يجب أن يكون الحقل :attribute عنوان IPv4 ذا بنية صحيحة.',
    'ipv6' => 'يجب أن يكون الحقل :attribute عنوان IPv6 ذا بنية صحيحة.',
    'json' => 'يجب أن يكون الحقل :attribute نصا من نوع JSON.',
    'max' => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute مساوية أو أصغر لـ :max.',
        'file' => 'يجب أن لا يتجاوز حجم الملف :attribute :max كيلوبايت',
        'string' => 'يجب أن لا يتجاوز طول النّص :attribute :max حروفٍ/حرفًا',
        'array' => 'يجب أن لا يحتوي الحقل :attribute على أكثر من :max عناصر/عنصر.',
    ],
    'mimes' => 'يجب أن يكون الحقل ملفًا من نوع : :values.',
    'mimetypes' => 'يجب أن يكون الحقل ملفًا من نوع : :values.',
    'min' => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute مساوية أو أكبر لـ :min.',
        'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت',
        'string' => 'يجب أن يكون طول النص :attribute على الأقل :min حروفٍ/حرفًا',
        'array' => 'يجب أن يحتوي الحقل :attribute على الأقل على :min عُنصرًا/عناصر',
    ],
    'not_in' => 'الحقل :attribute لاغٍ',
    'numeric' => 'يجب على الحقل :attribute أن يكون رقمًا',
    'present' => 'يجب تقديم الحقل :attribute',
    'regex' => 'صيغة الحقل :attribute .غير صحيحة',
    'required' => 'حقل :attribute مطلوب.',
    'required_if' => 'الحقل :attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_unless' => 'الحقل :attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with' => 'الحقل :attribute إذا توفّر :values.',
    'required_with_all' => 'الحقل :attribute إذا توفّر :values.',
    'required_without' => 'الحقل :attribute إذا لم يتوفّر :values.',
    'required_without_all' => 'الحقل :attribute إذا لم يتوفّر :values.',
    'same' => 'يجب أن يتطابق الحقل :attribute مع :other',
    'size' => [
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute مساوية لـ :size',
        'file' => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت',
        'string' => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالظبط',
        'array' => 'يجب أن يحتوي الحقل :attribute على :size عنصرٍ/عناصر بالظبط',
    ],
    'string' => 'يجب أن يكون الحقل :attribute نصآ.',
    'timezone' => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا',
    'unique' => ' :attribute مسجل بالفعل',
    'uploaded' => 'فشل في تحميل الـ :attribute',
    'url' => 'صيغة الرابط :attribute غير صحيحة',

    // custom
    'medicine_not_found' => 'الدواء غير موجود',
    'location_not_found' => 'المكان غير موجود',
    'no_auth' => 'ليس لك الصلاحية',
    'old_password_wrong' => 'كلمة المرور القديمة خاطئة',
    'num_of_units_validation' => 'عدد الوحدات يجب ان يكون اكبر من او يساوي 1',
    'effective_materail_validation' => 'الرجاء ملئ حقول المادة الفعالة بالشكل الصحيح',
    'effective_materail_value_validation' => 'الرجاء ملئ حقول قيمة المادة الفعالة كارقام فقط',
    'effective_materail_duplicate' => 'الرجاء عدم تكرار اختيار المادة الفعالة',
    'shipping_price_from' => 'الرجاء التأكد من قيم رانج اسعار الشحن',
    'shipping_price_to' => 'الرجاء التأكد من رانج اسعار الشحن',
    'shipping_price_type' => 'الرجاء التأكد من اختيار نوع اسعار الشحن',
    'shipping_price' => 'الرجاء التأكد من قيم اسعار الشحن',
    'shipping_cities' => 'الرجاء اختيار المدن لشركة الشحن',
    'shipping_cash' => 'الرجاء ادخال قيمة الكاش بشكل صحيح',
    'duplicate_coupon_products' => 'يوجد منتجات مشتركة بين المنتجات والمنتجات المستبعدة',
    'duplicate_coupon_categories' => 'يوجد تصنيفات مشتركة بين التصنيفات والتصنيفات المستبعدة',
    'validate_attributes' => 'الرجاء التأكد من ادخال حقول السمات بشكل صحيح',
    'must_have_variation' => 'المنتج متعدد الانواع , الرجاء اضافة نوع واحد على الاقل',
    'variations_must_have_in_attributes' => 'الانواع يجب انت تكون جميعها من السمات المختارة',
    'password_confirmation_error' => 'كلمة المرور الجديدة لا تتطابق مع تأكيد كملة المرور',
    'duplicate_coupon_is_automatic' => 'عذرا , يوجد كوبون تلقائي ( :coupon ) يشمل المنتجات والاصناف',

    'external_url_required' => 'الحقل الرابط الخارجي مطلوب',
    'category_required' => 'الحقل القسم مطلوب',
    'product_required' => 'الحقل المنتج مطلوب',



    /*
      |--------------------------------------------------------------------------
      | Custom Validation Language Lines
      |--------------------------------------------------------------------------
      |
      | Here you may specify custom validation messages for attributes using the
      | convention "attribute.rule" to name the lines. This makes it quick to
      | specify a specific custom language line for a given attribute rule.
      |
     */
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    /*
      |--------------------------------------------------------------------------
      | Custom Validation Attributes
      |--------------------------------------------------------------------------
      |
      | The following language lines are used to swap attribute place-holders
      | with something more reader friendly such as E-Mail Address instead
      | of "email". This simply helps us make messages a little cleaner.
      |
     */
    'attributes' => [
        'name' => 'الاسم',
        'username' => 'اسم المُستخدم',
        'email' => 'البريد الإلكتروني',
        'first_name' => 'الاسم',
        'last_name' => 'اسم العائلة',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'city' => 'المدينة',
        'country' => 'الدولة',
        'address' => 'العنوان',
        'phone1' => 'الهاتف',
        'owner_name' => 'اسم المالك',
        'customer_name' => 'اسم الزبون',
        'project_date' => 'تاريخ العقد',
        'location' => 'الموقع',
        'project_num' => 'رقم المشروع',
        'order_date' => 'تاريخ الطلبية',
        'order_type' => 'نوع الطلبية',
        'hour' => 'ساعة',
        'minute' => 'دقيقة',
        'second' => 'ثانية',
        'title' => 'العنوان',
        'content' => 'المُحتوى',
        'description' => 'الوصف',
        'excerpt' => 'المُلخص',
        'date' => 'التاريخ',
        'time' => 'الوقت',
        'available' => 'مُتاح',
        'size' => 'الحجم',
        'mobile' => 'الجوال',
        'phone' => 'رقم الموبايل',
        'role' => 'الصلاحية',
        'social_type' => 'نوع التسجيل',
        'social_unique_id' => 'رقم السوشال ميديا',
        'category_id' => 'الصنف',
        'medicine_type' => 'نوع الدواء',
        'company_id' => 'الشركة المنتجة',
        'lat' => 'المكان',
        'lng' => 'المكان',
        'discount_rate' => 'نسبة الخصم',
        'start_at' => 'تاريخ البداية',
        'end_at' => 'تاريخ النهايو',
        'code' => 'الكود',
        'num_used' => 'عدد مرات الاستخدام',
        'product_number' => 'رقم المنتج',
        'cash_value' => 'الدفع عند الاستلام',
        'min_price' => 'الحد الادنى للسعر',
        'max_used' => 'الحد الاقصى للاستخدام',
        'value' => 'القيمة',
        'name_ar' => 'الاسم بالعربي',
        'name_en' => 'الاسم بالانجليزي',
        'description_ar' => 'الوصف بالعربي',
        'description_en' => 'الوصف بالعربي',
        'regular_price' => 'السعر',
        'discount_price' => 'سعر التخفيض',
        'tax_status_id' => 'حالة الضريبة',
        'min_quantity' => 'الحد الادنى للكمية',
        'max_quantity' => 'الحد الاعلى للكمية',
        'sku' => 'رمز المخزون',
        'stock_status_id' => 'حالة المخزون',
        'stock_quantity' => 'كمية المخزون',
        'remain_product_count_in_low_stock' => 'منخفض المخزون',
        'weight' => 'الوزن',
        'length' => 'الطول',
        'width' => 'العرض',
        'height' => 'الارتفاع',
        'categories' => 'التصنيفات',
        'payment_method' => 'طريقة الدفع',
        'billing_national_address' => 'الرقم الوطني',
        'billing_building_number' => 'رقم المبنى',
        'billing_postalcode_number' => 'الرقم البريدي',
        'billing_unit_number' => 'رقم الوحدة',
        'billing_extra_number' => 'الرقم الاضافي',
        'product_id' => 'المنتج',
        'account_number' => 'رقم الحساب',
        'user_famous_rate' => 'نسبة المشهور',
        'price' => 'السعر',
        'order_id' => 'رقم الطلب',
        'bank_id' => 'البنك',

        'cash_note' => 'نص الدفع عند الاستلام',
        'bank_note' => 'نص الحوالة البنكية',
        'visa_note' => 'نص الدفع الالكتروني',

        'price_from' => 'السعر من',
        'price_to' => 'السعر الى',
        'packages' => 'الباقات',
        'package' => 'الباقة',
        'new_package' => 'باقة جديدة',
        'edit_package' => 'تعديل بيانات الباقة',
        'num_of_points' => 'عدد النقاط',

        'full_name' => 'الاسم كاملا',
        'old_password' =>'كلمة المرور القديمة',
        'new_password' =>'كلمة المرور الجديدة',

        'file_must_image_pdf' => 'الملف يجب ان يكون صورة او pdf',

        'shipping_company_id' => 'شركة الشحن',
        'payment_method_id' => 'طريقة الدفع',

        'invoice_number' =>'رقم الفاتورة',

        'gift_first_name' => 'الاسم الاول للمهدى اليه',
        'gift_last_name' => 'الاسم الاخير للمهدى اليه',
        'gift_target_phone' => 'رقم جوال المهدى اليه',
        'gift_target_email' => 'ايميل المهدى اليه',
        'card_name'=>'اسم حامل البطاقة',
        'card_number'=>'رقم البطاقة',
        'card_month'=>'تاريخ انتهاء البطاقة',
        'card_year'=>'تاريخ انتهاء البطاقة',
        'card_cvv'=>'ال cvv',
        'ticket_title'=>'عنوان المشكلة',
        'ticket_email'=>'البريد الالكتروني ',
        'ticket_description'=>'تفاصيل المشكلة ',
        'state'=>'القطعه',
        'street'=>'الشارع',
        'avenue'=>'الجادة',
        'user_shipping_id'=>'العنوان',
        'ticket_files'=>'الصور'


    ],
    'email.unique' => 'البريد الإلكتروني مسجل بالفعل',

];
