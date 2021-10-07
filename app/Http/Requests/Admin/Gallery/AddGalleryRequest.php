<?php

namespace App\Http\Requests\Admin\Gallery;

use App\Rules\CheckImageRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Traits\CustomValidationRequestMessage;

class AddGalleryRequest extends FormRequest
{
    use CustomValidationRequestMessage;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'name_ar' => ['required'] ,
            'name_en' => ['required'] ,
            'type_id' => ['required' , Rule::exists('gallery_types' , 'id')],
            'src' => ['required']
        ];
    }
}
