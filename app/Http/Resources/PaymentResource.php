<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'name' => $this->name ,
            'key' => $this->key ,
            'image' => $this->image ,
            'note' => $this->get_note($this),
        ];
    }

    public function get_note($payment) {
        $note = "";
        switch ($payment->key) {
            case 'knet' :
                $note =  $payment->note;
                break;

            case 'bank_transfer' :
                $banks = get_setting_messages()['banks'];
                $key_words = ['[banks]'];
                $replaces = [get_list_html_ul_of_banks($banks)];
                $get_new_bank_note = str_replace($key_words, $replaces, $payment->note );
                $note = $get_new_bank_note;
                break;

            case 'visa' :
                $note = $payment->note;
                break;
            
        }
        return $note;
    }
}
