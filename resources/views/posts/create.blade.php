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
                    {{ __('商品登録画面') }}
                </h2>
            </x-slot>
        
        <form action="/products/{{$count}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="title">
                <h2>商品名</h2>
                <input type="text" name="product[product_name]" placeholder="名前" value="{{ old('product.product_name') }}"/>
                <p class="title__error" style="color:red">{{ $errors->first('product.product_name') }}</p>
            </div>
            <div class="title">
                <h2>販売数</h2>
                <input type="text" name="product[number]" placeholder="数" value="{{ old('product.number') }}"/>
                <p class="title__error" style="color:red">{{ $errors->first('product.number') }}</p>
            </div>
            <div class="image">
                <h2>画像1</h2>
                <input type="file" name="image1" value="{{ old('product.image1') }}">
                <p class="title__error" style="color:red">{{ $errors->first('product.image1') }}</p>
            </div>
            <div class="image">
                <h2>画像2</h2>
                <input type="file" name="image2" value="{{ old('product.image2') }}">
                <p class="title__error" style="color:red">{{ $errors->first('product.image2') }}</p>
            </div>
            <div class="body">
                <h2>説明</h2>
                <textarea name="product[product_description]" placeholder="説明文">{{ old('product.product_description') }}</textarea>
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
            <input type="hidden" name="product[status]" value="正常">
            <input type="hidden" name="chat_message[message_text]" value="a">
            <input type="hidden" name="serch" value="a">
            <input type="hidden" name="review_user_product[review_amount]" value="a">
            <input type="hidden" name="review_user_product[body]" value=1>
            <input type="hidden" name="user[delivery]" value="a">
            <input type="hidden" name="product_order[number]" value=1>
            <p><br></p>
            <input class="bg-gray-500 rounded-lg" type="submit" value="保存ボタン"/>
        </form>
        <a href="/products/createPlus/{{$count}}"><button class="bg-gray-500 rounded-lg">タグ追加ボタン</button></a>
        <p><br></p>
        @if($count>0)
            <a href="/products/createMinus/{{$count}}"><button class="bg-gray-500 rounded-lg">タグ削除ボタン</button></a>
        @endif
        <p><br></p>
        <div class="footer">
            <a href="/"><button class="bg-gray-500 rounded-lg">戻るボタン</button></a>
        </div>
        </x-app-layout>
    </body>
</html>