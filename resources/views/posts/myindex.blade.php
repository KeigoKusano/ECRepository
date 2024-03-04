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
                    {{ __('MyIndex') }}
                </h2>
            </x-slot>
            <h1>ユーザーID:{{Auth::id()}}</h1><br>
            <h1>ユーザー名:{{Auth::user()->name}}</h1><br>
            <h1>ユーザーID:{{Auth::user()->password}}</h1><br>
            <h1>ユーザーID:{{Auth::user()->email}}</h1><br>
            <a href="/myedit"><button>編集画面ボタン</button></a>
            <p><br>--------------------------------------------------------------------</p>
        <div class='products'>
            @foreach ($products as $product)
                @if($product->user_id==Auth::id())
                    <div class='product'>
                    <h2 class='title'>{{ $product->product_name }}</h2>
                    <p class='body'>{{ $product->product_description }}</p>
                    <p class='body'>{{ $product->product_price }}</p>
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
                        <h2>タグ</h2>
                        @foreach($product_tags as $product_tag)
                            @if($product_tag->product_id==$product->id)
                                <P>{{$product_tag->tag->tag}}</P>
                            @endif
                        @endforeach
                    </div>
                    <p class='body'>{{ $product->updated_at }}</p>
                    <p class='body'>{{ $product->user->name }}</p>
                    <a href="/products/show/{{ $product->id }}"><button>商品画面ボタン</button></a>
                    <form action="/products/delete/{{ $product->id }}" id="form_{{ $product->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deletePost({{ $product->id }})">削除ボタン</button> 
                        <p>--------------------------------------------------------------------</p>
                    </form>
                    <br>
                </div>
                @endif    
            @endforeach
        </div>
        <div class='paginate'>
           
        </div>
        <script>
            function deletePost(id) {
                'use strict'

                if (confirm('削除すると復元できません。\n本当に削除しますか？')) {
                    document.getElementById(`form_${id}`).submit();
                }
            }
        </script>
        </x-app-layout>
    </body>
</html>