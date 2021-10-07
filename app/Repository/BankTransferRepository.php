<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 9/8/2019
 * Time: 11:29 م
 */

namespace App\Repository;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

// models
use App\Models\UserShipping;
use App\Models\Order;
use App\Models\OrderBank;

use App\Services\StoreFile;


use App\Validations\OrderValidation;

class BankTransferRepository
{

    public $order;
    public $validation;

    public function __construct(Order $order, OrderValidation $validation)
    {
        $this->order = $order;
        $this->validation = $validation;
    }

    public function __call($name, $arguments)
    {
        return $this->user->$name(...$arguments);
    }

    public function bank_transfer(Request $request)
    {

       
        $check_data = $this->validation->check_bank_transfer_data($request->toArray());
        if ($check_data['status']) {
            $order = $this->order->find($request->order_id);
            $order_bank = OrderBank::withTrashed()->where('order_id' , '=' , $order->id)->get();
            if($order_bank->count() >= 2) {
                return ['status' => false, 'message' => trans('api.exceeded_limit_send_bank_transfer'), 'data' => []];
            }

            optional( $order_bank->first())->delete();
            if ($request->hasFile('file')) {
                $path = (new StoreFile($request->file))->store_local('order_bank');
            } else {
                $path = null;
            }
            $order->bank()->create([
                'bank_id' => $request->bank_id,
                'name' => $request->name,
                'account_number' => $request->account_number,
                'price' => $request->price,
                'file' => $path,
            ]);


            return [
                'status' => true,
                'message' => trans('api.sent_bank_transfer_success'),
                'data' => []
            ];
        } else {
            return [
                'status' => false,
                'message' => $check_data['message'],
                'data' => []
            ];
        }


    }
}