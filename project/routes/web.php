<?php

use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\ProductController;
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


Route::get('/', function () {
    return view('shop.index');
});

Route::get('/catalog/{category}/', [CategoryController::class, 'listCategories'])
    ->where('category', '[0-9A-Za-z]+');

Route::get('/catalog/{category}/list', [ProductController::class, 'listProducts'])
    ->where('category', '[0-9A-Za-z-]+');

Route::get('/catalog/{category}/{id}', [ProductController::class, 'getProduct'])
    ->where('category', '[0-9A-Za-z-]+')
    ->where('id', '[0-9]+');
