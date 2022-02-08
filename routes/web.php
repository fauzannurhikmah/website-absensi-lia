<?php

use App\Http\Controllers\{AttendanceStatusController, DashboardController, EmployeeController, PositionController, PresenceController, UserController};
use Illuminate\Support\Facades\{Auth, Route};



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('admin')->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('user');
            Route::get('/create', [UserController::class, 'create'])->name('create-user');
            Route::post('/create', [UserController::class, 'store']);
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit-user');
            Route::put('/{user}/edit', [UserController::class, 'update']);
            Route::delete('/{user}/delete', [UserController::class, 'destroy'])->name('delete-user');
        });

        Route::prefix('position')->group(function () {
            Route::get('/', [PositionController::class, 'index'])->name('position');
            Route::post('/create', [PositionController::class, 'store'])->name('create-position');
            Route::put('/{position}/edit', [PositionController::class, 'update'])->name('edit-position');
            Route::delete('/{position}/delete', [PositionController::class, 'destroy'])->name('delete-position');
        });

        Route::prefix('attendance')->group(function () {
            Route::post('/export', [PresenceController::class, 'exportFile'])->name('export-file');
            Route::get('/', [PresenceController::class, 'index'])->name('attendance')->withoutMiddleware('admin');
            Route::post('/create', [PresenceController::class, 'store'])->name('create-attendance')->withoutMiddleware('admin');
            Route::put('/{attendance}/edit', [PresenceController::class, 'update'])->name('edit-attendance');
            Route::delete('/{attendance}/delete', [PresenceController::class, 'destroy'])->name('delete-attendance');
        });
    });
});
