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
        <form action="/serch" method="POST">
            @csrf
            <h2>検索</h2>
            <input type="text" name="serch"  placeholder="検索" />
            <p class="title__error" style="color:red">{{ $errors->first('serch') }}</p>
            <input class="bg-gray-500" type="submit" value="検索ボタン"/>
            
            <input type="hidden" name="product[product_name]" value="a">
            <input type="hidden" name="product[product_description]" value="a">
            <input type="hidden" name="product[product_price]" value=1>
            <input type="hidden" name="chat_message[message_text]" value="a">
        </form>
        <p>--------------------------------------------------------------------</p>
        <div class='products'>
            @foreach ($products as $product)
                @if($product->user_id!=Auth::id())
                    <div class='product'>
                    @foreach($product_orders as $product_order)
                        @if($product->id==$product_order->product_id&&$product_order->order_status=='発注一覧')
                            <P class="text-orange-700">売り切れ</P>
                        @endif
                    @endforeach
                    <h2 class='title'>商品名：{{ $product->product_name }}</h2>
                    <p class='body'>説明：{{ $product->product_description }}</p>
                    <p class='body'>税抜き金額：{{ $product->product_price }}円</p>
                    <p class='body'>更新日時:{{ $product->updated_at }}</p>
                    <p class='body'>ユーザー名：{{ $product->user->name }}<br></p>
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
                    <a class="bg-gray-500" href="/products/{{ $product->id }}"><button>商品画面ボタン</button></a>
                    <p>--------------------------------------------------------------------</p>
                    <p><br></p>
                </div>
                @endif
            @endforeach
        </div>
        </x-app-layout>
    </body>
</html>