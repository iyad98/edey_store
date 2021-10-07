<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
/* Traits */

use App\Traits\PaginationTrait;

/* Resource */

use App\Http\Resources\OfferResource;

/* Repository */

use App\Repository\NotificationAppUserRepository;


// models
use App\Models\Category;
use App\Models\Product;
use App\Models\Country;
use App\user;

// services
use App\Services\Firebase;
use App\Services\StoreFile;

// jobs
use App\Jobs\SendNotificationJob;


class NotificationAppUserController extends HomeController
{

    use PaginationTrait;

    public $notification;


    public function __construct(NotificationAppUserRepository $notification)
    {
        $this->middleware('check_role:view_application');
        $this->notification = $notification;

        parent::__construct();
        parent::$data['active_menu'] = 'app';
        parent::$data['route_name'] = trans('admin.notifications');
        parent::$data['route_uri'] = route('admin.notifications-user.index');
        parent::$data['sub_menu'] = 'notifications';
    }

    public function get_notifications()
    {
        return $this->notification->all();
    }


    public function index(Request $request)
    {
        $categories = Category::all();
        $countries = Country::Active()->get();

        parent::$data['categories'] = $categories;
        parent::$data['countries'] = $countries;

        return view('admin.notifications.index', parent::$data);

    }

    public function send_notifications(Request $request)
    {


        $pointer = $request->pointer;
        $title = $request->title;
        $message = $request->message;
        $category_id = $request->category_id;
        $product_id = $request->product_id;
        $external_url = $request->external_url;
        $user_ids = $request->user_ids != "" ? explode(",", $request->user_ids) : [];
        $country_ids = $request->country_ids != "" ? explode(",", $request->country_ids) : [];
        $platform = $request->platform;

        $rules = [
            'title' => 'required',
            'message' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
            if ($pointer == 1 && (is_null($external_url) || empty($external_url))) {
                return general_response(false, true, "", trans('validation.external_url_required'), "", []);
            }

            if ($pointer == 2 && (is_null($category_id) || empty($category_id))) {
                return general_response(false, true, "", trans('validation.category_required'), "", []);
            }
            if ($pointer == 3 && !is_numeric($product_id)) {
                return general_response(false, true, "", trans('validation.product_required'), "", []);
            }

        }

        $pointer_id = "";
        $name = "";
        switch ($pointer) {
            case 1 :
                $pointer_id = $external_url;
                $name = "";
                break;
            case 2 :
                $pointer_id = $category_id;
                $category = Category::find($pointer_id);
                $name = $category ? $category->name : "";
                break;
            case 3 :
                $pointer_id = $product_id;
                $product = Product::find($pointer_id);
                $name = $product ? $product->name : "";
                break;
            case 4  :
                $pointer_id = -1;
                $name = "";
                break;
        }

        if ($request->hasFile('image')) {
            $path = (new StoreFile($request->image))->store_local('notifications');
        } else {
            $path = get_default_image();
        }

        $data = [
            'from_user_id' => Auth::guard('admin')->user()->admin_id,
            'user_id' => 0,
            'type' => notification_status()['notify_admin'],
            'order_id' => null,
            'status' => 0,
            'data' => [
                'title' => $title,
                'sub_title' => $message,
                'pointer_type' => $pointer,
                'pointer_id' => $pointer_id,
                'name' => $name ,
                'image' => url('uploads/notifications')."/".$path

            ],
            'all' => true,
            'user_ids' => $user_ids ,
            'country_ids' => $country_ids ,
            'platform' => $platform
        ];



        $send_to_user_notification = (new SendNotificationJob($data));
        dispatch($send_to_user_notification);
        $this->add_action("add_app_notification" ,'app_notification', json_encode([]));

        return general_response(true, true, trans('admin.success'), "", "", []);

    }
}
