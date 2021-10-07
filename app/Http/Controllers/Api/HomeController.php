<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CancelReasonsResource;
use App\Models\CancelReasons;
use App\Models\Day;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/*  Repository */
use App\Repository\HomeRepository;

use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\StatisticRepository;
/* Resource */

use App\Http\Resources\CategoryResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResourceDFT;
use App\Http\Resources\SliderResource;

use App\Http\Resources\Product\ProductSimpleResource;
// services
use App\Services\SWWWTreeTraversal;

// models
use App\Models\Brand;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Advertisement;
use App\Models\Order;
use App\Models\Product;

use DB;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{

    public $home_repository;
    public function __construct(HomeRepository $home_repository)
    {
        $this->home_repository = $home_repository;
    }

    public function home(Request $request)
    {

        $response = $this->home_repository->get_app_home_data($request);
        return response_api(true, trans('api.success'), $response);
    }


    public function advertisements() {
        $advertisements = Advertisement::with(['product' , 'category'])->get();
        $pop_up = $advertisements->where('key' , '=' , 'pop_up')->first();
        $splash = $advertisements->where('key' , '=' , 'splash')->first();

        if($pop_up->status == 1) {
            $name = "";
            switch ($pop_up->point_type) {
                case 1 :
                    $name = $pop_up->category ? $pop_up->category->name : "";
                    break;
                case 2 :
                    $name = $pop_up->product ? $pop_up->product->name : "";
                    break;
            }
            $response['pop_up'] = [
                'id' => $pop_up->id ,
                'name' => $name ,
                'image' => $pop_up->image ,
                'point_type' => $pop_up->point_type ,
                'point_id' => $pop_up->point_id
            ];
        }else {
            $response['pop_up'] = null;
        }

        if($splash->status == 1) {
            $name = "";
            switch ($splash->point_type) {
                case 1 :
                    $name = $splash->category ? $splash->category->name : "";
                    break;
                case 2 :
                    $name = $splash->product ? $splash->product->name : "";
                    break;
            }
            $response['splash'] = [
                'id' => $splash->id ,
                'name' => $name,
                'image' => $splash->image ,
                'point_type' => $splash->point_type ,
                'point_id' => $splash->point_id
            ];
        }else {
            $response['splash'] = null;
        }
        
        return response_api(true, trans('api.success'), $response);

    }

    public function cancel_reasons(){
        $cancel_reasons = CancelReasons::all();

        $response['data'] = CancelReasonsResource::collection($cancel_reasons);

        return response_api(true, trans('api.success'), $response);

    }
}
