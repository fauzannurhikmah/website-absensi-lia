<?php

use App\Http\Controllers\{AttendanceStatusController, DashboardController, EmployeeController, PositionController, PresenceController};
use Illuminate\Support\Facades\{Auth, Route};



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('admin')->group(function () {
        Route::prefix('employee')->group(function () {
            Route::get('/', [EmployeeController::class, 'index'])->name('employee');
            Route::post('/create', [EmployeeController::class, 'store'])->name('create-employee');
            Route::put('/{employee}/edit', [EmployeeController::class, 'update'])->name('edit-employee');
            Route::delete('/{employee}/delete', [EmployeeController::class, 'destroy'])->name('delete-employee');
        });

        Route::prefix('position')->group(function () {
            Route::get('/', [PositionController::class, 'index'])->name('position');
            Route::post('/create', [PositionController::class, 'store'])->name('create-position');
            Route::put('/{position}/edit', [PositionController::class, 'update'])->name('edit-position');
            Route::delete('/{position}/delete', [PositionController::class, 'destroy'])->name('delete-position');
        });

        Route::prefix('attendance')->group(function () {
            Route::get('/', [PresenceController::class, 'index'])->name('attendance')->withoutMiddleware('admin');
            Route::post('/create', [PresenceController::class, 'store'])->name('create-attendance');
            Route::post('/status', [AttendanceStatusController::class, 'store'])->name('create-presence')->withoutMiddleware('admin');
            Route::put('/{attendance}/edit', [PresenceController::class, 'update'])->name('edit-attendance');
            Route::delete('/{attendance}/delete', [PresenceController::class, 'destroy'])->name('delete-attendance');
        });
    });
});
