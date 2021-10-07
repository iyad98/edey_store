<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryDataResourceDFT extends JsonResource
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
            'id' => $this->id ,
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'name' => $this->name,
            'nickname_ar' => $this->nickname_ar,
            'nickname_en' => $this->nickname_en,
            'website_nickname_ar' => $this->website_nickname_ar,
            'website_nickname_en' => $this->website_nickname_en,
            'image' => $this->image ,
            'guide_image' => $this->guide_image ,
            'description' => $this->description ,
            'slug' => $this->slug ,
            'in_sidebar' => $this->in_sidebar ,
            'in_sidebar_order' => $this->in_sidebar_order,
            'in_website_sidebar' => $this->in_website_sidebar ,
            'in_website_sidebar_order' => $this->in_website_sidebar_order,
            'parent' => $this->parent ,
            'parent_app' => $this->parent_app ,
            'parent_website' => $this->parent_website ,
            'get_parents' => $this->get_parents ,
            'parents_text' => $this->parents_text ,
            'category_with_parents_text' => $this->category_with_parents_text ,
            'slug_ar_data' => $this->slug_ar_data ,
            'slug_en_data' => $this->slug_en_data ,

            'children' => self::collection($this->children),
            'website_children' => self::collection($this->website_children),
            'product_count'=>$this->product_count,
        ];
    }
}
