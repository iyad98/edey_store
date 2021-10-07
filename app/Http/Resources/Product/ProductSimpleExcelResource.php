<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;


use Carbon\Carbon;

class ProductSimpleExcelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $get_images =  $this->images->pluck('image')->toArray();
        if($this->images->count() <= 0) {
            $get_images = $this->product->images->pluck('image')->toArray();
          $img_data =   isset(explode("uploads/products/", $this->product->image)[1])?explode("uploads/products/", $this->product->image)[1] : null;
            array_unshift($get_images , $img_data);
        }

//        $get_helper_product_price = get_helper_product_price($this, $request->price_tax_in_products);
        $data = [

            'id' => $this->id,
            'sku'=>$this->sku,
            'image' => '',

            'name' => '',
            'description' => '',
            'categories' => '',
//$this->product->can_returned ? $this->product->can_returned : 0
            'can_returned' => '',
            'can_gift' => '',

            'product_id' => $this->product_id ,


            'regular_price' =>$this->regular_price,
            'discount_price' =>$this->discount_price,
            'currency' => $request->get_currency_data ? $request->get_currency_data['symbol'] : get_currency(),
            'min_quantity' => $this->min_quantity,
            'max_quantity' => $this->max_quantity,
            'stock_quantity' => $this->stock_quantity ? $this->stock_quantity : 0 ,
            'attribute_values'=> $this->attribute_values ? implode(" , ", $this->attribute_values->pluck('name')->toArray()): '',
            'attribute_id'=>$this->attribute_values ? implode(" , ", $this->attribute_values->pluck('attribute_id')->toArray()): '',



            'images' => $get_images,

//
//            'color' =>implode(" , ", $this->attribute_values_color->pluck('name')->toArray()),
//            'size' =>implode(" , ", $this->attribute_values_size->pluck('name')->toArray()),
//            'intaglio' =>implode(" , ", $this->attribute_values_intaglio->pluck('name')->toArray()),

//

//            'attributes' => $this->is_variation == 0 ? [] : ProductAttributeResource::collection($this->attributes_size),

        ];

        return $data;

    }
}
