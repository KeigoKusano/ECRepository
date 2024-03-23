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
                    {{ __('マイページ') }}
                </h2>
            </x-slot>
            <h1>ユーザーID:{{Auth::id()}}</h1><br>
            <h1>ユーザー名:{{Auth::user()->name}}</h1>
            <h1>メール：{{Auth::user()->email}}</h1>
            @if(Auth::user()->delivery)
                <h1>住所：{{Auth::user()->delivery}}</h1>
            @else
                 <h1>住所：未登録</h1>
            @endif
            <p><br></p>
            <form action="/delivery/{{ Auth::id() }}" id="form_delivery" method="POST">
                @csrf
                @method('PUT')
                <h2>住所</h2>
                <input type="text" name="user[delivery]"  placeholder="住所" value={{Auth::user()->delivery}}>
                @if(Auth::user()->delivery)
                    <button class="bg-gray-500" type="button" onclick="deliveryPost()">変更ボタン</button> 
                @else
                    <button class="bg-gray-500" type="button" onclick="deliveryPost()">登録ボタン</button>
                @endif
                <input type="hidden" name="serch" value="a">   
                <input type="hidden" name="product[product_name]" value="a">
                <input type="hidden" name="product[product_description]" value="a">
                <input type="hidden" name="product[product_price]" value=1>
                <input type="hidden" name="chat_message[message_text]" value="a">
                <input type="hidden" name="review_user_product[review_amount]" value="a">
                <input type="hidden" name="review_user_product[body]" value=1>
            </form>
            <p><br></p>
            <p><br>--------------------------------------------------------------------</p>
        <div class='products'>
            @foreach ($products as $product)
                @if($product->user_id==Auth::id()&&$product->status!='削除')
                    <div class='product'>
                    <h2 class='title'>商品名：{{ $product->product_name }}</h2>
                    <p class='body'>説明：{{ $product->product_description }}</p>
                    <p class='body'>税抜き金額：{{ $product->product_price }}円</p>
                    @if($product->image1)
                    <div>
                        <img src="{{ $product->image1}}" alt="画像が読み込めません。"/>
                        <p><br></p>
                    </div>
                    @endif
                    @if($product->image2)
                    <div>
                        <img src="{{ $product->image2}}" alt="画像が読み込めません。"/>
                        <p><br></p>
                    </div>
                    @endif
                    <div class="tag">
                        @foreach($product_tags as $product_tag)
                            @if($product_tag->product_id==$product->id)
                                <P>タグ：{{$product_tag->tag->tag}}</P>
                            @endif
                        @endforeach
                    </div>
                    <p class='body'>更新日時：{{ $product->updated_at }}</p>
                    <p class='body'>ユーザー名：{{ $product->user->name }}</p>
                    <a href="/products/show/{{ $product->id }}"><button class="bg-gray-500">商品画面ボタン</button></a>
                    @if($product->status=='正常')
                    <form action="/products/status/{{ $product->id }}" id="form_s_{{ $product->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="product[status]" value="削除">
                        <button class="bg-gray-500" type="submit">削除ボタン</button> 
                    </form>
                    @endif
                     <p>--------------------------------------------------------------------</p>
                    <br>
                </div>
                @endif    
            @endforeach
        </div>
        <script>
            function deletePost(id) {
                'use strict'
                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                    document.getElementById(`form_${id}`).submit();
                }
            }
            function deliveryPost() {
                'use strict'
                if (confirm('住所を登録しますか？')) {
                    document.getElementById(`form_delivery`).submit();
                }
            }
        </script>
        </x-app-layout>
    </body>
</html>