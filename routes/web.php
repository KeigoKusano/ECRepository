<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Product_orderController; 
use App\Http\Controllers\Review_user_productController;
use App\Http\Controllers\Product_tag;
use App\Http\Controllers\Tag;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(ProductController::class)->middleware(['auth'])->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('/youindex/{youruser}', 'youindex')->name('youindex');
    Route::post('/serch', 'index_serch')->name('index_serch');
    Route::get('/mypage', 'myindex')->name('mypage');
    Route::get('/products/create', 'create')->name('create');
    Route::get('/products/createPlus/{count}', 'create_tagPlus')->name('create_tagPlus');
    Route::get('/products/createMinus/{count}', 'create_tagMinus')->name('create_tagMinus');
    Route::get('/products/{product}', 'show')->name('show');
    Route::get('/products/show/{product}', 'myshow')->name('myshow');
    Route::put('/products/update/{product}', 'update')->name('update');
    Route::put('/delivery/{user}', 'myupdate')->name('myupdate');
    //Route::put('/update', 'myupdate')->name('myupdate');
    Route::put('/products/status/{product}', 'status')->name('status');
    //Route::delete('/products/delete/{product}', 'delete')->name('delete');
    Route::delete('/tags/delete/{product}/{tag}', 'delete_tag')->name('delete_tag');
    Route::get('/products/{product}/edit', 'edit')->name('edit');
    Route::post('/products/{count}', 'store')->name('store');
    Route::post('/tag/store/{product}', 'store_tag')->name('store_tag');
    //Route::post('/orders', 'storeOrder')->name('storeOrder');
});

Route::controller(Product_orderController::class)->middleware(['auth'])->group(function(){
    Route::post('/orders/{product}','store')->name('order_store');
    Route::get('/history', 'history')->name('history');
    Route::get('/chats/{chat_room}/{id}', 'chat')->name('chat');
    //Route::put('/chats/update/{chat_room}', 'chat_update')->name('chat_update');
    Route::post('/chat/message/{chat_room}/{id}', 'message_store')->name('chat_store');
    Route::get('/order/{id}','order')->name('order_order');
    Route::get('/order', 'index')->name('order_index');
    Route::post('/chat','chat_store');
    Route::put('/receive/update/{chat_room}/{id}', 'receive_update')->name('update');
    Route::put('/orders/not/{product_order}','notbuy')->name('notbuy');
    Route::put('/order/notOK/{product_order}/{product}','delete_notbuy')->name('delete_notbuy');
    Route::get('/rank', 'rank')->name('rank');
});
Route::controller(Review_user_productController::class)->middleware(['auth'])->group(function(){
    Route::post('/review','store')->name('review_store');
    //Route::get('/products/{product}', 'show')->name('show');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::get('/register', [ProfileController::class, ''])->name('register');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

