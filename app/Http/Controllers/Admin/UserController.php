<?php

namespace App\Http\Controllers\Admin;


use App\Repository\UserRepository;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Services\StoreFile;
use App\Validations\UserValidation;
use DB;

class UserController extends HomeController
{

    public function __construct(UserRepository $user, UserValidation $validation)
    {
        $this->middleware('check_role:view_users|add_users|edit_users|delete_users', ['only' => ['index']]);
        $this->middleware('check_role:add_users', ['only' => ['store']]);
        $this->middleware('check_role:edit_users', ['only' => ['update' ,'change_status']]);
        $this->middleware('check_role:delete_users', ['only' => ['delete']]);


        parent::__construct();
        parent::$data['route_name'] = trans('admin.users');
        parent::$data['route_uri'] = route('admin.users.index');
        parent::$data['active_menu'] = 'users';
        $this->user = $user;
        $this->validation = $validation;
    }

    public function index()
    {

        return view('admin.users.index', parent::$data);
    }


    public function create()
    {

    }

    public function store(Request $request)
    {

        $check_data = $this->validation->check_create_data_cp($request->toArray());
        if ($check_data['status']) {

            if ($request->hasFile('image')) {
                $path = (new StoreFile($request->image))->store_local('users');
            } else {
                $path = get_default_image();
            }

            $get_data = $request->toArray();
            $get_data['image'] = $path;
            $get_data['platform'] = "";
            $add = $this->user->add_user($get_data);
            if ($add) {
                $this->add_action("add_user" ,'user', json_encode($add));

                return general_response(true, true, trans('admin.success'), "", "", []);

            } else {
                return general_response(false, true, "", trans('admin.error'), "", []);

            }

        } else {
            return general_response(false, true, "", $check_data['message'], "", []);
        }


    }

    public function edit()
    {

    }

    public function update(Request $request)
    {

        $id = $request->id;
        $get_data = $request->all();
        $get_data['user_id'] = $id;
        $check_data = $this->validation->check_update_user_cp($get_data);
        if ($check_data['status']) {
            $f_name = $request->first_name;
            $l_name = $request->last_name;
            $email = $request->email;
            $phone = null;
            //  $phone = $request->phone;

            $password = $request->filled('password') ? $request->password : null;
            $obj = User::find($id);


            if ($request->hasFile('image')) {
                $path = (new StoreFile($request->image))->store_local('users');
            } else {
                $path = $obj->getOriginal('image');
            }

            $add = $this->user->update_user($obj, $f_name, $l_name, $email, $phone, $password, $path);
            if ($add) {
                $this->add_action("update_user" ,'user', json_encode($obj));
                return general_response(true, true, trans('admin.success'), "", "", []);

            } else {
                return general_response(false, true, "", trans('admin.error'), "", []);

            }
        } else {
            return general_response(false, true, "", $check_data['message'], "", []);
        }

    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        try {
            if($user->orders()->count() > 0) {
                return general_response(false, true, "", trans('admin.cant_delete_because_have_orders'), "", []);
            }
            $get_user = $this->user->delete_user($user);
            $this->add_action("delete_user" ,'user', json_encode($user));
            return general_response(true, true, "", "", "", $get_user);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }


    public function change_status(Request $request)
    {
        $user = User::find($request->id);
        $copy_user = clone $user;
        $from_status = status_user()[$user->status]['title'];
        $get_user = $this->user->change_status($user);
        $to_status = status_user()[$get_user->status]['title'];

        /********************************************************************/
        $copy_user->from_status = $from_status;
        $copy_user->to_status = $to_status;
        $this->add_action("change_status_user" ,'user', json_encode($copy_user));
        /********************************************************************/

        return general_response(true, true, "", "", "", $get_user);

    }


    public function get_user_ajax(Request $request)
    {


        // $status = $request->filled('status') ? $request->status : -1;
        // $users = $this->user->get_users($status);


        $users = $this->user->leftJoin('packages' ,'packages.id' , '=' , 'users.package_id')
            ->where('is_guest' , '=' , 0)->select('users.*', 'packages.name_ar as package_name')->filter($request->toArray());
        return DataTables::of($users)
            ->editColumn('show_image', function ($model) {
                return view('admin.users.parts.image', ['image' => $model->image])->render();
            })
            ->editColumn('status', function ($model) {
                return view('admin.users.parts.status', ['status' => $model->status])->render();
            })
            ->addColumn('actions', function ($model) {
                return view('admin.users.parts.actions')->render();

            })->escapeColumns(['*'])->make(true);
    }

    public function get_remote_ajax_users(Request $request)
    {
        $search = $request->get('q');
        $country_ids = $request->country_ids ;
        $platform = $request->platform;

        $data = User::select(['id', 'first_name', 'last_name' , 'email'])
            ->where('is_guest' , '=' , 0)
            ->where(function ($query) use($search){
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        if($country_ids && count($country_ids) > 0) {
            $data = $data->whereIn('country_id' ,$country_ids );
        }
        if($platform && $platform == "android") {
            $data = $data->where('platform' ,'=' , 'android' );
        }else if($platform && $platform == "ios") {
            $data = $data->where('platform' ,'=' , "ios" );
        }
        $data = $data->paginate(10);
        return response()->json(['items' => $data->toArray()['data'], 'incomplete_results' => $data->nextPageUrl() ? true : false, 'total_count' => $data->total()]);
    }
}
