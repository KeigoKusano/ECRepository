<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product_order;
use App\Models\Product;
use App\Http\Requests\PostRequest; // useする
use Illuminate\Support\Facades\Auth;
use App\Models\User;
//use Cloudinary; 

class Product_orderController extends Controller
{
    public function chat(Product_order $product_order)
    {
        return view('orders.chat')->with(['product_orders' => $product_order->get()]);
    }
    public function index(Product_order $product_order,User $user)
    {
        $id=1;
        //$user = User::all()->keyBy('id');
        return view('orders.index')->with(['product_orders' =>$product_order->getPaginateByLimit(),//$user->getByUser(),
        'id' => $id,'users'=> $user->get()]);
    }
    public function store(Request $request, Product_order $product_order)
    {
        //$product_order['user_id']=Auth::id();
        //$product_order['product_id']=$product->id;
        //$product_order['postage']=200;
        //$product_order['order_status']="購入待ち";
        $input = $request['product_order'];
        $product_order->fill($input)->save();
        return redirect('/');
    }
    public function chat_store(Request $request, Product_order $product_order)
    {
        $input = $request['product_order'];
        $product_order->fill($input)->save();
        return redirect('/order/chat/',$product_order->product->user_id);
    }
    public function order(Product_order $product_order,$id,User $user)
    {
        return view('orders.index')->with(['product_orders' => $product_order->get(),
        'id' => $id,'users'=> $user->get()]);
    }
}
