<?php

use App\Http\Controllers\V1\MessageController;
use App\Http\Controllers\V1\UserController;
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

Route::group([
  'prefix' => 'v1', 
  'namespace' => 'Api\V1', 
], function () {

    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::get('/user/search/{keyword}', [UserController::class, 'searchByName']);


    Route::get('/message/{id}', [MessageController::class, 'show']);
    Route::get('/message/search/{keyword}', [MessageController::class, 'searchByText']);

});


