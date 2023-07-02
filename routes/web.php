<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// public display
Route::get('/', [ItemController::class, 'getItems'])->name('getItems');
Route::post('/search', [SearchController::class, 'search'])->name('search');

//users view
Route::resource('customer', CustomerController::class);
Route::prefix('user')->group(function () {
    Route::get('/signup', [UserController::class, 'getSignup']);
    Route::post('/signup', [UserController::class, 'postSignup'])->name('user.signup');
    Route::view('/signin', 'user.signin');
    Route::post('/signin', [LoginController::class, 'postSignin'])->name('user.signin');
    Route::get('/logout', [LoginController::class, 'getLogout'])->name('user.logout')->middleware('auth');
});


// protected by auth middleware - for users
Route::middleware('auth')->group(function () {
    Route::get('profile', [UserController::class, 'getProfile'])->name('user.profile');
    Route::get('add-to-cart/{id}', [ItemController::class, 'addtoCart'])->name('addToCart');
    Route::get('/shopping-cart', [ItemController::class, 'getCart'])->name('shoppingCart');
    Route::get('remove/{id}', [ItemController::class, 'removeItem'])->name('item.remove');
    Route::get('reduce/{id}', [ItemController::class, 'getReduceByOne'])->name('item.reduceByOne');
    Route::get('checkout', [ItemController::class, 'postCheckout'])->name('checkout');
});

// admin view
Route::prefix('admin')->middleware('role:admin')->group(function () {
    Route::get('/orders', [OrderController::class, 'orders'])->name('admin.orders');
    Route::post('/import', [ItemController::class, 'import'])->name('item-import');
    Route::get('/items', [ItemController::class, 'index']);
    Route::get('/items/create', function(){
        return view('/items/create');
    });
    Route::post('/items/store', [ItemController::class, 'store'])->name('items.store');
    Route::post('item/store-media', [ItemController::class, 'storeMedia'])->name('item.storeMedia');
    Route::delete('item/delete/{id}', [ItemController::class, 'destroy'])->name('item.delete');
    Route::get('/users', [UserController::class, 'getUsers'])->name('admin.users');
    Route::get('/item/{search}/show', [ItemController::class, 'show'])->name('item.show');
    Route::get('/customer/orders', [CustomerController::class, 'index']);
    Route::post('/orders/import', [OrderController::class, 'import'])->name('orders.import');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});
