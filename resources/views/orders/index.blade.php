<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>取引画面</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <x-app-layout>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    @php
                        $isbool=false;
                        $isNot=false;
                    @endphp
                    @foreach ($product_orders as $product_order)
                        @if($product_order->chat_room->reciver_id==Auth::id())
                            @if($isbool==true)
                                {{ __('新着') }}
                            @endif
                            @php
                                $isbool=true;
                            @endphp
                        @endif
                        @if($product_order->order_status=='取り消し'&&$product_order->product->user_id==Auth::id())
                            @if($isNot==true)
                                {{ __('承諾') }}
                            @endif
                            @php
                                $isNot=true;
                            @endphp
                            @if($isbool==true)
                                @break
                            @endif
                        @endif
                    @endforeach
                    @if($isbool==true||$isNot==true)
                        {{ __('赤色取引画面') }}
                    @else
                        {{ __('取引画面') }}
                    @endif
                </h2>
            </x-slot>
        <div class='products'>
            <form id="orderForm" action="/order/" method="GET">
                @csrf
                <label for="orders">発注項目選択</label>
                <select id="orders" name="orders" onchange="changeAction()">
                @if ($id == 1)
                    <option value=1 selected>検討中</option>
                    <option value=2>発注一覧</option>
                    <option value=3>発注済み</option>
                @elseif ($id == 2)
                    <option value=1>検討中</option>
                    <option value=2 selected>発注一覧</option>
                    <option value=3>発注済み</option>
                @elseif ($id == 3)
                    <option value=1>検討中</option>
                    <option value=2>発注一覧</option>
                    <option value=3 selected>発注済み</option>
                @endif
                </select>
            </form>
            @foreach ($product_orders as $product_order)
                @if ($id == 1 && $product_order->order_status == '検討中')
                    @if($product_order->user_id==Auth::id()||$product_order->product->user_id==Auth::id())
                    <div class='product'>
                        @if($product_order->chat_room->reciver_id==Auth::id())
                            <P class="text-orange-700">未読</P>
                        @endif
                        <P>商品名：{{$product_order->product->product_name }}</P>
                        <P>商品金額：{{$product_order->product->product_price }}円</P>
                        @if(Auth::id()==$product_order->user_id)
                            <p class='username'>ユーザー名：{{$product_order->product->user->name }}</p>
                        @elseif(Auth::id()==$product_order->product->user_id)
                            <p class='username'>購入者 ユーザー名：{{$product_order->user->name }}</p>
                        @endif
                        @if($product_order->chat_room->reciver_id==Auth::id())
                        <form action="/receive/update/{{$product_order->chat_room_id}}/{{$id}}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="chat_room[reciver_id]" value=0>
                                <input class="bg-gray-500 rounded-lg" type="submit" value="チャットボタン"/>
                        </form>
                        @else
                        <a href="/chats/{{$product_order->chat_room_id}}/{{$id}}"><button class="bg-gray-500 rounded-lg">
                            ダイレクトチャットボタン</button></a>
                        @endif
                        <a class="bg-gray-500 rounded-lg" href="/products/{{ $product_order->product_id }}"><button>商品画面ボタン</button></a>
                        <p>--------------------------------------------------------------------</p>
                        <p><br></p>
                    </div>
                    @endif
                @elseif ($id == 2 && ($product_order->order_status == '発注一覧'||$product_order->order_status == '取り消し'))
                    @if($product_order->user_id==Auth::id()||$product_order->product->user_id==Auth::id())
                    <div class='product'>
                        @if($product_order->chat_room->reciver_id==Auth::id())
                            <P>未読</P>
                        @endif
                        <P>商品名：{{$product_order->product->product_name }}</P>
                        <P>商品金額：{{$product_order->product->product_price }}円</P>
                        @if(Auth::id()==$product_order->user_id)
                            <P>購入数：{{$product_order->number }}個</P>
                            <p class='username'>販売者 ユーザー名：{{$product_order->product->user->name }}</p>
                            @php
                                $isbool=false;
                            @endphp
                            @foreach($product_orders as $product_order1)
                                @if($product_order1->order_status=='発注済み'&&$product_order1->product_id==$product_order->product_id&&
                                    $product_order1->user_id==$product_order->user_id)
                                    @php
                                        $isbool=true;
                                    @endphp
                                    @break
                                @endif
                            @endforeach
                            @if($isbool==false)
                                @if($product_order->order_status!='取り消し')
                                <form id="form_buy_not" 
                                    action="/orders/not/{{$product_order->id}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="product_order[order_status]" value="取り消し">
                                    <button class="bg-gray-500 rounded-lg" type="button" onclick="buyNot()">取り消し申請ボタン</button>
                                </form>
                                @else
                                    <P>取り消し申請済み</P>
                                @endif
                            @endif
                        @elseif(Auth::id()==$product_order->product->user_id)
                            <P>販売数：{{$product_order->number }}個</P>
                            <P>残りの販売数：{{$product_order->product->number }}個</P>
                            <p class='username'>購入者 ユーザー名：{{$product_order->user->name }}</p>
                            @if($product_order->order_status=='取り消し')
                                <form id="form_buy_notOK" action="/order/notOK/{{ $product_order->id }}/{{ $product_order->product_id }}" 
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    @php
                                        $num=$product_order->product->number+$product_order->number;
                                    @endphp
                                    <input type="hidden" name="product[number]" value={{$num}}>
                                    <input type="hidden" name="product[status]" value="正常">
                                    <input type="hidden" name="product_order[order_status]" value="削除">
                                    <button class="bg-gray-500 rounded-lg" type="button" onclick="delete_buyNot()">取り消し承諾ボタン</button> 
                                </form>    
                            @endif
                            @php
                                $idbool=false;
                            @endphp
                            @if($product_order->order_status!='取り消し')
                            @foreach($array as $a)
                                @if($a==$product_order->id)
                                    <form id="form_buy" 
                                        action="/orders/{{$product_order->product_id}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_order[product_id]" id="product_id">
                                        <input type="hidden" name="product_order[postage]" id="postage">
                                        <input type="hidden" name="product_order[user_id]" id="user_id">
                                        <input type="hidden" name="product_order[number]" id="number">
                                        <input type="hidden" name="product_order[order_status]" id="order_status">
                                        <input type="hidden" name="chat_room[user1_id]" id="user1_id">
                                        <input type="hidden" name="chat_room[user2_id]" id="user2_id">
                                        <input type="hidden" name="chat_room[reciver_id]" id="reciver_id">
                                        <input type="hidden" name="product[status]" value={{$product_order->product->status}}>
                                        <button class="bg-gray-500 rounded-lg" type="button" onclick="buyPost({{ $product_order->product_id }},
                                        {{ $product_order->user_id }},{{ $product_order->number }})">発注OKボタン</button>
                                    </form>
                                    @php
                                        $idbool=true;
                                    @endphp
                                    @break;
                                @endif
                            @endforeach
                           
                            @if($idbool==false)
                                <p class="text-orange-700">発注OK済み</p>
                            @endif
                            @endif
                        @endif
                        @if($product_order->chat_room->reciver_id==Auth::id())
                        <form action="/receive/update/{{$product_order->chat_room_id}}/{{$id}}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="chat_room[reciver_id]" value=0>
                                <input class="bg-gray-500" type="submit" value="チャットボタン"/>
                        </form>
                        @else
                            <a href="/chats/{{$product_order->chat_room_id}}/{{$id}}"><button class="bg-gray-500 rounded-lg">ダイレクトチャットボタン</button></a>
                        @endif
                        <a class="bg-gray-500 rounded-lg" href="/products/{{ $product_order->product_id }}"><button>商品画面ボタン</button></a>
                        <p>--------------------------------------------------------------------</p>
                        <p><br></p>
                    </div>
                    @endif
                @elseif ($id == 3 && $product_order->order_status == '発注済み')
                    @if($product_order->user_id==Auth::id()||$product_order->product->user_id==Auth::id())
                    <div class='product'>
                        @if($product_order->chat_room->reciver_id==Auth::id())
                            <P>未読</P>
                        @endif
                        <P>商品名：{{$product_order->product->product_name }}</P>
                        <P>商品金額：{{$product_order->product->product_price }}円</P>
                        @if(Auth::id()==$product_order->user_id)
                            <P>購入数：{{$product_order->number }}個</P>
                            <p class='username'>販売者 ユーザー名：{{$product_order->product->user->name }}</p>
                        @elseif(Auth::id()==$product_order->product->user_id)
                            <P>販売数：{{$product_order->number }}個</P>
                            <P>残りの販売数：{{$product_order->product->number }}個</P>
                            <p class='username'>購入者 ユーザー名：{{$product_order->user->name }}</p>
                        @endif
                        @if($product_order->chat_room->reciver_id==Auth::id())
                        <form action="/receive/update/{{$product_order->chat_room_id}}/{{$id}}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="chat_room[reciver_id]" value=0>
                            <input class="bg-gray-500" type="submit" value="チャットボタン"/>
                        </form>
                        @else
                            <a href="/chats/{{$product_order->chat_room_id}}/{{$id}}"><button class="bg-gray-500 rounded-lg">
                                ダイレクトチャットボタン</button></a>
                        @endif
                        <a class="bg-gray-500 rounded-lg" href="/products/{{ $product_order->product_id }}"><button>商品画面ボタン</button></a>
                        <p>--------------------------------------------------------------------</p>
                        <p><br></p>
                    </div>
                    @endif
                @endif
            @endforeach
        </div>
        <script>
            function changeAction() {
                var selectElement = document.getElementById('orders');
                var selectedValue = selectElement.value;
                document.getElementById('orderForm').action = '/order/' + selectedValue;
                document.getElementById('orderForm').submit();
            }
            function buyPost(id,userid2,number) {
                'use strict'
                if (confirm('購入しますか？')) {
                    var userId = '{{ Auth::user()->id }}';
                    document.getElementById('product_id').value = id;
                    document.getElementById('postage').value = 200;
                    document.getElementById('user_id').value = userid2;
                    document.getElementById('number').value = number;
                    document.getElementById('order_status').value = '発注済み';
                    document.getElementById('user1_id').value = userId;
                    document.getElementById('user2_id').value = userid2;
                    document.getElementById('reciver_id').value = 0;
                    document.getElementById(`form_buy`).submit();
                }
            }
            function buyNot(){
                'use strict'
                if (confirm('本当に取り消しますか？')) {
                    document.getElementById(`form_buy_not`).submit();
                }
            }
            function delete_buyNot(){
                'use strict'
                if (confirm('取り消しを承諾しますか？')) {
                    document.getElementById(`form_buy_notOK`).submit();
                }
            }
        </script>
        </x-app-layout>
    </body>
</html>