<?php

use Illuminate\Http\Request;

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('articles', 'Api\ArticleController@store');
    Route::put('articles/{article}', 'Api\ArticleController@update');
    Route::delete('articles/{article}', 'Api\ArticleController@destroy');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
