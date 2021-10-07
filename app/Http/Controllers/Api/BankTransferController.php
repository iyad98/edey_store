<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\StoreFile;

use DB;
use Carbon\Carbon;

/* Traits */

use App\Traits\PaginationTrait;

/* Models */

use App\Models\Order;
use App\Models\Bank;

/*  Resources  */

use Illuminate\Support\Facades\Validator;

use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Order\OrderDetailsResource;
use App\Http\Resources\Order\BankResource;

/*  Repository */
use App\Repository\OrderRepository;
use App\Repository\BankTransferRepository;

/*  validations */
use App\Validations\OrderValidation;
use Illuminate\Support\Str;

/*  services */
use App\Services\CartService;
use App\Services\NotificationService\MakeOrderNotification;

// notifications
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendMakeOrderNotification;

class BankTransferController extends Controller
{

    public $order;
    public $validation;

    public function __construct(OrderRepository $order, OrderValidation $validation)
    {
        $this->order = $order;
        $this->validation = $validation;
    }

    // order bank
    public function get_banks()
    {
        $banks = Bank::Active()->get();
        $response['banks'] = BankResource::collection($banks);
        return response_api(true, trans('api.done'), $response);
    }

    public function bank_transfer(Request $request)
    {
        $bank_transfer = new BankTransferRepository(new Order(), $this->validation);


        $send_bank_transfer = $bank_transfer->bank_transfer($request);

        if ($request->has('web')) {
            return $send_bank_transfer;
        } else {
            return response_api($send_bank_transfer['status'], $send_bank_transfer['message'], $send_bank_transfer['data']);
        }
    }
}
