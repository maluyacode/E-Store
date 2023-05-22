<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CustomerController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [ItemController::class, 'getItems'])->name('getItems');
Route::get('add-to-cart/{id}',[ItemController::class, 'addtoCart'])->middleware('auth')->name('addToCart');
Route::get('/shopping-cart', [ItemController::class, 'getCart'])->name('shoppingCart');
Route::get('remove/{id}',[ItemController::class, 'removeItem'])->name('item.remove');
Route::get('reduce/{id}',[ItemController::class, 'getReduceByOne'])->name('item.reduceByOne');
Route::get('checkout',[ItemController::class, 'postCheckout'])->name('checkout');

Route::get('/items', [ItemController::class, 'index']);
Route::get('/customer/orders', [CustomerController::class, 'index']);

Route::prefix('user')->group(function () {
    Route::get('/signup', [UserController::class, 'getSignup']);
    Route::post('/signup', [UserController::class, 'postSignup'])->name('user.signup');
    Route::get('profile', [UserController::class, 'getProfile' ])->name('user.profile')->middleware('auth');
    Route::view('/signin', 'user.signin');
    Route::post('/signin', [LoginController::class, 'postSignin'])->name('user.signin');
    Route::get('/logout',[LoginController::class,'getLogout'])->name('user.logout')->middleware('auth');
});
