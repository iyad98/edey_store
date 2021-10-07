<?php
/**
 * Created by PhpStorm.
 * User: HP15
 * Date: 16/8/2019
 * Time: 7:12 م
 */

namespace App\Repository;


use App\Models\Category;

use App\Http\Resources\CategoryResourceDFT;
use Illuminate\Support\Facades\Cache;

class CategoryRepository
{
    public $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function __call($name, $arguments)
    {
        return $this->category->$name(...$arguments);
    }

    public function get_category_parent() {
       return $this->category->Parents()->get();
    }

    public function update_category_in_cache() {

        update_categories_in_cache();
    }
}