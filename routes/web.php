<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\TemporaryFileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('login');
});

Route::middleware('auth')->group(function () {
    Route::controller(DashboardController::class)->name('dashboard.')->group(function () {
        Route::get('/home', 'index')->name('home');
    });

    Route::controller(TemporaryFileController::class)->name('tmp.')->group(function () {
        Route::post('/tmp/upload', 'upload')->name('upload');
        Route::delete('/tmp/delete', 'delete')->name('delete');
    });

    Route::controller(FolderController::class)->name('folder.')->group(function () {
        Route::get('/folder/tambah', 'tambah')->name('tambah');
        Route::post('/folder/simpan', 'simpan')->name('simpan');
        Route::get('/folder/{folder}/edit', 'edit')->name('edit');
        Route::patch('/folder/{folder}/edit', 'update')->name('update');
        Route::delete('/folder/{folder}/hapus', 'hapus')->name('hapus');
    });

    Route::controller(FileController::class)->name('file.')->group(function () {
        Route::post('/file/simpan', 'simpan')->name('simpan');
    });
});

Auth::routes([
    'register' => false
]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
