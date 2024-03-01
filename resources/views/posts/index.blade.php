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
                    {{ __('Index') }}
                </h2>
            </x-slot>
        <h1>Blog Name</h1>
        <p>--------------------------------------------------------------------</p>
        <p><br></p>
        <div class='products'>
            @foreach ($products as $product)
                <div class='product'>
                    <h2 class='title'>{{ $product->product_name }}</h2>
                    <p class='body'>{{ $product->product_description }}</p>
                    <p class='body'>{{ $product->product_price }}</p>
                    <p class='body'>{{ $product->updated_at }}</p>
                    <p class='body'>{{ $product->user_id }}</p>
                    <p class='body'>{{ $product->user->name }}<br></p>
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
                        <h2>タグ:</h2>
                        @foreach($product_tags as $product_tag)
                            @if($product_tag->product_id==$product->id)
                                <P>{{$product_tag->tag->tag}}</P>
                            @endif
                        @endforeach
                    </div>
                    <a href="/products/{{ $product->id }}"><button>商品画面</button></a>
                    <p>--------------------------------------------------------------------</p>
                    <p><br></p>
                </div>
            @endforeach
        </div>
        <div class='paginate'>
           
        </div>
        </x-app-layout>
    </body>
</html>