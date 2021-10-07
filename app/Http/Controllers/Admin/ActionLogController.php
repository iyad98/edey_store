<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;

/* Traits */

use App\Traits\DateFilterTrait;

use Carbon\Carbon;

use Yajra\DataTables\DataTables;
use DB;

use App\Models\ActionLog;

class ActionLogController extends HomeController
{

    use DateFilterTrait;

    public $notification;


    public function __construct()
    {
        $this->middleware('check_role:view_action_logs', ['only' => ['index']]);

        parent::__construct();
        parent::$data['active_menu'] = 'action_logs';
        parent::$data['route_name'] = trans('admin.action_logs');
        parent::$data['route_uri'] = route('admin.action_logs.index');

    }

    public function index() {
        return view('admin.action_logs.index' , parent::$data);
    }
    public function get_action_logs_ajax(Request $request)
    {

        $logs = ActionLog::with(['admin']);
        $date_from = $request->filled('date_from') ? $request->date_from : -1 ;
        $date_to = $request->filled('date_to') ? $request->date_to : -1 ;

        $get_date_filter = $this->get_date_filter($date_from , $date_to);

        if($get_date_filter['date_from'] != -1 && $get_date_filter['date_to'] != -1) {
            $logs = $logs->where(DB::raw('date(action_logs.created_at)') , '>=' ,$get_date_filter['date_from'] )
                ->where(DB::raw('date(action_logs.created_at)') , '<=' ,$get_date_filter['date_to'] );
        }

        return DataTables::of($logs)
            ->addColumn('description', function ($model) {
                return $model->description;
            })->escapeColumns(['*'])->make(true);
    }


}
