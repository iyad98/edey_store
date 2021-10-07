<?php
/**
 * Created by PhpStorm.
 * User: Al
 * Date: 13/6/2020
 * Time: 06:30 م
 */

namespace App\Services;

use App\Models\Gallery;
use Carbon\Carbon;
use Golchha21\ReSmushIt\Facades\Optimize;
use Golchha21\ReSmushIt\ReSmushIt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use DB;

use App\Models\ProductImage;
use App\Models\ProductVariationImage;

use Intervention\Image\Facades\Image;
use App\Facades\AwsFacade;
use App\Jobs\OptimizeImageJob;

class FileService
{


    public function __construct()
    {
    }

    public function storeImage($file , $folder,$model , $attr , $add , $thumb = true , $other_file = false ) {
        if($file instanceof UploadedFile) {
            return $this->store_cloud($file , $folder , $thumb , $other_file);
        }else if(is_numeric($file)) {
            if(!$add) {
                $previous_gallery = Gallery::where('src' , '=' , $model->getOriginal($attr))
                    ->where('num_used' , '>' , 0)->first();
                optional($previous_gallery  ,function ($value){
                    $value->decrement('num_used');
                });
            }
            $new_gallery =  Gallery::find($file);
            $new_gallery->increment('num_used');
            return  $new_gallery->getOriginal('src');
        }else {
            if(!$add && $model instanceof Model) {
                return  $model->getOriginal($attr);
            }else {
                return getImage($folder, false);
            }
        }


//        if($file instanceof UploadedFile) {
//            return $this->store_local($file , $folder , $thumb , $other_file);
//        }else if(is_numeric($file)) {
//            if(!$add) {
//                $previous_gallery = Gallery::where('src' , '=' , $model->getOriginal($attr))
//                    ->where('num_used' , '>' , 0)->first();
//                optional($previous_gallery  ,function ($value){
//                    $value->decrement('num_used');
//                });
//            }
//            $new_gallery =  Gallery::find($file);
//            $new_gallery->increment('num_used');
//            return  $new_gallery->getOriginal('src');
//        }else {
//            if(!$add && $model instanceof Model) {
//                return  $model->getOriginal($attr);
//            }else {
//                return getImage($folder, false);
//            }
//        }

    }

    public function store_local($file , $folder , $thumb = true , $other_file = false) {

        $ext = $file->getClientOriginalExtension();
        $date_today = Carbon::now()->format('Y-m-d');
        $file_content = File::get($file);

        $folder_path = $folder."/$date_today";
        $path = getUploadsPath($folder_path);



        if(!File::exists($path)) {
            File::makeDirectory($path , 0777,true);
        }
        $file_random_name = Str::random(20) . time() .Str::random(20);
        $file_name = $file_random_name. "." . $ext;
        $file_name_jpg = $file_name;
       // $file_name_jpg = $file_random_name.".jpg";

        $full_path = $path."/".$file_name;

        File::put($full_path, $file_content);
        Optimize::path($full_path);

        if(!$other_file) {
//            Image::make($full_path)->save($path."/".$file_name_jpg , 80 , 'jpg');
//
//            if($thumb) {
//                $thumb_path = getUploadsThumbPath($folder_path);
//                if(!File::exists($thumb_path)) {
//                    File::makeDirectory($thumb_path , 0777,true);
//                }
//                Image::make($path."/".$file_name_jpg)->resize(200 , 200)->save($thumb_path."/".$file_name_jpg);
//
//            }
            return $folder_path."/".$file_name_jpg;
        }else {
            return $folder_path."/".$file_name;
        }


    }
    public function deleteImage(Model $model) {
        if(!Str::contains( $model->getOriginal('image'), "default.png") ) {
            File::delete(public_path()."/uploads/".$model->getOriginal('image'));
        }
    }

    // delete image
    public function delete_image_v1(Model $model) {
        if($this->check_if_default_image($model , 'image')) {
            File::delete(public_path()."/uploads/".$model->getOriginal('image'));
        }

    }
    public function delete_image_v2(Model $model) {
        if($this->check_if_default_image($model , 'image_ar')) {
            File::delete(public_path()."/uploads/".$model->getOriginal('image_ar'));
        }
        if($this->check_if_default_image($model , 'image_en')) {
            File::delete(public_path()."/uploads/".$model->getOriginal('image_en'));
        }
        if($this->check_if_default_image($model , 'image_website_ar')) {
            File::delete(public_path()."/uploads/".$model->getOriginal('image_website_ar'));
        }
        if($this->check_if_default_image($model , 'image_website_en')) {
            File::delete(public_path()."/uploads/".$model->getOriginal('image_website_en'));
        }
    }

    public function check_if_default_image(Model $model ,$image) {
        if(!Str::contains( $model->getOriginal($image), "default.png") && !Str::contains( $model->getOriginal($image), "galleries") ) {
            return true;
        }
        return false;
    }


    public function decrementNumUsedGallery($model)
    {
        $images = [];
        $images[] = $model->getOriginal('image');
        $images[] = $model->getOriginal('image_ar');
        $images[] = $model->getOriginal('image_en');
        $images[] = $model->getOriginal('image_website_ar');
        $images[] = $model->getOriginal('image_website_en');

        $images = array_filter($images , function ($value){
            return !is_null($value);
        });
        $images =  array_count_values($images);
        foreach ($images as $key=>$value) {
            Gallery::whereIn('src', [$key])->where('num_used', '>', 0)
                ->update(['num_used' => DB::raw("num_used - $value")]);
        }

    }
    public function decrementNumUsedProductGallery($model)
    {

        $images = [];
        $images[] = $model->getOriginal('image');
        $images = array_merge($images ,$model->images()->toBase()->pluck('image')->toArray());
        $images = array_merge($images , ProductVariationImage::whereHas('product_variation' , function ($query) use($model){
            $query->where('product_id' , '=' ,$model->id );
        })->toBase()->pluck('image')->toArray());

        $images =  array_count_values($images);

        foreach ($images as $key=>$value) {
            Gallery::whereIn('src', [$key])->where('num_used', '>', 0)
                ->update(['num_used' => DB::raw("num_used - $value")]);
        }
    }
    public function store_cloud($file , $folder , $thumb = true , $other_file = false) {

        $ext = $file->getClientOriginalExtension();
        $date_today = Carbon::now()->format('Y-m-d');
        $file_content = File::get($file);

        $folder_path = $folder."/$date_today";
        $file_random_name = Str::random(20) . time() .Str::random(20).".$ext";
        $saved_file = $folder_path."/".$file_random_name;
        $full_path = "uploads/".$saved_file;


        // store in cloud
        if ($ext != 'gif'){
            $file_content = Image::make($file)->encode('jpg', 50);
        }

        AwsFacade::upload_file($full_path ,$file_content );

        if(!$other_file) {
            if($thumb) {
                $thumb_path = "uploads/optimize/".$saved_file;
                $optimize_image = (new OptimizeImageJob($full_path , $thumb_path, $file_random_name));
                dispatch($optimize_image);
            }
        }
        return $saved_file;

    }
}