<?php

namespace App\Services\NotificationService;

// models
use App\User;
use App\Models\Admin;
use App\Models\AdminFcm;
use Illuminate\Support\Facades\Auth;


use DB;

// jobs
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Jobs\SendNotificationAdminJob;

// services
use App\Services\JawalService\SendMessage;

/*  Models */
use App\Models\NotificationAdmin;
/* Repository */
use App\Repository\NotificationAdminRepository;

class NotificationAdminService
{
    use DispatchesJobs;
    public function __construct()
    {

    }


    public  function send_notification($order , $type)
    {
        $admin_ids = Admin::where(function ($query){
            $query->whereHas('permissions' , function ($query1){
                $query1->whereIn('key' ,['view_orders']);
            })->orWhere('super_admin' , '=' , 1);
        })->pluck('admin_id')->toArray();

        $notify_data = [
            'admin_ids' => $admin_ids ,
            'type' => $type,
            'data' => ['order_id' => $order->id] ,
            'order_id' => $order->id
        ];

        $send_to_admin_notification = (new SendNotificationAdminJob($notify_data));
        dispatch($send_to_admin_notification);
    }


    // mark as read
    public  function mark_as_read_notification($order_id) {
        $notification = new NotificationAdminRepository(new NotificationAdmin());
        $notification->mark_as_read($order_id , Auth::guard('admin')->user()->admin_id);
    }

    // remove spin admin token
    public function remove_auth_admin_fcm_expire() {

        $admin_fcms = AdminFcm::all();
        $admin_fcms_filtered = $admin_fcms->filter(function ($value){
            return !unserialize(session()->getHandler()->read($value->session_id));
        })->pluck('id')->toArray();

        AdminFcm::whereIn('id' , $admin_fcms_filtered)->delete();
    }


}