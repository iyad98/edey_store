<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductExcelResource extends JsonResource
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
            'id' => $this->id,
            'sku'=>$this->variation->sku,
            'image' => isset(explode("uploads/products/", $this->image)[1])?explode("uploads/products/", $this->image)[1] : null,

            'name' => $this->name,
            'description' => strip_tags($this->description),
            'categories' => implode(" , ", $this->categories->pluck('name')->toArray()),

            'can_returned' => $this->can_returned ? $this->can_returned : 0,
            'can_gift' => $this->can_gift ? $this->can_returned : 0,

        ];
    }
}
