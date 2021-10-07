<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Attribute;
use App\Models\AttributeType;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/*  Models */

use App\Models\FilterData;


/* service */

use App\Services\StoreFile;
use App\Services\Firestore;
use DB;

use Illuminate\Validation\Rule;

class AttributeController extends HomeController
{


    public function __construct()
    {
        $this->middleware('check_role:view_attributes|add_attributes|edit_attributes|delete_attributes', ['only' => ['index']]);
        $this->middleware('check_role:add_attributes', ['only' => ['store']]);
        $this->middleware('check_role:edit_attributes', ['only' => ['update']]);
        $this->middleware('check_role:delete_attributes', ['only' => ['delete']]);

        parent::__construct();
        parent::$data['route_name'] = trans('admin.attributes');
        parent::$data['route_uri'] = route('admin.attributes.index');
        parent::$data['active_menu'] = 'attributes';

    }


    public function index()
    {
        $attribute_types = AttributeType::Active()->get();
        parent::$data['attribute_types'] = $attribute_types;
        return view('admin.attributes.index', parent::$data);
    }

    public function store(Request $request)
    {

        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('attributes', 'name_ar')->whereNull('deleted_at')
            ],
          /*  'name_en' => [
                'required',
                Rule::unique('attributes', 'name_en')->whereNull('deleted_at')
            ],*/
            'attribute_type_id' => [
                'required',
                Rule::exists('attribute_types', 'id')->whereNull('deleted_at')
            ],

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {

            $name_ar = $request->name_ar;
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
            $attribute_type_id = $request->attribute_type_id;

           $attribute= Attribute::create([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'attribute_type_id' => $attribute_type_id
            ]);
            $this->add_action("add_attribute", "attribute" , json_encode($attribute));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }

    }

    public function update(Request $request)
    {

        $id = $request->id;

        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('attributes', 'name_ar')->ignore($id)->whereNull('deleted_at')
            ],
            /*'name_en' => [
                'required',
                Rule::unique('attributes', 'name_en')->ignore($id)->whereNull('deleted_at')
            ],*/
            'attribute_type_id' => [
                'required',
                Rule::exists('attribute_types', 'id')->whereNull('deleted_at')
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
            $attribute = Attribute::find($id);

            $name_ar = $request->name_ar;
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
            $attribute_type_id = $request->attribute_type_id;

            $attribute->update([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'attribute_type_id' => $attribute_type_id
            ]);
            $this->add_action("update_attribute" ,"attribute", json_encode($attribute));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }
    }

    public function delete(Request $request)
    {
        $attribute = Attribute::find($request->id);
        if($attribute->products()->count() > 0) {
            return general_response(false, true, "", trans('admin.cant_delete_because_have_products'), "", []);
        }
        try {
            $attribute->delete();
            $this->add_action("delete_attribute", "attribute" , json_encode($attribute));
            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    public function get_attributes_ajax(Request $request)
    {
        $attribute_type_id = $request->filled('attribute_type_id') ? $request->attribute_type_id : -1;

        $attribute_data = Attribute::leftJoin('attribute_types', 'attribute_types.id', '=', 'attributes.attribute_type_id');
        if ($attribute_type_id != -1) {
            $attribute_data = $attribute_data->where('attributes.attribute_type_id', '=', $attribute_type_id);
        }
        $attribute_data = $attribute_data->select('attributes.*', 'attribute_types.name_ar as attribute_type_name');

        return DataTables::of($attribute_data)
            ->addColumn('name_en_link', function ($model) {
                return view('admin.attributes.parts.show_attribute_values', ['id' => $model->id, 'name' => $model->name_en])->render();

            })->addColumn('name_ar_link', function ($model) {
                return view('admin.attributes.parts.show_attribute_values', ['id' => $model->id, 'name' => $model->name_ar])->render();

            })
            ->addColumn('actions', function ($model) {
                return view('admin.attributes.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }


}
