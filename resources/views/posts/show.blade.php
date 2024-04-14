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
                    {{ __('商品画面') }}
                </h2>
            </x-slot>
        <h1 class="title">
            商品名：{{ $product->product_name }}
        </h1>
        <div class="content">
            <div class="content__post">
                <p>ユーザー名：{{ $product->user->name }}</p><br>   
            </div>
            <div class="content__post">
                <p><br></p>
                <p>販売個数：{{ $product->number }}個</p>
            </div>
            @if($product->image1)
                <div>
                    <img src="{{ $product->image1}}" alt="画像が読み込めません。" width="100" height="100"/>
                    <p><br></p>
                </div>
            @endif
            @if($product->image2)
                <div>
                    <img src="{{ $product->image2}}" alt="画像が読み込めません。" width="100" height="100"/>
                    <p><br></p>
                </div>
            @endif
            <div class="content__post">
                <h3>説明</h3>
                <p>{{ $product->product_description }}</p>
                <p><br></p>
            </div>
            <div class="content__post">
                <p>税抜き金額：{{ $product->product_price }}円<br></p>   
            </div>
            <div class="tag">
                @foreach($product_tags as $product_tag)
                    @if($product_tag->product_id==$product->id)
                        <P>タグ：{{$product_tag->tag->tag}}</P>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="footer">
            <a href="/youindex/{{$product->user_id}}"><button class="bg-gray-500 rounded-lg">ユーザー一覧ボタン</button></a>
            @if($chatFlag==0&&$buyFlag==0)
            <form id="form2_{{ $product->id }}" action="/chat" method="POST">
                @csrf
                <input type="hidden" name="product_order[product_id]" id="product_id2">
                <input type="hidden" name="product_order[postage]" id="postage2">
                <input type="hidden" name="product_order[user_id]" id="user_id2">
                <input type="hidden" name="product_order[order_status]" id="order_status2">
                <input type="hidden" name="product_order[number]" value=1>
                <input type="hidden" name="chat_room[user1_id]" id="user1_id2">
                <input type="hidden" name="chat_room[user2_id]" id="user2_id2">
                <input type="hidden" name="chat_room[reciver_id]" id="reciver_id2">
                <button class="bg-gray-500 rounded-lg" type="button" onclick="buyChat({{ $product->id }})">
                    ダイレクトチャットボタン</button>
            </form>
            @endif
            @if($buyFlag==0&&$product->status=='正常')
            <form id="form_{{ $product->id }}" action="/orders/{{$product->id}}" method="POST">
                @csrf
                <input type="hidden" name="product_order[product_id]" id="product_id">
                <input type="hidden" name="product_order[postage]" id="postage">
                <input type="hidden" name="product_order[user_id]" id="user_id">
                <input type="hidden" name="product_order[order_status]" id="order_status">
                <input type="hidden" name="product[status]" id="status2">
                <input type="hidden" name="chat_room[user1_id]" id="user1_id">
                <input type="hidden" name="chat_room[user2_id]" id="user2_id">
                <input type="hidden" name="chat_room[reciver_id]" id="reciver_id">
                <input type="hidden" name="product[number]" id="number1">
                <h2>販売個数の入力</h2>
                <input type="input" name="product_order[number]" placeholder="内容" id="number2" value="{{ old('product_order.number') }}">
                <p class="title__error" style="color:red">{{ $errors->first('product_order.number') }}</p>
                <button class="bg-gray-500 rounded-lg" type="button" onclick="buyPost({{ $product->id }})">購入ボタン</button>
            </form>
            @endif
            <p><br></p>
            @if($flag==0)
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
                    <p class="title__error" style="color:red">{{ $errors->first('review_user_product.review_amount') }}</p>
                </div>
                <input type="hidden" name="review_user_product[user_id]" id="user_id3">
                <input type="hidden" name="review_user_product[product_id]" id="product_id3">
                <button class="bg-gray-500 rounded-lg" type="button" onclick="review_Form()">送信ボタン</button>
                
                <input type="hidden" name="chat_message[message_text]" value="a">
                <input type="hidden" name="product[product_name]" value="a">
                <input type="hidden" name="product[product_description]" value="a">
                <input type="hidden" name="product[product_price]" value=1>
                <input type="hidden" name="product[number]" value=0>
                <input type="hidden" name="serch" value="a">
                <input type="hidden" name="user[delivery]" value="a">
                <input type="hidden" name="product_order[number]" value=1>
            </form>
            @endif
            <a href="/"><button class="bg-gray-500 rounded-lg">戻るボタン</button></a>
            <p><br></p>
            @php
                $sum=0;
                $count1=0;
                foreach ($review_user_products as $review_user_product1){
                    if($review_user_product1->product_id==$product->id){
                        $sum+=$review_user_product1->review_amount;
                        $count1++;
                    }
                }    
                if($count1>0){
                    $sum=$sum/$count1;
                }
            @endphp
            @if($count1>0)
                <p><br>平均評価：{{$sum}}<br>総合評価数：{{$count1}}<br></p>
            @endif
            @foreach ($review_user_products as $review_user_product1)
                @if($review_user_product1->product_id==$product->id)
                <div>
                <p><br>更新日時：{{$review_user_product1->updated_at}}</p>
                <p>ユーザー名：{{$review_user_product1->user->name}}</p>   
                <p>レビュー内容：{{$review_user_product1->body}}</p>
                <p>評価：{{$review_user_product1->review_amount}}</p>
                </div>
                @endif
            @endforeach
        </div>
        <script>
            function buyPost(id) {
                'use strict'
                if (confirm('購入しますか？')) {
                    var userId = '{{ Auth::user()->id }}';
                    var number1=document.getElementById('number1').value;
                    var number=document.getElementById('number2').value;
                    document.getElementById('product_id').value = {{$product->id}};
                    document.getElementById('postage').value = 200;
                    document.getElementById('user_id').value = userId;
                    document.getElementById('order_status').value = '発注一覧';
                    document.getElementById('user1_id').value = userId;
                    document.getElementById('user2_id').value = {{$product->user_id}};
                    document.getElementById('reciver_id').value = 0;
                    if({{$product->number}}< number){
                        if (confirm('個数が超過しています。やり直しますか？')) {
                            window.location.href = '/products/{{$product->id}}';    
                        }
                        else{
                            window.location.href = '/';
                        }
                    }
                    else{
                        if({{$product->number}}==number){
                            document.getElementById('status2').value = '売り切れ';
                            document.getElementById('number1').value = 0;
                        }
                        else{
                            var num={{$product->number}}-number;
                            document.getElementById('number1').value = num;
                            document.getElementById('status2').value = '正常';
                        }
                        document.getElementById(`form_${id}`).submit();
                    }
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
                    document.getElementById('user2_id2').value = {{$product->user_id}};
                    document.getElementById('reciver_id2').value = 0;
                    document.getElementById(`form2_${id}`).submit();
                }
            }
            function review_Form(){
                var userId = '{{ Auth::user()->id }}';
                document.getElementById('product_id3').value = {{$product->id}};
                document.getElementById('user_id3').value = userId;
                document.getElementById(`review_form`).submit();
            }
        </script>
        </x-app-layout>
    </body>
</html>