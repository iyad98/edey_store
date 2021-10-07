<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Bank;
use App\Models\Product;

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
use Illuminate\Support\Facades\File;

use Illuminate\Validation\Rule;

class BankController extends HomeController
{


    public function __construct()
    {
        $this->middleware('check_role:view_banks|add_banks|edit_banks|delete_banks', ['only' => ['index']]);
        $this->middleware('check_role:add_banks', ['only' => ['store']]);
        $this->middleware('check_role:edit_banks', ['only' => ['update']]);
        $this->middleware('check_role:delete_banks', ['only' => ['delete']]);

        parent::__construct();
        parent::$data['route_name'] = trans('admin.banks');
        parent::$data['route_uri'] = route('admin.banks.index');
        parent::$data['active_menu'] = 'settings';
        parent::$data['sub_menu'] = 'banks';

    }


    public function index(Request $request)
    {
        
        return view('admin.banks.index', parent::$data);
    }

    public function store(Request $request)
    {

        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('banks', 'name_ar')->whereNull('deleted_at')
            ],
           /* 'name_en' => [
                'required',
                Rule::unique('banks', 'name_en')->whereNull('deleted_at')
            ],*/
            'account_number' => [
                'required','integer',
                Rule::unique('banks', 'account_number')->whereNull('deleted_at')
            ],
            'iban' => [
                'required',
                Rule::unique('banks', 'iban')->whereNull('deleted_at')
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
            $iban = $request->iban;
            $account_number = $request->account_number;

            if ($request->hasFile('image')) {
                $path = (new StoreFile($request->image))->store_local('banks');
            } else {
                $path = get_default_image();
            }
            $bank = Bank::create([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'account_number' => $account_number ,
                'iban' => $iban,
                'image' => $path,
            ]);
            $this->add_action("add_bank" ,'bank', json_encode($bank));
            update_setting_messages();
            return general_response(true, true, trans('admin.success'), "", "", []);
        }

    }

    public function update(Request $request)
    {

        $id = $request->id;

        $rules = [
            'name_ar' => [
                'required',
                Rule::unique('banks', 'name_ar')->ignore($id)->whereNull('deleted_at')
            ],
           /* 'name_en' => [
                'required',
                Rule::unique('banks', 'name_en')->ignore($id)->whereNull('deleted_at')
            ],*/
            'account_number' => [
                'required','integer',
                Rule::unique('banks', 'account_number')->ignore($id)->whereNull('deleted_at')
            ],
            'iban' => [
                'required',
                Rule::unique('banks', 'iban')->ignore($id)->whereNull('deleted_at')
            ],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
            $bank = Bank::find($id);

            $name_ar = $request->name_ar;
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
            $iban = $request->iban;
            $account_number = $request->account_number;

            if ($request->hasFile('image')) {
                if( $bank->getOriginal('image') != get_default_image()) {
                    File::delete(public_path()."/uploads/banks/".$bank->getOriginal('image'));
                }
                $path = (new StoreFile($request->image))->store_local('banks');
            } else {
                $path = $bank->getOriginal('image');
            }

            $bank->update([
                'name_ar' => $name_ar,
                'name_en' => $name_en,
                'iban' => $iban,
                'account_number' => $account_number ,
                'image' => $path,
            ]);
            $this->add_action("update_bank" ,'bank', json_encode($bank));
            update_setting_messages();
            return general_response(true, true, trans('admin.success'), "", "", []);
        }
    }

    public function delete(Request $request)
    {
        $bank = Bank::find($request->id);

        try {
            $bank->delete();
            update_setting_messages();
            $this->add_action("delete_bank" ,'bank', json_encode($bank));
            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    public function get_banks_ajax(Request $request)
    {

        $banks = Bank::select('*');
        return DataTables::of($banks)
            ->editColumn('show_image', function ($model) {
                return view('admin.banks.parts.image', ['image' => $model->image])->render();
            })
            ->addColumn('actions', function ($model) {
                return view('admin.banks.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);
    }


}
