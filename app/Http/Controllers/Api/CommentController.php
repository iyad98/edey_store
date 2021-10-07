<?php

namespace App\Http\Controllers\Api;

use App\Repository\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/* Traits */
use App\Traits\PaginationTrait;

/*  Resources  */

use App\Http\Resources\BrandResource;
use App\Http\Resources\Comment\CommentResource;


use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

// models
use App\Models\Brand;
use App\Models\Comment;
use App\Models\Product;

// validations
use App\Validations\CommentValidation;

use Carbon\Carbon;

class CommentController extends Controller
{
    use PaginationTrait;

    public $validation;

    public function __construct(CommentValidation $validation)
    {
        $this->validation = $validation;
    }


    public function store(Request $request)
    {
        $check_data = $this->validation->check_add_comment($request->toArray());

        if ($check_data['status']) {

            $comment = Comment::create([
                'user_id' => $request->user->id,
                'product_id' => $request->product_id,
                'comment' => $request->comment,
            ]);

            $response['data'] = new CommentResource($comment);
            return response_api(true, trans('api.added_comment'), $response);
        } else {
            return response_api(false, $check_data['message'], "");
        }
    }
    public function show(Request $request , $product_id) {

        if ($request->has('page')) {
            $filters = $request->except(['user', 'page' , 'price_tax_in_products' , 'get_currency_data']);
        } else {
            $filters = $request->except(['user' , 'price_tax_in_products' , 'get_currency_data']);
        }


        $product = Product::find($product_id);
        if(!$product) {
            return response_api(false, trans('api.product_not_found'), []);
        }

        $comments = $product->comments()->GetGeneralData()->paginate(10);
        $filter_option = "&" . http_build_query($filters);
        $response['data'] = CommentResource::collection($comments);
        $pagination_options = $this->get_options_v2($comments, $filter_option);
        $response = $response + $pagination_options;

        return response_api(true, trans('api.success'), $response);
    }
}
