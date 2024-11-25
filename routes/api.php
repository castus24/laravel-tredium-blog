<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\TagController;
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

Route::get('/', [HomeController::class, 'index']);

Route::prefix('articles')
    ->group(function () {
        Route::get('/', [ArticleController::class, 'index']);
        Route::get('/{slug}', [ArticleController::class, 'show']);
        Route::post('/{slug}/comment', [ArticleController::class, 'store']);
    });

Route::get('/tags', [TagController::class, 'index']);



