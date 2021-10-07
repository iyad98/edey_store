<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Repository\AdminRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;


/*  Models */
use App\Models\Order;
class ChatController extends HomeController
{


    public function __construct()
    {

        parent::__construct();
        parent::$data['active_menu'] = 'chats';
    }

    public function index()
    {
      //  $order_pending = Order::whereIn('status' , [0,1,2,3,4])->select('id' , 'type' ,'user_id')->get();
     //   parent::$data['order_pending'] = $order_pending;
        return view('admin.chats.chat', parent::$data);
    }

    public function index2()
    {
        return view('admin.chats.chat_new', parent::$data);
    }

    public function get_paginate_chats(Request $request) {
        $page = $request->page;
        $search = $request->search;
        $type = $request->type;
        $is_search = $request->is_search;
        $length = 10;

        $pending = [order_status()['pending_add'] ,order_status()['pending_confirm_form_user']
            ,order_status()['pending'] ,order_status()['processing'] ,order_status()['on_the_way'] ];

        $finished =[order_status()['delivered'] , order_status()['cancel_from_user'] , order_status()['return']];

        if($is_search == 1) {
            $page = 1;
        }
        $orders = Order::select('*')->with('user')->latest()->take($length)->skip(($page - 1)*$length);
        if(!empty($search)) {
            $orders = $orders->where('id' , '=' , $search);
        }
        if($type == 1) {
            $orders->whereIn('status' ,$pending );
        }else if($type == 2) {
            $orders->whereIn('status' ,$finished );
        }
        $orders = $orders->get();

        return response()->json(['orders' => $orders]);
    }


}
