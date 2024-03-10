<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>Blog</title>
    </head>
    <body>
        <x-app-layout>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Create') }}
                </h2>
            </x-slot>
        <h1>Blog Name</h1>
        <form action="/products/{{$count}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="title">
                <h2>商品名</h2>
                <input type="text" name="product[product_name]" placeholder="名前" value="{{ old('product.product_name') }}"/>
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
                <textarea name="product[product_description]" placeholder="説明文" value="{{ old('product.product_description') }}"></textarea>
                <p class="title__error" style="color:red">{{ $errors->first('product.product_description') }}</p>
            </div>
            <div class="title">
                <h2>金額</h2>
                <input type="text" name="product[product_price]" placeholder="金額" value="{{ old('product.product_price') }}"/>
                <p class="title__error" style="color:red">{{ $errors->first('product.product_price') }}</p>
            </div>
            <div class="tagPush">
            <h2>タグ追加</h2>
            @for($i = 0; $i < $count; $i++)
                <input type="text" name="tag_array[]" placeholder="タグ" value="{{ old('tag.tag') }}"/>
                <p class="title__error" style="color:red">{{ $errors->first('tag.tag') }}</p>
                <p><br></p>
            @endfor
            </div>
            <p><br></p>
            <input class="bg-gray-500" type="submit" value="保存ボタン"/>
        </form>
        <a href="/products/createPlus/{{$count}}"><button class="bg-gray-500">タグ追加ボタン</button></a>
        <p><br></p>
        @if($count>0)
            <a href="/products/createMinus/{{$count}}"><button class="bg-gray-500">タグ削除ボタン</button></a>
        @endif
        <p><br></p>
        <div class="footer">
            <a href="/"><button class="bg-gray-500">戻るボタン</button></a>
        </div>
        </x-app-layout>
    </body>
</html>