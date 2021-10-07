<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderExportResource extends JsonResource
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
            'user_name' => $this->order_user_shipping['first_name'] . ' '.$this->order_user_shipping['last_name'] ,
            'status_text' => trans_orignal_order_status()[$this->status],
            'payment_method' => $this->payment_method ? $this->payment_method->name : "",
            'company_shipping' => $this->company_shipping ? $this->company_shipping->shipping_company_name : "",

            'shipping_policy'=>$this->shipping_policy,
            'total_price' => $this->total_price,
            'currency' => $this->currency->symbol,
            'date' => $this->created_at,
        ];
    }
}
