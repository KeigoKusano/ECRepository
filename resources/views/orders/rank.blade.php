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
                    {{ __('ランキング') }}
                </h2>
            </x-slot>
        <div class='products'>
            @php
                $tags =  App\Models\Tag::all();
                $product_tags =  App\Models\Product_tag::all();
                $array=[];
                foreach($tags as $tag){
                    $array[$tag->tag] = 0;
                }
                foreach ($product_orders as $product_order){
                    if($product_order->order_status=='発注済み'){
                        foreach($product_tags as $product_tag){
                            if($product_order->product_id==$product_tag->product_id){
                                if (isset($array[$product_tag->tag->tag])) {
                                    $array[$product_tag->tag->tag]++;
                                }
                            }
                        }
                    }
                }
                krsort($array);
                $count=1;
            @endphp
            @foreach ($array as $key => $value)
                <p>{{$count}}位：{{$key}}:{{$value}}</p>
                @php
                    $count++;
                @endphp
                @if($count>10)
                    @break
                @endif
            @endforeach
        </div>
        </x-app-layout>
    </body>
</html>