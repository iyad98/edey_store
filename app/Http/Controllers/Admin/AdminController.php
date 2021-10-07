<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Repository\AdminRepository;
use App\Repository\StatisticRepository;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

/*  Models */

use App\Models\Order;
use App\User;
use App\Models\Pharmacy;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\AdminFcm;
use App\Models\Coupon;

use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class AdminController extends HomeController
{


    public $admin;
    public $statistic_repository;

    public function __construct(AdminRepository $admin, StatisticRepository $statistic_repository)
    {

        $this->middleware('check_role:a', ['except' => ['index', 'set_fcm_token', 'update', 'profile', 'update_profile', 'change_password']]);

        parent::__construct();
        parent::$data['route_name'] = trans('admin.admins');
        parent::$data['route_uri'] = route('admin.admins.index');
        parent::$data['active_menu'] = 'admins';
        $this->admin = $admin;
        $this->statistic_repository = $statistic_repository;
    }



    public function index(Request $request)
    {


        $start_at = $request->filled('start_at') ? $request->start_at : Carbon::now()->subDays(29)->format('Y-m-d');
        $end_at = $request->filled('end_at') ? $request->end_at : Carbon::now()->format('Y-m-d');

        $general_latest_data = $this->statistic_repository->general_latest_data();
        $general_data = $this->statistic_repository->general_data($start_at, $end_at);
        $financial = $this->statistic_repository->get_financial_orders($start_at, $end_at);
        $users_statistic = $this->statistic_repository->get_users_statistic($start_at, $end_at);
        $orders_data = $this->statistic_repository->get_orders_data($start_at, $end_at);
        $get_orders_payment_types_data = $this->statistic_repository->get_orders_payment_types_data($start_at, $end_at);
        $get_orders_shipping_types_data = $this->statistic_repository->get_orders_shipping_types_data($start_at, $end_at);

        $orders_count_data = $this->statistic_repository->get_orders_count_data($start_at, $end_at);

        $coupons = $this->statistic_repository->show_coupon_in_home();

        parent::$data['coupons'] = $coupons;
        parent::$data['general_latest_data'] = $general_latest_data;
        parent::$data['general_data'] = $general_data;
        parent::$data['all_total_price'] = round($financial['all_total_price'] , 2);
        parent::$data['all_shipping'] = round($financial['all_shipping'] , 2);
        parent::$data['all_coupon_price'] = round($financial['all_coupon_price'] , 2);
        parent::$data['all_tax'] = round($financial['all_tax'] , 2);
        parent::$data['financial'] = json_encode($financial);


//        return $get_orders_shipping_types_data;
        parent::$data['users_statistic'] = json_encode($users_statistic);
        parent::$data['all_count_users'] = $users_statistic['all_count_users'];
        parent::$data['orders_type_data'] = json_encode($orders_data);
        parent::$data['get_orders_payment_types_data'] = json_encode($get_orders_payment_types_data);
        parent::$data['get_orders_shipping_types_data'] = json_encode($get_orders_shipping_types_data);
        parent::$data['orders_count_data'] = json_encode($orders_count_data);
        parent::$data['all_orders_count'] = $orders_count_data['all_orders_count'];


        parent::$data['start_at'] = $start_at;
        parent::$data['end_at'] = $end_at;

        parent::$data['route_name'] = trans('admin.dashboard');
        parent::$data['route_uri'] = route('admin.index');

        parent::$data['active_menu'] = 'dashoard';

        return view('admin.index', parent::$data);
    }

    public function admins()
    {
        return view('admin.admins.index', parent::$data);
    }

    public function store(Request $request)
    {


        $rules = [
            'name' => 'required',
            'username' => 'required|unique:admins,admin_username',
            'email' => 'required|email|unique:admins,admin_email',
            'phone' => 'required|numeric|unique:admins,admin_phone',
            'password' => 'required',
            'role' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
            $name = $request->name;
            $username = $request->username;
            $email = $request->email;
            $phone = $request->phone;
            $password = $request->password;
            $role = $request->role;
            if ($request->hasFile('image')) {
                $path = store_image($request->image, 'admins');
            } else {
                $path = get_default_image();
            }
            $add = $this->admin->addAdmin($name, $username, $email, $phone, $password, $path, $role);
            if ($add) {
                return general_response(true, true, trans('admin.success'), "", "", []);

            } else {
                return general_response(false, true, "", trans('admin.error'), "", []);

            }
        }
    }
    public function update(Request $request)
    {

        $id = $request->id;
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:admins,admin_username,' . $id . ',admin_id',
            'email' => 'required|email|unique:admins,admin_email,' . $id . ',admin_id',
            'phone' => 'required|numeric|unique:admins,admin_phone,' . $id . ',admin_id',
            'password' => '',
            'role' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {

            $name = $request->name;
            $username = $request->username;
            $email = $request->email;
            $phone = $request->phone;
            $role = $request->role;
            $password = $request->filled('password') ? $request->password : null;
            $obj = Admin::find($id);


            if ($request->hasFile('image')) {
                $path = store_image($request->image, 'admins');
                if ($obj->getOriginal('admin_image') != get_default_image()) {
                    $delete_path = public_path() . "/uploads/admins/" . $obj->getOriginal('admin_image');
                    File::delete($delete_path);
                }


            } else {
                $path = $obj->getOriginal('admin_image');
            }

            $edit = $this->admin->updateAdmin($obj, $name, $username, $email, $phone, $password, $path, $role);
            if ($edit) {
                return general_response(true, true, trans('admin.success'), "", "", []);

            } else {
                return general_response(false, true, "", trans('admin.error'), "", []);

            }
        }
    }
    public function delete(Request $request)
    {
        $user = Admin::find($request->id);
        try {
            $get_user = $this->admin->deleteAdmin($user);
            return general_response(true, true, "", "", "", $get_user);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }
    public function change_status(Request $request)
    {
        $user = Admin::find($request->id);
        if ($user->admin_status == 1) {
            $user->fcms()->delete();
        }

        $get_user = $this->admin->changeStatus($user);
        return general_response(true, true, "", "", "", $get_user);

    }


    /*          profile            */

    public function profile()
    {
        return view('admin.profile.profile', parent::$data);
    }
    public function update_profile(Request $request)
    {

        $id = Auth::guard('admin')->user()->admin_id;
        $rules = [
            'name' => 'required',
            'username' => 'required|unique:admins,admin_username,' . $id . ',admin_id',
            'email' => 'required|email|unique:admins,admin_email,' . $id . ',admin_id',
            'phone' => 'required|numeric|unique:admins,admin_phone,' . $id . ',admin_id',
            'password' => '',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {

            $name = $request->name;
            $username = $request->username;
            $email = $request->email;
            $phone = $request->phone;

            $password = $request->filled('password') ? $request->password : null;
            $obj = Admin::find($id);


            if ($request->hasFile('image')) {
                $path = store_image($request->image, 'admins');
                if ($obj->getOriginal('admin_image') != get_default_image()) {
                    $delete_path = public_path() . "/uploads/admins/" . $obj->getOriginal('admin_image');
                    File::delete($delete_path);
                }
            } else {
                $path = $obj->getOriginal('admin_image');
            }


            $role = $obj->admin_role;
            $edit = $this->admin->updateAdmin($obj, $name, $username, $email, $phone, $password, $path, $role);

            if ($edit) {
                return general_response(true, true, trans('admin.success'), "", "", []);

            } else {
                return general_response(false, true, "", trans('admin.error'), "", []);

            }
        }
    }
    public function change_password(Request $request)
    {
        $id = Auth::guard('admin')->user()->admin_id;
        $rules = [
            'new_password' => 'required',
            're_new_password' => 'required|same:new_password',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {

            $admin = Admin::find($id);
            $password = $request->new_password;
            $edit = $this->admin->changePassword($admin, bcrypt($password));
            if ($edit) {
                return general_response(true, true, trans('admin.success'), "", "", []);

            } else {
                return general_response(false, true, "", trans('admin.error'), "", []);

            }


        }
    }


    /*        ajax data          */
    public function get_admin_ajax(Request $request)
    {

        /*
        $status = $request->filled('status') ? $request->status : -1;
        $users = $this->admin->getAdmins($status);
        */

        $admins = $this->admin->filter($request->toArray());
        return DataTables::of($admins)
            ->editColumn('show_image', function ($model) {
                return view('admin.admins.parts.image', ['image' => $model->admin_image])->render();
            })
            ->editColumn('admin_status', function ($model) {
                return view('admin.admins.parts.status', ['status' => $model->admin_status])->render();

            })->addColumn('role_name', function ($model) {
                return view('admin.admins.parts.role', ['role' => $model->admin_role])->render();
            })
            ->addColumn('actions', function ($model) {
                if ($model->super_admin != 1) {
                    return view('admin.admins.parts.actions' , ['id' => $model->admin_id])->render();
                } else {
                    return "Super Admin";
                }

            })->escapeColumns(['*'])->make(true);
    }
    public function set_fcm_token(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $fcm = AdminFcm::where('fcm', '=', $request->fcm);

        if ($fcm->exists()) {
            $fcm->update([
                'admin_id' => $admin->admin_id,
                'session_id' => Auth::guard('admin')->getSession()->getId()
            ]);
        } else {
            $admin->fcms()->create([
                'fcm' => $request->fcm,
                'session_id' => Auth::guard('admin')->getSession()->getId() ,
                'last_update_fcm' => Carbon::now()
            ]);
        }

        return response()->json($request->fcm);
    }

    /* test */
    public function test()
    {
        return view('admin.test.test', parent::$data);
    }

    public function testupload(Request $request)
    {
        try {
            $files = $request->file;
            if (count($files) > 0) {
                foreach ($files as $file) {
                    store_image($file, 'test');
                }
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }


        return response()->json("done");

    }
}
