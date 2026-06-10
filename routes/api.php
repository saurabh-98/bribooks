<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ChapterController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\VersionController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\WorkflowController;
use App\Http\Controllers\Api\DashboardController;

/*
|--------------------------------------------------------------------------
| Authentication APIs
|--------------------------------------------------------------------------
*/

Route::prefix('auth')
    ->controller(AuthController::class)
    ->group(function () {

        Route::post('register', 'register');
        Route::post('login', 'login');

        Route::middleware('auth:api')
            ->group(function () {

                Route::get('profile', 'profile');
                Route::post('logout', 'logout');
            });
    });

/*
|--------------------------------------------------------------------------
| Protected APIs
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Dashboard
        |--------------------------------------------------------------------------
        */

        Route::get(
            'dashboard',
            [DashboardController::class, 'index']
        );

        /*
        |--------------------------------------------------------------------------
        | Books
        |--------------------------------------------------------------------------
        */

        Route::apiResource(
            'books',
            BookController::class
        );

        /*
        |--------------------------------------------------------------------------
        | Chapters
        |--------------------------------------------------------------------------
        */

        Route::get(
            'books/{book}/chapters',
            [ChapterController::class, 'index']
        );

        Route::post(
            'books/{book}/chapters',
            [ChapterController::class, 'store']
        );

        Route::get(
            'chapters/{chapter}',
            [ChapterController::class, 'show']
        );

        Route::put(
            'chapters/{chapter}',
            [ChapterController::class, 'update']
        );

        Route::patch(
            'chapters/{chapter}',
            [ChapterController::class, 'update']
        );

        Route::delete(
            'chapters/{chapter}',
            [ChapterController::class, 'destroy']
        );

        /*
        |--------------------------------------------------------------------------
        | Pages
        |--------------------------------------------------------------------------
        */

        Route::get(
            'chapters/{chapter}/pages',
            [PageController::class, 'index']
        );

        Route::post(
            'chapters/{chapter}/pages',
            [PageController::class, 'store']
        );

        Route::get(
            'pages/{page}',
            [PageController::class, 'show']
        );

        Route::put(
            'pages/{page}',
            [PageController::class, 'update']
        );

        Route::patch(
            'pages/{page}',
            [PageController::class, 'update']
        );

        Route::delete(
            'pages/{page}',
            [PageController::class, 'destroy']
        );

        /*
        |--------------------------------------------------------------------------
        | Versions
        |--------------------------------------------------------------------------
        */

        Route::post(
            'books/{book}/versions',
            [VersionController::class, 'store']
        );

        Route::get(
            'books/{book}/versions',
            [VersionController::class, 'index']
        );

        Route::get(
            'books/{book}/versions/{version}',
            [VersionController::class, 'show']
        );

        Route::post(
            'books/{book}/versions/{version}/rollback',
            [VersionController::class, 'rollback']
        );

        /*
        |--------------------------------------------------------------------------
        | Uploads
        |--------------------------------------------------------------------------
        */

        Route::post(
            'books/{book}/upload',
            [UploadController::class, 'store']
        );

        Route::get(
            'books/{book}/uploads',
            [UploadController::class, 'index']
        );

        Route::get(
            'uploads/{upload}',
            [UploadController::class, 'show']
        );

        Route::delete(
            'uploads/{upload}',
            [UploadController::class, 'destroy']
        );

        /*
        |--------------------------------------------------------------------------
        | Publishing Workflow
        |--------------------------------------------------------------------------
        */

        Route::post(
            'books/{book}/submit',
            [WorkflowController::class, 'submit']
        );

        Route::post(
            'books/{book}/approve',
            [WorkflowController::class, 'approve']
        );

        Route::post(
            'books/{book}/reject',
            [WorkflowController::class, 'reject']
        );

        Route::post(
            'books/{book}/publish',
            [WorkflowController::class, 'publish']
        );
    });