<?php

namespace App\Http\Controllers\Admin;

use App\Models\WebsiteHome;
use App\Models\Widget;
use App\Services\StoreFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;

class WidgetController  extends HomeController
{
    public function __construct()
    {

        $this->middleware('check_role:view_website');
        parent::__construct();
        parent::$data['active_menu'] = 'widget';


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.widget.index', parent::$data);
    }
    public function get_widget_ajax(){


        $website_home_for_widget = WebsiteHome::where('type',1)->get();
        return DataTables::of($website_home_for_widget)
            ->addColumn('actions', function ($model) {
                return view('admin.widget.parts.actions', ['id' => $model->id])->render();
            })->escapeColumns(['*'])->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $widget = Widget::where('website_home_id',$id)->first();
        parent::$data['widget'] = $widget;

        return view('admin.widget.edit', parent::$data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {


            $widget = Widget::where('website_home_id',$id)->first();

            $rules = [
                'image_ar' => 'required',
                'image_en' => 'required',
                'widget_type' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);




            if ($validator->fails()) {
                $messages = $validator->errors();
                $get_one_message = get_error_msg($rules, $messages);
                return general_response(false, true, "", $get_one_message, "", []);
            } else {

                if ($request->hasFile('image_ar')) {
                    $path_ar = (new StoreFile($request->image_ar))->store_local('ads');
                } else {
                    $path_ar = $widget->getOriginal('image_ar');
                }
                if ($request->hasFile('image_en')) {
                    $path_en = (new StoreFile($request->image_en))->store_local('ads');
                } else {
                    $path_en = $widget->getOriginal('image_en');
                }

                if ($request->hasFile('image_mobile_ar')) {
                    $path_mobile_ar = (new StoreFile($request->image_mobile_ar))->store_local('ads');
                } else {
                    $path_mobile_ar = $widget->getOriginal('image_mobile_ar');
                }
                $product_id = $request->product_id;
                $category_id = $request->category_id;

                $widget->update([
                    'image_ar' => $path_ar,
                    'image_en' => $path_en,
                    'image_mobile_ar' => $path_mobile_ar,
                    'widget_type' =>$request['widget_type'],
                    'website_home_id' =>$request['website_home_id'],

                ]);
                $this->add_action("update_website_note" ,'website_note', json_encode([]));
                return general_response(true, true, trans('admin.success'), "", "", []);
            }
        } catch (\Exception $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        } catch (\Error $e) {
            return general_response(false, true, "", $e->getMessage(), "", []);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
