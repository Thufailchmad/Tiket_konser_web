<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Route::get('/', [TicketsController::class, 'home'])->name('home'); // Kode asli
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/ticket/{id}', [TicketsController::class, 'show']);

Route::prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::prefix('tickets')->name('tickets.')->group(function () {
        Route::get('/', [TicketsController::class, 'index'])->name('index');
        Route::get('create', [TicketsController::class, 'create'])->name('create');
        Route::post('store', [TicketsController::class, 'store'])->name('store');
        Route::get('edit/{id}', [TicketsController::class, 'edit'])->name('edit');
        Route::patch('update/{id}', [TicketsController::class, 'update'])->name('update');
        Route::delete('delete/{id}', [TicketsController::class, 'destroy'])->name('destroy');
    });

    Route::get('/history', [HistoryController::class, 'adminIndex'])->name('history.admin');
    Route::put('/history/verify', [HistoryController::class, 'reqPayment'])->name('history.reqPayment');
});

Route::middleware(['auth'])->group(function () {
    Route::group(['prefix' => '/ticket'], function () {
        Route::get('/create', [TicketsController::class, 'create']);
        Route::get('/{id}/edit', [TicketsController::class, 'edit']);
        Route::post('/', [TicketsController::class, 'store']);
        Route::put('/{id}', [TicketsController::class, 'update']);
        Route::delete('/{id}', [TicketsController::class, 'destroy']);
    });

    Route::group(['prefix' => '/chart'], function () {
        Route::get('/', [ChartController::class, 'index']);
        Route::post('/', [ChartController::class, 'store']);
        Route::put('/{id}', [ChartController::class, 'update']);
        Route::delete('/{id}', [ChartController::class, 'destroy']);
    });

    Route::group(['prefix' => '/history'], function () {
        Route::get('/', [HistoryController::class, 'index'])->name('history.index');
        Route::get('/{id}', [HistoryController::class, 'show'])->name('history.show');
        Route::post('/', [HistoryController::class, 'store'])->name('history.store');
        Route::put('/{id}', [HistoryController::class, 'reqPayment'])->name('history.reqPayment');

        Route::post('/{id}/upload', [HistoryController::class, 'uploadImage'])->name('history.uploadImage');
    });
});

Route::get('/dashboard', [TicketsController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
