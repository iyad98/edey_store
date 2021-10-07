<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Attribute;
use App\Models\AttributeType;
use App\Models\AttributeValue;

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

class AttributeValuesController extends HomeController
{


    public function __construct()
    {
        $this->middleware('check_role:view_attributes|add_attributes|edit_attributes|delete_attributes', ['only' => ['index']]);
        $this->middleware('check_role:add_attributes', ['only' => ['store']]);
        $this->middleware('check_role:edit_attributes', ['only' => ['update']]);
        $this->middleware('check_role:delete_attributes', ['only' => ['delete']]);

        parent::__construct();
        parent::$data['active_menu'] = 'attributes';

    }


    public function index(Request $request)
    {
        $attribute_id = $request->attribute_id;
        $attribute = Attribute::with('attribute_type')->find($attribute_id);
        parent::$data['attribute'] = $attribute;
        return view('admin.attribute_values.index', parent::$data);
    }

    public function store(Request $request)
    {

        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('attributes', 'name_ar')->whereNull('deleted_at')
            ],
           /* 'name_en' => [
                'required',
                Rule::unique('attributes', 'name_en')->whereNull('deleted_at')
            ],*/

            'attribute_id' => [
                'required',
                Rule::exists('attributes', 'id')->whereNull('deleted_at')
            ],
        ];

        if($request->attribute_key != 'image') {
            $rules['value'] = 'required';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {


            $name_ar = $request->name_ar;
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
            $value = $request->value;
            $attribute_id = $request->attribute_id;

            if($request->attribute_key == 'image') {
                if ($request->hasFile('value')) {
                    $path = (new StoreFile($request->value))->store_local('attribute_values');
                } else {
                    $path = get_default_image();
                }
                $value = $path;
            }
            $attribute_value = AttributeValue::create([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'value' => $value ,
                'attribute_id' => $attribute_id
            ]);
            $this->add_action("add_attribute_value" ,"attribute_value", json_encode($attribute_value));
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
           /* 'name_en' => [
                'required',
                Rule::unique('attributes', 'name_en')->ignore($id)->whereNull('deleted_at')
            ],*/
            'value' => [
                'required',
            ],
            'attribute_id' => [
                'required',
                Rule::exists('attributes', 'id')->whereNull('deleted_at')
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
            $attribute_value = AttributeValue::find($id);

            $name_ar = $request->name_ar;
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
            $value = $request->value;
            $attribute_id = $request->attribute_id;

            if($request->attribute_key == 'image') {
                if ($request->hasFile('value')) {
                    $path = (new StoreFile($request->value))->store_local('attribute_values');
                } else {
                    $path = $attribute_value->value;
                }
                $value = $path;
            }

            $attribute_value->update([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'value' => $value ,
                'attribute_id' => $attribute_id
            ]);
            $this->add_action("update_attribute_value" ,"attribute_value", json_encode($attribute_value));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }
    }

    public function delete(Request $request)
    {
        $attribute_value = AttributeValue::find($request->id);
        if($attribute_value->product_attributes()->count() > 0) {
            return general_response(false, true, "", trans('admin.cant_delete_because_have_products'), "", []);
        }
        try {
            $attribute_value->delete();
            $this->add_action("delete_attribute_value","attribute_value" , json_encode($attribute_value));
            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    public function get_attribute_values_ajax(Request $request)
    {
        $attribute_id = $request->filled('attribute_id') ? $request->attribute_id : -1;
        $attribute_key = Attribute::find($attribute_id)->attribute_type->key;
        $attribute_value_data = AttributeValue::leftJoin('attributes', 'attributes.id', '=', 'attribute_values.attribute_id');
        if ($attribute_id != -1) {
            $attribute_value_data = $attribute_value_data->where('attribute_values.attribute_id', '=', $attribute_id);
        }
        $attribute_value_data = $attribute_value_data->select('attribute_values.*', 'attributes.name_ar as attribute_name');

        return DataTables::of($attribute_value_data)
            ->addColumn('view_value', function ($model) use ($attribute_key) {
                return view('admin.attribute_values.parts.view_value', ['value' => $model->value, 'attribute_key' => $attribute_key])->render();
            })->editColumn('value', function ($model) use ($attribute_key) {
                if($attribute_key == 'image') {
                    return url('uploads/attribute_values')."/".$model->value;
                }else {
                    return $model->value;
                }
            })
            ->addColumn('actions', function ($model) {
                return view('admin.attribute_values.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }


}
