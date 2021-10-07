<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/*  Models */

use App\Models\FilterData;
use App\Models\CouponCategory;
use App\Models\City;
use App\Models\CouponType;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Category;
use App\Models\CouponProduct;

/* service */

use App\Services\StoreFile;
use App\Services\Firestore;
use DB;

use Illuminate\Validation\Rule;

use Carbon\Carbon;
use App\Services\SWWWTreeTraversal;

class CouponController extends HomeController
{


    public function __construct()
    {
        $this->middleware('check_role:view_coupons|add_coupons|edit_coupons|delete_coupons', ['only' => ['index']]);
        $this->middleware('check_role:add_coupons', ['only' => ['store' ]]);
        $this->middleware('check_role:edit_coupons', ['only' => ['update' ]]);
        $this->middleware('check_role:delete_coupons', ['only' => ['delete' ]]);

        parent::__construct();
        parent::$data['route_name'] = trans('admin.coupons');
        parent::$data['route_uri'] = route('admin.coupons.index');
        parent::$data['active_menu'] = 'coupons';

    }


    public function index()
    {


        $coupon_types = CouponType::Active()->get();

        parent::$data['coupon_types'] = $coupon_types;
        return view('admin.coupons.index', parent::$data);
    }

    public function store(Request $request)
    {


        $rules = [
            'coupon' => [
                'required',
                Rule::unique('coupons', 'coupon')->whereNull('deleted_at')
            ],
            'value' => [
                'required', 'numeric'

            ],
            'min_price' => [
                'required', 'numeric'
            ],
            'max_used' => [
                'required', 'integer'
            ],
            'start_at' => 'required',
            'end_at' => 'required',
            'type' => ['required', 'integer'],
            'user_famous_id' => [
                'sometimes', 'nullable', Rule::exists('users', 'id')->whereNull('deleted_at')
            ],
        ];

        if ($request->filled('user_famous_id')) {
            $rules['user_famous_rate'] = ['required', 'numeric', 'gt:0'];
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {

            $coupon = $request->coupon;
            $value = $request->value;
            $min_price = $request->min_price;
            $max_used = $request->max_used;
            $start_at = Carbon::createFromFormat("Y-m-d h:i A", $request->start_at);
            $end_at = Carbon::createFromFormat("Y-m-d h:i A", $request->end_at);
            $type = $request->type;
            $is_automatic = (int)$request->is_automatic;
            $show_in_home = (int)$request->show_in_home;
            $apply_for_discount_product = (int)$request->apply_for_discount_product;

            $user_famous_id = $is_automatic == 0 ? $request->user_famous_id : null;
            $user_famous_rate = $is_automatic == 0 && $request->user_famous_rate ? $request->user_famous_rate : 0;

            $products = $request->products != "" ? explode(",", $request->products) : [];
            $excluded_products = $request->excluded_products != "" ? explode(",", $request->excluded_products) : [];
            $categories = $request->categories != "" ? explode(",", $request->categories) : [];
            $excluded_categories = $request->excluded_categories != "" ? explode(",", $request->excluded_categories) : [];


            if ($type == 2 || $type == 4) {
                if (is_array($products) && is_array($excluded_products) && count($products) > 0 && count($excluded_products) > 0 && array_intersect($products, $excluded_products)) {
                    return general_response(false, true, "", trans('validation.duplicate_coupon_products'), "", []);

                }
                if (is_array($categories) && is_array($excluded_categories) && count($categories) > 0 && count($excluded_categories) > 0 && array_intersect($categories, $excluded_categories)) {
                    return general_response(false, true, "", trans('validation.duplicate_coupon_categories'), "", []);

                }
            }

            if ($is_automatic == 1) {

                $check_ = $this->check_other_coupon_automatic($coupon, $categories, $excluded_categories, $products, $excluded_products);
                if (!$check_['status']) {
                    return general_response(false, true, "", $check_['message'], "", []);
                }

            }
            $coupon = Coupon::create([
                'coupon' => $coupon,
                'value' => $value,
                'min_price' => $min_price,
                'max_used' => $max_used,
                'start_at' => $start_at,
                'end_at' => $end_at,
                'coupon_type_id' => $type,
                'is_automatic' => $is_automatic,
                'user_famous_id' => $user_famous_id,
                'user_famous_rate' => $user_famous_id ? $user_famous_rate : 0 ,
                'show_in_home' => $show_in_home,
                'apply_for_discount_product' => $apply_for_discount_product

            ]);

            if ($type == 1 || $type == 2 || $type == 3 ||$type == 4 ||$type == 5) {

                $product_ids = [];
                foreach ($products as $product) {
                    $product_ids[$product] = ['type' => 1];
                }
                $excluded_product_ids = [];
                foreach ($excluded_products as $excluded_product) {
                    $excluded_product_ids[$excluded_product] = ['type' => 0];
                }
                $category_ids = [];
                foreach ($categories as $category) {
                    $category_ids[$category] = ['type' => 1];
                }
                $excluded_category_ids = [];
                foreach ($excluded_categories as $excluded_category) {
                    $excluded_category_ids[$excluded_category] = ['type' => 0];
                }

                if ($is_automatic == 1) {
                    $get_coupon = $coupon;
                    if(count($categories) <= 0 && count($excluded_categories) <= 0 && count($products) <= 0 && count($excluded_products) <= 0) {
                        Product::select('*')->update(['coupon_automatic_id' => $get_coupon->id]);
                    }else {

                        if(count($products) > 0) {
                            Product::whereIn('id', $products)->update( ['coupon_automatic_id' => $get_coupon->id]);
                        }else if(count($categories) <= 0){
                            Product::select('*')->update(['coupon_automatic_id' => $get_coupon->id]);
                        }

                        if(count($categories) > 0) {
                            Product::whereHas('categories', function ($query) use ($categories) {
                                $query->whereIn('category_id', $categories);
                            })->update([
                                'coupon_automatic_id' => $get_coupon->id,
                            ]);
                        } else if ((count($products) <= 0) || (count($products) > 0 && (count($excluded_products) >0 || count($excluded_categories) > 0))) {
                            Product::select('*')->update(['coupon_automatic_id' => $get_coupon->id]);
                        }

                        if(count($excluded_products) > 0) {
                            Product::whereIn('id', $excluded_products)->whereNotIn('id',$products)->update( ['coupon_automatic_id' => null]);
                        }
                        if(count($excluded_categories) > 0) {
                            Product::whereHas('categories', function ($query) use ($excluded_categories) {
                                $query->whereIn('category_id', $excluded_categories);
                            })->whereNotIn('id',$products)->update([
                                'coupon_automatic_id' => null,
                            ]);
                        }


                    }

                }
                if($type != 5) {
                    $coupon->products()->attach($product_ids);
                    $coupon->products()->attach($excluded_product_ids);
                    $coupon->categories()->attach($category_ids);
                    $coupon->categories()->attach($excluded_category_ids);
                }

            }

            $this->add_action("add_coupon" ,'coupon', json_encode($coupon));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }


    }

    public function update(Request $request)
    {


        try {
            $id = $request->id;
            $rules = [
                'coupon' => [
                    'required',
                    Rule::unique('coupons', 'coupon')->ignore($id)->whereNull('deleted_at')
                ],
                'value' => [
                    'required', 'numeric'

                ],
                'min_price' => [
                    'required', 'numeric'
                ],
                'max_used' => [
                    'required', 'integer'
                ],
                'start_at' => 'required',
                'end_at' => 'required',
                'type' => ['required', 'integer'],
                'user_famous_id' => [
                    'sometimes', 'nullable', Rule::exists('users', 'id')->whereNull('deleted_at')
                ],

            ];

            if ($request->filled('user_famous_id')) {
                $rules['user_famous_rate'] = ['required', 'numeric', 'gt:0'];
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $messages = $validator->errors();
                $get_one_message = get_error_msg($rules, $messages);
                return general_response(false, true, "", $get_one_message, "", []);
            } else {

                // return response()->json($request->all());
                $get_coupon = Coupon::find($id);


                $coupon = $request->coupon;
                $value = $request->value;
                $min_price = $request->min_price;
                $max_used = $request->max_used;

                $start_at = Carbon::createFromFormat("Y-m-d h:i A", $request->start_at);
                $end_at = Carbon::createFromFormat("Y-m-d h:i A", $request->end_at);

                $type = $request->type;
                $show_in_home = (int)$request->show_in_home;
                $apply_for_discount_product = (int)$request->apply_for_discount_product;


                $products = $request->products != "" ? explode(",", $request->products) : [];
                $excluded_products = $request->excluded_products != "" ? explode(",", $request->excluded_products) : [];
                $categories = $request->categories != "" ? explode(",", $request->categories) : [];
                $excluded_categories = $request->excluded_categories != "" ? explode(",", $request->excluded_categories) : [];
                $is_automatic = (int)$request->is_automatic;

                $user_famous_id = $is_automatic == 0 ? $request->user_famous_id : null;
                $user_famous_rate = $is_automatic == 0 ? $request->user_famous_rate : 0;


                if ($type == 1 || $type == 2 || $type == 3 ||$type == 4) {
                    if (is_array($products) && is_array($excluded_products) && count($products) > 0 && count($excluded_products) > 0 && array_intersect($products, $excluded_products)) {
                        return general_response(false, true, "", trans('validation.duplicate_coupon_products'), "", []);

                    }
                    if (is_array($categories) && is_array($excluded_categories) && count($categories) > 0 && count($excluded_categories) > 0 && array_intersect($categories, $excluded_categories)) {
                        return general_response(false, true, "", trans('validation.duplicate_coupon_categories'), "", []);

                    }
                }

                if ($is_automatic == 1) {

                    $check_ = $this->check_other_coupon_automatic($coupon, $categories, $excluded_categories, $products, $excluded_products);
                    if (!$check_['status']) {
                        return general_response(false, true, "", $check_['message'], "", []);
                    }

                }


                $get_coupon->update([
                    'coupon' => $coupon,
                    'value' => $value,
                    'min_price' => $min_price,
                    'max_used' => $max_used,
                    'start_at' => $start_at,
                    'end_at' => $end_at,
                    'coupon_type_id' => $type,
                    'is_automatic' => $is_automatic,
                    'user_famous_id' => $user_famous_id,
                    'user_famous_rate' => $user_famous_id ? $user_famous_rate : 0 ,
                    'show_in_home' => $show_in_home,
                    'apply_for_discount_product' => $apply_for_discount_product

                ]);


                $get_coupon->products()->detach();
                $get_coupon->categories()->detach();

                if ($type == 1 || $type == 2 || $type == 3 ||$type == 4 || $type == 5) {
                    $product_ids = [];
                    foreach ($products as $product) {
                        $product_ids[$product] = ['type' => 1];
                    }
                    $excluded_product_ids = [];
                    foreach ($excluded_products as $excluded_product) {
                        $excluded_product_ids[$excluded_product] = ['type' => 0];
                    }
                    $category_ids = [];
                    foreach ($categories as $category) {
                        $category_ids[$category] = ['type' => 1];
                    }
                    $excluded_category_ids = [];
                    foreach ($excluded_categories as $excluded_category) {
                        $excluded_category_ids[$excluded_category] = ['type' => 0];
                    }

                    Product::where('coupon_automatic_id', '=', $get_coupon->id)->update([
                        'coupon_automatic_id' => null,
                        'coupon_automatic_from_category_id' => 0
                    ]);

                    if ($is_automatic == 1) {


                        if(count($categories) <= 0 && count($excluded_categories) <= 0 && count($products) <= 0 && count($excluded_products) <= 0) {
                            Product::select('*')->update(['coupon_automatic_id' => $get_coupon->id]);
                        }else {

                            if(count($products) > 0) {
                                Product::whereIn('id', $products)->update( ['coupon_automatic_id' => $get_coupon->id]);
                            }else if(count($categories) <= 0){
                                Product::select('*')->update(['coupon_automatic_id' => $get_coupon->id]);
                            }

                            if(count($categories) > 0) {
                                Product::whereHas('categories', function ($query) use ($categories) {
                                    $query->whereIn('category_id', $categories);
                                })->update([
                                    'coupon_automatic_id' => $get_coupon->id,
                                ]);
                            } else if ((count($products) <= 0) || (count($products) > 0 && (count($excluded_products) >0 || count($excluded_categories) > 0))) {
                                Product::select('*')->update(['coupon_automatic_id' => $get_coupon->id]);
                            }

                            if(count($excluded_products) > 0) {
                                Product::whereIn('id', $excluded_products)->whereNotIn('id',$products)->update( ['coupon_automatic_id' => null]);
                            }
                            if(count($excluded_categories) > 0) {
                                Product::whereHas('categories', function ($query) use ($excluded_categories) {
                                    $query->whereIn('category_id', $excluded_categories);
                                })->whereNotIn('id',$products)->update([
                                    'coupon_automatic_id' => null,
                                ]);
                            }

                        }

                    }

                    if($type != 5) {
                        $get_coupon->products()->attach($product_ids);
                        $get_coupon->products()->attach($excluded_product_ids);
                        $get_coupon->categories()->attach($category_ids);
                        $get_coupon->categories()->attach($excluded_category_ids);
                    }

                }
                $this->add_action("update_coupon" ,'coupon', json_encode($get_coupon));
                return general_response(true, true, trans('admin.success'), "", "", []);
            }
        } catch (\Exception $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        } catch (\Error $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        }


    }

    public function delete(Request $request)
    {
        $coupon = Coupon::find($request->id);

        try {
            Product::where('coupon_automatic_id', '=', $coupon->id)->update([
                'coupon_automatic_id' => null,
                'coupon_automatic_from_category_id' => 0
            ]);


            $coupon->products()->detach();
            $coupon->categories()->detach();
            $coupon->delete();

            $this->add_action("delete_coupon" ,'coupon', json_encode($coupon));
            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    public function get_coupons_ajax(Request $request)
    {

        $status = $request->filled('status') ? $request->status : -1;
        $coupons = Coupon::with(['type' ,'user_famous', 'available_products', 'not_available_products', 'available_categories', 'not_available_categories'])
            ->CouponUsed([
                'date_from' => -1,
                'date_to' => -1
            ]);

        if ($status == 1) {
            $coupons->Active();
        } else if ($status == 0) {
            $coupons->NotActive();
        }

        return DataTables::of($coupons)
            ->addColumn('start_at_edit', function ($model) {
                return Carbon::parse($model->start_at)->format('Y-m-d h:i A');
            })->addColumn('end_at_edit', function ($model) {
                return Carbon::parse($model->end_at)->format('Y-m-d h:i A');

            })->addColumn('show_status', function ($model) {
                if ($model->start_at <= Carbon::now()->format('Y-m-d H:i:s') && $model->end_at >= Carbon::now()->format('Y-m-d H:i:s')) {
                    $status = 1;
                } else {
                    $status = 0;
                }
                return view('admin.coupons.parts.status', ['status' => $status, 'is_automatic' => $model->is_automatic])->render();

            })->addColumn('user_famous_data', function ($model) {
                $user_name = "";
                $id = 0;
                if ($model->user_famous) {
                    $user_name = $model->user_famous->email ? $model->user_famous->first_name . " " . $model->user_famous->last_name . " ( " . $model->user_famous->email . " ) " : "";
                    $id = $model->user_famous->id;
                }

                return ['user_name' => $user_name, 'id' => $id];
            })
            ->addColumn('actions', function ($model) {
                return view('admin.coupons.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }

    // help
    public function check_other_coupon_automatic($coupon, $categories, $excluded_categories, $products, $excluded_products)
    {

        $check_products = Product::whereIn('id', $products)->whereHas('automatic_coupon', function ($query) use ($coupon) {
            $query->where('coupon', '<>', $coupon)->IsActiveAndAutomatic();
        });

        if ($check_products->exists()) {
            $message = trans('admin.coupon_auomtaic_duplicate_product');

            return [
                'status' => false,
                'message' => $message
            ];

        }
        if (count($products) <= 0 && count($categories) <= 0) {
            $check_products_v2 = Product::whereHas('automatic_coupon', function ($query) use ($coupon) {
                $query->where('coupon', '<>', $coupon)->IsActiveAndAutomatic();
            })->whereNotIn('id', $excluded_products)
                ->whereHas('categories', function ($query) use ($excluded_categories) {
                    $query->whereNotIn('category_id', $excluded_categories);
                });

            if ($check_products_v2->exists()) {

                return [
                    'status' => false,
                    'message' => trans('admin.products_or_categories_found_other_coupon')
                ];

            }
        }
        if (count($categories) >= 0) {
            $check_products_v3 = Product::whereHas('automatic_coupon', function ($query) use ($coupon) {
                $query->where('coupon', '<>', $coupon)->IsActiveAndAutomatic();
            })->whereNotIn('id', $excluded_products)
                ->whereHas('categories', function ($query) use ($categories) {
                    $query->whereIn('category_id', $categories);
                });

            if ($check_products_v3->exists()) {

                return [
                    'status' => false,
                    'message' => trans('admin.categories_found_other_coupon')
                ];

            }
        }

        return [
            'status' => true,
            'message' => ""
        ];
    }


    public function check_automatic_coupon(Request $request)
    {
        $coupon_id = $request->coupon_id;
        $category_ids = $request->category_id;

        if (is_array($category_ids)) {
            $other_products = CouponProduct::with('product:id,name_ar,name_en')
                ->whereHas('coupon', function ($query) use ($coupon_id) {
                    $query->IsActiveAndAutomatic()->where('coupon_id', '<>', $coupon_id);

                })->whereHas('product', function ($query) use ($category_ids) {
                    $query->whereHas('categories', function ($query) use ($category_ids) {
                        $query->whereIn('product_categories.category_id', $category_ids);
                    });
                })->get();
        } else {
            $other_products = [];
        }

        return response()->json($other_products);
    }
}
