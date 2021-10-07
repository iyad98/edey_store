<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpgradeAccountRequest extends FormRequest
{
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
            'store_name' => 'required',
            'logo_store' => 'required_without:id',
            'image_banar_store' => 'required_without:id',
            'phone_store' => 'required|integer',
            'phone_whatsapp_store' => 'required|integer',
            'facebook_link' => 'required',
            'twitter_link' => 'required',
            'instagram_link' => 'required',
            'merchant_first_name' => 'required',
//          'merchant_first_name' => 'nullable',
            'merchant_last_name' => 'required',
            'identification_number' => 'required|integer',
            'phone_merchants' => 'required|integer',
            'about_us_merchants' => 'required',
            'commercial_register_number' => 'nullable|integer',
            'maroof_number' => 'nullable',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'area_id' => 'required|exists:areas,id',
            'address_store' => 'required',
            'street_store' => 'required',
            'nearest_public_place' => 'nullable',
            'account_barea' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'exists' => trans('validation.exists'),
            'required' => trans('validation.required'),
            'required_without' => trans('validation.required_without'),
            'mimes' => trans('validation.mimes'),
            'integer' => trans('validation.integer'),
        ];
    }
}
