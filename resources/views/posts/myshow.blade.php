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
        </h1><br>
        <div class="content">
            <div class="content__post">
                <p>ユーザー名：{{ $product->user->name }}<br></p> 
            </div>
            <div class="content__post">
                <p><br></p>
                <h3>販売個数</h3>
                <p>{{ $product->number }}個</p>
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
                <p><br></p>
                <h3>説明</h3>
                <p>{{ $product->product_description }}<br></p>
            </div>
            <div class="content__post">
                <p><br></p>
                <p>税抜き金額：{{ $product->product_price }}<br></p>  
                <p><br></p>
            </div>
            <div class="tag">
                @foreach($product_tags as $product_tag)
                    @if($product_tag->product_id==$product->id)
                        <P>タグ：{{$product_tag->tag->tag}}</P>
                        <p><br></p>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="footer">
            <a href="/products/{{ $product->id }}/edit"><button class="bg-gray-500 rounded-lg">編集ボタン</button></a>
            @php
                $product_orders =  App\Models\Product_order::all();
            @endphp
            @php
                $isbool = false;
            @endphp
            @foreach($product_orders as $product_order)
                @if($product->id==$product_order->product_id)
                    @php
                        $isbool = true;
                    @endphp
                    @break
                @endif
            @endforeach
            @if($isbool==false)
                <form action="/products/status/{{ $product->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="product[status]" value="削除">
                    <button class="bg-gray-500 rounded-lg" type="submit">削除ボタン</button> 
                </form>
            @endif
            <a href="/mypage"><button class="bg-gray-500 rounded-lg">戻るボタン</button></a>
        </div>
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
        </x-app-layout>
    </body>
</html>