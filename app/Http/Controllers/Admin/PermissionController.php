<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Permission;
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

class PermissionController extends HomeController
{


    public function __construct()
    {
        $this->middleware('check_role:1');
        parent::__construct();
        parent::$data['active_menu'] = 'permissions';

    }


    public function permissions($id)
    {

        $admin = Admin::find($id);
        $admin_permissions = $admin->permissions()->pluck('permission_id')->toArray();
        $permissions = Permission::active()->orderBy('order')->select('*')->get()->groupBy('parent_ar');
        $admin_order_statuses = $admin->order_statuses;
        $admin_order_statuses->map(function ($value){
            $value->text = trans_order_status()[$value->from] ." - ".trans_order_status()[$value->to];
            return $value;
        });
        parent::$data['route_name'] = trans('admin.permissions');
        parent::$data['route_uri'] = route('admin.permissions.index', ['id' => $id]);

        parent::$data['admin'] = $admin;
        parent::$data['admin_permissions'] = $admin_permissions;
        parent::$data['permissions'] = $permissions;
        parent::$data['admin_order_statuses'] = $admin_order_statuses;

        return view('admin.admins.permissions', parent::$data);

    }

    public function update(Request $request)
    {

        try {
            $admin = Admin::find($request->admin_id);
            $permissions = json_decode($request->permissions);
            $admin->permissions()->sync($permissions);

            return general_response(true, true, trans('admin.success'), "", "", []);

        } catch (\Error $e) {
            return general_response(false, true, trans('admin.success'), $e->getMessage(), "", []);

        }


    }

    //
    public function add_admin_order_status(Request $request) {
        $admin = Admin::find($request->admin_id);
        $admin_order_statuses = json_decode($request->order_statuses , true);

        $admin->order_statuses()->delete();
        $admin->order_statuses()->createMany($admin_order_statuses);

        return general_response(true, true, trans('admin.success'), "", "", []);
    }

}
