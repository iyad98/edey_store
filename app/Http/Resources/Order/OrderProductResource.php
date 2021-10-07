<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->product->id ,
            'image' => $this->product->image ,
            'name' => $this->product->name ,
            'quantity' => $this->quantity ,
            'price' => number_format( $this->price_after , round_digit(),'.','')   ,
            'total_price' => number_format( $this->total_price , round_digit(),'.','')   ,
            'attribute_values' => OrderProductAttributeValues::collection($this->product_attribute_values) ,
            'currency' => $request->currency,
            'order_products_id' => $this->id,
            'status_text' => trans_order_status()[$this->product->variation->order_status],
            'status' => $this->product->variation->order_status,

            'note_in_manufacturing' => $this->product->variation->note_in_manufacturing,
            'note_charged_up' => $this->product->variation->note_charged_up,
            'note_charged_at_sea' => $this->product->variation->note_charged_at_sea,
            'note_at_the_harbour' => $this->product->variation->note_at_the_harbour,
            'note_in_the_warehouse' => $this->product->variation->note_in_the_warehouse,
            'note_delivered' => $this->product->variation->note_delivered,

        ];
    }
}
