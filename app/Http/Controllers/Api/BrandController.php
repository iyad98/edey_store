<?php

namespace App\Http\Controllers\Api;

use App\Repository\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*  Resources  */
use App\Http\Resources\BrandResource;


use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// models
use App\Models\Brand;

class BrandController extends Controller
{


    public function get_brands(Request $request) {
        $brands =  Brand::all();
        $response['data'] = BrandResource::collection($brands);
        return response_api(true , trans('api.success') , $response);
    }

}
