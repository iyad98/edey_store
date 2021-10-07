<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 16/8/2019
 * Time: 6:21 م
 */

namespace App\Filters;
use Illuminate\Database\Eloquent\Builder;

class BaseFilter
{
    public $builder;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }



    public function filter_by_name($value)
    {

        if(!is_null($value)) {
            return $this->builder->where('name', 'LIKE', "%$value%");
        }


    }

    public function filter_by_status($value)
    {
        if(!is_null($value) && $value != -1 ) {
            return $this->builder->where('users.status', '=', $value);
        }

    }


}
