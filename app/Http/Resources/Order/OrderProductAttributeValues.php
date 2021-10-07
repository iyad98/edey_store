<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductAttributeValues extends JsonResource
{

    public function toArray($request)
    {
        $key= $this->attribute_value->attribute->attribute_type->key;
        return [
            'id' => $this->attribute_value->id ,
            'key' => $this->attribute_value->attribute->attribute_type->key ,
            'name' => $this->attribute_value->name  ,
            'value' => $key == 'image' ? add_full_path($this->attribute_value->value , 'attribute_values') : $this->attribute_value->value,

        ];
    }
}
