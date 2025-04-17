<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OpenAIController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log; 
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


Route::get('/', [App\Http\Controllers\Client\ClientController::class, 'index'])->name('productsDetails.index');
Route::get('/productsClient', [App\Http\Controllers\Client\ClientController::class, 'productsClient'])->name('productsDetails.productsClient');
Route::get('/details/{product}', [App\Http\Controllers\Client\ClientController::class, 'show'])->name('productDetails.show');
Route::get('/checkout', [App\Http\Controllers\Client\ClientController::class, 'checkout'])->name('productDetails.checkout');
Route::post('/place-order', [App\Http\Controllers\Client\ClientController::class, 'placeOrder'])->name('productDetails.placeOrder');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::put('/orders/{order}/update-delivery-status', [OrderController::class, 'updateDeliveryStatus']);


Route::get('/openai/formprompt', [OpenAIController::class, 'showForm'])->name('openai.formprompt');
Route::post('/store-product', [OpenAIController::class, 'storeProduct'])->name('products.generate.store');

Route::get('/generate-product/{category}/{keys}', [OpenAIController::class, 'generateProductAndImage'])->name('getPrompt');

Route::get('/generate-info', [OpenAIController::class, 'productInfo'])->name('productInfo');


Route::get('/generate-product-back', [OpenAIController::class, 'generateProductBack'])->name('generate.product.back');

Auth::routes();

