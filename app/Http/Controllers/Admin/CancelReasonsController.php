<?php

namespace App\Http\Controllers\Admin;

use App\Models\CancelReasons;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


use Illuminate\Validation\Rule;

class CancelReasonsController extends HomeController
{
    public function __construct()
    {


        parent::__construct();
        parent::$data['route_name'] = trans('admin.cancel_reasons');
        parent::$data['route_uri'] = route('admin.cancel_reasons.index');

        parent::$data['active_menu'] = 'cancel_reasons';

    }

    public function index(Request $request)
    {

        return view('admin.cancel_reasons.index', parent::$data);
    }

    public function store(Request $request)
    {

        $rules = [
            'title_ar' => [
                'required',
                Rule::unique('cancel_reasons', 'title_ar')->whereNull('deleted_at')
            ],
            /* 'title_en' => [
                 'required',
                 Rule::unique('cancel_reasons', 'title_en')->whereNull('deleted_at')
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


            $cancel_reasons = CancelReasons::create([
                'title_ar' => $title_ar,
                'title_en' => $title_en,

            ]);
            $this->add_action("add_cancel_reasons" ,'cancel_reasons', json_encode($cancel_reasons));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }

    }

    public function update(Request $request)
    {

        $id = $request->id;

        $rules = [
            'title_ar' => [
                'required',
                Rule::unique('cancel_reasons', 'title_ar')->ignore($id)->whereNull('deleted_at')
            ],
            /*  'title_en' => [
                  'required',
                  Rule::unique('cancel_reasons', 'title_en')->ignore($id)->whereNull('deleted_at')
              ],*/

        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
            $cancel_reasons = CancelReasons::find($id);

            $title_ar = $request->title_ar;
            $title_en = $request->filled('title_en') ? $request->title_en : $request->title_ar;


            $cancel_reasons->update([
                'title_ar' => $title_ar,
                'title_en' => $title_en,

            ]);
            $this->add_action("update_cancel_reasons",'cancel_reasons', json_encode($cancel_reasons));
            return general_response(true, true, trans('admin.success'), "", "", []);
        }
    }

    public function delete(Request $request)
    {
        $cancel_reasons = CancelReasons::find($request->id);

        try {

            $cancel_reasons->delete();
            $this->add_action("delete_cancel_reasons",'cancel_reasons' , json_encode($cancel_reasons));
            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    public function get_cancel_reasons_ajax(Request $request)
    {

        $cancel_reasons = CancelReasons::select('*');
        return DataTables::of($cancel_reasons)
            ->addColumn('actions', function ($model) {
                return view('admin.cancel_reasons.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }
}
