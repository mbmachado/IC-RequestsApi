<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequestController;

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

Route::post('sign-in', [AuthController::class, 'login']);
Route::post('sign-out', [AuthController::class, 'logout']);
Route::post('sign-up', [AuthController::class, 'signUp']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::post('me', [AuthController::class, 'me']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('requests', RequestController::class)->except(['update', 'delete']);
    Route::apiResource('requests.comments', \App\Http\Controllers\CommentController::class)->only(['store']);
    Route::post('upload', [\App\Http\Controllers\MediaController::class, 'store']);
});

