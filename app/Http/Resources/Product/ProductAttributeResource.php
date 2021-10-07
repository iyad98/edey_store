<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Product\ProductAttributeValueResource;

class ProductAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

       // $request->request->add('asd' , 'ddddd');
        return [
            'id' => $this->attribute_id ,
            'name' => $this->attribute->name ,
            'key' => $this->attribute->attribute_type->key ,
            'is_variation' => $this->is_variation != 0 ? true : false ,
            'attribute_values' => ProductAttributeValueResource::collection($this->attribute_values)

        ];
    }
}
