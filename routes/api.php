<?php

use App\Http\Controllers\Api\Article\ArticleAllController;
use App\Http\Controllers\Api\Article\ArticleShowController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\User\ForgotPasswordController;
use App\Http\Controllers\Api\User\LoginController;
use App\Http\Controllers\Api\User\RegisterController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('user')
    ->group(function () {
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('login', [LoginController::class, 'login']);
        Route::prefix('password')
            ->group(function() {
                Route::post('email', [ForgotPasswordController::class, 'sendResetLink']);
                Route::post('reset', [ForgotPasswordController::class, 'reset']);
            });
        Route::middleware('auth:sanctum')
            ->group(function () {
                Route::get('', UserController::class);
            });
    });

Route::prefix('articles')
    ->group(function () {
        Route::get('', ArticleAllController::class);
        Route::get('{slug}', ArticleShowController::class);
//        Route::post('{slug}/comment', [ArticleController::class, 'store']); //todo make using route /{slug}
    });

Route::get('tags', [TagController::class, 'index']);



