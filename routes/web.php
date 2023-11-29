<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::controller(DashboardController::class)->name('dashboard.')->group(function () {
    Route::get('/', 'index')->name('index');
});
