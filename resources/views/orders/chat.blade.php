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
                    {{ __('取引画面') }}
                </h2>
            </x-slot>
        <h1>Chat</h1>
        <p><br></p>
        <div class='chat'>
            @foreach($chat_messages as $chat_message)
                @if($chat_message->chat_room_id==$chat_room->id)
                    @if($chat_message->user_id==Auth::user()->id)
                        <p>自分：</p>
                    @elseif($chat_message->user_id!=Auth::user()->id)
                         <p>相手：</p>
                    @endif
                    <p>{{$chat_message->updated_at}}</p>
                    <p>{{$chat_message->user->name}}</p>
                    <p>{{$chat_message->message_text}}<br></p>
                    <p>--------------------------------------------------------------------<br></p>
                @endif
            @endforeach
            <p><br></p>
            <form id="chatForm" action="/chat/message/{{$chat_room->id}}" method="POST">
                @csrf
                <div class="body">
                    <h2>送信メール</h2>
                    <textarea name="chat_message[message_text]" placeholder="内容" value="{{ old('chat_message.message_text') }}"></textarea>
                    <p class="title__error" style="color:red">{{ $errors->first('chat_message.message_text') }}</p>
                    <input type="hidden" name="chat_message[user_id]" id="sender_id">
                    <input type="hidden" name="chat_message[chat_room_id]" id="chat_room_id">
                    <button type="button" onclick="chatMessage()">送信</button>
                </div>
            </form>
            <script>
            function chatMessage() {
                'use strict'
                var userId = '{{ Auth::user()->id }}';
                document.getElementById('sender_id').value = userId;
                document.getElementById('chat_room_id').value = {{$chat_room->id}};
                document.getElementById(`chatForm`).submit();
            }
        </script>
        </div>
        </x-app-layout>
    </body>
</html>