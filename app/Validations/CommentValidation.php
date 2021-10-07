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

class CommentValidation extends BaseValidation
{

    public $validator;

    public function __construct()
    {
        parent::__construct();
        $this->validator = new BaseValidation();
    }


    public function check_add_comment($data)
    {
        $rules = [
            'product_id' => ['required' ,'integer', Rule::exists('products' , 'id')->whereNull('deleted_at')] ,
            'comment' => 'required'
        ];
        $validator = $this->validator->check_data($data, $rules);
        return $validator;
    }

}