<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RequestTemplateController;
use App\Http\Controllers\WorkflowController;
use App\Http\Controllers\CommentController;

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

Route::post('sign-in', [AuthController::class, 'singIn']);
Route::post('sign-out', [AuthController::class, 'signOut']);
Route::post('sign-up', [AuthController::class, 'signUp']);
Route::post('refresh', [AuthController::class, 'refresh']);
Route::post('me', [AuthController::class, 'me']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('users', UserController::class)->except(['delete']);
    Route::apiResource('workflows', WorkflowController::class)->except(['delete']);
    Route::apiResource('requests', RequestController::class)->except(['update', 'delete']);
    Route::apiResource('request-templates', RequestTemplateController::class)->except(['delete']);
    Route::apiResource('requests.comments', CommentController::class)->only(['store']);
    Route::post('requests/{request}/assignees/{user}', [RequestController::class, 'attachAssignee']);
    Route::delete('requests/{request}/assignees/{user}', [RequestController::class, 'detachAssignee']);
    Route::put('requests/{request}/priority', [RequestController::class, 'changePriority']);
    Route::put('requests/{request}/status', [RequestController::class, 'changeStatus']);
    Route::post('upload', [\App\Http\Controllers\MediaController::class, 'store']);
});

