<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Review_user_product;
use App\Http\Requests\PostRequest; // useする
use Illuminate\Support\Facades\Auth;
use Cloudinary; 

class ProductController extends Controller
{
    public function index(Product $product ,User $user)
    {
        return view('posts.index')->with(['products' => $product->getPaginateByLimit(10),
        'users'=>$user->get()]);
       //blade内で使う変数'posts'と設定。'posts'の中身にgetを使い、インスタンス化した$postを代入。
    }
    public function myindex(Product $product ,User $user)
    {
        return view('posts.myindex')->with(['products' => $product->getPaginateByLimit(10),
        'users'=>$user->get()]);
       //blade内で使う変数'posts'と設定。'posts'の中身にgetを使い、インスタンス化した$postを代入。
    }
    public function edit(Product $product)
    {
        return view('posts.edit')->with(['product' => $product]);
    }
    public function myedit()
    {
        return view('posts.myedit');
    }
    public function create()
    {
        return view('posts.create');
    }
    public function show(Product $product,User $user,Review_user_product $review_user_product)
    {
        return view('posts.show')->with(['product' => $product,
        //'review_user_product'=> $review_user_product,
        'review_user_products'=>$review_user_product->get()]);//$user->getByReview_user_product()]);
    }
    public function myshow(Product $product)
    {
        return view('posts.myshow')->with(['product' => $product]);
        //'post'はbladeファイルで使う変数。中身は$postはid=1のPostインスタンス。
    }
    public function myupdate(Request $request, User $user)
    {
        $input = $request['user'];
        Auth::user()->fill($input)->save();
        return redirect('/');
    }
    public function update(Request $request, Product $product)
    {
        $input_product = $request['product'];
        if($request->file('image1')){ 
            $image_url1 = Cloudinary::upload($request->file('image1')->getRealPath())->getSecurePath();
            $input_product += ['image1' => $image_url1];  //追加
        }
        if($request->file('image2')){ 
            $image_url2 = Cloudinary::upload($request->file('image2')->getRealPath())->getSecurePath();
            $input_product += ['image2' => $image_url2];  //追加
        }
        $product->fill($input_product)->save();
        return redirect('/products/show/' . $product->id);
    }
    public function store(Request $request, Product $product)
    {
        $product['user_id']=Auth::id();
        $input = $request['product'];
        if($request->file('image1')){ 
            $image_url1 = Cloudinary::upload($request->file('image1')->getRealPath())->getSecurePath();
            $input += ['image1' => $image_url1];  //追加
        }
        if($request->file('image2')){ 
            $image_url2 = Cloudinary::upload($request->file('image2')->getRealPath())->getSecurePath();
            $input += ['image2' => $image_url2];  //追加
        }
        $product->fill($input)->save();
        return redirect('/products/show/' . $product->id);
    }
    public function delete(Product $product)
    {
        $product->delete();
        return redirect('/');
    }
}
