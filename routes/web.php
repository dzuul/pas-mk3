<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\LeaderboardController;


Route::get('/', function () {
    return view('welcome');
});

// Dashboard Route with Authentication Middleware
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('index');


// Authentication and Profile Routes
Route::middleware('auth')->group(function () {
    // Alias for profile route
    Route::get('/profile', [UserController::class, 'edit'])->name('profile');
    Route::post('/profile-picture', [UserController::class, 'updateProfilePicture'])->name('profile.picture.update');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    


    // Other Routes
    Route::get('/about', function () {
        return view('about');
    })->name('about');

    Route::get('/aim-trainer', function () {
        return view('aim-trainer');
    })->name('aim-trainer');

    Route::get('/catcher', function () {
        return view('catcher');
    })->name('catcher');

    Route::get('/memory-tap', function () {
        return view('memory-tap');
    })->name('memory-tap');

    // In routes/web.php
    Route::get('/leaderboard', [LeaderboardController::class, 'index']);
    Route::get('/scores', [LeaderboardController::class, 'index'])->name('scores');
    Route::post('/save-score', [ScoreController::class, 'saveScore']);





    Route::get('/profile-view', function () {
        return view('profile-view');
    })->name('profile-view');
});

require __DIR__.'/auth.php';
