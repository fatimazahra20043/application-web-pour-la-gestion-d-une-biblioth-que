<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file defines all routes for the library system.
| Routes are separated into public, user, and admin sections.
|
*/

// --- Public page (welcome) ---
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// --- Authentication routes ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// --- Protected routes for authenticated users ---
Route::middleware(['auth'])->group(function () {
    // Books
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');
    
    // Reservations
    Route::post('/books/{book}/reserve', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    
    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/books/{book}/favorite', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/books/{book}/favorite', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

// --- Admin routes ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Books (CRUD)
    Route::resource('books', AdminBookController::class);
    
    // Reservations (admin management)
    Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations/search', [AdminReservationController::class, 'searchByCode'])->name('reservations.search');
    Route::get('/reservations/{reservation}', [AdminReservationController::class, 'show'])->name('reservations.show');
    Route::post('/reservations/{reservation}/confirm', [AdminReservationController::class, 'confirm'])->name('reservations.confirm');
    Route::post('/reservations/{reservation}/cancel', [AdminReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::post('/reservations/{reservation}/return', [AdminReservationController::class, 'returnBook'])->name('reservations.return');
    Route::post('/reservations/{reservation}/note', [AdminReservationController::class, 'addNote'])->name('reservations.note');
    
    // Users (CRUD + statistics & notes)
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/statistics', [UserController::class, 'updateStatistics'])->name('users.updateStatistics');
    Route::post('/users/{user}/notes', [UserController::class, 'updateNotes'])->name('users.updateNotes');
    
    // Categories (CRUD)
    Route::resource('categories', CategoryController::class);
});
