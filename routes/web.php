<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\StatusController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('product.index');
Route::get('/products/data', [ProductController::class, 'getDataProduct'])->name('product.data');
Route::get('/products/{product}', [ProductController::class, 'show'])->whereNumber('product')->name('product.show');
Route::post('/products', [ProductController::class, 'store'])->name('product.store');
Route::put('/products/{product}', [ProductController::class, 'update'])->whereNumber('product')->name('product.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->whereNumber('product')->name('product.destroy');

Route::get('/kategori/list', [KategoriController::class, 'list']);
Route::get('/status/list', [StatusController::class, 'list']);