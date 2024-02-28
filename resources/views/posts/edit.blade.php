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
                                <input type="submit" value="保存"/>
                            </form>
                        </div>
        </x-app-layout>
    </body>
</html>