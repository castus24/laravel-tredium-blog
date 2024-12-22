<?php

use App\Http\Controllers\Api\Article\ArticleAddController;
use App\Http\Controllers\Api\Article\ArticleAllController;
use App\Http\Controllers\Api\Article\ArticleDeleteController;
use App\Http\Controllers\Api\Article\ArticlePhotoDeleteController;
use App\Http\Controllers\Api\Article\ArticlePhotoUploadController;
use App\Http\Controllers\Api\Article\ArticleShowController;
use App\Http\Controllers\Api\Article\ArticleUpdateController;
use App\Http\Controllers\Api\Permission\PermissionAddController;
use App\Http\Controllers\Api\Permission\PermissionDeleteController;
use App\Http\Controllers\Api\Permission\PermissionGroupController;
use App\Http\Controllers\Api\Permission\PermissionListController;
use App\Http\Controllers\Api\Permission\PermissionUpdateController;
use App\Http\Controllers\Api\Role\RoleAddController;
use App\Http\Controllers\Api\Role\RoleDeleteController;
use App\Http\Controllers\Api\Role\RoleListController;
use App\Http\Controllers\Api\Role\RoleUpdateController;
use App\Http\Controllers\Api\Tag\TagAddController;
use App\Http\Controllers\Api\Tag\TagAllController;
use App\Http\Controllers\Api\Tag\TagDeleteController;
use App\Http\Controllers\Api\Tag\TagShowController;
use App\Http\Controllers\Api\Tag\TagUpdateController;
use App\Http\Controllers\Api\User\ForgotPasswordController;
use App\Http\Controllers\Api\User\LoginController;
use App\Http\Controllers\Api\User\RegisterController;
use App\Http\Controllers\Api\User\UserAvatarDeleteController;
use App\Http\Controllers\Api\User\UserAvatarUploadController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\User\UserEmailEmailController;
use App\Http\Controllers\Api\User\UserEmailUpdateController;
use App\Http\Controllers\Api\User\UserListController;
use App\Http\Controllers\Api\User\UserNameUpdateController;
use App\Http\Controllers\Api\User\UserPasswordUpdateController;
use App\Http\Controllers\Api\User\UserRoleUpdateController;
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

Route::namespace('App\Http\Controllers\Api')
    ->group(function () {
        Route::namespace('User')
            ->prefix('users')
            ->group(function () {
                Route::post('register', [RegisterController::class, 'register']);
                Route::post('login', [LoginController::class, 'login']);
                Route::prefix('password')
                    ->group(function () {
                        Route::post('email', [ForgotPasswordController::class, 'sendResetLink']);
                        Route::post('reset', [ForgotPasswordController::class, 'reset']);
                        Route::put('update', UserPasswordUpdateController::class)
                            ->middleware('auth:sanctum');
                    });
                Route::middleware('auth:sanctum')
                    ->group(function () {
                        Route::get('', UserController::class);
                        Route::get('list', UserListController::class);
                        Route::put('name', UserNameUpdateController::class);
                        Route::put('{user}/role', UserRoleUpdateController::class);
                        Route::prefix('avatar')
                            ->group(function () {
                                Route::post('upload', UserAvatarUploadController::class);
                                Route::delete('delete', UserAvatarDeleteController::class);
                            });
                        Route::prefix('email')
                            ->group(function() {
                                Route::post('email', UserEmailEmailController::class);
                                Route::put('update', UserEmailUpdateController::class)
                                    ->middleware('throttle:2');
                            });
                    });
            });

        Route::namespace('Article')
            ->prefix('articles')
            ->group(function () {
                Route::get('', ArticleAllController::class);
                Route::post('', ArticleAddController::class);
                Route::get('{article:slug}', ArticleShowController::class);
                Route::put('{article:slug}', ArticleUpdateController::class);
                Route::delete('{article:slug}', ArticleDeleteController::class);
                Route::post('/{article:slug}/photo', ArticlePhotoUploadController::class);
                Route::delete('/{article:slug}/photo', ArticlePhotoDeleteController::class);
            });

        Route::namespace('Tag')
            ->prefix('tags')
            ->group(function () {
                Route::get('', TagAllController::class);
                Route::post('', TagAddController::class);
                Route::put('{tag}', TagUpdateController::class);
                Route::delete('{tag}', TagDeleteController::class);
            });

        Route::namespace('Permission')
            ->prefix('permissions')
            ->group(function () {
                Route::get('list', PermissionListController::class);
                Route::get('group', PermissionGroupController::class);
                Route::post('', PermissionAddController::class);
                Route::put('{permission}', PermissionUpdateController::class);
                Route::delete('{permission}', PermissionDeleteController::class);
            });

        Route::namespace('Role')
            ->prefix('roles')
            ->group(function () {
                Route::get('list', RoleListController::class);
                Route::post('', RoleAddController::class);
                Route::put('{role}', RoleUpdateController::class);
                Route::delete('{role}', RoleDeleteController::class);
            });
    });



