<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // WAJIB DI-IMPORT

class AdminController extends Controller
{
    public function index()
    {
        // Laravel manggil API Node.js yang jalan di port 5000
        $response = Http::get('http://localhost:5000/api/users');

        // Ubah respon dari Node.js jadi array PHP
        $users = $response->json();

        // Kirim data users ke view Blade
        return view('admin.users', compact('users'));
    }

    // 1. Fungsi buat nampilin halaman form tambah ruangan
    public function createRoom()
    {
        return view('admin.createRoom');
    }

    // 2. Fungsi buat ngirim data form ke Node.js (Eksekutor)
    public function storeRoom(\Illuminate\Http\Request $request)
    {
        // Kirim data ke Node.js pake HTTP POST
        $response = \Illuminate\Support\Facades\Http::post('http://127.0.0.1:5000/api/rooms', [
            'nama_ruangan' => $request->nama_ruangan,
            'lokasi'       => $request->lokasi,
        ]);

        if ($response->successful()) {
            // Kalau sukses, balikkin ke halaman form dengan pesan sukses
            return redirect()->back()->with('success', 'Ruangan Berhasil Ditambahkan, King!');
        } else {
            return redirect()->back()->with('error', 'Gagal menambah ruangan.');
        }
    }

}
