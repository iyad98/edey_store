<?php

namespace App\Services;

use DB;

// jobs
use App\Jobs\ResizeImageJob\DispatchResizeProductImage;

class ResizeImageService
{


    public function __construct()
    {

    }
    public static function resize_product_image($product , $width=200 , $height=200) {
        $resize_image = (new DispatchResizeProductImage($product , $width ,$height ));
        dispatch($resize_image);
    }

}