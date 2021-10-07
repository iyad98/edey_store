<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Excel;
use App\Exports\OrderExport;
use App\Imports\UsersImport;

use App\Models\Company;
use App\Models\MedicineType;
use App\Models\EffectiveMaterial;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;

use Carbon\Carbon;

class TestController extends Controller
{
    public function __construct()
    {

    }

    public function test1()
    {
        $orders = Order::leftJoin('payment_methods' , 'payment_methods.id' , '=','orders.payment_method_id' )
            ->FinishedOrder()
            ->select('orders.id','payment_methods.name_ar' ,'total_price')->get();

        $orders = $orders->map(function ($value){
            $value->AAA = "AAAAAAAA";
            return $value;
        });

        return Excel::download(new OrderExport($orders), 'oders.xlsx');
        $date1 = Carbon::parse('2019-08-01 11:00:00');
        $date2 = Carbon::parse('2019-10-05 01:00:00');
        $num_of_weeks = $date1->diffInWeeks($date2);
        $weeks = [];
        for ($i=0 ; $i < $num_of_weeks ; $i++) {

            $from =  $date1->format('Y-m-d h:i:s');
            $to =  $date1->addWeek()->format('Y-m-d h:i:s');
            $weeks[] = ['start_at' => $from , 'end_at' =>  $to ];
        }
        return $weeks;

     //   return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function test2()
    {
        return view('tests.import');
    }

    public function test3()
    {
        $a = Excel::toArray(new UsersImport, request()->file('file'));
        $products = $a[0];
        $data_ =[];
        /*
        foreach ($products as $product) {
            if($product['id']) {
                $effective_materials = explode( ",", $product['efficitva_materials']);
                $effective_materials_ = [];
                foreach ($effective_materials as $effective_material) {
                    $qwe = explode(":" ,trim($effective_material));
                    $effective_materials_[EffectiveMaterial::where('name_en' , '=' , $qwe[0])->first()->id] = ['value' =>$qwe[1] ];
                }

                // category

                $categories = explode( ",", $product['uses']);
                $categories_ = [];
                foreach ($categories as $category) {

                    $categories_[] = Category::where('name_ar' , '=' ,trim($category) )->first()->id;
                }
                $categories_ = array_unique($categories_);
                $data['product_number'] = $product['id'];
                $data['name_en'] = $product['english_name'];
                $data['name_ar'] = $product['arabic_name'];
                $data['num_of_units'] = $product['number_of_unit'];
                $data['efficitva_materials'] =$effective_materials_;
                $data['categories'] =$categories_;
                $data['weight'] = $product['weight'];
                $data['price'] = $product['price'];
                $data['image'] = get_default_image();
                $data['company_id'] = Company::where('name_en' , '=' , $product['company_name'] )->first()->id;
                $data['medicine_type_id'] = MedicineType::where('name_en' , '=' , $product['english_small_unit'] )->first()->id;
                $data['description_en'] = "no";
                $data['description_ar'] = "no";
                $data['quantity'] = 1000;
                $data['is_stripe'] = MedicineType::where('name_en' , '=' , $product['english_small_unit'] )->first()->is_stripe;
                $data['price'] = $product['price'] ;
                $data['weight'] = $product['weight'] ;
                $data['active_constituent'] = 0 ;

                // add product
                $add = Product::create([
                    'product_number' => $data['product_number'] ,
                    'name_en' => $data['name_en'],
                    'name_ar' => $data['name_ar'],
                    'description_en' => $data['description_en'],
                    'description_ar' => $data['description_ar'],
                    'category_id' => 1,
                    'company_id' => $data['company_id'],
                    'quantity' => $data['quantity'],
                    'image' => get_default_image(),
                    'price' => $data['price'],
                    'old_price' => 0,
                    'weight' => $data['weight'],
                    'active_constituent' => "ss",
                    'medicine_type_id' => $data['medicine_type_id'],
                    'num_of_units' => $data['num_of_units'],
                    'is_stripe' => $data['is_stripe'],

                ]);
                $add->categories()->sync($data['categories']);
                $add->effective_materials()->sync($effective_materials_);
            }
            $data_[] = $data;


        }
        */
        foreach ($products as $product) {
            if($product['id']) {
                $effective_materials = explode( ",", $product['efficitva_materials']);
                $effective_materials_ = [];
                foreach ($effective_materials as $effective_material) {
                    $effective_material_from_excel = explode(":" ,trim($effective_material));
                    $get_effective_material = EffectiveMaterial::where('name_en' , '=' , $effective_material_from_excel[0]);

                    if($get_effective_material->exists()) {
                        $effective_material_id = $get_effective_material->first()->id;
                    }else {
                        $effective_material_id = EffectiveMaterial::create([
                            'name_en' =>$effective_material_from_excel[0] ,
                            'name_ar' => $effective_material_from_excel[0]
                        ])->id;

                    }

                    $effective_materials_[$effective_material_id] = ['value' =>$effective_material_from_excel[1] ];
                }

                // category

                $categories = explode( ",", $product['uses']);
                $categories_ = [];
                foreach ($categories as $category) {

                    $get_category =Category::where('name_ar' , '=' ,trim($category) );
                    if($get_category->exists()) {
                        $categories_[] = $get_category->first()->id;
                    }

                }
                $categories_ = array_unique($categories_);

                // company
                $get_company_from_excel = Company::where('name_en' , '=' , $product['company_name'] );
                if($get_company_from_excel->exists()) {
                    $company_id = $get_company_from_excel->first()->id;
                }else {
                    $company_id = Company::create([
                        'name_en' => $product['company_name'],
                        'name_ar' => $product['company_name'] ,
                        'type' => strtolower($product['company_type']) == "local" ? 1 : 2
                    ])->id;
                }

                // MedicineType
                $get_medicine_type_from_excel = MedicineType::where('name_en' , '=' , $product['english_small_unit'] );
                if($get_medicine_type_from_excel->exists()) {
                    $medicine_type = $get_medicine_type_from_excel->first();
                }else {
                    $medicine_type = MedicineType::create([
                        'name_en' => $product['english_small_unit'],
                        'name_ar' => $product['english_small_unit'],
                        'is_stripe' => 1
                    ]);
                }
                $data['product_number'] = $product['id'];
                $data['name_en'] = $product['english_name'];
                $data['name_ar'] = $product['arabic_name'];
                $data['num_of_units'] = $product['number_of_unit'];
                $data['efficitva_materials'] =$effective_materials_;
                $data['categories'] =$categories_;
                $data['weight'] = $product['weight'];
                $data['price'] = $product['price'];
                $data['image'] = get_default_image();
                $data['company_id'] = $company_id;
                $data['medicine_type_id'] = $medicine_type->id;
                $data['description_en'] = "no";
                $data['description_ar'] = "no";
                $data['quantity'] = 1000;
                $data['is_stripe'] = $medicine_type->is_stripe;
                $data['price'] = $product['price'] ;
                $data['weight'] = $product['weight'] ;
                $data['active_constituent'] = 0 ;


                // add product

                $data_[] = $data;


                $add = Product::create([
                    'product_number' => $data['product_number'] ,
                    'name_en' => $data['name_en'],
                    'name_ar' => $data['name_ar'] ? $data['name_ar'] : "",
                    'description_en' => $data['description_en'],
                    'description_ar' => $data['description_ar'],
                    'category_id' => 1,
                    'company_id' => $data['company_id'],
                    'quantity' => $data['quantity'],
                    'image' => get_default_image(),
                    'price' => $data['price'],
                    'old_price' => 0,
                    'weight' => $data['weight'],
                    'active_constituent' => "ss",
                    'medicine_type_id' => $data['medicine_type_id'],
                    'num_of_units' => $data['num_of_units'],
                    'is_stripe' => $data['is_stripe'],

                ]);
                $add->categories()->sync($data['categories']);
                $add->effective_materials()->sync($data['efficitva_materials']);


            }
        }
        return response()->json($data_);
    }
    

}
