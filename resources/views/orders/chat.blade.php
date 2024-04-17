<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>チャット</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <x-app-layout>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('チャット') }}
                </h2>
            </x-slot>
        <p><br></p>
        <div class='chat'>
            @foreach($chat_messages as $chat_message)
                @if($chat_message->chat_room_id==$chat_room->id)
                    @if($chat_message->user_id==Auth::user()->id)
                        <p>自分：</p>
                    @elseif($chat_message->user_id!=Auth::user()->id)
                         <p>相手：</p>
                    @endif
                    <p>更新日時：{{$chat_message->updated_at}}</p>
                    <p>ユーザー名：{{$chat_message->user->name}}</p>
                    <p>メッセージ：{{$chat_message->message_text}}<br></p>
                    <p>--------------------------------------------------------------------<br></p>
                @endif
            @endforeach
            <p><br></p>
            <form id="chatForm" action="/chat/message/{{$chat_room->id}}/{{$id}}" method="POST">
                @csrf
                <div class="body">
                    <h2>送信メール</h2>
                    <textarea name="chat_message[message_text]" placeholder="内容" value="{{ old('chat_message.message_text') }}"></textarea>
                    <p class="title__error" style="color:red">{{ $errors->first('chat_message.message_text') }}</p>
                    <input type="hidden" name="chat_message[user_id]" id="sender_id">
                    <input type="hidden" name="chat_message[chat_room_id]" id="chat_room_id">
                    <button class="bg-gray-500 rounded-lg" type="button" onclick="chatMessage()">送信ボタン</button>
                    
                    <input type="hidden" name="product[product_name]" id="product_name">
                    <input type="hidden" name="product[product_description]" id="product_description">
                    <input type="hidden" name="product[product_price]" id="product_price">
                    <input type="hidden" name="product[number]" value=1>
                    <input type="hidden" name="serch" value="a">
                    <input type="hidden" name="review_user_product[review_amount]" value="a">
                    <input type="hidden" name="review_user_product[body]" value=1>
                    <input type="hidden" name="user[delivery]" value="a">
                    <input type="hidden" name="product_order[number]" value=1>
                    
                </div>
            </form>
            
            <a href="/order/{{$id}}"><button class="bg-gray-500 rounded-lg">戻るボタン</button></a>
            <script>
                function chatMessage() {
                    'use strict'
                    var userId = '{{ Auth::user()->id }}';
                    document.getElementById('sender_id').value = userId;
                    document.getElementById('chat_room_id').value = {{$chat_room->id}};
                
                    document.getElementById('product_name').value = 'a';
                    document.getElementById('product_description').value = 'a';
                    document.getElementById('product_price').value = 1;
               
                    document.getElementById(`chatForm`).submit();
                }
            </script>
        </div>
        </x-app-layout>
    </body>
</html>