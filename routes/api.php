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
Route::group(['middleware' => ['api']], function(){
    Route::resource('posts', 'Api\PostsController');
});

Route::prefix('V1_0')->group(function () {

    Route::middleware([
        'jwt_auth',  // JWTトークンによる認証を強制 - \Tymon\JWTAuth\Http\Middleware\Authenticate::class
    ])->group(function () {
        Route::post('/refresh-token', 'Api\V1_0\RefreshTokenController@refreshToken');
    });

    Route::post('register', 'Api\V1_0\RegisterController@register');
    Route::post('/login', 'Api\V1_0\LoginController@login');
});
