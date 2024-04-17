<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>履歴</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <x-app-layout>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('履歴') }}
                </h2>
            </x-slot>
        <div class='products'>
            @foreach ($product_orders as $product_order)
                <div class='product'>
                    @if($product_order->order_status=='発注済み'&&($product_order->user_id==Auth::id()||
                        $product_order->product->user_id==Auth::id()))
                        <p>{{$product_order->order_status}} &nbsp;  購入者：{{$product_order->user->name}} &nbsp; 販売者：
                        {{$product_order->product->user->name}} &nbsp; 商品名：
                        {{$product_order->product->product_name}} &nbsp; 商品金額：{{$product_order->product->product_price}}円 &nbsp; 
                        日時：{{$product_order->updated_at}}</p>
                    @endif
                    @php
                        $money=$product_order->product->product_price*$product_order->number;
                    @endphp
                    @if($product_order->order_status=='発注済み'&&$product_order->user_id==Auth::id())
                        <p>購入数：{{$product_order->number}}個</p>
                        <p>消費：{{$money}}+200円</p>
                        <p>--------------------------------------------------------------------</p>
                        <p><br></p>
                    @elseif($product_order->order_status=='発注済み'&&$product_order->product->user_id==Auth::id())
                        <p>販売数：{{$product_order->number}}個</p>
                        <p>利益：{{$money}}円</p>
                        <p>--------------------------------------------------------------------</p>
                        <p><br></p>
                    @elseif($product_order->order_status=='削除'&&($product_order->user_id==Auth::id()||
                        $product_order->product->user_id==Auth::id()))
                        @if($product_order->user_id==Auth::id())
                            <p>販売者：{{$product_order->product->user->name}} &nbsp; 商品名：
                            {{$product_order->product->product_name}} &nbsp; 商品金額：{{$product_order->product->product_price}}円 &nbsp; 
                            日時：{{$product_order->updated_at}}</p>
                            <p>取り消し申請が承諾されました。</p>
                        @else
                            <p>購入者：{{$product_order->user->name}} &nbsp; 商品名：
                            {{$product_order->product->product_name}} &nbsp; 商品金額：{{$product_order->product->product_price}}円 &nbsp; 
                            日時：{{$product_order->updated_at}}</p>
                            <p>取り消し申請を承諾しました。</p>
                        @endif
                        <p>--------------------------------------------------------------------</p>
                        <p><br></p>
                    @endif
                </div>
            @endforeach
        </div>
        </x-app-layout>
    </body>
</html>