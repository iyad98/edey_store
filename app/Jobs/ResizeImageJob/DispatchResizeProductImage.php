<?php

namespace App\Jobs\ResizeImageJob;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

// service
use App\Services\StoreFile;

class DispatchResizeProductImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $product;
    public $width;
    public $height;
    public function __construct( $product , $width ,$height )
    {
        $this->product = $product;
        $this->width = $width;
        $this->height = $height;
    }


    public function handle()
    {
        (new StoreFile(null))->resize_product_images($this->product , $this->width , $this->height);
//        try {
//            (new StoreFile(null))->resize_product_images($this->product);
//
//        }catch (\Exception $e) {
//
//        }catch (\Error $e) {
//
//        }

    }
}
