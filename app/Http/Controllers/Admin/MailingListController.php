<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MailingListExport;
use App\Models\MailingList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Excel;
class MailingListController extends HomeController
{
    public function __construct()
    {
        $this->middleware('check_role:view_mailing_list', ['only' => ['index']]);

        parent::__construct();

        parent::$data['route_name'] = trans('admin.mailing_list');
        parent::$data['route_uri'] = route('admin.mailing_list.index');

        parent::$data['active_menu'] = 'mailing_list';

    }
    public function index(){
        return view('admin.mailing_list.index', parent::$data);

    }
    public function get_mailing_list_ajax(){
        $mailing_list = MailingList::select('*');
        return DataTables::of($mailing_list)
           ->escapeColumns(['*'])->make(true);
    }

    public function download_excel_mailing_list(){
        $mailing_list = MailingList::select('*')->get();

        return Excel::download(new MailingListExport($mailing_list), "mailing_list.xlsx");

    }
}
