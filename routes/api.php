<?php

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\UserSettingsController;

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

Route::post('/register', 'Auth\UserAuthController@register');
Route::post('/login', 'Auth\UserAuthController@login');
Route::post('/logout', 'Auth\UserAuthController@logout');


Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user', [\App\Http\Controllers\Auth\UserController::class, 'current']);

    Route::post('save-profile', [\App\Http\Controllers\Settings\ProfileController::class, 'update']);
    Route::post('delete-profile', [\App\Http\Controllers\Settings\ProfileController::class, 'destroy']);
});



Route::group(['prefix'=>'weather'], function(){
    Route::get('/today/{long?}/{lat?}',  [WeatherController::class, 'index'])->middleware('auth:api');
    Route::get('/forecast/{long?}/{lat?}',  [WeatherController::class, 'forecast'])->middleware('auth:api');
    Route::get('/history5days/{long?}/{lat?}',  [WeatherController::class, 'history5days'])->middleware('auth:api');
    Route::get('/alert/{long?}/{lat?}',  [WeatherController::class, 'alert'])->middleware('auth:api');
});
