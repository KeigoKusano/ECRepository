<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product_order;
use App\Models\Product;
use App\Models\Chat_room;
use App\Models\Chat_message;
use App\Http\Requests\PostRequest; // useする
use Illuminate\Support\Facades\Auth;
use App\Models\User;
//use Cloudinary; 

class Product_orderController extends Controller
{
    public function chat(Chat_room $chat_room,Chat_message $chat_message,User $user)
    {
        return view('orders.chat')->with(['chat_room' =>$chat_room,'chat_messages'=>$chat_message->getPaginateByLimit(10)]);//$user->getByChat()
    }
    public function index(Product_order $product_order,User $user)
    {
        $id=1;
        return view('orders.index')->with(['product_orders' => $product_order->getPaginateByLimit(),//get(),//getPaginateByLimit(),//$user->getByUser(),
        'id' => $id,'users'=> $user->get()]);
    }
    public function store(Request $request, Product_order $product_order,Chat_room $chat_room)
    {
        $input2 = $request['chat_room'];
        $chat_room->fill($input2)->save();
        $product_order['chat_roomid']=$chat_room->id;
        $input = $request['product_order'];
        $product_order->fill($input)->save();
        return redirect('/');
    }
    public function chat_store(Request $request, Product_order $product_order,Chat_room $chat_room)
    {
        $input2 = $request['chat_room'];
        $chat_room->fill($input2)->save();
        $product_order['chat_roomid']=$chat_room->id;
        $input = $request['product_order'];
        $product_order->fill($input)->save();
        return redirect('/chats/'.$chat_room->id);
    }
    public function message_store(Request $request, Chat_message $chat_message,Chat_room $chat_room)
    {
        $input = $request['chat_message'];
        $chat_message->fill($input)->save();
        return redirect('/chats/'.$chat_room->id);
    }
    public function order(Product_order $product_order,$id,User $user)
    {
        return view('orders.index')->with(['product_orders' => $product_order->getPaginateByLimit(),//get(),
        'id' => $id,'users'=> $user->get()]);
    }
    public function history(Product_order $product_order)
    {
        return view('orders.history')->with(['product_orders' => $product_order->get()]);
    }
}
