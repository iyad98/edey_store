<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller\Website;
use phpDocumentor\Reflection\Types\Self_;
use Illuminate\Support\Facades\Validator;

// models
use App\Models\Contact;

use Illuminate\Support\Facades\Cache;

use App\Repository\OrderRepository;
use App\Repository\CartRepository;
use App\Validations\OrderValidation;

use  App\Http\Controllers\Api\OrderController;

class ContactController extends Controller
{


    public function __construct()
    {
        parent::__construct();
    }

    public function send_contact(Request $request) {

        $rules = [
            'name' => 'required|max:250',
            'email' => 'required|email|max:250',
            'message' => 'required',


        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {

            $name = $request->name;
            $email = $request->email;
            $message = $request->message;

            Contact::create([
                'name' => $name ,
                'email' => $email ,
                'message' => $message,
            ]);
            return general_response(true, true, trans('website.send_contact_successfully'), "", "", []);

        }

    }


}
