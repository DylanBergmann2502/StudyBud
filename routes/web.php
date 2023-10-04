<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Core Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// User Routes
Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// Session Routes
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/authenticate', [SessionController::class, 'store'])->name('authenticate');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

// Topic Routes
Route::get('/topics', [TopicController::class, 'index'])->name('topics.index');

// Room Routes
Route::resource('/rooms', RoomController::class)->except(['index']);

// Message Routes
Route::resource('rooms.messages', MessageController::class)->only(['store']);
Route::resource('/messages', MessageController::class)->only(['destroy']);

