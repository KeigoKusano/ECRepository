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
                    {{ __('Edit') }}
                </h2>
            </x-slot>
                    <h1 class="title">編集画面</h1>
                        <div class="content">
                            <form action="/products/update/{{ $product->id }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="title">
                                    <h2>商品名</h2>
                                    <input type="text" name="product[product_name]" placeholder="名前" value="{{ $product->product_name }}"/>
                                    <p class="title__error" style="color:red">{{ $errors->first('product.product_name') }}</p>
                                </div>
                                <div class="image">
                                    <h2>画像1</h2>
                                    <input type="file" name="image1">
                                    <p class="title__error" style="color:red">{{ $errors->first('product.image1') }}</p>
                                </div>
                                <div class="image">
                                    <h2>画像2</h2>
                                    <input type="file" name="image2">
                                    <p class="title__error" style="color:red">{{ $errors->first('product.image2') }}</p>
                                </div>
                                <div class="body">
                                    <h2>説明</h2>
                                    <textarea name="product[product_description]" placeholder="説明文">
                                        {{ $product->product_description }}
                                    </textarea>
                                    <p class="title__error" style="color:red">{{ $errors->first('product.product_description') }}</p>
                                </div>
                                <div class="title">
                                    <h2>税抜き金額</h2>
                                    <input type="text" name="product[product_price]" placeholder="金額" value="{{ $product->product_price }}"/>
                                    <p class="title__error" style="color:red">{{ $errors->first('product.product_price') }}</p>
                                </div>
                                <input type="hidden" name="chat_message[message_text]" value="a">
                                <input type="hidden" name="serch" value="a">
                                <input type="hidden" name="review_user_product[review_amount]" value="a">
                                <input type="hidden" name="review_user_product[body]" value=1>
                                <input class="bg-gray-500" type="submit" value="保存ボタン"/>
                            </form>
                            <div class="tag">
                                    <h2>タグ:</h2>
                                    @foreach($product_tags as $product_tag)
                                        <form action="/tags/delete/{{$product_tag->tag_id}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            @if($product_tag->product_id==$product->id)
                                                <P>{{$product_tag->tag->tag}}</P>
                                                <input class="bg-gray-500" type="submit" onclick="tagDelete()" value="削除ボタン"/>
                                                <p><br></p>
                                            @endif
                                    @endforeach
                                </form>
                            </div>
                            <form id="tagsPush" action="/tag/store/{{$product->id}}" method="POST">
                                    @csrf
                                    <h2>タグ追加</h2>
                                    <input type="hidden" name="product[id]" id="product_id">
                                    <input type="hidden" name="product_tag[product_id]" id="product_tag_pid">
                                    <input type="text" name="tag[tag]" placeholder="タグ" value="{{ old('tag.tag') }}"/>
                                    <p class="title__error" style="color:red">{{ $errors->first('tag.tag') }}</p>
                                    <input class="bg-gray-500" type="button" onclick="tagPush()" value="追加ボタン"/>
                            </form>   
                            <script>
                                function tagPush() {
                                    'use strict'
                                    var userId = '{{ Auth::user()->id }}';
                                    document.getElementById('product_id').value = {{$product->id}};
                                    document.getElementById('product_tag_pid').value = {{$product->id}};
                                    document.getElementById(`tagsPush`).submit();
                                }
                            </script>
                        </div>
        </x-app-layout>
    </body>
</html>