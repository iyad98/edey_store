<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;

class PublishedProductsScope
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Product::addGlobalScope('public', function($builder) {
            $builder->where('in_archive', 0);
        });


        Product::addGlobalScope('stock_quantity', function( $builder) {
            $builder->whereHas('variation' , function ($q){
                $q->where('stock_quantity', '>',0);

            });
        });


        return $next($request);
    }
}
