<?php

namespace App\Http\Controllers\Api;

use App\Repository\UserRepository;

use App\User;
use App\Validations\UserValidation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
/*   Models  */


use App\Models\Day;
use App\Models\UserLocation;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Neighborhood;
use App\Models\ShippingCompany;
use App\Models\PaymentMethod;
use App\Models\ShippingCompanyCity;
use App\Models\Store;
/*  Resources  */

use App\Http\Resources\UserResource;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/* Traits */

use App\Traits\PaginationTrait;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

/*  Services  */

use App\Services\StoreFile;
use App\Services\Google;
use App\Services\PublicOrderDataService;


use Illuminate\Support\Str;

/* Resource */
use App\Http\Resources\CountryResource;
use App\Http\Resources\CityRescourse;
use App\Http\Resources\StateResource;
use App\Http\Resources\NeighborhoodResource;
use App\Http\Resources\ShippingCompanyResource;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\StoreResource;

class ApiController extends Controller
{
    use PaginationTrait, SendsPasswordResetEmails;
    public $user;
    public $validation;

    public function __construct(UserRepository $user , UserValidation $validation)
    {
        $this->user = $user;
        $this->validation = $validation;
    }


    // public data
    public function get_countries() {
        $countries = Country::Active()->GeneralData()->get();
        $response['data'] = CountryResource::collection($countries);
        return response_api(true, trans('api.success'), $response);
    }

    public function get_cities($country_code) {

        $country = Country::where('iso2' , '=' , $country_code)->with('payment_methods')->first();
        $country_id = $country ? $country->id : -1;
        $cities = City::where('country_id' , '=' , $country_id)->Active()->get();
        $response['data'] =  CityRescourse::collection($cities);
        $response['payment_methods'] = PaymentResource::collection( $country->payment_methods) ;
        return response_api(true, trans('api.success'),$response);
    }
    public function get_cities_2(Request $request) {

        $cities = City::Active()->get();
        $response['data'] =  CityRescourse::collection($cities);
        return response_api(true, trans('api.success'),$response);
    }
    public function get_stores(Request $request) {

        $request->request->add(['show_stores' => true]);
        $cities = City::whereHas('stores')->with('stores')->get();
        $response['data'] =  CityRescourse::collection($cities);

        return response_api(true, trans('api.success'),$response);
    }


    public function get_shipping_companies($city_id = -1) {

        $shipping_companies = ShippingCompany::Active()->ShowForUser();
        if($city_id != -1) {
            $shipping_companies = $shipping_companies->InCity($city_id);
        }

        $shipping_companies = $shipping_companies->get();
        $response['data'] = ShippingCompanyResource::collection($shipping_companies);
        return response_api(true, trans('api.success'),$response );

    }

    public function get_payment_methods(Request $request) {

        //  $country = Country::where('iso2' , '=' , $request->get_country_code_data)->first();
        $user = $request->user;

        $shipping_company = $user->shipping_info->billing_shipping_type_;
        $shipping_city_id = $user->shipping_info->city;

        $city = City::find($shipping_city_id);
        $shipping_company_city = ShippingCompanyCity::InCompanyAndCity($shipping_company , $city)->first();
        $payments = PublicOrderDataService::get_filtered_payment_methods($city , $shipping_company_city);

        $response['data'] =  count($payments) > 0 ? PaymentResource::collection($payments) : [];
        return response_api(true, trans('api.success'),$response);
    }
}
