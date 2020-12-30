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


Route::post('/register', 'ServerController@register');
Route::post('/login', 'ServerController@login');
Route::post('/checkToken', 'ServerController@checkToken');
Route::post('/logout', 'ServerController@logout');

Route::post('/updateProfile', 'ServerController@updateProfile');
Route::post('/updateUsername', 'ServerController@updateUsername');
Route::post('/updatePassword', 'ServerController@updatePassword');

Route::get('/transactions', 'ServerController@getTransaction');
Route::post('/transactions', 'ServerController@saveTransaction');
Route::delete('/transactions', 'ServerController@deleteTransaction');
Route::put('/transactions', 'ServerController@updateTransaction');