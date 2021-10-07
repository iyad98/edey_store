<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

/* Traits */

use App\Traits\PaginationTrait;

/* Resource */

use App\Http\Resources\NotificationAppUserResource;

/* Repository */
use App\Repository\NotificationAppUserRepository;
use  App\Jobs\SendNotificationJob;
use App\Models\Order;
use Carbon\Carbon;
use App\Services\Firebase;


class NotificationAppUserController extends Controller
{

    use PaginationTrait;

    public $notification;


    public function __construct(NotificationAppUserRepository $notification)
    {
        $this->notification = $notification;

    }

    public function get_notifications(Request $request) {

        $user = $request->user;
        $notification_for_all = $this->notification->where('user_id' , '=' , 0);
        $notifications = $user->notifications()->union($notification_for_all)->latest()->paginate(10);

        $pagination_options = $this->get_options_v2($notifications);

        $response['notifications'] = NotificationAppUserResource::collection($this->notification->get_description_notifications($notifications));
        $response['pagination_options'] = $pagination_options;

        return response_api(true, trans('api.success'), $response);
    }

    public function mark_as_read(Request $request , $notification_id) {

        $user = $request->user;
        $this->notification->where('id' , '=' , $notification_id)
                            ->update([
                                'read_at' => Carbon::now()
                            ]);

        return response_api(true, trans('api.success'), [
            'unread_notifications' => $user->unreadnotifications()->count()
        ]);
    }

    public function test() {

        $data =[
            'from_user_id' => 9 ,
            'user_id' => 9 ,
            'type' => 1 ,
            'order_id' => 18 ,
            'status' => 1,
            'data' => ['order_id' => 18]
        ];
        $test = (new SendNotificationJob($data));
        dispatch($test);
        return "done";
       // return $this->notification->add_notification($data);
    }
}
