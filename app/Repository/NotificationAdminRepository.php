<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 16/8/2019
 * Time: 7:11 م
 */

namespace App\Repository;


use App\Models\NotificationAdmin;
use Carbon\Carbon;

/*  Models */
use App\User;
use App\Models\Order;
use App\Models\AdminFcm;
/*  service */
use App\Services\Firebase;

use Illuminate\Support\Str;

class NotificationAdminRepository
{
    public $notification;

    public function __construct(NotificationAdmin $notification)
    {
        $this->notification = $notification;
    }

    public function __call($name, $arguments)
    {
        return $this->notification->$name(...$arguments);
    }

    public function add_notification($notify_data) {

        $firebase = new Firebase();


        $admin_ids = $notify_data['admin_ids'];
        $type = $notify_data['type'];
        $data = $notify_data['data'];
        $order_id = $notify_data['order_id'];
        $admin_fcms = AdminFcm::whereIn('admin_id' ,$admin_ids )->get();

        $admin_fcms_filtered = $admin_fcms->filter(function ($value){
            return unserialize(session()->getHandler()->read($value->session_id));
        })->pluck('fcm')->toArray();

        /* notification database  */
        $add_data = [];
        foreach ($admin_ids as $admin_id) {
            $add_data [] = [
                'id' => Str::uuid()->toString().Str::random(50).time().Str::random(50).Str::uuid()->toString(),
                'admin_id' => $admin_id ,
                'type' => $type,
                'order_id' => $order_id,
                'data' => serialize($data),
                'created_at' => Carbon::now()
            ];
        }
        NotificationAdmin::insert($add_data);
        /*            */

        $get_title_sub_title_notification = $this->get_title_sub_title_notification($type , $data ,'ar' );
        $title = $get_title_sub_title_notification['title'];
        $sub_title = $get_title_sub_title_notification['sub_title'];
        $url = $this->point_type_to_url($type ,$order_id );

        $data_ = $data;
        $data_['url'] = $url;
        $data_['human_date'] =  Carbon::parse(Carbon::now())->diffForHumans();;
        $data_['read_at'] = null;
        $data_['type']=$type;

        $firebase->send_web($title ,$sub_title ,$data_ ,$admin_fcms_filtered);
    }

    public function get_description_notifications($notifications) {
        $notifications = $notifications->map(function ($value){
            $data = unserialize($value->data);
            $title = trans('notification_admin.'.$this->point_type_to_title($value->type) , $data , app()->getLocale());
            $sub_title = trans('notification_admin.'.$this->point_type_to_description($value->type) , $data , app()->getLocale());
            $url = $this->point_type_to_url($value->type , $value->order_id);
            $value->title = $title;
            $value->sub_title = $sub_title;
            $value->url = $url;

            $value->data = $data;
            $value->human_date = Carbon::parse($value->created_at)->diffForHumans();
            return $value;
        });

        return $notifications;
    }
    public function point_type_to_description($type) {
        $key = "";
        switch ($type) {
            case notification_admin_status()['new_order'] :
                $key = "new_order";
                break;
        }

        return $key;
    }
    public function point_type_to_title($type) {
        $key = "";
        switch ($type) {
            case notification_admin_status()['new_order'] :
                $key = "orders";
                break;

        }

        return $key;
    }


    public function point_type_to_url($type , $order_id) {
        $key = "";
        switch ($type) {
            case notification_admin_status()['new_order'] :
                $key = "https://www.q8store.co/"."/admin/orders/".$order_id;
                break;
        }
        return $key;
    }
    public function get_title_sub_title_notification($type, $data , $lang) {

        if(!$lang) {
            $lang = 'ar';
        }
        $trans['title'] = trans('notification_admin.'.$this->point_type_to_title($type) , $data , $lang);
        $trans['sub_title'] = trans('notification_admin.'.$this->point_type_to_description($type) , $data , $lang);
        return $trans;
    }


    public function mark_as_read($order_id , $admin_id) {

        $get_notification = $this->notification
            ->where('order_id' , '=' ,$order_id)
            ->where('admin_id' , '=' , $admin_id)
            ->whereNull('read_at');

        if($get_notification->exists()) {
            $get_notification->update([
                'read_at' => Carbon::now()
            ]);
        }
    }
    public function mark_as_read_delivery_notification($order_id) {
        $this->notification->where('order_id' , '=' , $order_id)
            ->where('type' , '=' ,notification_admin_status()['prepared_from_another'])
            ->update([
                'read_at' => Carbon::now()
            ]);

    }


    /*  filter date */
    public function get_date_filter($date_from, $date_to)
    {



        if (!empty($date_from) && !empty($date_to) && $date_from != -1 && $date_to != -1) {
            try {
                $date_from = Carbon::parse($date_from)->format('Y-m-d');
                $date_to = Carbon::parse($date_to)->format('Y-m-d');
            } catch (\Exception $e) {
                $date_from = -1;
                $date_to = -1;
            }
        }else {
            $date_from = -1 ;
            $date_to = -1 ;
        }
        $data = [
            'date_from' => $date_from ,
            'date_to' => $date_to
        ];
        return $data;
    }
}