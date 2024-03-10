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
                    {{ __('履歴') }}
                </h2>
            </x-slot>
        <div class='products'>
            @foreach ($product_orders as $product_order)
                <div class='product'>
                    @if($product_order->user_id==Auth::id()||$product_order->product->user_id==Auth::id())
                        <p>{{$product_order->order_status}}  購入者：{{$product_order->user->name}}  販売者：
                        {{$product_order->product->user->name}}  商品名：
                        {{$product_order->product->product_name}}  日時：{{$product_order->updated_at}}</p>
                    @endif
                    @if($product_order->user_id==Auth::id())
                        <p>消費：{{$product_order->product->product_price}}円</p>
                        <p>--------------------------------------------------------------------</p>
                    @elseif($product_order->product->user_id==Auth::id())
                        <p>利益：{{$product_order->product->product_price}}円</p>
                        <p>--------------------------------------------------------------------</p>
                    @endif
                    <p><br></p>
                </div>
            @endforeach
        </div>
        </x-app-layout>
    </body>
</html>