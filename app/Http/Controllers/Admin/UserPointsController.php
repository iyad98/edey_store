<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UserPointsExport;
use App\Http\Resources\UserPointsResource;
use App\Models\WalletLog;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Excel;

class UserPointsController extends HomeController
{

    public function __construct()
    {
        $this->middleware('check_role:view_mailing_list', ['only' => ['index']]);

        parent::__construct();

        parent::$data['route_name'] = trans('admin.users_points');
        parent::$data['route_uri'] = route('admin.user_points.index');
        parent::$data['active_menu'] = 'points';
        parent::$data['sub_menu'] = 'users_points';

    }
    public function index(){

        return view('admin.user_points.index',parent::$data);
    }


    public function get_user_point_ajax(){


        $users = User::whereHas('orders')->select('*');
        return DataTables::of($users)
            ->editColumn('action', function ($model) {
                return view('admin.user_points.parts.action', ['model' => $model])->render();
            })
            ->escapeColumns(['*'])->make(true);

    }

    public function increase_point(Request $request){
        $user = User::find($request->id);
        $point = $request->point;
        try {

            if ($point < 0){
                return general_response(false, true, "", trans('admin.error'), "", []);

            }
            if ($user->points_count < $point){
                return general_response(false, true, "", trans('admin.not_enough_point'), "", []);
            }
            WalletLog::create([
                'user_id'=>$user->id,
                'points'=> ($point * -1) ,
                'type'=>1,
                'pricepoints'=>0,

            ]);
            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }

    }
    public function download_excel_user_point(){
        $users = User::whereHas('orders')->select('*')->get();
        $users =  UserPointsResource::collection($users);

        return Excel::download(new UserPointsExport($users), "user_points.xlsx");
    }
}
