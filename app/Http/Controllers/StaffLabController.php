<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StaffLabController extends Controller
{
    public function dashboard()
    {
        $inventories = Http::get(
            'http://localhost:5000/api/inventories'
        )->json();

        $bhps = Http::get(
            'http://localhost:5000/api/bhps'
        )->json();

        $maintenances = Http::get(
            'http://localhost:5000/api/maintenances'
        )->json();

        return view(
            'staff_lab.dashboard',
            [
                'totalInventories' => count($inventories['data'] ?? []),
                'totalBhps' => count($bhps['data'] ?? []),
                'totalMaintenances' => count($maintenances['data'] ?? []),

                'bhps' => array_slice($bhps['data'] ?? [], 0, 5),
                'maintenances' => array_slice($maintenances['data'] ?? [], 0, 5)
            ]
        );
    }

    public function maintenances()
    {
        $response = Http::get('http://localhost:5000/api/maintenances');

        return view(
            'staff_lab.maintenances',
            [
                'maintenances' => $response->json()['data'] ?? []
            ]
        );
    }

    public function createMaintenance()
    {
        $inventories = Http::get(
            'http://localhost:5000/api/inventories'
        )->json();

        $bhps = Http::get(
            'http://localhost:5000/api/bhps'
        )->json();

        return view(
            'staff_lab.createMaintenance',
            [
                'inventories' => $inventories['data'] ?? [],
                'bhps' => $bhps['data'] ?? []
            ]
        );
    }

    public function storeMaintenance(Request $request)
    {
        Http::post(
            'http://localhost:5000/api/maintenances',
            [
                'item_id' => $request->item_id,
                'deskripsi_kerusakan' => $request->deskripsi_kerusakan,
                'solusi' => $request->solusi,
                'bhp_item_id' => $request->bhp_item_id,
                'jumlah_terpakai' => $request->jumlah_terpakai,
            ]
        );

        return redirect('/staf-lab/maintenances')
            ->with('success', 'Maintenance berhasil ditambahkan');
    }
}