<?php

namespace App\Http\Controllers\Api;

use App\Repository\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*  Resources  */
use App\Http\Resources\CategoryResource;


use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// models
use App\Models\Setting;
class SettingController extends Controller
{


    public function calculate_commission(Request $request) {
        
        $commission = Setting::where('key' , '=' , 'commission')->first();
        if(!$commission ) {
            $commission = 5;
        }else {
            $commission = $commission->value;
        }
        $price = $request->price;
        if(!is_numeric($price) || $price < 0) {
            return response_api(false, trans('api.validate_price'), "");
        }
        $commission_price = $price - $price*($commission/100);
        return response_api(true, trans('api.done'), [
            'commission_price' => round($commission_price , 2)
        ]);

    }

}
