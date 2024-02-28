<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review_user_product;
use App\Models\Product;
use App\Models\User;
use App\Http\Requests\PostRequest; 

class Review_user_productController extends Controller
{
    public function store(Request $request, Review_user_product $review_user_product)
    {
        //$review_user_product['user_id']=Auth::id();
        $input = $request['review_user_product'];
        $review_user_product->fill($input)->save();
        return redirect('/');
    }
    public function show(Product $product,Review_user_product $review_user_product,User $user)
    {
        return view('posts.show')->with(['product' => $product,
        //'review_user_product'=> $review_user_product,
        'review_user_products'=>$review_user_product->getPaginateByLimit(10)]);//$user->getByReview_user_product()]);
    }
}
