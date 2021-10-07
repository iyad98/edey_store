<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller\Website;
use phpDocumentor\Reflection\Types\Self_;

// models
use App\Models\Product;

class RSSController extends Controller
{


    public function __construct()
    {

    }

    public function show(Request $request, $product_id) {
        $product = Product::find($product_id);
        return [
            'name' => optional($product)->name_ar ,
            'description' => optional($product)->description_ar ,
            'image' => optional($product)->image
        ];
    }


}
