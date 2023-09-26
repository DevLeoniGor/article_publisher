<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\SubscriptionController;
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

Route::prefix('users')->group(function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('token', [AuthController::class, 'token']);
});

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/user', function (Request $request) {
        return $request->user();
    });

    Route::middleware('admin')->group(function() {
        Route::apiResource('subscriptions', SubscriptionController::class);
        Route::put('subscriptions/active/{id}', [SubscriptionController::class, 'active'])
            ->where('id', '[0-9]+');
    });

    Route::middleware('author')->group(function() {
        Route::apiResource('publications', PublicationController::class);
        Route::put('publications/active/{id}', [PublicationController::class, 'active'])
            ->where('id', '[0-9]+');
        Route::put('subscriptions/buy/{id}', [SubscriptionController::class, 'buy'])
            ->where('id', '[0-9]+');
    });
});

Route::get('publications', [PublicationController::class, 'index']);
Route::get('publications/{id}', [PublicationController::class, 'show'])
    ->where('id', '[0-9]+');




