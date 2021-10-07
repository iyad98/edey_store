<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Comment;
use App\Models\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

/*  Models */

use App\Models\FilterData;


/* service */

use App\Services\StoreFile;
use App\Services\Firestore;
use DB;
use Illuminate\Support\Facades\File;

use Illuminate\Validation\Rule;

class CommentController extends HomeController
{


    public function __construct()
    {

        $this->middleware('check_role:view_comments');


        parent::__construct();
        parent::$data['route_name'] = trans('admin.comments');
        parent::$data['route_uri'] = route('admin.comments.index');
        parent::$data['active_menu'] = 'comments';

    }


    public function index(Request $request)
    {
        /*
        $comments = Comment::select('status',DB::raw('count(*)'))
              ->groupBy('status')
              ->get();
        return $comments;
        */
        $comment_status = $this->get_comment_status_data();
        return view('admin.comments.index', parent::$data, ['comment_status' => $comment_status]);
    }


    public function change_status(Request $request)
    {
        $comment = Comment::find($request->id);

        try {
            $comment->status = $request->status;
            $comment->update([
                'status' => $request->status
            ]);

            $comment_status = $this->get_comment_status_data();
            return general_response(true, true, "", "", "", ['comment_status' => $comment_status]);
        } catch (\Exception $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        }
    }

    public function destroy(Request $request ,$id)
    {
        $comment = Comment::withTrashed()->find($id);
        $type = $request->type;
        try {
            if($type == 1) {
                $comment->delete();
            }else {
                $comment->restore();
            }

            $comment_status = $this->get_comment_status_data();
            return general_response(true, true, "", "", "", ['comment_status' => $comment_status]);

        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    public function get_comments_ajax(Request $request)
    {
        $get_comment_status = $request->get_comment_status;
        $comments = Comment::whereHas('product')->withTrashed()->with(['product:id,name_ar,name_en', 'user:id,first_name,last_name,image,email']);

        switch ($get_comment_status) {
            case 2 :
                $comments = $comments->whereNull('deleted_at')->pending();
                break;
            case 3 :
                $comments = $comments->whereNull('deleted_at')->approve();
                break;
            case 4 :
                $comments = $comments->whereNull('deleted_at')->disapprove();
                break;
            case 5 :
                $comments = $comments->onlyTrashed();
                break;

        }
        return DataTables::of($comments)
            ->addColumn('user_data', function ($model) {
                return view('admin.comments.parts.user_data', ['user' => $model->user])->render();
            })
            ->addColumn('actions', function ($model) {
                return view('admin.comments.parts.actions', ['status' => $model->status, 'deleted_at' => $model->deleted_at])->render();
            })->escapeColumns(['*'])->make(true);
    }
    public function get_comment_status_data()
    {

        $comments_approve_count = Comment::whereHas('product')->select(DB::raw('count(*)'))->whereRaw('status = 1');
        $comments_disapprove_count = Comment::whereHas('product')->select(DB::raw('count(*)'))->whereRaw('status = 2');
        $comments_pending_count = Comment::whereHas('product')->select(DB::raw('count(*)'))->whereRaw('status = 0');
        $comments_trash_count = Comment::whereHas('product')->withTrashed()->select(DB::raw('count(*)'))->whereRaw('deleted_at is not null');

        $comments_status = Comment::select(getSubQuerySql($comments_approve_count, 'count_approve'),
            getSubQuerySql($comments_disapprove_count, 'count_disapprove'),
            getSubQuerySql($comments_pending_count, 'count_pending'),
            getSubQuerySql($comments_trash_count, 'count_trash'))
            ->limit(1)->first();

        $response['approve'] = $comments_status ? $comments_status->count_approve : 0;
        $response['disapprove'] = $comments_status ? $comments_status->count_disapprove : 0;
        $response['pending'] = $comments_status ? $comments_status->count_pending : 0;
        $response['trash'] = $comments_status ? $comments_status->count_trash : 0;
        $response['all'] = $response['approve'] + $response['disapprove'] + $response['pending'] + $response['trash'];
        return $response;

    }

    public function get_comments_status() {
        return response()->json($this->get_comment_status_data());
    }



}
