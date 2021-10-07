<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductAttributeValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $key = $this->attribute_value->attribute->attribute_type->key ;
        return [
            'id' => $this->attribute_value->id ,
            'name' => $this->attribute_value->name ,
            'value' => $key == 'image' ? add_full_path($this->attribute_value->value , 'attribute_values') : $this->attribute_value->value,
            'is_selected' => $this->is_selected && $this->is_selected == 1 ? true : false ,
//            'is_selected' => in_array($this->attribute_value->id ,$request->attribute_values) ? true : false ,
          //  'aaa' => $request->aaa,
        ];
    }
}
