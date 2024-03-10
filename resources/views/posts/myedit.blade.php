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
                    {{ __('MyEdit') }}
                </h2>
            </x-slot>
                    <h1 class="title">編集画面</h1>
                        <div class="content">
                            <form action="/update" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="title">
                                    <h2>ユーザー名</h2>
                                    <input type="text" name="user[name]" placeholder="ユーザー名" value="{{ old('user.name') }}"/>
                                    <p class="title__error" style="color:red">{{ $errors->first('user.name') }}</p>
                                </div>
                                <div class="body">
                                    <h2>パスワード</h2>
                                    <textarea name="user[password]" placeholder="パスワード" value="{{ old('user.password') }}"></textarea>
                                    <p class="title__error" style="color:red">{{ $errors->first('user.password') }}</p>
                                </div>
                                <div class="title">
                                    <h2>e-mail</h2>
                                    <input type="text" name="user[email]" placeholder="e-mail" value="{{ old('user.email') }}"/>
                                    <p class="title__error" style="color:red">{{ $errors->first('user.email') }}</p>
                                </div>
                                <input class="bg-gray-500" type="submit" value="保存"/>
                            </form>
                        </div>
        </x-app-layout>
    </body>
</html>