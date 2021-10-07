<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 9/8/2019
 * Time: 11:36 م
 */

namespace App\Services;


use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

// Models
use App\Models\ProductVariationImage;

class StoreFile
{

    public $file;
    public function __construct($file)
    {
        $this->file = $file;
    }

    public function store_local($path) {

        $ext = $this->file->getClientOriginalExtension();
        $file_content = File::get($this->file);
        $file_name = Str::random(20) . time() .Str::random(20). "." . $ext;
        $full_path = public_path() . "/uploads/".$path."/". $file_name;

        $path = $path.$file_name;
        File::put($full_path, $file_content);
        return $file_name;
    }

    public function resize_product_images($product , $width=400 ,$height=400 )
    {

        $images = $this->get_product_images($product);
        foreach ($images as $image) {
            $thumb_image = Image::make($image['image'])->resize($width, $height);
            $thumb_path = public_path() . "/uploads/thumbs/products" . "/" . $image['original_image'];
            if(!File::exists($thumb_path)) {
                $thumb_image->save($thumb_path);
            }

        }


    }


    // delete product images
    public function delete_product_images($product) {
        $images = $this->get_product_images($product);
        foreach ($images as $image) {
            if($image['original_image'] != get_default_image()) {
                File::delete(public_path('') . "/uploads/products/" . $image['original_image']);
                File::delete(public_path('') . "/uploads/thumbs/products/" . $image['original_image']);
            }


        }

    }

    // get images for products
    public function get_product_images($product) {
        $images = [];
        $product_variation_ids = $product->all_variations->pluck('id')->toArray();

        $product_images = $product->images;
        foreach ($product_images as $product_image) {
            $images[] = ['original_image' => $product_image->getOriginal('image'), 'image' => $product_image->image];
        }

        $product_variation_images = ProductVariationImage::whereIn('product_variation_id', $product_variation_ids)->get();
        foreach ($product_variation_images as $product_variation_image) {
            $images[] = [
                'original_image' => $product_variation_image->getOriginal('image'),
                'image' => $product_variation_image->image
            ];
        }

        $images[] = ['original_image' => $product->getOriginal('image') , 'image' =>$product->image ];
        return $images;
    }
}