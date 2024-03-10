<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <x-app-layout>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('取引画面') }}
                </h2>
            </x-slot>
        <h1>Blog Name</h1>
        <div class='products'>
            <form id="orderForm" action="/order/" method="POST">
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
                        <P>商品名：{{$product_order->product->product_name }}</P>
                        @if(Auth::id()==$product_order->user_id)
                            <p class='username'>ユーザー名：{{$product_order->product->user->name }}</p>
                        @elseif(Auth::id()==$product_order->product->user_id)
                            <p class='username'>ユーザー名：{{$product_order->user->name }}</p>
                        @endif
                        <a href="/chats/{{$product_order->chat_roomid}}"><button class="bg-gray-500">
                            ダイレクトチャットボタン</button></a>
                        <p>--------------------------------------------------------------------</p>
                        <p><br></p>
                    </div>
                    @endif
                @elseif ($id == 2 && $product_order->order_status == '発注一覧')
                    @if($product_order->user_id==Auth::id()||$product_order->product->user_id==Auth::id())
                    <div class='product'>
                        <P>商品名：{{$product_order->product->product_name }}</P>
                        @if(Auth::id()==$product_order->user_id)
                            <p class='username'>ユーザー名：{{$product_order->product->user->name }}</p>
                        @elseif(Auth::id()==$product_order->product->user_id)
                            <p class='username'>ユーザー名：{{$product_order->user->name }}</p>
                            <form id="form_buy" 
                                action="/orders/{{$product_order->product_id}}" method="POST">
                                @csrf
                                <input type="hidden" name="product_order[product_id]" id="product_id">
                                <input type="hidden" name="product_order[postage]" id="postage">
                                <input type="hidden" name="product_order[user_id]" id="user_id">
                                <input type="hidden" name="product_order[order_status]" id="order_status">
                                <input type="hidden" name="chat_room[user1_id]" id="user1_id">
                                <input type="hidden" name="chat_room[user2_id]" id="user2_id">
                                <button type="button" onclick="buyPost({{ $product_order->product_id }},
                                    {{ $product_order->user_id }})">発注OKボタン</button>
                            </form>
                        @endif
                        <a href="/chats/{{$product_order->chat_roomid}}"><button class="bg-gray-500">
                            ダイレクトチャットボタン</button></a>
                        <p>--------------------------------------------------------------------</p>
                        <p><br></p>
                    </div>
                    @endif
                @elseif ($id == 3 && $product_order->order_status == '発注済み')
                    @if($product_order->user_id==Auth::id()||$product_order->product->user_id==Auth::id())
                    <div class='product'>
                        <P>商品名：{{$product_order->product->product_name }}</P>
                        @if(Auth::id()==$product_order->user_id)
                            <p class='username'>ユーザー名：{{$product_order->product->user->name }}</p>
                        @elseif(Auth::id()==$product_order->product->user_id)
                            <p class='username'>ユーザー名：{{$product_order->user->name }}</p>
                        @endif
                        <a href="/chats/{{$product_order->chat_roomid}}"><button class="bg-gray-500">
                            ダイレクトチャットボタン</button></a>
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
            function buyPost(id,userid2) {
                'use strict'
                if (confirm('購入しますか？')) {
                    var userId = '{{ Auth::user()->id }}';
                    document.getElementById('product_id').value = id;
                    document.getElementById('postage').value = 200;
                    document.getElementById('user_id').value = userid2;
                    document.getElementById('order_status').value = '発注済み';
                    document.getElementById('user1_id').value = userId;
                    document.getElementById('user2_id').value = userid2;
                    document.getElementById(`form_buy`).submit();
                }
            }
        </script>
        </x-app-layout>
    </body>
</html>