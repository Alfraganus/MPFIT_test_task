<?php

use App\Http\Controllers\OrderCommentController;
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




Route::patch('/orders/{id}/mark-finished', [OrderController::class, 'markAsFinished'])->name('orders.markFinished');
Route::post('/orders/{order}/comments', [OrderCommentController::class, 'store'])->name('orders.comments.store');

Route::resource('orders', OrderController::class);
Route::resource('products', ProductController::class);

Route::get('/', [ProductController::class, 'index']);
