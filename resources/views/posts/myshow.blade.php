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
           商品名：{{ $product->product_name }}
        </h1><br>
        <div class="content">
            <div class="content__post">
                <p>ユーザー名：{{ $product->user->name }}<br></p> 
            </div>
            <div class="content__post">
                <p><br></p>
                <h3>説明</h3>
                <p>{{ $product->product_description }}<br></p>
            </div>
            <div class="content__post">
                <p><br></p>
                <p>税抜き金額：{{ $product->product_price }}<br></p>  
                <p><br></p>
            </div>
            <div class="tag">
                @foreach($product_tags as $product_tag)
                    @if($product_tag->product_id==$product->id)
                        <P>タグ：{{$product_tag->tag->tag}}</P>
                        <p><br></p>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="footer">
            <a href="/products/{{ $product->id }}/edit"><button class="bg-gray-500">編集ボタン</button></a>
            <a href="/products/delete/{{ $product->id }}"><button class="bg-gray-500">削除ボタン</button></a>
            <a href="/mypage">戻るボタン</a>
        </div>
        <p><br></p>
            @foreach ($review_user_products as $review_user_product1)
                @if($review_user_product1->product_id==$product->id)
                <div>
                <p><br>更新日時：{{$review_user_product1->updated_at}}</p>
                <p>ユーザー名：{{$review_user_product1->user->name}}</p>   
                <p>レビュー内容：{{$review_user_product1->body}}</p>
                <p>評価：{{$review_user_product1->review_amount}}</p>
                </div>
                @endif
            @endforeach
        </x-app-layout>
    </body>
</html>