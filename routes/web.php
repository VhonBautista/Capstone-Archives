<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\CapstoneController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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
    // Admin Home
    Route::get('dashboard', [HomeController::class, 'admin'])->name('admin.dashboard');
    
    // Capstone
    Route::get('capstone/', [CapstoneController::class, 'index'])->name('admin.capstone');
    Route::post('capstone/add', [CapstoneController::class, 'store'])->name('capstone.add');
    Route::get('capstone/edit/{id}', [CapstoneController::class, 'edit'])->name('capstone.edit');
    Route::patch('capstone/update', [CapstoneController::class, 'update'])->name('capstone.update');
    Route::delete('capstone/delete/{id}', [CapstoneController::class, 'destroy'])->name('capstone.destroy');
    
    // Approval
    Route::get('capstone/approval', [ApprovalController::class, 'index'])->name('admin.approval');
    Route::get('approval/preview/{id}', [CapstoneController::class, 'preview'])->name('approval.preview');
    Route::patch('/approval/approve/{id}', [ApprovalController::class, 'approve'])->name('approval.approve');
    Route::patch('/approval/reject/{id}', [ApprovalController::class, 'reject'])->name('approval.reject');

    // Capstone -> Files
    Route::patch('capstone/update/pdf', [CapstoneController::class, 'updatePDF'])->name('update.pdf');
    Route::patch('capstone/update/images', [CapstoneController::class, 'updateImage'])->name('update.images');
    
    // User
    Route::get('user/', [UserController::class, 'index'])->name('admin.user');
    
    // Permission
    Route::get('user/permission', [PermissionController::class, 'index'])->name('admin.permission');
    Route::post('user/permission/add', [PermissionController::class, 'store'])->name('permission.add');
    Route::get('user/permission/{id}', [PermissionController::class, 'edit'])->name('permission.edit');
    Route::patch('user/permission/update', [PermissionController::class, 'update'])->name('permission.update');
    Route::delete('user/permission/delete/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy');

    // Verification
    Route::get('user/verification', [VerificationController::class, 'index'])->name('admin.verification');
    Route::patch('/verification/accept/{id}', [VerificationController::class, 'accept'])->name('verification.accept');
    Route::patch('/verification/reject/{id}', [VerificationController::class, 'reject'])->name('verification.reject');
    
    // Log
    Route::get('log', [LogController::class, 'index'])->name('admin.log');
});

// Regular User & Admin
Route::middleware('auth')->group(function () {
    // Home
    Route::get('collections', [HomeController::class, 'index'])->name('home');
    
    // Settings
    Route::get('settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('settings', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('verify', [ProfileController::class, 'verify'])->name('profile.verify');
    Route::post('reassess', [ProfileController::class, 'reassess'])->name('profile.reassess');
    
    // Capstones
    Route::get('capstone/view/{id}', [CapstoneController::class, 'view'])->name('capstone.view');
    Route::get('capstone/view/download-pdf/{fileName}', [CapstoneController::class, 'downloadPDF'])->name('capstone.download');
    Route::post('capstone/request', [CapstoneController::class, 'capstoneRequest'])->name('capstone.request');
    
    // Favorite
    Route::get('favorites', [FavoriteController::class, 'index'])->name('favorite');
    Route::post('favorite', [FavoriteController::class, 'favorite'])->name('capstone.favorite');

    // Notification
    Route::post('read', [NotificationController::class, 'markRead'])->name('notification.read');
});

require __DIR__.'/auth.php';
