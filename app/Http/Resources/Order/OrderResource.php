<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id ,
//            'id_view' => $this->id ,
            'status_text' => trans_orignal_order_status()[$this->status] ,
            'status' => $this->status ,
            'payment_method' => $this->payment_method->name ,
            'total_items' => $this->order_products_count ,
            'total' => number_format($this->total_price * $this->exchange_rate , round_digit()) ,
            'currency' => $this->currency->symbol ,
            'sms_code' => $this->sms_code,
            'date' => Carbon::parse($this->created_at)->format('Y-m-d')
        ];
    }
}
