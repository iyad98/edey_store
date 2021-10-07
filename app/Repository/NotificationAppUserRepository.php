<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 16/8/2019
 * Time: 7:11 م
 */

namespace App\Repository;


use App\Models\NotificationAppUser;
use Carbon\Carbon;

/*  Models */
use App\User;
use App\Models\Order;

/*  service */
use App\Services\Firebase;

use Illuminate\Support\Str;


class NotificationAppUserRepository
{
    public $notification;

    public function __construct(NotificationAppUser $notification)
    {
        $this->notification = $notification;
    }

    public function __call($name, $arguments)
    {
        return $this->notification->$name(...$arguments);
    }

    public function add_notification($notify_data) {



        $firebase = new Firebase();


        $user_id = $notify_data['user_id'];
        $from_user_id = $notify_data['from_user_id'];
        $type = $notify_data['type'];
        $order_id = $notify_data['order_id'];
        $status = $notify_data['status'];
        $data = $notify_data['data'];


        
        $data_ = $data;
        $data_['type'] = $type;
        $data_['status'] = $status;
        $data_['order_id'] = $order_id;

        $get_user = User::find($user_id);
        $current_lang = app()->getLocale();
        $user_lang = $get_user ? $get_user->lang : "ar";

        app()->setLocale($user_lang);
        if(!$get_user) {
            return;
        }
        try {

            $data['status_text'] = trans_order_status()[$status];

        }catch (\Exception $e) {
            $data['status_text'] = "";

        }catch (\Error $e2) {
            $data['status_text'] = "";

        }
        $get_title_sub_title_notification = $this->get_title_sub_title_notification($type , $data ,$get_user->lang );
        $title = $get_title_sub_title_notification['title'];
        $sub_title = $get_title_sub_title_notification['sub_title'];

        if($get_user->notification == 1) {
            if($get_user->platform == "android") {
                $firebase->send_without_notification_builder($title ,$sub_title ,$data_ ,$get_user->fcm_token);
            }else {
                $firebase->send($title ,$sub_title ,$data_ ,$get_user->fcm_token);
            }

        }

        // notification database
        $notification = new NotificationAppUser();
        $notification->from_user_id = $from_user_id ;
        $notification->user_id = $user_id ;
        $notification->order_id = $order_id ;
        $notification->type = $type ;
        $notification->status = $status ;
        $notification->data = json_encode($data) ;
        $notification->save();

        app()->setLocale($current_lang);
    }

