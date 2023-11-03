<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Index
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('home');
        }
    } else {
        return redirect()->route('login');
    }
});

// Admin User
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

// Regular User & Admin
Route::middleware('auth')->group(function () {
    Route::get('home', function () {
        return view('home');
    })->name('home');

    Route::get('settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('verify', [ProfileController::class, 'verify'])->name('profile.verify');
    Route::post('reassess', [ProfileController::class, 'reassess'])->name('profile.reassess');
});

require __DIR__.'/auth.php';
