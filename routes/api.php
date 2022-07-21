<?php

use Illuminate\Support\Facades\Route;
use App\Facades\Localization\LocalizationFacade;
use App\Http\Controllers\Api;

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
    'prefix' => LocalizationFacade::langPrefix(),
    'middleware' => 'localization'
], function () {
    # Home route
    Route::get('/', [Api\HomeController::class, 'index']);

    # Auth routes
    Route::put('register', [Api\PassportAuthController::class, 'register'])
        ->name('register');
    Route::post('login', [Api\PassportAuthController::class, 'login'])
        ->name('login');

    # Api authenticated routes
    Route::middleware('auth:api')->group(function () {
        # Post routes
        Route::resource('post', Api\PostController::class);
    });

    # Post share routes
    Route::group(['prefix' => 'share', 'as'=>'share.'], function () {
        Route::post('telegram', [Api\PostShareController::class, 'telegram'])
            ->name('telegram');
        Route::post('viber', [Api\PostShareController::class, 'viber'])
            ->name('viber');
        Route::post('email', [Api\PostShareController::class, 'email'])
            ->name('e-mail');
    });
});
