<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $response = Http::post(
            'http://localhost:5000/api/login',
            [
                'email' => $request->email,
                'password' => $request->password
            ]
        );

        $data = $response->json();

        if (!$data['success']) {
            return back()->with('error', 'Login gagal');
        }

        session([
            'user' => $data['user'],
            'token' => $data['token']
        ]);

        if ($data['user']['role'] === 'admin') {
            return redirect('/admin');
        }

        if ($data['user']['role'] === 'kepala_lab') {
            return redirect('/kalab/dashboard');
        }

        if ($data['user']['role'] === 'ketua_prodi') {
            return redirect('/kaprodi/dashboard');
        }

        if ($data['user']['role'] === 'staf_admin') {
            return redirect('/staf-admin/dashboard');
        }

        if ($data['user']['role'] === 'staf_lab') {
            return redirect('/staf-lab/dashboard');
        }

return redirect('/');

        return redirect('/');
    }

    public function logout()
    {
        session()->flush();

        return redirect('/login');
    }


    public function DashboardAdmin()
    {
        if (!session()->has('user') || session('user')['role'] !== 'admin') {
            return redirect('/login');
        }

        return view('admin.dashboard');
    }
}