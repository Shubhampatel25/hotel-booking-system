<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes - Hotel Booking System
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', function () {
    return view('home');
});

// User Authentication
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Admin Authentication
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'adminLogin']);

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/rooms', [RoomController::class, 'index']);
    Route::get('/booking/{id}', [RoomController::class, 'showBooking']);
    Route::post('/book', [BookingController::class, 'store']);
    Route::get('/my-bookings', [BookingController::class, 'my']);
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    
    // Room Management
    Route::get('/rooms', [AdminController::class, 'rooms']);
    Route::get('/add-room', [AdminController::class, 'addRoomForm']);
    Route::post('/add-room', [AdminController::class, 'addRoom']);
    Route::get('/edit-room/{id}', [AdminController::class, 'editRoomForm']);
    Route::post('/update-room/{id}', [AdminController::class, 'updateRoom']);
    Route::get('/delete-room/{id}', [AdminController::class, 'deleteRoom']);
    
    // Booking Management
    Route::get('/bookings', [AdminController::class, 'bookings']);
    Route::get('/cancel-booking/{id}', [AdminController::class, 'cancelBooking']);
    
    // User Management
    Route::get('/users', [AdminController::class, 'users']);
    Route::get('/user-details/{id}', [AdminController::class, 'userDetails']);
    Route::get('/delete-user/{id}', [AdminController::class, 'deleteUser']);
});