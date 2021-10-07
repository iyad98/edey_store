<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Country;
use App\Models\Neighborhood;
use App\Models\Category;
use App\Models\AppHome;
use App\Models\Advertisement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
/*  Models */

use App\Models\FilterData;
use App\Models\Banner;

/* service */

use App\Services\StoreFile;
use App\Services\Firestore;
use DB;

use Illuminate\Validation\Rule;
// jobs
use App\Jobs\UpdateCategoriesBannersAppJob;

class AdvertisementController extends HomeController
{


    public function __construct()
    {
        $this->middleware('check_role:view_application');

        parent::__construct();
        parent::$data['route_name'] = trans('admin.advertisements');
        parent::$data['route_uri'] = route('admin.advertisements.index');
        parent::$data['active_menu'] = 'app';
        parent::$data['sub_menu'] = 'advertisements';

    }


    public function index(Request $request)
    {

        $categories = Category::all();
        $advertisements = Advertisement::with('product')->get();

        $pop_up = $advertisements->where('key', '=', 'pop_up')->first();
        $splash = $advertisements->where('key', '=', 'splash')->first();

        parent::$data['categories'] = $categories;
        parent::$data['pop_up'] = $pop_up;
        parent::$data['splash'] = $splash;

        return view('admin.advertisements.index', parent::$data);
    }


    public function update(Request $request)
    {

        try {
            $advertisement = Advertisement::all();
            $pop_up = $advertisement->where('key', '=', 'pop_up')->first();
            $splash = $advertisement->where('key', '=', 'splash')->first();

            $pop_up_category = $request->pop_up_category;
            $pop_up_product = $request->pop_up_product;
            $pop_up_pointer = $request->pop_up_pointer;
            $pop_up_status = (int)$request->pop_up_status;


            $splash_category = $request->splash_category;
            $splash_product = $request->splash_product;
            $splash_pointer = $request->splash_pointer;
            $splash_status = (int)$request->splash_status;

            if ($pop_up_pointer == 1 && (is_null($pop_up_category) || empty($pop_up_category))) {
                return general_response(false, true, "", trans('admin.must_pop_up_category'), "", []);
            }
            if ($pop_up_pointer == 2 && !is_numeric($pop_up_product)) {
                return general_response(false, true, "", trans('admin.must_pop_up_product'), "", []);
            }

            if ($splash_pointer == 1 && (is_null($splash_category) || empty($splash_category))) {
                return general_response(false, true, "", trans('admin.must_splash_category'), "", []);
            }
            if ($splash_pointer == 2 && !is_numeric($splash_product)) {
                return general_response(false, true, "", trans('admin.must_splash_product'), "", []);
            }

            $pop_up_path = $this->store_file_service($request->pop_up_image, 'advertisements', $pop_up, 'image', false);
            $splash_path = $this->store_file_service($request->splash_image, 'advertisements', $splash, 'image', false);


            Advertisement::where('key', '=', 'pop_up')->update([
                'point_type' => $pop_up_pointer,
                'point_id' => $pop_up_pointer == 1 ? $pop_up_category : ($pop_up_pointer == 2 ? $pop_up_product : 0),
                'image' => $pop_up_path,
                'status' => $pop_up_status
            ]);
            Advertisement::where('key', '=', 'splash')->update([
                'point_type' => $splash_pointer,
                'point_id' => $splash_pointer == 1 ? $splash_category : ($splash_pointer == 2 ? $splash_product : 0),
                'image' => $splash_path,
                'status' => $splash_status
            ]);
            $this->add_action("update_advertisement" ,'advertisement', json_encode([]));

        } catch (\Exception $e) {
            return general_response(false, true, trans('admin.success'), $e->getMessage(), "", []);

        } catch (\Error $e) {
            return general_response(false, true, trans('admin.success'), $e->getMessage(), "", []);

        }


        return general_response(true, true, trans('admin.success'), "", "", []);
    }

}
