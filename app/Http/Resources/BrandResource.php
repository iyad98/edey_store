<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{


    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'title' => $this->name ,
            'slug' => $this->slug ,
            'description' => $this->description ,
            'image' => $this->image,
            'product_count'=> Product::where('brand_id', $this->id)->count()
        ];
    }
}
