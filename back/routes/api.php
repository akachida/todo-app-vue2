<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\TagController;
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

// Todo Routes
Route::group(['prefix' => 'todo'], function () {
    Route::get('/list', [TodoController::class, 'list']);
    Route::get('/{todo}', [TodoController::class, 'show']);
    Route::post('/', [TodoController::class, 'create']);
    Route::put('/{todo}', [TodoController::class, 'update']);
    Route::delete('/{todo}', [TodoController::class, 'destroy']);
});

// Tag Routes
Route::group(['prefix' => 'tag'], function () {
    Route::get('/list', [TagController::class, 'list']);
    Route::get('/{tag}', [TagController::class, 'show']);
    Route::post('/', [TagController::class, 'create']);
    Route::put('/{tag}', [TagController::class, 'update']);
    Route::delete('/{tag}', [TagController::class, 'destroy']);
});
