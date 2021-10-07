<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Country;
use App\Models\Neighborhood;
use App\Models\OrderBank;
use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
/*  Models */

use App\Models\FilterData;
use App\Models\Slider;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariation;
/* service */

use App\Services\StoreFile;
use App\Services\Firestore;
use App\Services\NotificationService\BankNotification;
use App\Services\ShippingService\SAMSAShipping\SAMSA;
use App\Services\JawalService\SendMessage;
use App\Services\ShippingService\SAMSAShipping\SAMSALibrary;
use DB;

use Illuminate\Validation\Rule;
use  App\Jobs\SendNotificationJob;
use App\Jobs\DispatchSendEmail;

use App\Services\ResizeImageService;

// test
use App\Services\Firebase;
use App\Services\NotificationService\NotificationAdminService;

// notification
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendApproveBankTransferNotification;
use App\Notifications\SendRejectBankTransferNotification;

class BankTransferController extends HomeController
{


    public function __construct()
    {
        $this->middleware('check_role:view_order_transfer');

        parent::__construct();
        parent::$data['route_name'] = trans('admin.bank_transfers');
        parent::$data['route_uri'] = route('admin.order_bank.index');
        parent::$data['active_menu'] = 'order_bank';

    }


    public function index()
    {

       // return (new NotificationAdminService())->remove_auth_admin_fcm_expire();

        return view('admin.order_bank.index', parent::$data);
    }


    public function approve(Request $request)
    {
        $order_bank = OrderBank::find($request->id);

        try {

            if(!$order_bank->order) {
                return general_response(false, true, "", trans('api.product_not_found'), "", []);
            }
            $order_bank->status = 1;
            $order_bank->update();

            $order = Order::with('order_user_shipping')->find($order_bank->order_id);
            $order->status = order_status()['processing'];
            $order->update();
            // send notification to user
            Notification::route('test', 'test')->notify(new SendApproveBankTransferNotification($order));
          //  BankNotification::send_approve_notification($order);

            $this->add_action("approve_bank_transfer" ,'bank_transfer', json_encode($order_bank));
            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }
    }

    public function reject(Request $request)
    {
        $order_bank = OrderBank::find($request->id);

        try {
            if(!$order_bank->order) {
                return general_response(false, true, "", trans('api.product_not_found'), "", []);
            }

            $order_bank->status = 2;
            $order_bank->reject_reason = $request->reject_reason;
            $order_bank->update();

            $order = Order::with('order_user_shipping')->find($order_bank->order_id);

            // send notification to user
            Notification::route('test', 'test')->notify(new SendRejectBankTransferNotification($order, $request->reject_reason));
            //  BankNotification::send_reject_notification($order, $request->reject_reason);

            $this->add_action("reject_bank_transfer" ,'bank_transfer', json_encode($order_bank));
            return general_response(true, true, "", "", "", []);
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }
    }

    public function get_order_bank_ajax(Request $request)
    {

        $order_bank = OrderBank::leftJoin('banks', 'order_bank.bank_id', '=', 'banks.id')
            ->select('order_bank.*', 'order_bank.status as order_bank_status', 'banks.name_ar as bank_name');

        return DataTables::of($order_bank)
            ->editColumn('order_id', function ($model) {
                return view('admin.order_bank.parts.order_number', ['order_id' => $model->order_id])->render();

            })->editColumn('file', function ($model) {
                return view('admin.order_bank.parts.file', ['file' => $model->file])->render();

            })->addColumn('actions', function ($model) {
                if ($model->order_bank_status == 0) {
                    return view('admin.order_bank.parts.actions', ['id' => $model->id])->render();

                } else if ($model->order_bank_status == 1) {
                    $order_bank_status_text = trans('admin.approved_bank_transfer');
                    $order_bank_status = $model->order_bank_status;
                    return view('admin.order_bank.parts.order_bank_status', [
                        'order_bank_status_text' => $order_bank_status_text,
                        'order_bank_status' => $order_bank_status,
                    ])->render();
                } else {
                    $order_bank_status_text = trans('admin.rejected_bank_transfer');
                    $order_bank_status = $model->order_bank_status;
                    $reject_reason = $model->reject_reason;

                    return view('admin.order_bank.parts.order_bank_status', [
                        'order_bank_status_text' => $order_bank_status_text,
                        'order_bank_status' => $order_bank_status,
                        'reject_reason' => $reject_reason,
                    ])->render();

                }

            })->escapeColumns(['*'])->make(true);
    }


}
