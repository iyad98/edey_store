<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:admin' , ['except'=> ['logout']]);
    }

    public function show_login() {
        return view('admin.auth.login');
    }

    public function login(Request $request) {
       $email = $request->email;
       $password = $request->password;

       $data = ['admin_email' => $email , 'password' => $password];
       if(Auth::guard('admin')->attempt($data)) {
           if(Auth::guard('admin')->user()->admin_status == 0) {
               Auth::guard('admin')->logout();
               return redirect()->back()->with('error' , trans('auth.not_active'));
           }
           return redirect()->intended('admin/');
       }else {
           return redirect()->back()->with('error' , trans('auth.fail_login'));
       }
    }



    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.auth.login');
    }
}
