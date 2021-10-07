<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 15/8/2019
 * Time: 5:26 م
 */

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class UserFilter extends BaseFilter
{

    public function __construct(Builder $builder)
    {
       parent::__construct($builder);

    }

    public function get_filters()
    {
        return [
            'name' => 'filter_by_name',
            'phone' => 'filter_by_phone' ,
            'status' => 'filter_by_status'
        ];
    }

    public function filter_by_phone($value) {
        $this->builder->where('phone' , '=' , $value);
    }



}