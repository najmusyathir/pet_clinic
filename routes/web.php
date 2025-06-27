<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

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

// User related route
Route::middleware('auth')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('users');
    Route::get('/profile/{id}', [UserController::class, 'detail'])->name('user.detail');
    Route::put('/user/{id}/updateRole', [UserController::class, 'updateRole'])->name('user.updateRole');
    Route::delete('/user/{id}/delete', [UserController::class, 'destroy'])->name('user.destroy');
    Route::put('/user/{id}/reset-password', [UserController::class, 'resetPassword'])->name('user.resetPassword');
});

// Pets related route
Route::middleware('auth')->group(function () {
    Route::get('/pet', [PetController::class, 'index'])->name(name: 'pets');
    Route::get('/add', [PetController::class, 'addPage'])->name('pet.add');
    Route::post('/create', [PetController::class, 'create'])->name('pet.create');
    Route::get('/pet/update/{id}', [PetController::class, 'detail'])->name('pet.detail');
    Route::put('/pet/{id}/update', [PetController::class, 'update'])->name('pet.update');
    Route::delete('/pet/{id}/delete', [PetController::class, 'destroy'])->name('pet.destroy');
});

require __DIR__ . '/auth.php';
