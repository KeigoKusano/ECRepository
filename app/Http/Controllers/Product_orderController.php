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
    public function rank(Product_order $product_order)//,User $user)
    {
        return view('orders.rank')->with(['product_orders' => $product_order->getPaginateByLimit()]);
    }
    public function chat(Chat_room $chat_room,Chat_message $chat_message,$id)//,User $user)
    {
        return view('orders.chat')->with(['chat_room' =>$chat_room,'chat_messages'=>$chat_message->getPaginateByLimit(10)
            ,'id'=>$id]);//$user->getByChat()
    }
    public function index(Product_order $product_order)//,User $user)
    {
        $array=[];
        foreach($product_order->get() as $product_order1){
            foreach($product_order->get() as $product_order2){
                if($product_order1->order_status=='発注一覧'&&$product_order2->order_status=='発注済み'&&
                $product_order1->user_id==$product_order2->user_id&&$product_order1->product_id==$product_order2->product_id){
                    $array[]= $product_order1->id;   
                }
            }
        }
        $array2=[];
        foreach($product_order->get() as $product_order1){
            $count=0;
            foreach($array as $a){
                if($a==$product_order1->id){
                    $count=1;
                    break;
                } 
            }
            if($count==0){
                $array2[]= $product_order1->id;   
            }
        }
        $id=1;
        return view('orders.index')->with(['product_orders' => $product_order->getPaginateByLimit(),//get(),//getPaginateByLimit(),//$user->getByUser(),
        'id' => $id,'array'=>$array2]);//,'users'=> $user->get()]);
    }
    public function store(Request $request, Product_order $product_order,Chat_room $chat_room,Product $product)
    {
        //$product = $request->product['status'];
        $input3 = $request['product'];
        $product->fill($input3)->save();
        //$product->save();
        $input2 = $request['chat_room'];
        $chat_room->fill($input2)->save();
        $product_order['chat_room_id']=$chat_room->id;
        $input = $request['product_order'];
        $product_order->fill($input)->save();
        $id=2;
        return redirect('/order/'.$id);
    }
    public function chat_store(Request $request, Product_order $product_order,Chat_room $chat_room)
    {
        $input2 = $request['chat_room'];
        $chat_room->fill($input2)->save();
        
        $product_order['chat_room_id']=$chat_room->id;
        $input = $request['product_order'];
        $product_order->fill($input)->save();
        $id=1;
        return redirect('/chats/'.$chat_room->id.'/'.$id);
    }
    public function receive_update(Request $request, Chat_room $chat_room,$id)
    {
        $input2 = $request['chat_room'];
        $chat_room->fill($input2)->save();
        return redirect('/chats/'.$chat_room->id.'/'.$id);
    }
    /*public function chat_update(Request $request,Chat_room $chat_room)
    {
        $input2 = $request['chat_room'];
        $chat_room->fill($input2)->save();
        return redirect('/chats/'.$chat_room->id);
    }*/
    public function message_store(PostRequest $request, Chat_message $chat_message,Chat_room $chat_room,$id)
    {
        if($chat_room->user1_id==Auth::id()){
            $chat_room['reciver_id'] = $chat_room->user2_id;
        }
        else if($chat_room->user2_id==Auth::id()){
            $chat_room['reciver_id'] = $chat_room->user1_id;
        }
        //$input2 = $request['chat_room'];
        $chat_room->save();
        
        $input = $request['chat_message'];
        $chat_message->fill($input)->save();
        return redirect('/chats/'.$chat_room->id.'/'.$id);
    }
    public function notbuy(Request $request, Product_order $product_order)
    {
        $input3 = $request['product_order'];
        $product_order->fill($input3)->save();
        $id=2;
        return redirect('/order/'.$id);
    }
    public function delete_notbuy(Request $request,Product_order $product_order,Product $product)
    {
        $input2 = $request['product_order'];
        $product_order->fill($input2)->save();
        $input3 = $request['product'];
        $product->fill($input3)->save();
        $id=2;
        return redirect('/order/'.$id);
    }
    public function order(Product_order $product_order,$id)//,User $user)
    {
        $array=[];
        foreach($product_order->get() as $product_order1){
            foreach($product_order->get() as $product_order2){
                if($product_order1->order_status=='発注一覧'&&$product_order2->order_status=='発注済み'&&
                $product_order1->user_id==$product_order2->user_id&&$product_order1->product_id==$product_order2->product_id){
                    $array[]= $product_order1->id;   
                }
            }
        }
        $array2=[];
        foreach($product_order->get() as $product_order1){
            $count=0;
            foreach($array as $a){
                if($a==$product_order1->id){
                    $count=1;
                    break;
                } 
            }
            if($count==0){
                $array2[]= $product_order1->id;   
            }
        }
        return view('orders.index')->with(['product_orders' => $product_order->getPaginateByLimit(),//get(),
        'id' => $id,'array'=>$array2]);
    }
    public function history(Product_order $product_order)
    {
        return view('orders.history')->with(['product_orders' => $product_order->get()]);
    }
}