    public function add_notification_to_all($notify_data)
    {
        $firebase = new Firebase();

        $user_id = 0;
        $from_user_id = $notify_data['from_user_id'];
        $type = $notify_data['type'];
        $order_id = null;
        $status = 0;
        $user_ids = array_key_exists('user_ids', $notify_data) ? $notify_data['user_ids'] : [];
        $country_ids = array_key_exists('country_ids', $notify_data) ? $notify_data['country_ids'] : [];
        $platform = array_key_exists('platform', $notify_data) ? $notify_data['platform'] : [];

        $data = $notify_data['data'];
        $data['status_text'] = "";


        $data_ = $data;
        $data_['type'] = $type;
        $data_['status'] = 0;
        $data_['order_id'] = null;

        $title = $data_['title'];
        $sub_title = $data_['sub_title'];


        // notification database
        $user_firebase_android_notifications = User::select('*');
        $user_firebase_ios_notifications = User::select('*');

        if ($user_ids && is_array($user_ids) && count($user_ids) > 0) {
            $user_firebase_android_notifications = $user_firebase_android_notifications->whereIn('id', $user_ids);
            $user_firebase_ios_notifications = $user_firebase_ios_notifications->whereIn('id', $user_ids);

        } else if ($country_ids && is_array($country_ids) && count($country_ids) > 0) {
            $user_firebase_android_notifications = $user_firebase_android_notifications->whereIn('country_id', $country_ids);
            $user_firebase_ios_notifications = $user_firebase_ios_notifications->whereIn('country_id', $country_ids);

        }

        if($platform == 'all' || $platform == 'android') {
            $user_firebase_android_notifications->where('notification', '=', 1)
                ->whereNotNull('fcm_token')
                ->where('platform', '=', 'android')
                ->chunk(100, function ($users) use ($firebase, $title, $sub_title, $data_) {
                    $get_users_fcm = $users->unique('fcm_token')->pluck('fcm_token')->toArray();
                    $firebase->send_without_notification_builder($title, $sub_title, $data_, $get_users_fcm);
                });
        }

        if($platform == 'all' || $platform == 'ios') {
            $user_firebase_ios_notifications->where('notification', '=', 1)
                ->whereNotNull('fcm_token')
                ->where('platform', '=', 'ios')
                ->chunk(100, function ($users) use ($firebase, $title, $sub_title, $data_) {
                    $get_users_fcm = $users->unique('fcm_token')->pluck('fcm_token')->toArray();
                    $firebase->send($title, $sub_title, $data_, $get_users_fcm);
                });
        }


        $user_notifications = User::select('*');
        if ($user_ids && is_array($user_ids) && count($user_ids) > 0) {
            $user_notifications = $user_notifications->whereIn('id', $user_ids);
        } else if ($country_ids && is_array($country_ids) && count($country_ids) > 0) {
            $user_notifications = $user_notifications->whereIn('country_id', $country_ids);
        }
        if($platform == 'ios') {
            $user_notifications = $user_notifications->where('platform', '=', 'ios');
        }else if($platform == 'android') {
            $user_notifications = $user_notifications->where('platform', '=', 'android');
        }

        $user_notifications->chunk(100, function ($users) use ($from_user_id, $order_id, $type ,$status, $data) {
            $add_data = [];
            foreach ($users as $user) {
                $notification_id = Str::uuid()->toString() . Str::random(50) . time() . Str::random(50) . Str::uuid()->toString();
                $add_data [] = [
                    'id' => $notification_id,
                    'from_user_id' => $from_user_id,
                    'user_id' => $user->id,
                    'type' => $type,
                    'order_id' => $order_id,
                    'status' => $status,
                    'data' => json_encode($data),
                    'created_at' => Carbon::now()
                ];
            }
            NotificationAppUser::insert($add_data);
        });

//        $notification = new NotificationAppUser();
//        $notification->from_user_id = $from_user_id ;
//        $notification->user_id = $user_id ;
//        $notification->order_id = $order_id ;
//        $notification->type = $type ;
//        $notification->status = $status ;
//        $notification->data = json_encode($data) ;
//        $notification->save();
    }

    public function get_description_notifications($notifications) {
        $notifications = $notifications->map(function ($value){
            $data = collect(json_decode($value->data , true))->toArray();
            $data['status_text'] = trans_order_status()[$value->status];
            $data_ = $data;
            $get_title_sub_title_notification = $this->get_title_sub_title_notification($value->type , $data ,app()->getLocale() );
            $value->data = $data_;
            $value->title = $get_title_sub_title_notification['title'];
            $value->sub_title = $get_title_sub_title_notification['sub_title'];
            return $value;
        });

        return $notifications;
    }


    public function point_type_to_description($type) {
        $key = "";
        switch ($type) {
            case notification_status()['orders'] :
                $key = "order_description";
                break;
            case notification_status()['approve_bank_transfer'] :
                $key = "approve_bank_transfer_description";
                break;
            case notification_status()['reject_bank_transfer'] :
                $key = "reject_bank_transfer_description";
                break;

        }

        return $key;
    }

    public function point_type_to_title($type) {
        $key = "";
        switch ($type) {
            case notification_status()['orders'] :
                $key = "orders";
                break;
            case notification_status()['approve_bank_transfer'] :
                $key = "approve_bank_transfer";
                break;
            case notification_status()['reject_bank_transfer'] :
                $key = "reject_bank_transfer";
                break;

        }

        return $key;
    }

    public function get_title_sub_title_notification($type, $data , $lang) {

        if(!$lang) {
            $lang = 'ar';
        }
        $trans['title'] = trans('notification.'.$this->point_type_to_title($type) , $data , $lang);
        $trans['sub_title'] = trans('notification.'.$this->point_type_to_description($type) , $data , $lang);
        return $trans;
    }

}