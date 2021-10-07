<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => (int) $this->id ,
            'name' => $request->is_nickname ? $this->nickname :$this->name  ,
            'parent' => $this->parent ? $this->parent :0 ,
            'parent_app' => $this->parent_app ? $this->parent_app :0 ,

            'image' => $this->image ,
            'have_children' => $this->children_count && $this->children_count > 0 ? true : false ,

        ];
    }
}
