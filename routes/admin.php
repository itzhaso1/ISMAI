<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth'])
    ->group(function (): void {
        Route::get('/', DashboardController::class)->name('dashboard');
    });
