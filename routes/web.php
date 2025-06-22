<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('users');
    Route::get('/profile/{id}', [UserController::class, 'detail'])->name('user.detail');
    Route::put('/user/{id}/updateRole', [UserController::class, 'updateRole'])->name('user.updateRole');
    Route::delete('/user/{id}/delete', [UserController::class, 'destroy'])->name('user.destroy');
});
require __DIR__.'/auth.php';
