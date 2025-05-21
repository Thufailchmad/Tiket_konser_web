<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\TicketsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/', [TicketsController::class, 'index']);

Route::post('/login', [AuthenticatedSessionController::class, 'login']);
Route::post('/register', [RegisteredUserController::class, 'storeApi']);

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/logout', [AuthenticatedSessionController::class, 'logout']);

    Route::group(['prefix' => '/ticket/{id}'], function () {
        Route::get('/', [TicketsController::class, 'show']);
        Route::post('/', [TicketsController::class, 'store']);
        Route::put('/', [TicketsController::class, 'update']);
        Route::delete('/', [TicketsController::class, 'destroy']);
    });

    Route::group(['prefix' => '/chart'], function () {
        Route::get('/', [ChartController::class, 'index']);
        Route::post('/', [ChartController::class, 'store']);
        Route::put('/{id}', [ChartController::class, 'update']);
        Route::delete('/{id}', [ChartController::class, 'destroy']);
    });

    Route::group(['prefix' => '/history'], function () {
        Route::get('/', [HistoryController::class, 'index']);
        Route::get('/{id}', [HistoryController::class, 'show']);
        Route::post('/', [HistoryController::class, 'store']);
        Route::post('/{id}', [HistoryController::class, 'uploadImage']);
    });
});
