<?php

use Illuminate\Http\Request;

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


/**
 * Auth:api middleware is set to use passport. Login and register routes send $accessToken. 
 * To access passport guarded routes these headers need to be included in the request: 
 * ‘headers’ => [
 *  ‘Accept’ => ‘application/json’,
 *  ‘Authorization’ => ‘Bearer ‘.$accessToken,
 * ]
 */

Route::prefix('auth')->group(function(){
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('getUser', 'AuthController@getUser');
    });
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/posts', 'PostController@index');
    Route::post('/posts', 'PostController@store');
    Route::get('/posts/{post}', 'PostController@show');
    Route::patch('/posts/{post}', 'PostController@update');
    Route::delete('/posts/{post}', 'PostController@destroy');
});
