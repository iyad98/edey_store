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

class UserValidation extends BaseValidation
{

    public $validator;

    public function __construct()
    {
        parent::__construct();
        $this->validator = new BaseValidation();
    }

    public function check_login_user($data)
    {
        $rules = [
            'email' => [
                'required', 'email',
                Rule::exists('users', 'email')->whereNull('deleted_at'),
            ],
            'password' => 'required',
        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_social_login_user($data)
    {
        $rules = [
            'email' => [
                'required', 'email',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'social_type' => 'required|in:google,facebook',
            'social_unique_id' => 'required',
        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_create_data($data)
    {

        $rules = [
            'phone' => ['required','digits:8', Rule::unique('users', 'phone')->whereNull('deleted_at'),],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),

            ],
            'password' => 'required',
            'platform' => 'required|in:android,ios'

        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_update_user($data)
    {

        $id = $data['user_id'];
        $rules = [
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')->ignore($id)->whereNull('deleted_at'),
            ],
            'first_name'=>['required'],
            'last_name'=>['required'],
            'phone'=>['required','digits:8'],

        ];

        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }


    public function check_ticket_data($data)
    {

        $rules = [
            'ticket_email' => [
                'sometimes',
                'email',
                'required'

            ],

            'ticket_title' => [
                'required'
            ],

            'ticket_description' => [
                'required'
            ],
            'ticket_files'=>[
                'array',
                'max:5'
            ]

        ];

        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }


    public function check_create_data_cp($data)
    {

        $rules = [
            'first_name' => 'required|max:250',
            'last_name' => 'required|max:250',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'password' => 'required|min:6',

        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_update_user_cp($data)
    {

        $id = $data['user_id'];
        $rules = [
            'first_name' => [
                'required',
                'max:255'
            ],
            'last_name' => [
                'required',
                'max:255'
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id)->whereNull('deleted_at'),
            ],

        ];

        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_change_password_user($data)
    {
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_change_password_user_website($data)
    {
        $rules = [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'password_confirmation' => 'required|same:new_password'
        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }


    public function check_phone_user($data)
    {
        $rules = [
            'phone' => [
                'required',
                Rule::exists('users', 'phone')->whereNull('deleted_at'),
            ]

        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_code_user($data)
    {
        $rules = [
            'code' => 'required',

        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_address_code_user($data)
    {
        $rules = [
            'code' => 'required',
            'address_id' => ['required', Rule::exists('user_shipping', 'id')]

        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }


    public function check_add_contact_data($data)
    {
        $rules = [
            'name' => 'required|max:250',
            'email' => [
                'required', 'email', 'max:250',
            ],
            'message' => 'required',
        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }


    public function check_update_shipping_user($data)
    {

        $rules = [
            'first_name' => ['required' , 'regex:/^[\pL\s\-]+$/u'],
            'last_name' => ['required' , 'regex:/^[\pL\s\-]+$/u'],
            'email' => [
                'required','email'
            ],
            'phone' => [
                'required' ,'digits:8',
            ],
            'city' => [
                'required',
                Rule::exists('cities', 'id')->whereNull('deleted_at'),
            ],
            'shipping_company_id' => [
                'required',
                Rule::exists('shipping_companies', 'id')
                    ->where('status', 1)
                    ->whereNull('deleted_at'),
            ]

        ];
        if(array_key_exists('billing_shipping_type' , $data) && $data['billing_shipping_type'] == 3) {

            $rules['state'] = ['required'];
            $rules['street'] = ['required'];
            $rules['avenue'] = ['required'];

        }
        $validator = $this->validator->check_data($data, $rules);

        return $validator;
    }
    public function check_delete_shipping_user($data)
    {
        $rules = [
            'address_id' => ['required' , Rule::exists('user_shipping', 'id')->where('user_id',$data['user']->id),]

        ];
        if(array_key_exists('billing_shipping_type' , $data) && $data['billing_shipping_type'] == 3) {

            $rules['state'] = ['required'];
            $rules['street'] = ['required'];
            $rules['avenue'] = ['required'];

        }
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }
    public function check_empty_shipping_user($data)
    {

        if ($data['first_name'] == null or
            $data['last_name'] == null or
            $data['email'] == null or
            $data['phone'] == null or
            $data['city'] == null
        ){
            return false;

        }
        return true;


    }

    public function chech_set_as_default_shipping_address($data){
        $rules = [
            'address_id' => ['required' , Rule::exists('user_shipping', 'id')->where('user_id',$data['user']->id),]

        ];

        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_update_shipping_with_company_user($data)
    {
        $shipping_company = $data['shipping_company'];
        $rules['billing_national_address'] = $shipping_company->billing_national_address == 1 ? ['required'] : [];
        $rules['billing_building_number'] = $shipping_company->billing_building_number == 1 ? ['required'] : [];
        $rules['billing_postalcode_number'] = $shipping_company->billing_postalcode_number == 1 ? ['required'] : [];
        $rules['billing_unit_number'] = $shipping_company->billing_unit_number == 1 ? ['required'] : [];
        $rules['billing_extra_number'] = $shipping_company->billing_extra_number == 1 ? ['required'] : [];

        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_login_data_website($data)
    {

        $rules = [
            'email' => [
                'required',
                'email',
            ],
            'password' => 'required',
        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }
    public function check_create_data_website($data)
    {

        $rules = [
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|min:4|confirmed',
            'password_confirmation' =>'required',
        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

    public function check_mailing_list($data){
        $rules = [
            'email' => [
                'required',
                'email',
                Rule::unique('mailing_list', 'email'),
            ]
        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }
}
