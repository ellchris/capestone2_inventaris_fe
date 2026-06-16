<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    // dashboard admin
    public function dashboard()
    {
        $usersResponse = Http::get('http://127.0.0.1:5000/api/users');
        $roomsResponse = Http::get('http://127.0.0.1:5000/api/rooms');

        $users = [];
        $rooms = [];

        if ($usersResponse->successful()) {

            $users = $usersResponse->json()['data'] ?? [];

        }

        if ($roomsResponse->successful()) {

            $rooms = $roomsResponse->json();

        }

        $totalUsers = count($users);
        $totalRooms = count($rooms);

        return view(
            'admin.dashboard',
            compact(
                'totalUsers',
                'totalRooms',
                'users',
                'rooms'
            )
        );
    }

    // KELOLA PENGGUNA
    public function index()
    {
        $response = Http::get('http://127.0.0.1:5000/api/users');

        $users = [];

        if ($response->successful()) {

            $data = $response->json();

            $users = $data['data'] ?? [];
        }

        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        return view('admin.createUser');
    }

    public function storeUser(Request $request)
    {
        $response = Http::post(
            'http://127.0.0.1:5000/api/users',
            [
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => $request->password,
                'role' => $request->role
            ]
        );

        if ($response->successful()) {

            return redirect('/admin/users')
                ->with(
                    'success',
                    'User berhasil ditambahkan!'
                );
        }

        return back()
            ->with(
                'error',
                'Gagal menambahkan user!'
            );
    }

    public function deleteUser($id)
    {
        $response = Http::delete(
            "http://127.0.0.1:5000/api/users/$id"
        );

        return redirect('/admin/users')
            ->with(
                'success',
                'User berhasil dihapus!'
            );
    }

    public function editUser($id)
    {
        $response = Http::get(
            "http://127.0.0.1:5000/api/users/$id"
        );

        $user = $response->json()['data'];

        return view(
            'admin.editUser',
            compact('user')
        );
    }

    public function updateUser(Request $request,$id)
    {
        Http::put(
            "http://127.0.0.1:5000/api/users/$id",
            [
                'nama' => $request->nama,
                'email' => $request->email,
                'role' => $request->role
            ]
        );

        return redirect('/admin/users')
            ->with(
                'success',
                'User berhasil diupdate!'
            );
    }

   // KELOLA RUANGAN
    public function rooms()
    {
        $response = Http::get('http://127.0.0.1:5000/api/rooms');

        $rooms = [];

        if ($response->successful()) {
            $rooms = $response->json();
        }

        return view('admin.rooms', compact('rooms'));
    }

    public function editRoom($id)
    {
        $response = Http::get(
            "http://127.0.0.1:5000/api/rooms/$id"
        );

        $room = $response->json()['data'];

        return view(
            'admin.editRoom',
            compact('room')
        );
    }

    public function updateRoom(Request $request, $id)
    {
        Http::put(
            "http://127.0.0.1:5000/api/rooms/$id",
            [
                'nama_ruangan' => $request->nama_ruangan,
                'lokasi' => $request->lokasi
            ]
        );

        return redirect('/admin/rooms')
            ->with(
                'success',
                'Ruangan berhasil diupdate!'
            );
    }

    public function deleteRoom($id)
    {
        Http::delete(
            "http://127.0.0.1:5000/api/rooms/$id"
        );

        return redirect('/admin/rooms')
            ->with(
                'success',
                'Ruangan berhasil dihapus!'
            );
    }

    // tambah ruangan
    public function createRoom()
    {
        return view('admin.createRoom');
    }

    // simpan ruangan
    public function storeRoom(Request $request)
    {
        $response = Http::post(
            'http://127.0.0.1:5000/api/rooms',
            [
                'nama_ruangan' => $request->nama_ruangan,
                'lokasi' => $request->lokasi
            ]
        );

        if ($response->successful()) {

            return redirect('/admin/rooms')
                ->with(
                    'success',
                    'Ruangan berhasil ditambahkan!'
                );
        }

        return back()
            ->with(
                'error',
                'Gagal menambahkan ruangan!'
            );
    }
}