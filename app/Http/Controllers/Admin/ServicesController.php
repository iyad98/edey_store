<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
class ServicesController extends HomeController
{

    public function __construct()
    {
        $this->middleware('check_role:view_services|add_services|edit_services|delete_services', ['only' => ['index']]);
        $this->middleware('check_role:add_services', ['only' => ['store']]);
        $this->middleware('check_role:edit_services', ['only' => ['update']]);
        $this->middleware('check_role:delete_services', ['only' => ['delete']]);

        parent::__construct();
        parent::$data['route_name'] = trans('admin.services');
        parent::$data['route_uri'] = route('admin.services.index');

        parent::$data['active_menu'] = 'services';

    }


    public function index(Request $request)
    {

        return view('admin.services.index', parent::$data);
    }

    public function store(Request $request)
    {

        $rules = [
            'title_ar' => [
                'required',
                Rule::unique('services', 'title_ar')->whereNull('deleted_at')
            ],
            /* 'title_en' => [
                 'required',
                 Rule::unique('services', 'title_en')->whereNull('deleted_at')
             ],*/

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {


            $title_ar = $request->title_ar;
            $title_en = $request->filled('title_en') ? $request->title_en : $request->title_ar;

            $description_ar = $request->description_ar;
            $description_en = $request->filled('description_en') ? $request->description_en : $request->description_ar;


            $path = $this->store_file_service($request->image , 'services' , null , null ,true , false);

            $service = Service::create([
                'title_ar' => $title_ar,
                'title_en' => $title_en,
                'description_ar' => $description_ar,
                'description_en' =>  $description_en,
                'image' => $path,
            ]);
            $this->add_action("add_services" ,'services', json_encode($service));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }

    }

    public function update(Request $request)
    {

        $id = $request->id;

        $rules = [
            'title_ar' => [
                'required',
                Rule::unique('services', 'title_ar')->ignore($id)->whereNull('deleted_at')
            ],
            /*  'title_en' => [
                  'required',
                  Rule::unique('services', 'title_en')->ignore($id)->whereNull('deleted_at')
              ],*/

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
            $service = Service::find($id);

            $title_ar = $request->title_ar;
            $title_en = $request->filled('title_en') ? $request->title_en : $request->title_ar;
            $path = $this->store_file_service($request->image, 'services', $service, 'image', false , false);

            $description_ar = $request->description_ar;
            $description_en = $request->filled('description_en') ? $request->description_en : $request->description_ar;



            $service->update([
                'title_ar' => $title_ar,
                'title_en' => $title_en,
                'description_ar' => $description_ar,
                'description_en' =>  $description_en,
                'image' => $path,
            ]);
            $this->add_action("update_service",'service', json_encode($service));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }
    }

    public function delete(Request $request)
    {
        $service = Service::find($request->id);

        try {

            $service->delete();
            $this->add_action("delete_service",'brand' , json_encode($service));
            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    public function get_services_ajax(Request $request)
    {

        $service = Service::select('*');
        return DataTables::of($service)
            ->editColumn('show_image', function ($model) {
                return view('admin.services.parts.image', ['image' => $model->image])->render();
            })
            ->addColumn('actions', function ($model) {
                return view('admin.services.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }
}
