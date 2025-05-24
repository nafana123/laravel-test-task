<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
Route::put('/product/update/{product}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/product/destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::get('/order/create', [OrderController::class, 'create'])->name('order.create');
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('order.show');
Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
