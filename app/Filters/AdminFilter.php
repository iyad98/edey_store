<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 15/8/2019
 * Time: 5:26 م
 */

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class AdminFilter extends BaseFilter
{

    public function __construct(Builder $builder)
    {
        parent::__construct($builder);
    }

    public function get_filters()
    {
        return [
            'name' => 'filter_by_name',
            'status' => 'filter_by_status' ,
            'role' => 'filter_by_role'
        ];
    }


    public function filter_by_name($value)
    {

        if(!is_null($value)) {
            return $this->builder->where('admin_name', 'LIKE', "%$value%");
        }


    }

    public function filter_by_status($value)
    {
        if(!is_null($value) && $value != -1 ) {
            return $this->builder->where('admin_status', '=', $value);
        }

    }

    public function filter_by_role($value)
    {
        if(!is_null($value) && $value != -1 ) {
            return $this->builder->where('admin_role', '=', $value);
        }

    }


}