<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| LOGIN & LOGOUT
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLogin']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| DASHBOARD ADMIN
|--------------------------------------------------------------------------
*/

Route::get('/admin', [AdminController::class, 'dashboard']);

/*
|--------------------------------------------------------------------------
| KELOLA PENGGUNA
|--------------------------------------------------------------------------
*/

Route::get('/admin/users', [AdminController::class, 'index']);
Route::get('/admin/users/create', [AdminController::class, 'createUser']);
Route::post('/admin/users/store', [AdminController::class, 'storeUser']);
Route::delete('/admin/users/delete/{id}', [AdminController::class, 'deleteUser']);
Route::get('/admin/users/edit/{id}', [AdminController::class, 'editUser']);
Route::put('/admin/users/update/{id}', [AdminController::class, 'updateUser']);

/*
|--------------------------------------------------------------------------
| KELOLA RUANGAN
|--------------------------------------------------------------------------
*/

Route::get('/admin/rooms', [AdminController::class, 'rooms']);
Route::get('/admin/rooms/create', [AdminController::class, 'createRoom']);
Route::post('/admin/rooms/store', [AdminController::class, 'storeRoom']);
Route::get('/admin/rooms/edit/{id}', [AdminController::class, 'editRoom']);
Route::put('/admin/rooms/update/{id}', [AdminController::class, 'updateRoom']);
Route::delete('/admin/rooms/delete/{id}', [AdminController::class, 'deleteRoom']);