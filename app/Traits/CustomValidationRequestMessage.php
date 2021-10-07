<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 04/08/19
 * Time: 10:08 ص
 */

namespace App\Traits;

use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

trait CustomValidationRequestMessage
{

    protected function failedValidation(Validator $validator)
    {
        $response = general_response(false , true , '' , $validator->errors()->first() , [] , [] );
        throw new ValidationException($validator, $response);
    }
}