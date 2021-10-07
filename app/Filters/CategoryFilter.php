<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 15/8/2019
 * Time: 5:26 م
 */

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class CategoryFilter extends BaseFilter
{

    public function __construct(Builder $builder)
    {
        parent::__construct($builder);

    }

    public function get_filters()
    {
        return [
            'type' => 'filter_by_type',
            'parent' => 'filter_by_parent',
        ];
    }

    public function filter_by_type($value)
    {
        if (!is_null($value) && $value != -1) {
            $this->builder->where('type', '=', $value);
        }


    }

    public function filter_by_parent($value)
    {
       // $this->builder->where('parent', '=', $value);

        if($value == -1 || is_null($value)) {
            $this->builder->whereNull('parent');
        }else if(!is_null($value) && $value != -1) {
            $this->builder->where('parent', '=', $value);
        }

    }


   
}