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
        <h1>Blog Name</h1>
        <div class='products'>
            <form id="orderForm" action="/order/" method="POST">
                @csrf
                <label for="orders">発注項目選択</label>
                <select id="orders" name="orders" onchange="changeAction()">
                @if ($id == 1)
                    <option value=1>検討中</option>
                    <option value=2>発注一覧</option>
                    <option value=3>発注済み</option>
                @elseif ($id == 2)
                    <option value=1>検討中</option>
                    <option value=2 selected>発注一覧</option>
                    <option value=3>発注済み</option>
                @elseif ($id == 3)
                    <option value=1>検討中</option>
                    <option value=2>発注一覧</option>
                    <option value=3 selected>発注済み</option>
                @endif
                </select>
            </form>
            @foreach ($product_orders as $product_order)
                @if ($id == 1 && $product_order->order_status == '検討中')
                    <div class='product'>
                        <p class='body'>{{ $product_order->user_id }}</p>
                        <p class='username'>{{$product_order->user->name }}</p>
                        <a href="/order/chat/{{$product_order->product->user_id}}"><button>ダイレクトチャット</button></a>
                        <p><br></p>
                    </div>
                @elseif ($id == 2 && $product_order->order_status == '発注待ち')
                    <div class='product'>
                        <p class='body'>{{ $product_order->user_id }}</p>
                        <p class='username'>{{$product_order->user->name }}</p>
                        <a href="/order/chat/{{$product_order->product->user_id}}"><button>ダイレクトチャット</button></a>
                        <p><br></p>
                    </div>
                @elseif ($id == 3 && $product_order->order_status == '発注済み')
                    <div class='product'>
                        <p class='body'>{{ $product_order->user_id }}</p>
                        <p class='username'>{{$product_order->user->name }}</p>
                        <a href="/order/chat/{{$product_order->product->user_id}}"><button>ダイレクトチャット</button></a>
                        <p><br></p>
                    </div>
                @endif
            @endforeach
        </div>
        <div class='paginate'>
           
        </div>
        <script>
            function changeAction() {
                var selectElement = document.getElementById('orders');
                var selectedValue = selectElement.value;
                document.getElementById('orderForm').action = '/order/' + selectedValue;
                document.getElementById('orderForm').submit();
            }
        </script>
        </x-app-layout>
    </body>
</html>