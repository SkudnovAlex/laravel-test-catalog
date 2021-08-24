<?php

use App\Http\Controllers\Api\ProductApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['prefix' => 'product'], function () {
    Route::put('', ProductApiController::class . '@create');
    Route::delete('', ProductApiController::class . '@delete');
    Route::post('update', ProductApiController::class . '@update');
    Route::post('list', ProductApiController::class . '@getListByCategoryId');
    Route::get('{id}', ProductApiController::class . '@getById')
        ->where('id', '[0-9]+');
});
