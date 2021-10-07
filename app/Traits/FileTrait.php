<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 04/08/19
 * Time: 10:08 ص
 */

namespace App\Traits;

use App\Facades\FileFacade;
use Illuminate\Database\Eloquent\Model;

trait FileTrait
{

    public function store_file_service($image , $folder ,$model, $attr , $add , $thumb = true , $other_file = false) {

        return FileFacade::storeImage($image, $folder,$model, $attr , $add , $thumb , $other_file);
    }
    public function decrement_num_used_gallery($model ) {
        return FileFacade::decrementNumUsedGallery($model);
    }
    public function decrement_num_used_product_gallery($model ) {
        return FileFacade::decrementNumUsedProductGallery($model);
    }
    public function delete_image_v1(Model $model) {
        FileFacade::delete_image_v1($model);
    }
    public function delete_image_v2(Model $model) {
        FileFacade::delete_image_v2($model);
    }

}