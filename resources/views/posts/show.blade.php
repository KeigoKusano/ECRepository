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
                    {{ __('Create') }}
                </h2>
            </x-slot>
        <h1 class="title">
            {{ $product->product_name }}
        </h1>
       
        <div class="content">
            <div class="content__post">
                <h3>ユーザー名</h3>
                <p>{{ $product->user_id }}</p><br>   
            </div>
            <div class="content__post">
                <h3>説明</h3>
                <p>{{ $product->product_description }}</p><br>
            </div>
            <div class="content__post">
                <h3>金額</h3>
                <p>{{ $product->product_price }}<br></p>   
            </div>
            <div class="tag">
                <h2>タグ</h2>
                @foreach($product_tags as $product_tag)
                    @if($product_tag->product_id==$product->id)
                        <P>{{$product_tag->tag->tag}}</P>
                        <p><br></p>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="footer">
            <form id="form2_{{ $product->id }}" action="/chat" method="POST">
                @csrf
                <input type="hidden" name="product_order[product_id]" id="product_id2">
                <input type="hidden" name="product_order[postage]" id="postage2">
                <input type="hidden" name="product_order[user_id]" id="user_id2">
                <input type="hidden" name="product_order[order_status]" id="order_status2">
                <input type="hidden" name="chat_room[user1_id]" id="user1_id2">
                <input type="hidden" name="chat_room[user2_id]" id="user2_id2">
                <button type="button" onclick="buyChat({{ $product->id }})">ダイレクトチャットボタン</button>
            </form>
            <form id="form_{{ $product->id }}" action="/orders/{{$product->id}}" method="POST">
                @csrf
                <input type="hidden" name="product_order[product_id]" id="product_id">
                <input type="hidden" name="product_order[postage]" id="postage">
                <input type="hidden" name="product_order[user_id]" id="user_id">
                <input type="hidden" name="product_order[order_status]" id="order_status">
                <input type="hidden" name="chat_room[user1_id]" id="user1_id">
                <input type="hidden" name="chat_room[user2_id]" id="user2_id">
                <button type="button" onclick="buyPost({{ $product->id }})">購入ボタン</button>
            </form>
            <p><br></p>
            <form id="review_form" action="/review" method="POST">
                @csrf
                <div class="body">
                    <h2>レビュー</h2>
                    <textarea name="review_user_product[body]" placeholder="内容" value="{{ old('review_user_product.body') }}"></textarea>
                    <p class="title__error" style="color:red">{{ $errors->first('review_user_product.body') }}</p>
                </div>
                <div class="title">
                    <label for="review">評価選択</label>
                    <select id="review" name="review_user_product[review_amount]">
                        <option value=1>1</option>
                        <option value=2>2</option>
                        <option value=3>3</option>
                        <option value=4>4</option>
                        <option value=5>5</option>
                    </select>
                </div>
                <input type="hidden" name="review_user_product[user_id]" id="user_id2">
                <input type="hidden" name="review_user_product[product_id]" id="product_id2">
                <button type="button" onclick="review_Form()">送信ボタン</button>
            </form>
            <a href="/">戻るボタン</a>
            @foreach ($review_user_products as $review_user_product1)
                @if($review_user_product1->product_id==$product->id)
                <div>
                <p><br>{{$review_user_product1->updated_at}}</p>
                <p>{{$review_user_product1->user->name}}</p>   
                <p>{{$review_user_product1->body}}</p>
                <p>{{$review_user_product1->review_amount}}</p>
                </div>
                @endif
            @endforeach
        </div>
        <script>
            function buyPost(id) {
                'use strict'
                if (confirm('購入しますか？')) {
                    var userId = '{{ Auth::user()->id }}';
                    document.getElementById('product_id').value = {{$product->id}};
                    document.getElementById('postage').value = 200;
                    document.getElementById('user_id').value = userId;
                    document.getElementById('order_status').value = '発注一覧';
                    
                    document.getElementById('user1_id').value = userId;
                    document.getElementById('user2_id').value = {{$product->user_id}};;
                    document.getElementById(`form_${id}`).submit();
                }
            }
            function buyChat(id) {
                'use strict'
                if (confirm('チャットしますか？')) {
                    var userId = '{{ Auth::user()->id }}';
                    document.getElementById('product_id2').value = {{$product->id}};
                    document.getElementById('postage2').value = 200;
                    document.getElementById('user_id2').value = userId;
                    document.getElementById('order_status2').value = '検討中';
                    document.getElementById('user1_id2').value = userId;
                    document.getElementById('user2_id2').value = {{$product->user_id}};;
                    document.getElementById(`form2_${id}`).submit();
                }
            }
            function review_Form(){
                var userId = '{{ Auth::user()->id }}';
                document.getElementById('product_id2').value = {{$product->id}};
                document.getElementById('user_id2').value = userId;
                document.getElementById(`review_form`).submit();
            }
        </script>
        </x-app-layout>
    </body>
</html>