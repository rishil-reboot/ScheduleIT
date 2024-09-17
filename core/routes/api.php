<?php

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

// Route::get('/states', [App\Http\Controllers\CountryStateController::class, 'state']);
// Route::get('/countries', [App\Http\Controllers\CountryStateController::class, 'country']);

Route::post('login', [App\Http\Controllers\Api\CommonApiController::class, 'login']);
Route::post('/register', [App\Http\Controllers\Api\CommonApiController::class, 'register']);

Route::group(['middleware'=>'auth:api'],function(){

    Route::post('/add-webpage-monitor', [App\Http\Controllers\Api\CommonApiController::class, 'addWebpageMonitor']);
    Route::any('me', [App\Http\Controllers\Api\CommonApiController::class, 'me']);
	Route::post('refresh', [App\Http\Controllers\Api\CommonApiController::class, 'refresh']);
	Route::post('logout', [App\Http\Controllers\Api\CommonApiController::class, 'logout']);
});

Route::get('/show/{id}', [App\Http\Controllers\Api\ApiController::class, 'show']);

Route::get('/userlisting', [App\Http\Controllers\Api\ApiController::class, 'index']);
