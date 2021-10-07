<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(is_null($this->category_id ) && is_null($this->product_id )) {
            $id = -1;
            $name = "";
            $type = 0;
            $type_text = 'nothing';
        }else if(!is_null($this->category_id )) {
            $id = $this->category_id;
            $name = $this->category ? $this->category->name : "";
            $type = 1;
            $type_text = 'category';
        }else {
            $id = $this->product_id;
            $name = $this->product ? $this->product->name : "";
            $type = 2;
            $type_text = 'product';
        }
        return [
            'id' => $id ,
            'name' => $name ,
            'parent' => $this->parent_id ,
            'image' => $this->image ,
            'image_website' => $this->image_website,
            'type' => $type ,
            'type_text' => $type_text ,
            'have_children' =>false ,
            //  'children' => self::collection($this->children)
        ];
    }
}
