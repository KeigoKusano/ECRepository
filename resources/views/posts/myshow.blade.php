<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Posts</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <x-app-layout>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Create') }}
                </h2>
            </x-slot>
            
        <h1 class="title">
            {{ $product->product_name }}
        </h1><br>
        <div class="content">
            <div class="content__post">
                <h3>ユーザー名</h3>
                <p>{{ $product->user_id }}</p><br>   
            </div>
            <div class="content__post">
                <h3>説明</h3>
                <p>{{ $product->product_description }}</p><br>
            </div>
            <div class="content__post">
                <h3>金額</h3>
                <p>{{ $product->product_price }}</p><br>    
            </div>
        </div>
        <div class="footer">
            <a href="/products/{{ $product->id }}/edit"><button>編集</button></a>
            <a href="/products/delete/{{ $product->id }}"><button>削除</button></a>
            <a href="/mypage">戻る</a>
        </div>
        </x-app-layout>
    </body>
</html>