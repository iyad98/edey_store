<?php

namespace App\Http\Controllers\Website;

use App\Http\Requests\UpgradeAccountRequest;
use App\Models\Area;
use App\Models\Attribute;
use App\Models\AttributeType;
use App\Models\AttributeValue;
use App\Models\Bank;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Merchant;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\UserBank;
use App\Traits\FileTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller\Website;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class MerchantController extends Controller
{
    use FileTrait;


    public function upgrade_account(Request $request)
    {
        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"], ['name' => trans('website.upgrade_account'), 'url' => url('upgrade-account')]];
        $countries = Country::Active()->GeneralData()->get();
        $country_code = $request->get_country_data ? $request->get_country_data->iso2 : null;

        $cities = City::Active()->get();
        $banks = Bank::Active()->get();
        $areas = Area::Active()->get();


        parent::$data['breadcrumb_title'] = trans('website.upgrade_account');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.upgrade_account');
        parent::$data['title'] = parent::$data['breadcrumb_title'];
        parent::$data['menu'] = 'cart';


        parent::$data['countries'] = $countries;
        parent::$data['country_code'] = json_encode($country_code);
        parent::$data['cities'] = $cities;
        parent::$data['banks'] = $banks;
        parent::$data['areas'] = $areas;


        return view('website_v3.profile.upgrade_account', parent::$data);
    }

    public function merchant_details(Request $request, $merchant_id, $category_id = null)
    {
        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"], ['name' => trans('website.merchant_account'), 'url' => url('merchant')]];
        $countries = Country::Active()->GeneralData()->get();
        $country_code = $request->get_country_data ? $request->get_country_data->iso2 : null;


        $cities = City::Active()->get();
        $banks = Bank::Active()->get();
        $areas = Area::Active()->get();
        $merchant = Merchant::query()->find($merchant_id);
        $attributeTypes = AttributeType::query()->whereNull('deleted_at')->with('attribute')->get();

        if ($category_id) {

            $products_merchants_all = ProductCategory::query()->where('category_id', $category_id)->where('merchant_id', $merchant_id)->with('product')->pluck('product_id')->toArray();
            $products_merchants_unique = array_unique($products_merchants_all);
            $arr = [];
            foreach ($products_merchants_unique as $item) {
                $products_merchants = ProductCategory::query()->where('merchant_id', $merchant_id)->where('product_id', $item)->with('product')->first();
                array_push($arr, $products_merchants);
            }

            $products_merchants = $arr;
            $category_name = Category::query()->find($category_id)->name_ar;


        } else {

            $products_merchants_all = ProductCategory::query()->where('merchant_id', $merchant_id)->with('product')->pluck('product_id')->toArray();
            $products_merchants_unique = array_unique($products_merchants_all);
            $arr = [];
            foreach ($products_merchants_unique as $item) {
                $products_merchants = ProductCategory::query()->where('merchant_id', $merchant_id)->where('product_id', $item)->with('product')->first();
                array_push($arr, $products_merchants);
            }
            $products_merchants = $arr;
            $category_name = 'all';
        }

        $categories_merchants = get_category_merchant($merchant_id);
        parent::$data['breadcrumb_title'] = trans('website.merchant_account');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.merchant_account');
        parent::$data['title'] = parent::$data['breadcrumb_title'];
        parent::$data['menu'] = 'cart';
        parent::$data['countries'] = $countries;
        parent::$data['country_code'] = json_encode($country_code);
        parent::$data['cities'] = $cities;
        parent::$data['banks'] = $banks;
        parent::$data['areas'] = $areas;
        parent::$data['merchant'] = $merchant;
        parent::$data['products_merchants'] = $products_merchants;
        parent::$data['categories_merchants'] = $categories_merchants;
        parent::$data['category_name'] = $category_name;
        parent::$data['attributeTypes'] = $attributeTypes;


        return view('website_v3.shop.merchant_details', parent::$data);
    }


    public function store_merchant(UpgradeAccountRequest $request)
    {
        try {
            if (auth()->user()) {
                DB::beginTransaction();
                $user = auth()->user();
                $path2 = $this->store_file_service($request->logo_store, 'products', null, null, true);
                $path3 = $this->store_file_service($request->image_banar_store, 'products', null, null, true);
                if (Merchant::query()->where('email', $user->email)->count() > 0) {
                    return redirect()->back()->with('success', 'تم ترقية الحساب بنجاح');
                }


                $merchant = Merchant::query()->create([
                    'store_name' => $request->store_name,
                    'logo_store' => $path2,
                    'image_banar_store' => $path3,
                    'phone_store' => $request->phone_store,
                    'phone_whatsapp_store' => $request->phone_whatsapp_store,
                    'facebook_link' => $request->facebook_link,
                    'twitter_link' => $request->twitter_link,
                    'instagram_link' => $request->instagram_link,
                    'email' => $user->email,
                    'merchant_first_name' => $request->merchant_first_name,
                    'merchant_last_name' => $request->merchant_last_name,
                    'identification_number' => $request->identification_number,
                    'phone_merchants' => $request->phone_merchants,
                    'about_us_merchants' => $request->about_us_merchants,
                    'commercial_register_number' => $request->commercial_register_number,
                    'maroof_number' => $request->maroof_number,
                    'country_id' => $request->country_id,
                    'city_id' => $request->city_id,
                    'area_id' => $request->area_id,
                    'address_store' => $request->address_store,
                    'street_store' => $request->street_store,
                    'nearest_public_place' => $request->nearest_public_place,
                    'active' => 0, //default value  accept from cpanel
                    'account_barea' => $request->account_barea,
                    'password' => $user->email,
                ]);

                UserBank::query()->create([
                    'bank_id' => $request->bank_id,
                    'merchants_id' => $merchant->id,
                    'bank_account_name' => $request->bank_account_name,
                    'iban_number' => $request->iban_number
                ]);
                DB::commit();
                return redirect()->back()->with('success', 'تم ترقية الحساب بنجاح');

            } else {
                return redirect()->back()->with('error', 'يجب تسجيل الدخلو اولاُ');
            }

        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'حدث خطأ ما يرجى المحاولة لاحقاٌ');
        }
    }


    public function filter_product(Request $request)
    {
        dd($request->color_filter);
    }


    public function searchProduct(Request $request, $merchant_id)
    {

        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"], ['name' => trans('website.merchant_account'), 'url' => url('merchant')]];
        $countries = Country::Active()->GeneralData()->get();
        $country_code = $request->get_country_data ? $request->get_country_data->iso2 : null;


        $cities = City::Active()->get();
        $banks = Bank::Active()->get();
        $areas = Area::Active()->get();
        $merchant = Merchant::query()->find($merchant_id);
        $attributeTypes = AttributeType::query()->whereNull('deleted_at')->with('attribute')->get();

        $query = Product::query()
            ->where('merchant_id', $merchant_id)
            ->where('name_ar', 'like', '%' . $request->name . '%')
            ->orWhere('name_en', 'like', '%' . $request->name . '%')
            ->orWhere('description_en', 'like', '%' . $request->name . '%')
            ->orWhere('name_ar', 'like', '%' . $request->name . '%')
            ->orWhere('name_ar', 'like', '%' . $request->name . '%')->get();
//        dd($query);


        $arr_products_merchants = [];
        foreach ($query as $item) {
            $productCategories = ProductCategory::query()->with('product')->find($item->id);
            array_push($arr_products_merchants,$productCategories);
        }



        parent::$data['breadcrumb_title'] = trans('website.merchant_account');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.merchant_account');
        parent::$data['title'] = parent::$data['breadcrumb_title'];
        parent::$data['menu'] = 'cart';
        parent::$data['countries'] = $countries;
        parent::$data['country_code'] = json_encode($country_code);
        parent::$data['cities'] = $cities;
        parent::$data['banks'] = $banks;
        parent::$data['areas'] = $areas;
        parent::$data['merchant'] = $merchant;
        parent::$data['products_merchants'] = $arr_products_merchants;

        return view('website_v3.shop.product_search', parent::$data);


    }


}
