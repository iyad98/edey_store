<?php
/**
 * Created by PhpStorm.
 * User: Al
 * Date: 11/9/2019
 * Time: 03:39 م
 */

namespace App\Validations;

use App\Models\Filter;
use App\Validations\BaseValidation;
use Illuminate\Validation\Rule;

use App\Models\ProductVariation;

class StoreValidation extends BaseValidation
{

    public $validator;

    public function __construct()
    {
        parent::__construct();
        $this->validator = new BaseValidation();
    }


    public function check_store_data($data) {


        $rules = [
            'phone' => 'required',
            'name_en' => 'required',
            'name_ar' => 'required',
            'address_en' => 'required',
            'address_ar' => 'required',
            'lat' => 'required',
            'lng' => 'required',
            'city_id' => ['required' , Rule::exists('cities' , 'id')->whereNull('deleted_at')],

        ];

        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

}