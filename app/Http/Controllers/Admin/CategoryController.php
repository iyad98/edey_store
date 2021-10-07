<?php

namespace App\Http\Controllers\Admin;


use App\Models\Category;
use App\Models\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;

use App\User;
use App\Models\AppHome;
use App\Models\WebsiteHome;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use App\Services\StoreFile;

use App\Http\Resources\CategoryDataResourceDFT;

// jobs
use App\Jobs\UpdateCategoriesBannersAppJob;

use App\Services\SWWWTreeTraversal;

class CategoryController extends HomeController
{

    public $category;

    public function __construct(CategoryRepository $category)
    {
        $this->middleware('check_role:view_categories|add_categories|edit_categories|delete_categories', ['only' => ['index']]);
        $this->middleware('check_role:add_categories', ['only' => ['store']]);
        $this->middleware('check_role:edit_categories', ['only' => ['update']]);
        $this->middleware('check_role:delete_categories', ['only' => ['delete']]);

        parent::__construct();
        parent::$data['route_name'] = trans('admin.categories');
        parent::$data['route_uri'] = route('admin.categories.index');
        parent::$data['active_menu'] = 'categories';
        $this->category = $category;
    }

    public function index()
    {

        return view('admin.categories.index', parent::$data);
    }


    public function store(Request $request)
    {


        $rules = [
           // 'name_en' => 'required',
            'name_ar' => 'required',
            // 'description_en' => 'required',
            // 'description_ar' => 'required',
            'parent' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
            $name_ar = $request->name_ar;
            $description_en = $request->filled('description_en') ? $request->description_en : "";
            $description_ar = $request->filled('description_ar') ?  $request->description_ar : "";
            $parent = $request->parent == -1 ? null : $request->parent;

            $path = $this->store_file_service($request->image , 'categories' , null , null ,true , false);
            $guide_image_path = $this->store_file_service($request->guide_image , 'categories' , null , null ,true , false);

            if (!is_null($parent)) {
                $type = Category::find($parent)->type;
            }

            $slug_ar = get_slug($name_ar);
            $slug_en = get_slug($name_en);

            $add = $this->category->create([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'slug_ar' => $slug_ar,
                'slug_en' => $slug_en,
                'description_en' => $description_en,
                'description_ar' => $description_ar,
                'parent' => $parent,
                'image' => $path,
                'guide_image' => $guide_image_path
            ]);

            $this->category->update_category_in_cache();
            update_all_category_with_parents();

            if ($add) {
                $this->add_action("add_category","category" , json_encode($add));
                return general_response(true, true, trans('admin.success'), "", "",
                    [
                        'category_parent' => get_all_category_with_parents(),
                        'parent_id' => $add->parent
                    ]
                );

            } else {
                return general_response(false, true, "", trans('admin.error'), "", []);

            }
        }
    }

    public function update(Request $request)
    {

        $id = $request->id;
        $rules = [
          //  'name_en' => 'required',
            'name_ar' => 'required',
            //    'description_en' => 'required',
            //    'description_ar' => 'required',
            'parent' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->errors();
            $get_one_message = get_error_msg($rules, $messages);
            return general_response(false, true, "", $get_one_message, "", []);
        } else {
            $name_en = $request->filled('name_en') ? $request->name_en : $request->name_ar;
            $name_ar = $request->name_ar;
            $description_en = $request->filled('description_en') ? $request->description_en : "";
            $description_ar = $request->filled('description_ar') ?  $request->description_ar : "";

            $slug_ar = get_slug($name_ar);
            $slug_en = get_slug($name_en);

            $parent = $request->parent == -1 ? null : $request->parent;

            $obj = Category::find($id);

            $path = $this->store_file_service($request->image, 'categories', $obj, 'image', false , false);
            $guide_image_path = $this->store_file_service($request->guide_image, 'categories', $obj, 'guide_image', false , false);

            $tree = get_categories_cache();
            $tree = json_decode(collect($tree)->where('id', '=', $obj->id), true);

            $conf = array('tree' => $tree);
            $instance = new SWWWTreeTraversal($conf);
            $category_ids = $instance->get();

            Category::whereIn('id' ,$category_ids)->update([
                'guide_image' => $guide_image_path
            ]);
            $update = $obj->update([
                'name_en' => $name_en,
                'name_ar' => $name_ar,
                'slug_ar' => $slug_ar,
                'slug_en' => $slug_en,
                'description_en' => $description_en,
                'description_ar' => $description_ar,
                'parent' => $parent,
                'image' => $path,
                'guide_image' => $guide_image_path
            ]);
            $this->category->update_category_in_cache();
            update_all_category_with_parents();

            
            if ($update) {
                $this->add_action("update_category","category" , json_encode($obj));
                return general_response(true, true, trans('admin.success'), "", "",
                    [
                        'category_parent' => get_all_category_with_parents(),
                        'parent_id' => $obj->parent
                    ]
                );

            } else {
                return general_response(false, true, "", trans('admin.error'), "", []);

            }
        }
    }

