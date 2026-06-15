<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KaprodiController extends Controller
{
   public function dashboard()
    {
        $response = Http::get(
            'http://127.0.0.1:5000/api/procurements'
        );

        $procurements = $response->json()['data'];

        return view(
            'kaprodi.dashboard',
            compact('procurements')
        );
    }

    public function index()
    {
        $response = Http::get(
            'http://127.0.0.1:5000/api/procurements'
        );

        $procurements = $response->json()['data'];

        return view(
            'kaprodi.procurements',
            compact('procurements')
        );
    }

    public function show($id)
    {
        $response = Http::get(
            "http://127.0.0.1:5000/api/procurements/$id"
        );

        $procurement = $response->json()['data'];

        return view(
            'kaprodi.detail',
            compact('procurement')
        );
    }

    public function approve($id)
    {
        Http::put(
            "http://127.0.0.1:5000/api/procurements/$id/approve"
        );

        return redirect()
            ->back()
            ->with('success', 'Draft berhasil disetujui');
    }

    public function reject($id)
    {
        Http::put(
            "http://127.0.0.1:5000/api/procurements/$id/reject"
        );

        return redirect()
            ->back()
            ->with('success', 'Draft berhasil ditolak');
    }

    public function finalize($id)
    {
        Http::put(
            "http://127.0.0.1:5000/api/procurements/$id/finalize"
        );

        return redirect()
            ->back()
            ->with('success', 'Draft berhasil difinalisasi');
    }

}
