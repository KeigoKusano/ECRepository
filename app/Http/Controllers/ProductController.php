<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Product_tag;
use App\Models\Tag;
use App\Models\Review_user_product;
use App\Http\Requests\PostRequest; // useする
use Illuminate\Support\Facades\Auth;
use Cloudinary; 

class ProductController extends Controller
{
    public function index(Product $product,Product_tag $product_tag)
    {
        return view('posts.index')->with(['products' => $product->getPaginateByLimit(10),
        'product_tags' => $product_tag->getPaginateByLimit(10)]);
    }
    public function index_serch(Request $request,Product_tag $product_tag)
    {
        $keyword = $request->input("serch");
        $query = Product::query();
        $articles = Product::whereHas('tags', function ($query) use ($keyword) {
            $query->where('tag', 'LIKE', "%{$keyword}%");
        })->orwhere('product_name','like',"%{$request->serch}%")->
        orWhere('product_description','like',"%{$request->serch}%")->get();
        
        return view('posts.index')->with(['products' =>$articles,
        'product_tags' => $product_tag->getPaginateByLimit(10)]);
    }
    public function myindex(Product $product , Product_tag $product_tag)
    {
        return view('posts.myindex')->with(['products' => $product->getPaginateByLimit(10),
        'product_tags' => $product_tag->getPaginateByLimit(10)]);
    }
    public function edit(Product $product, Product_tag $product_tag, Tag $tag)
    {
        return view('posts.edit')->with(['product' => $product,
        'product_tags' => $product_tag->getPaginateByLimit(10)]);
    }
    public function myedit()
    {
        return view('posts.myedit');
    }
    public function create()
    {
        $count=0;
        return view('posts.create')->with(['count' => $count]);
    }
    public function create_tagPlus($count)
    {
        $count=$count+1;
        return view('posts.create')->with(['count' => $count]);
    }
    public function create_tagMinus($count)
    {
        $count=$count-1;
        return view('posts.create')->with(['count' => $count]);
    }
    public function show(Product $product,Review_user_product $review_user_product,Product_tag $product_tag)
    {
        return view('posts.show')->with(['product' => $product,
        'review_user_products'=>$review_user_product->get(),
        'product_tags' => $product_tag->getPaginateByLimit(10)]);//$user->getByReview_user_product()]);
    }
    public function myshow(Product $product,Product_tag $product_tag)
    {
        return view('posts.myshow')->with(['product' => $product,
        'product_tags' => $product_tag->getPaginateByLimit(10)]);
    }
    public function store_tag(Request $request,Product $product, Tag $tag,Product_tag $product_tag)
    {
        $bool=0;
        $tag_tag=Tag::where('tag', $request['tag'])->first();//$request->tag[tag]);
        foreach($tag->get() as $t){
            if($t->tag==$tag_tag->tag){
                $product_tag['tag_id']=$t->id;
                $input_pt = $request['product_tag'];
                $product_tag->fill($input_pt)->save();
                $bool=1;
                break;
            }
        }
        if($bool==0){
            $input_tag = $request['tag'];
            $tag->fill($input_tag)->save();
            $product_tag['tag_id']=$tag->id;
            $input_pt = $request['product_tag'];
            $product_tag->fill($input_pt)->save();
        }
        return redirect('/');
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
    public function store(Request $request, Product $product,$count,Tag $tag)
    {
        if($count>0){
            $arrays=[];
            $input_tags = $request->tag_array;
            //$tag_tag=Tag::where('tag', $request['tag'])->first();//$request->tag[tag]);
            foreach($input_tags as $input_t){
                $count=0;
                foreach($tag->get() as $t){
                    if($t->tag==$input_t){
                        $arrays[]=$t->id;
                        $count=1;
                        break;
                    }
                }
                if($count==0){
                    $new_tag = new Tag();
                    $new_tag->tag = $input_t; // タグ名を設定
                    $new_tag->save();
                    $arrays[]=$new_tag->id;
                }
            }
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
            $product->tags()->attach($arrays);
        }
        else{
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
        }
        return redirect('/products/show/' . $product->id);
    }
    public function delete(Product $product)
    {
        $product->delete();
        return redirect('/');
    }
    public function delete_tag(Tag $tag)
    {
        Product_tag::where('tag_id', $tag->id)->delete();
        $tag->delete();
        return redirect('/');
    }
    function same_store()
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
    }
}
