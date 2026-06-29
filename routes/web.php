<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StackController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Main dash
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::resource('entries', EntryController::class)->except('show');
    Route::resource('stacks', StackController::class)->except(['index', 'create']);
    Route::resource('journals', JournalController::class)->except(['index', 'create']);
    Route::resource('pages', PageController::class);

    Route::post('/photo-upload/{type}/{id}', [PhotoController::class, 'update'])->name('photo.upload');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
