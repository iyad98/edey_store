<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Gallery\AddGalleryRequest;

use App\Models\GalleryType;
use App\Models\Gallery;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class GalleryController extends HomeController
{


    public function __construct()
    {

        parent::__construct();
        parent::$data['route_name'] = trans('admin.galleries');
        parent::$data['route_uri'] = route('admin.galleries.index');
        parent::$data['active_menu'] = '';
        parent::$data['sub_menu'] = 'galleries';

    }
    public function index()
    {
        parent::$data['types'] = GalleryType::all();
        return view('admin.galleries.index', parent::$data);

    }

    public function create()
    {


    }

    public function store(AddGalleryRequest $request)
    {

        $data = $request->validated();
        $path = $this->store_file_service($request->src ,'galleries' , null , null , true);

        try {
            $size = get_headers('https://q8store-space.fra1.digitaloceanspaces.com/uploads/galleries/2021-03-26/Vg2EaxQaOeaQEGLy7NvM1616790099kvsGLquUXEhYpQkk4yUD.png', 1)['Content-Length'];
            $mime_type = @getimagesize('https://q8store-space.fra1.digitaloceanspaces.com/uploads/galleries/2021-03-26/Vg2EaxQaOeaQEGLy7NvM1616790099kvsGLquUXEhYpQkk4yUD.png')['mime'];

        }catch (\Exception $e) {
            $size = 0;
            $mime_type = "image";
        }

        $data['src'] = $path;
        $data['size'] = $size;
        $data['mime_type'] = $mime_type;

        $gallery = Gallery::create($data);
        return general_response(true,true, trans('admin.success') ,'' , [], [
            'gallery' => $gallery
        ]);
//
//        $data = $request->validated();
//
//        $path = $this->store_file_service($request->src ,'galleries' , null , null , true);
//
//        $data['src'] = $path;
//        $data['size'] = File::size(getUploadsPath($path));
//        $data['mime_type'] = File::mimeType(getUploadsPath($path));
//
//        $gallery = Gallery::create($data);
//        return general_response(true,true, trans('admin.success') ,'' , [], [
//            'gallery' => $gallery
//        ]);
    }


    public function show($id)
    {

    }


    public function edit($id)
    {

    }


    public function update(AddGalleryRequest $request, Gallery $gallery)
    {
        $data = $request->validated();
        $path = $this->store_file_service($request->src ,'galleries' , $gallery , 'src' , false);

        $image = Image::make(getUploadsPath($path));

        $data['src'] = $path;
        $data['size'] = $image->filesize();
        $data['mime_type'] = $image->mime();

        $gallery->update($data);
        return general_response(true,true, trans('admin.success') ,'' , [], [
            'gallery' => $gallery
        ]);
    }


    public function destroy($id)
    {
        $gallery = Gallery::find($id);
        try {
            if($gallery->num_used > 0) {
                return general_response(false,true,'' , trans('admin.cant_remove_because_used') , [], []);
            }
            File::delete(public_path()."/uploads/".$gallery->getOriginal('src'));
            File::delete(public_path()."/uploads/thumbs/".$gallery->getOriginal('src'));

            $gallery->delete();
            return general_response(true,true, trans('admin.success') ,'' , [], []);

        } catch (\Exception $e) {
            return general_response(false,true, $e->getMessage() ,'' , [], []);
        } catch (\Error $e) {
            return general_response(false,true, $e->getMessage() ,'' , [], []);

        }
    }


    // help function
    public function get_remote_gallery(Request $request) {
        $galleries = Gallery::latest()->Search($request->search)->Type($request->type_id)
            ->paginate($request->paginate ?? 10);
        return $galleries;
    }
}
