<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

/* Traits */

use App\Traits\PaginationTrait;

/* Resource */

use App\Http\Resources\OfferResource;

/* Repository */

use App\Repository\NotificationAdminRepository;

use App\Models\AdminFcm;
use App\Models\NotificationAdmin;

use Carbon\Carbon;

use Yajra\DataTables\DataTables;
use DB;

class NotificationAdminController extends HomeController
{

    use PaginationTrait;

    public $notification;


    public function __construct(NotificationAdminRepository $notification)
    {
        $this->middleware('check_role:view_admin_notifications', ['only' => ['index']]);

        parent::__construct();
        parent::$data['active_menu'] = 'notifications';
        parent::$data['route_name'] = trans('admin.notifications');
        parent::$data['route_uri'] = route('admin.notifications.index');
        $this->notification = $notification;

    }

    public function index() {
        return view('admin.admin_notifications.index' , parent::$data);
    }
    public function get_notifications()
    {
        return $this->notification->all();
    }


    public function get_notification_ajax(Request $request)
    {

        $admin = auth()->guard('admin')->user();

        $admin_id = $admin->admin_id;
        $date_from = $request->filled('date_from') ? $request->date_from : -1 ;
        $date_to = $request->filled('date_to') ? $request->date_to : -1 ;

        $get_date_filter = $this->notification->get_date_filter($date_from , $date_to);
        $notifications = $this->notification->where('admin_id' , '=' , $admin_id)->latest('notification_admins.created_at')->select('*');

        if($get_date_filter['date_from'] != -1 && $get_date_filter['date_to'] != -1) {
            $notifications = $notifications->where(DB::raw('date(notification_admins.created_at)') , '>=' ,$get_date_filter['date_from'] )
                ->where(DB::raw('date(notification_admins.created_at)') , '<=' ,$get_date_filter['date_to'] );
        }

        return DataTables::of($notifications)

            ->addColumn('title', function ($model) {
                return view('admin.admin_notifications.parts.title' , ['type' => $model->type , 'data' => unserialize($model->data)])->render();
            })
            ->addColumn('sub_title', function ($model) {
                return view('admin.admin_notifications.parts.description' , ['type' => $model->type ,
                    'data' => unserialize($model->data) , 'order_id' => $model->order_id ])->render();
            })
            ->escapeColumns(['*'])->make(true);
    }

    public function get_notifications_pagination(Request $request)
    {
        $admin = auth()->guard('admin')->user();
        $admin_id = $admin->admin_id;
        $page = $request->filled('page') ? $request->page : 1;
        $length = 5;
        $notifications = $this->notification->select('*')->where('admin_id' , '=' ,$admin_id)->latest()->skip(($page-1)*$length)->take($length)->get();
        $notifications = $this->notification->get_description_notifications($notifications);
        $unread_count = $this->notification->select('*')->where('admin_id' , '=' ,$admin_id)->whereNull('read_at')->count();


        return response()->json(['notifications' => $notifications , 'unread_count' => $unread_count]);
    }
    public function update_read_notification(Request $request)
    {
        $admin = auth()->guard('admin')->user();
        if($admin->admin_role == role()['admin_role']) {
            $admin_id = 0;
        }else {
            $admin_id = $admin->admin_id;
        }

        $page = $request->filled('page') ? $request->page : 1;
        $length = 5;
        $admin->notification_admin()->update(['read_at'=>Carbon::now()]);

        $notifications = $admin->notification_admin()->latest()->skip(($page-1)*$length)->take($length)->get();

        $unread_count = $admin->notification_admin()->whereNull('read_at')->count();

        return response()->json(['notifications' => $notifications , 'unread_count' => $unread_count]);
    }


    public function test()
    {

       // $notifications = $this->notification->all();
       // return $this->notification->get_description_notifications($notifications);
        $data['admin_id'] = 11;
        $data['type'] = 1;
        $data['data'] = ['order_id' => 54];
        $data['order_id'] = 54;
        $data['fcms'] = AdminFcm::select('*')->pluck('fcm')->toArray();

        return $this->notification->add_notification($data);
    }
}
