<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\HistoryController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User related route
Route::middleware('auth')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('users');
    Route::get('/user/{id}', [UserController::class, 'detail'])->name('user.detail');
    Route::put('/user/{id}/updateRole', [UserController::class, 'updateRole'])->name('user.updateRole');
    Route::delete('/user/{id}/delete', [UserController::class, 'destroy'])->name('user.destroy');
    Route::put('/user/{id}/reset-password', [UserController::class, 'resetPassword'])->name('user.resetPassword');
});

// Pets related route
Route::middleware('auth')->group(function () {
    Route::get('/pet', [PetController::class, 'index'])->name(name: 'pets');
    Route::get('/pet/add', [PetController::class, 'addPage'])->name('pet.add');
    Route::post('/pet/create', [PetController::class, 'create'])->name('pet.create');
    Route::get('/pet/details/{id}', [PetController::class, 'detail'])->name('pet.detail');
    Route::put('/pet/update/{id}', [PetController::class, 'update'])->name('pet.update');
    Route::delete('/pet/delete/{id}', [PetController::class, 'destroy'])->name('pet.destroy');
});

// Appointment related route
Route::middleware('auth')->group(function () {
    Route::get('/appointment', [AppointmentController::class, 'index'])->name(name: 'appointments');
    Route::get('/appointment/add', [AppointmentController::class, 'addPage'])->name('appointment.add');
    Route::post('/appointment/create', [AppointmentController::class, 'create'])->name('appointment.create');
    Route::get('/appointment/update/{id}', [AppointmentController::class, 'detail'])->name('appointment.detail');
    Route::put('/appointment/update/{id}', [AppointmentController::class, 'update'])->name('appointment.update');
    Route::put('/appointment/cancel/{id}', [AppointmentController::class, 'cancel'])->name('appointment.cancel');
    Route::delete('/appointment/delete/{id}', [AppointmentController::class, 'destroy'])->name('appointment.destroy');
    Route::get('/receipt/{id}', [AppointmentController::class, 'print'])->name('appointment.print');
});

// Appointment History related route
Route::middleware('auth')->group(function () {
    Route::get('/history', [HistoryController::class, 'index'])->name(name: 'histories');
    Route::get('/history/{id}', [HistoryController::class, 'detail'])->name('history.detail');
});

require __DIR__ . '/auth.php';

