<?php

use Illuminate\Database\Seeder;

use App\Moels\Admin;
use App\Models\Permission;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::truncate();
        $keys_1 = [

            ['key' => 'users', 'parents' => 'المستخدمين'],
            ['key' => 'categories', 'parents' => 'التصنيفات'],
            ['key' => 'attributes', 'parents' => 'السمات'],
            ['key' => 'brands', 'parents' => 'الماركات'],
            ['key' => 'cities', 'parents' => 'المدن'],
            ['key' => 'banks', 'parents' => 'البنوك'],
            ['key' => 'banners', 'parents' => 'البانر'],
            ['key' => 'slider_app', 'parents' => 'سلايدر التطبيق'],
            ['key' => 'coupons', 'parents' => 'الكوبونات'],
            ['key' => 'packages', 'parents' => 'الباقات'],
            ['key' => 'products', 'parents' => 'المنتجات'],
            ['key' => 'shipping_companies', 'parents' => 'شركات الشحن'],
        ];
        $keys_2 = [
            ['key' => 'orders', 'parents' => 'الطلبات'],
            ['key' => 'reports', 'parents' => 'التقارير'],
            ['key' => 'settings', 'parents' => 'الاعدادات'],
            ['key' => 'advertisements', 'parents' => 'اعلانات التطبيق'],
            ['key' => 'app_category', 'parents' => 'الاصناف في التطبيق'],
            ['key' => 'order_transfer', 'parents' => 'الحوالات البنكية'],

        ];

        $permissions = [];

        foreach ($keys_1 as $key_1) {
            $index = 1;
            $permissions[] =
                [
                    'key' => "view_" . $key_1['key'],
                    'name_ar' => 'عرض',
                    'name_en' => 'view',
                    'parent_ar' => $key_1['parents'],
                    'parent_en' => $key_1['parents'],
                    'order' => $index++,
                    'status' => 1
                ];

            $permissions[] = [
                'key' => "add_" . $key_1['key'],
                'name_ar' => 'إضافة',
                'name_en' => 'add',
                'parent_ar' => $key_1['parents'],
                'parent_en' => $key_1['parents'],
                'order' => $index++,
                'status' => 1
            ];

            $permissions[] = [
                'key' => "edit_" . $key_1['key'],
                'name_ar' => 'تعديل',
                'name_en' => 'edit',
                'parent_ar' => $key_1['parents'],
                'parent_en' => $key_1['parents'],
                'order' => $index++,
                'status' => 1
            ];
            $permissions[] = [
                'key' => "delete_" . $key_1['key'],
                'name_ar' => 'حذف',
                'name_en' => 'delete',
                'parent_ar' => $key_1['parents'],
                'parent_en' => $key_1['parents'],
                'order' => $index++,
                'status' => 1

            ];
        }

        $permissions[] = [
            'key' => "view_orders",
            'name_ar' => 'عرض',
            'name_en' => 'view',
            'parent_ar' => "الطلبات",
            'parent_en' => "الطلبات",
            'order' => 1,
            'status' => 1
        ];


        $permissions[] = [
            'key' => "view_order_transfer",
            'name_ar' => 'تحكم',
            'name_en' => 'control',
            'parent_ar' => "الحوالات البنكية",
            'parent_en' => "الحوالات البنكية",
            'order' => 1,
            'status' => 1
        ];
        // settings
        $permissions[] = [
            'key' => "view_settings",
            'name_ar' => 'تحكم',
            'name_en' => 'control',
            'parent_ar' => "الاعدادات",
            'parent_en' => "الاعدادات",
            'order' => 1,
            'status' => 1
        ];


        $permissions[] = [
            'key' => "view_advertisements",
            'name_ar' => 'تحكم',
            'name_en' => 'control',
            'parent_ar' => "اعلانات التطبيق",
            'parent_en' => "اعلانات التطبيق",
            'order' => 1,
            'status' => 1
        ];

        $permissions[] = [
            'key' => "view_app_category",
            'name_ar' => 'تحكم',
            'name_en' => 'control',
            'parent_ar' => "الاصناف في التطبيق",
            'parent_en' => "الاصناف في التطبيق",
            'order' => 1,
            'status' => 1
        ];


        $permissions[] = [
            'key' => "store_statistics",
            'name_ar' => 'تقارير المتجر',
            'name_en' => 'Store Statistics',
            'parent_ar' => "التقارير",
            'parent_en' => "التقارير",
            'order' => 1,
            'status' => 1
        ];
        $permissions[] = [
            'key' => "store_bill",
            'name_ar' => 'فواتير المتجر',
            'name_en' => 'Store Bill',
            'parent_ar' => "التقارير",
            'parent_en' => "التقارير",
            'order' => 2,
            'status' => 1
        ];
        $permissions[] = [
            'key' => "invoice",
            'name_ar' => 'فواتير المبيعات',
            'name_en' => 'invoice',
            'parent_ar' => "التقارير",
            'parent_en' => "التقارير",
            'order' => 1,
            'status' => 1
        ];
        $permissions[] = [
            'key' => "invoice2",
            'name_ar' => 'فواتير المبيعات2',
            'name_en' => 'invoice2',
            'parent_ar' => "التقارير",
            'parent_en' => "التقارير",
            'order' => 3,
            'status' => 1
        ];
        $permissions[] = [
            'key' => "coupon",
            'name_ar' => 'احصائيات القسائم',
            'name_en' => 'coupon',
            'parent_ar' => "التقارير",
            'parent_en' => "التقارير",
            'order' => 4,
            'status' => 1
        ];

        Permission::insert($permissions);
    }
}
