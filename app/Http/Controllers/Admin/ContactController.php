<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;


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

/* service */

use App\Services\StoreFile;
use App\Services\Firestore;
use DB;

use Illuminate\Validation\Rule;
use  App\Jobs\SendNotificationJob;
use App\Jobs\DispatchSendEmail;

class ContactController extends HomeController
{


    public function __construct()
    {
        $this->middleware('check_role:view_contacts');
        
        parent::__construct();
        parent::$data['route_name'] = trans('admin.contacts');
        parent::$data['route_uri'] = route('admin.contacts.index');
        parent::$data['active_menu'] = 'contacts';

    }


    public function index()
    {

        return view('admin.contacts.index', parent::$data);
    }


    public function get_contacts_ajax(Request $request)
    {

        $contacts = Contact::select('*');
        return DataTables::of($contacts)->escapeColumns(['*'])->make(true);
    }


}
