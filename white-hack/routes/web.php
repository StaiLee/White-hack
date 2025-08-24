<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\LabLinkController;
use App\Http\Controllers\ProfileController;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware('auth')->group(function () {
    // App
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    Route::get('/courses', [CourseController::class,'index'])->name('courses.index');
    Route::get('/courses/{slug}', [CourseController::class,'show'])->name('courses.show');

    Route::get('/practice', [PracticeController::class,'index'])->name('practice.index');
    Route::post('/labs/{target}/link', [LabLinkController::class,'store'])->name('labs.link');

    // ✅ Routes profil attendues par Breeze (profile.edit, update, destroy)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Inclure les routes d’auth si présentes
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}
