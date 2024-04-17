<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>商品閲覧画面</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <x-app-layout>
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('商品閲覧画面') }}
                </h2>
            </x-slot>
       
        <p><br></p>
        <form action="/serch" method="POST">
            @csrf
            <h2>検索</h2>
            <input type="text" name="serch"  placeholder="検索" value={{$serch}}>
            <p class="title__error" style="color:red">{{ $errors->first('serch') }}</p>
            <input class="bg-gray-500 rounded-lg" type="submit" value="検索ボタン"/>
            
            <input type="hidden" name="product[product_name]" value="a">
            <input type="hidden" name="product[product_description]" value="a">
            <input type="hidden" name="product[product_price]" value=1>
            <input type="hidden" name="chat_message[message_text]" value="a">
            <input type="hidden" name="review_user_product[review_amount]" value="a">
            <input type="hidden" name="review_user_product[body]" value=1>
            <input type="hidden" name="user[delivery]" value="a">
            <input type="hidden" name="product[number]" value=1>
            <input type="hidden" name="product_order[number]" value=1>
        </form>
        <p>--------------------------------------------------------------------</p>
        <div class='products'>
            @php
                $review_user_products =  App\Models\Review_user_product::all();
            @endphp
            @foreach ($products as $product)
                @if($product->user_id!=Auth::id()&&$product->status!='削除')
                    <div class='product'>
                    @if($product->status=='売り切れ')
                        <P class="text-orange-700">売り切れ</P>
                    @endif
                    <h2 class='title'>商品名：{{ $product->product_name }}</h2>
                    <p class='title'>販売個数：{{ $product->number }}</p>
                    <p class='body'>説明：{{ $product->product_description }}</p>
                    <p class='body'>税抜き金額：{{ $product->product_price }}円</p>
                    <p class='body'>更新日時:{{ $product->updated_at }}</p>
                    <p class='body'>ユーザー名：{{ $product->user->name }}<br></p>
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
                    <div class="tag">
                        @foreach($product_tags as $product_tag)
                            @if($product_tag->product_id==$product->id)
                                <P>タグ：{{$product_tag->tag->tag}}</P>
                            @endif
                        @endforeach
                    </div>
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
                    <a class="bg-gray-500 rounded-lg" href="/products/{{ $product->id }}"><button>商品画面ボタン</button></a>
                    <p>--------------------------------------------------------------------</p>
                    <p><br></p>
                </div>
                @endif
            @endforeach
        </div>
        </x-app-layout>
    </body>
</html>