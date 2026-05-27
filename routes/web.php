<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// 1. Halaman Utama Bawaan Laravel
Route::get('/', function () {
    return view('welcome');
});

// 2. Fitur Kelola Pengguna (Admin) - Menampilkan Data dari Node.js
Route::get('/admin/users', [AdminController::class, 'index']);

// 3. Fitur Input Ruangan Baru (Admin) - Menampilkan Form Input
Route::get('/admin/rooms/create', [AdminController::class, 'createRoom']);

// 4. Fitur Eksekutor Input Ruangan (Admin) - Mengirim Paket POST ke Node.js
Route::post('/admin/rooms/store', [AdminController::class, 'storeRoom']);