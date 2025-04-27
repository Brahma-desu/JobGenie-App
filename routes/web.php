<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobDescriptionController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [JobDescriptionController::class, 'index'])->name('home');
Route::post('/generate', [JobDescriptionController::class, 'generate'])->name('generate');

// Protected routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/save', [JobDescriptionController::class, 'save'])->name('save');
    Route::get('/job-description/show', [JobDescriptionController::class, 'jobDescriptionShow'])->name('jobDescription.show');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
