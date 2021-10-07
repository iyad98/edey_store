<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

class CartAttributeValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $key = $this->attribute->attribute_type->key ;
        return [
            'id' => $this->id ,
            'name' => $this->name ,
            'key' => $this->attribute->attribute_type->key ,
            'value' => $key == 'image' ? add_full_path($this->value , 'attribute_values') : $this->value,

        ];
    }
}
