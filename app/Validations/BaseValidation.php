<?php
/**
 * Created by PhpStorm.
 * User: Al
 * Date: 11/9/2019
 * Time: 03:33 م
 */
namespace App\Validations;

use Illuminate\Support\Facades\Validator;
class BaseValidation
{

    public $validator;
    public function __construct()
    {
        $this->validator = "";
    }

    public function check_data($data ,$rules ) {

        $validator_response = Validator::make($data , $rules);
        if($validator_response->fails()) {
            $response['status'] = false;
            $response['message'] = get_error_msg($rules , $validator_response->errors());
        }else {
            $response['status'] = true;
            $response['message'] = "";
        }

        return $response;
    }

    public function check_data_2($data ,$rules ) {

        $validator_response = Validator::make($data , $rules);
        if($validator_response->fails()) {
            $response['status'] = false;
            $response['message'] = array_values($validator_response->errors()->toArray())[0][0];
        }else {
            $response['status'] = true;
            $response['message'] = "";
        }

        return $response;
    }
}