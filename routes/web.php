<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TicketsController::class, 'index']);
Route::get('/ticket/{id}', [TicketsController::class,'show']);

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix'=> '/ticket'], function () {
        Route::get('/create', [TicketsController::class,'create']);
        Route::get('/{id}/edit', [TicketsController::class,'edit']);
        Route::post('/', [TicketsController::class,'store']);
        Route::put('/{id}', [TicketsController::class,'update']);
        Route::delete('/{id}', [TicketsController::class,'destroy']);
    });

    Route::group(['prefix'=> '/chart'], function () {
        Route::get('/', [ChartController::class,'index']);
        Route::post('/', [ChartController::class,'store']);
        Route::put('/{id}', [ChartController::class,'update']);
        Route::delete('/{id}', [ChartController::class,'destroy']);
    });

    Route::group(['prefix'=> '/history'], function () {
        Route::get('/', [HistoryController::class,'index']);
        Route::get('/{id}', [HistoryController::class,'show']);
        Route::post('/', [HistoryController::class,'store']);
        Route::put('/{id}', [HistoryController::class,'reqPayment']);
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