    public function delete(Request $request)
    {
        $category = Category::find($request->id);
        $parent_id = $category->parent;
        if($category->products()->count() > 0) {
            return general_response(false, true, "", trans('admin.cant_delete_because_have_products'), "", []);
        }
        try {
            AppHome::where('type_id' , '=' , $request->id)->where('type' , '=' , 1)->delete();
            WebsiteHome::where('type_id' , '=' , $request->id)->where('type' , '=' , 1)->delete();

            $category->children()->delete();
            $category->delete();

            $this->category->update_category_in_cache();
            update_all_category_with_parents();

            $this->add_action("delete_category","category" , json_encode($category));

            return general_response(true, true, "", "", "",
                [
                    //     'category_parent' => $this->category->all() ,
                    'parent_id' => $parent_id
                ]
            );
        } catch (\Exception $e) {
            return general_response(false, true, "", trans('admin.error'), "", []);

        }


    }

    public function get_category_ajax(Request $request)
    {
        $filters = [
            'parent' => $request->filled('parent') ? $request->parent : null,
        ];
        $categories = $this->category->filter($filters)->with(['parent', 'children']);

        return DataTables::of($categories)
            ->editColumn('name_en', function ($model) {
                if ($model->children->count() > 0) {
                    return view('admin.categories.parts.show_category', ['id' => $model->id, 'name' => $model->name_en])->render();
                } else {
                    return $model->name_en;
                }
            })
            ->addColumn('name_en_edit', function ($model) {
                return $model->name_en;
            })->addColumn('name_ar_edit', function ($model) {
                return $model->name_ar;
            })
            ->editColumn('name_ar', function ($model) {
                if ($model->children->count() > 0) {
                    return view('admin.categories.parts.show_category', ['id' => $model->id, 'name' => $model->name_ar])->render();
                } else {
                    return $model->name_ar;
                }
            })
            ->editColumn('show_image', function ($model) {
                return view('admin.categories.parts.image', ['image' => $model->image])->render();
            })
            ->addColumn('actions', function () {
                return view('admin.categories.parts.actions')->render();
            })->escapeColumns(['*'])->make(true);
    }


    /*   helpers functions */
    public function get_category_parent()
    {
       // return response()->json($this->category->all());
        return response()->json(get_all_category_with_parents());

    }

    public function get_tree_of_parent(Request $request)
    {
        $id = $request->category_id;
        $category = Category::find($id);

        /*
         if($category) {
             $parent = $category->parent_;

             while($parent) {
                 $parents[] = $parent;
                 $parent = $parent->parent_;
             }
             if($category) {
                 $parents[] = $category;
             }

         }*/
        if ($category) {
            $parents = $category->getParentsAttribute();
        }
        $parents[] = ['id' => -1, 'name' => trans('admin.main_category')];
        $parents = array_reverse(collect($parents)->toArray());
        return response()->json($parents);
    }

    public function get_remote_ajax_categories(Request $request)
    {
        $search = $request->get('q');
        $data = Category::select(['id', 'name_ar', 'name_en'])
            ->where('name_ar', 'like', '%' . $search . '%')
            ->orWhere('name_en', 'like', '%' . $search . '%')
            ->paginate(10);
        return response()->json(['items' => $data->toArray()['data'], 'incomplete_results' => $data->nextPageUrl() ? true : false, 'total_count' => $data->total()]);
    }

    public function get_remote_ajax_leaf_categories(Request $request)
    {
        $search = $request->get('q');
        $data = Category::whereDoesntHave('children')
            ->select(['id', 'name_ar', 'name_en'])
            ->where(function ($query) use($search){
                $query->where('name_ar', 'like', '%' . $search . '%')
                    ->orWhere('name_en', 'like', '%' . $search . '%');
            })->paginate(10);
        return response()->json(['items' => $data->toArray()['data'], 'incomplete_results' => $data->nextPageUrl() ? true : false, 'total_count' => $data->total()]);
    }


}
