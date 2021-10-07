<?php

namespace App\Http\Controllers\Website;

use App\Models\OrderBank;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller\Website;
use phpDocumentor\Reflection\Types\Self_;

// models
use App\Models\Brand;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Bank;

use Illuminate\Support\Facades\Cache;

use App\Repository\OrderRepository;
use App\Repository\CartRepository;
use App\Validations\OrderValidation;

use  App\Http\Controllers\Api\OrderController;

class BankTransferController extends Controller
{


    public function __construct()
    {
        parent::__construct();
    }

    public function bank_transfer(Request $request , $order_number) {

        $breadcrumb_arr = [['name' => trans('website.home'), 'url' => "/"]];
        $banks = Bank::Active()->get();
        $order = Order::where('order_number' , $order_number)->first();
        if(!$order) { abort(404);}
        parent::$data['breadcrumb_title'] = trans('website.bank_transfer');
        parent::$data['breadcrumb_arr'] = $breadcrumb_arr;
        parent::$data['breadcrumb_last_item'] = trans('website.bank_transfer');
        parent::$data['title'] = parent::$data['breadcrumb_title'];

        parent::$data['banks'] = $banks;
        parent::$data['order'] = $order;


        $order_bank = OrderBank::withTrashed()->where('order_id' , '=' , $order->id)->get();
        parent::$data['count_transformation'] = $order_bank->count();

        return view('website.order.bank_transfer' , parent::$data);
    }


}
