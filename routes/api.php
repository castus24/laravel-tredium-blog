<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\User\ForgotPasswordController;
use App\Http\Controllers\Api\User\LoginController;
use App\Http\Controllers\Api\User\RegisterController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('', [HomeController::class, 'index']);

Route::prefix('user')
    ->group(function () {
        Route::post('register', [RegisterController::class, 'register']);
        Route::post('login', [LoginController::class, 'login']);
        Route::prefix('password')
            ->group(function() {
                Route::post('email', [ForgotPasswordController::class, 'sendResetLink']);
                // TODO: Заменить на PUT?
                Route::post('reset', [ForgotPasswordController::class, 'reset']);
            });
    });

Route::prefix('articles')
    ->group(function () {
        Route::get('', [ArticleController::class, 'index']);
        Route::get('{slug}', [ArticleController::class, 'show']);
        Route::post('{slug}/comment', [ArticleController::class, 'store']); //todo make using route /{slug}
    });

Route::get('tags', [TagController::class, 'index']);



