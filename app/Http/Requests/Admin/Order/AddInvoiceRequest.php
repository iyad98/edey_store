<?php

namespace App\Http\Requests\Admin\Order;

use App\Rules\CheckImageRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Traits\CustomValidationRequestMessage;

class AddInvoiceRequest extends FormRequest
{
    use CustomValidationRequestMessage;

    public $data;
    public function authorize()
    {
        return true;
    }
    public function all($keys = null)
    {
        $data = parent::all(null);
        $order = optional($this->route('order'));
        $data['id'] = $order->id;
        $this->data = $data;
        return $data;
    }


    public function rules()
    {
        return [
            'id'             => ['required', Rule::exists('orders' , 'id')] ,
            'invoice_number' => ['required' , Rule::unique('orders' , 'invoice_number')->ignore($this->data['id'])]
        ];
    }
}
