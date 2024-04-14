<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Product_order;
use App\Models\Product_tag;
use App\Models\Tag;
use App\Models\Review_user_product;
use App\Http\Requests\PostRequest; // useする
use Illuminate\Support\Facades\Auth;
use Cloudinary; 

class ProductController extends Controller
{
    public function index(Product $product,Product_tag $product_tag,Product_order $product_order)
    {
        $serch="";
        return view('posts.index')->with(['products' => $product->getPaginateByLimit(10),
        'product_tags' => $product_tag->getPaginateByLimit(10),'product_orders'=>$product_order->get(),'serch'=>$serch]);
    }
    public function youindex(Product $product,Product_tag $product_tag,$youruser)
    {
        return view('posts.youindex')->with(['products' => $product->getPaginateByLimit(10),
        'product_tags' => $product_tag->getPaginateByLimit(10),'youruser'=>$youruser]);
    }
    public function index_serch(PostRequest $request,Product_tag $product_tag,Product_order $product_order)
    {
        $keyword = $request->input("serch");
        $query = Product::query();
        $articles = Product::whereHas('tags', function ($query) use ($keyword) {
            $query->where('tag', 'LIKE', "%{$keyword}%");
        })->orwhere('product_name','like',"%{$request->serch}%")->
        orWhere('product_description','like',"%{$request->serch}%")->get();
        
        return view('posts.index')->with(['products' =>$articles,
        'product_tags' => $product_tag->getPaginateByLimit(10),'product_orders'=>$product_order->get(),'serch'=>$keyword]);
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
    public function show(Product $product,Review_user_product $review_user_product,
        Product_tag $product_tag,Product_order $product_order)
    {
        $flag=0;
        foreach ($review_user_product->get() as $review_user_product1){
            if($review_user_product1->product_id==$product->id&&$review_user_product1->user_id==Auth::id()){
                $flag=1;
                break;
            }
        }
        $chatFlag=0;
        $buyFlag=0;
        foreach ($product_order->get() as $product_order1){
            if($product_order1->product_id==$product->id&&
                $product_order1->order_status=='検討中'&&$product_order1->user_id==Auth::id()){
                $chatFlag=1;
            }
            elseif($product_order1->product_id==$product->id&&
                $product_order1->order_status=='発注一覧'&&$product_order1->user_id==Auth::id()){
                $buyFlag=1;   
            }
            elseif($buyFlag==1) break;
        }
        return view('posts.show')->with(['product' => $product,
        'review_user_products'=>$review_user_product->get(),
        'product_tags' => $product_tag->getPaginateByLimit(10),
        'flag'=>$flag,'chatFlag'=>$chatFlag,'buyFlag'=>$buyFlag]);//$user->getByReview_user_product()]);
    }
    public function myshow(Product $product,Product_tag $product_tag,Review_user_product $review_user_product)
    {
        return view('posts.myshow')->with(['product' => $product,
        'product_tags' => $product_tag->getPaginateByLimit(10),'review_user_products'=>$review_user_product->get()]);
    }
    public function store_tag(PostRequest $request,Product $product, Tag $tag,Product_tag $product_tag)
    {
        $tag_tag=Tag::where('tag', $request['tag'])->first();//$request->tag[tag]);
        if($tag_tag){
            $product_tag['tag_id']=$tag_tag->id;
            $input_pt = $request['product_tag'];
            $product_tag->fill($input_pt)->save();
        }
        else{
            $input_tag = $request['tag'];
            $input_tag2 = $request->tag['tag'];
            if($input_tag2==null){
                return redirect('/products/'.$product->id.'/edit');
            }
            $tag->fill($input_tag)->save();
            $product_tag['tag_id']=$tag->id;
            $input_pt = $request['product_tag'];
            $product_tag->fill($input_pt)->save();
        }
        return redirect('/products/'.$product->id.'/edit');
    }
    public function update(PostRequest $request, Product $product)
    {
        try{
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
        catch(Cloudinary\Api\Exception\BadRequest $e){
            return redirect('/');
        }
    }
    public function myupdate(PostRequest $request, User $user)
    {
        $input_user = $request['user'];
        $user->fill($input_user)->save();
        return redirect('/mypage');
    }
    public function store(PostRequest $request, Product $product,$count,Tag $tag)
    {
        try{
        if($count>0){
            $arrays=[];
            $input_tags = $request->tag_array;
            $input_tags = array_filter($input_tags);
            if(empty($input_tags)){
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
            else {
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
        //return redirect('/products/show/' . $product->id);
        return redirect('/mypage');
        }
        catch(Cloudinary\Api\Exception\BadRequest $e){
            return redirect('/');
        }
    }
    public function status(Request $request,Product $product)
    {
        $input = $request['product'];
        $product->fill($input)->save();
        return redirect('/mypage');
    }
    /*public function delete(Product $product)
    {
        Product_tag::where('product_id', $product->id)->delete();
        $product->delete();
        return redirect('/mypage');
    }*/
    public function delete_tag(Product $product,Tag $tag,Product_tag $product_tags)
    {
        $product_tags=Product_tag::where('tag_id', $tag->id)->get();
        foreach($product_tags as $p){
            if($product->id==$p->product_id){
                //dd(1);
                $p->delete();  
                break;
            }
        }
        //Product::where('id',$product_tag->id)->delete();          
        //Product_tag::where('tag_id', $tag->id)->delete();
        $flag=0;
        foreach($product_tags as $p){
            if($p->tag_id==$tag->id&&$p->product_id!=$product->id){
                $flag=1;
                break;
            }
        }
        if($flag==0){
            $tag->delete();
        }
        return redirect('/products/'.$product->id.'/edit');
    }
}
/*public function myupdate(Request $request, User $user)
    {
        $input = $request['user'];
        Auth::user()->fill($input)->save();
        return redirect('/');
    }*/