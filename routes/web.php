<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\KaprodiController;
use App\Http\Controllers\StafAdminController;
use App\Http\Controllers\StaffLabController;

// halaman awal

Route::get('/', function () {

    if (session()->has('user')) {

        $role = session('user')['role'];

        if ($role === 'admin') {
            return redirect('/admin');
        }

        elseif ($role === 'kepala_lab') {
            return redirect('/kalab/dashboard');
        }

        elseif ($role === 'ketua_prodi') {
            return redirect('/kaprodi/dashboard');
        }

    }

    return redirect('/login');

});

// login & logout

Route::get('/login', [LoginController::class, 'showLogin']);
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout']);

// admin dashboard

Route::get('/admin', [AdminController::class, 'dashboard']);

// KELOLA PENGGUNA

Route::get('/admin/users', [AdminController::class, 'index']);
Route::get('/admin/users/create', [AdminController::class, 'createUser']);
Route::post('/admin/users/store', [AdminController::class, 'storeUser']);
Route::delete('/admin/users/delete/{id}', [AdminController::class, 'deleteUser']);
Route::get('/admin/users/edit/{id}', [AdminController::class, 'editUser']);
Route::put('/admin/users/update/{id}', [AdminController::class, 'updateUser']);

// KELOLA RUANGAN

Route::get('/admin/rooms', [AdminController::class, 'rooms']);
Route::get('/admin/rooms/create', [AdminController::class, 'createRoom']);
Route::post('/admin/rooms/store', [AdminController::class, 'storeRoom']);
Route::get('/admin/rooms/edit/{id}', [AdminController::class, 'editRoom']);
Route::put('/admin/rooms/update/{id}', [AdminController::class, 'updateRoom']);
Route::delete('/admin/rooms/delete/{id}', [AdminController::class, 'deleteRoom']);

// KEPALA LAB

Route::get('/kalab/dashboard', [ProcurementController::class, 'dashboard']);
Route::get('/kalab/procurements', [ProcurementController::class, 'index']);
Route::get('/kalab/procurements/create', [ProcurementController::class, 'create']);
Route::post('/kalab/procurements/store', [ProcurementController::class, 'store']);
Route::get('/kalab/procurements/edit/{id}', [ProcurementController::class, 'edit']);
Route::put('/kalab/procurements/update/{id}', [ProcurementController::class, 'update']);
Route::get('/kalab/procurements/show/{id}', [ProcurementController::class, 'show']);
Route::post('/kalab/procurements/lock/{id}', [ProcurementController::class, 'lock']);
Route::delete('/kalab/procurements/delete/{id}', [ProcurementController::class, 'destroy']);
Route::get('/kalab/inventory', [ProcurementController::class, 'inventory']);
Route::get('/kalab/consumables', [ProcurementController::class, 'consumables']);

// kaprodi

Route::get('/kaprodi/dashboard', [KaprodiController::class, 'dashboard']);
Route::get('/kaprodi/procurements', [KaprodiController::class, 'index']);
Route::get('/kaprodi/procurements/{id}', [KaprodiController::class, 'show']);
Route::put('/kaprodi/procurements/{id}/approve',[KaprodiController::class, 'approve']);
Route::put( '/kaprodi/procurements/{id}/reject', [KaprodiController::class, 'reject']);
Route::put('/kaprodi/procurements/{id}/finalize',[KaprodiController::class, 'finalize']);

// staf admin
Route::get('/staf-admin/dashboard', [StafAdminController::class, 'dashboard']);
Route::get('/staf-admin/procurements', [StafAdminController::class, 'procurements']);
Route::get('/staf-admin/procurements/{id}', [StafAdminController::class, 'showProcurement']);
Route::put('/staf-admin/procurements/item/{id}/receive', [StafAdminController::class, 'receiveItem']);
Route::get('/staf-admin/items/register/{procurement_item_id}', [StafAdminController::class, 'registerItemForm']);
Route::post('/staf-admin/items/store-registered', [StafAdminController::class, 'storeRegisteredItem']);
Route::get('/staf-admin/inventory', [StafAdminController::class, 'inventory']);
Route::get('/staf-admin/items/edit/{id}', [StafAdminController::class, 'editItem']);
Route::put('/staf-admin/items/update/{id}', [StafAdminController::class, 'updateItem']);
Route::delete('/staf-admin/items/delete/{id}', [StafAdminController::class, 'deleteItem']);

// staf lab
Route::get('/staf-lab/dashboard',[StaffLabController::class, 'dashboard']);
Route::get('/staf-lab/maintenances',[StaffLabController::class, 'maintenances']);
Route::get('/staf-lab/maintenances/create',[StaffLabController::class, 'createMaintenance']);
Route::post('/staf-lab/maintenances/store',[StaffLabController::class, 'storeMaintenance']);