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
            <a href="/myedit"><button>編集画面</button></a><br>
        <div class='products'>
            @foreach ($products as $product)
                <div class='product'>
                    <h2 class='title'>{{ $product->product_name }}</h2>
                    <p class='body'>{{ $product->product_description }}</p>
                    <p class='body'>{{ $product->product_price }}</p>
                    <p class='body'>{{ $product->updated_at }}</p>
                    <p class='body'>{{ $product->user_id }}</p>
                    <p class='body'>{{ $product->user->name }}</p>
                    <a href="/products/show/{{ $product->id }}"><button>商品画面</button></a>
                    <form action="/products/delete/{{ $product->id }}" id="form_{{ $product->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="deletePost({{ $product->id }})">削除</button> 
                    </form>
                    <br>
                </div>
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