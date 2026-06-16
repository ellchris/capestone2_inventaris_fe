<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ProcurementController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            function ($request, $next) {
                if (!session()->has('user') || session('user')['role'] !== 'kepala_lab') {
                    return redirect('/login')->with('error', 'Silakan login sebagai Kepala Lab terlebih dahulu.');
                }
                return $next($request);
            }
        ];
    }
    // DASHBOARD KALAB
    public function dashboard()
    {
        $userId = session('user')['id'];
        $response = Http::get("http://127.0.0.1:5000/api/procurements", [
            'user_id' => $userId
        ]);

        $procurements = [];
        if ($response->successful()) {
            $procurements = $response->json()['data'] ?? [];
        }

        $totalDrafts = count($procurements);
        $activeDrafts = count(array_filter($procurements, function($item) {
            return $item['status'] === 'draft';
        }));
        $lockedDrafts = count(array_filter($procurements, function($item) {
            return $item['status'] === 'locked';
        }));

        return view('kalab.dashboard', compact('totalDrafts', 'activeDrafts', 'lockedDrafts'));
    }

    // LIST PROCUREMENTS
    public function index()
    {
        $userId = session('user')['id'];
        $response = Http::get("http://127.0.0.1:5000/api/procurements", [
            'user_id' => $userId
        ]);

        $procurements = [];
        if ($response->successful()) {
            $procurements = $response->json()['data'] ?? [];
        }

        return view('kalab.procurements.index', compact('procurements'));
    }

    // CREATE DRAFT FORM
    public function create()
    {
        $itemsResponse = Http::get('http://127.0.0.1:5000/api/items');
        $existingItems = [];
        if ($itemsResponse->successful()) {
            $existingItems = $itemsResponse->json()['data'] ?? [];
        }

        return view('kalab.procurements.create', compact('existingItems'));
    }

    // STORE DRAFT
    public function store(Request $request)
    {
        $userId = session('user')['id'];
        
        // Parse items to ensure boolean types and handle replacement selection
        $formattedItems = [];
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                if (empty($item['nama_barang'])) continue;
                
                $isReplacement = isset($item['is_replacement']) && $item['is_replacement'] == '1';
                $formattedItems[] = [
                    'nama_barang' => $item['nama_barang'],
                    'harga' => intval($item['harga']),
                    'jumlah' => intval($item['jumlah']),
                    'link_pembelian' => $item['link_pembelian'] ?? '',
                    'is_replacement' => $isReplacement,
                    'replaced_item_id' => $isReplacement ? intval($item['replaced_item_id']) : null
                ];
            }
        }

        $response = Http::post('http://127.0.0.1:5000/api/procurements', [
            'user_id' => $userId,
            'tahun_anggaran' => intval($request->tahun_anggaran),
            'items' => $formattedItems
        ]);

        if ($response->successful()) {
            return redirect('/kalab/procurements')->with('success', 'Draf pengadaan berhasil disimpan.');
        }

        return back()->with('error', 'Gagal menyimpan draf pengadaan.')->withInput();
    }

    // EDIT DRAFT FORM
    public function edit($id)
    {
        $response = Http::get("http://127.0.0.1:5000/api/procurements/$id");
        if (!$response->successful()) {
            return redirect('/kalab/procurements')->with('error', 'Draf pengadaan tidak ditemukan.');
        }

        $procurement = $response->json()['data'];
        
        if ($procurement['status'] === 'locked') {
            return redirect('/kalab/procurements')->with('error', 'Draf sudah dikunci (locked) dan tidak dapat diedit.');
        }

        $itemsResponse = Http::get('http://127.0.0.1:5000/api/items');
        $existingItems = [];
        if ($itemsResponse->successful()) {
            $existingItems = $itemsResponse->json()['data'] ?? [];
        }

        return view('kalab.procurements.edit', compact('procurement', 'existingItems'));
    }

    // UPDATE DRAFT
    public function update(Request $request, $id)
    {
        // Parse items to ensure boolean types and handle replacement selection
        $formattedItems = [];
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                if (empty($item['nama_barang'])) continue;
                
                $isReplacement = isset($item['is_replacement']) && $item['is_replacement'] == '1';
                $formattedItems[] = [
                    'nama_barang' => $item['nama_barang'],
                    'harga' => intval($item['harga']),
                    'jumlah' => intval($item['jumlah']),
                    'link_pembelian' => $item['link_pembelian'] ?? '',
                    'is_replacement' => $isReplacement,
                    'replaced_item_id' => $isReplacement ? intval($item['replaced_item_id']) : null
                ];
            }
        }

        $response = Http::put("http://127.0.0.1:5000/api/procurements/$id", [
            'tahun_anggaran' => intval($request->tahun_anggaran),
            'items' => $formattedItems
        ]);

        if ($response->successful()) {
            return redirect('/kalab/procurements')->with('success', 'Draf pengadaan berhasil diperbarui.');
        }

        $msg = $response->json()['message'] ?? 'Gagal memperbarui draf pengadaan.';
        return back()->with('error', $msg)->withInput();
    }

    // DETAIL VIEW
    public function show($id)
    {
        $response = Http::get("http://127.0.0.1:5000/api/procurements/$id");
        if (!$response->successful()) {
            return redirect('/kalab/procurements')->with('error', 'Draf pengadaan tidak ditemukan.');
        }

        $procurement = $response->json()['data'];
        return view('kalab.procurements.show', compact('procurement'));
    }

    // LOCK DRAFT
    public function lock($id)
    {
        $response = Http::put("http://127.0.0.1:5000/api/procurements/$id/lock");
        
        if ($response->successful()) {
            return redirect('/kalab/procurements')->with('success', 'Draf pengadaan berhasil dikunci (locked).');
        }

        return redirect('/kalab/procurements')->with('error', 'Gagal mengunci draf pengadaan.');
    }

    // DELETE DRAFT
    public function destroy($id)
    {
        $response = Http::delete("http://127.0.0.1:5000/api/procurements/$id");
        
        if ($response->successful()) {
            return redirect('/kalab/procurements')->with('success', 'Draf pengadaan berhasil dihapus.');
        }

        $msg = $response->json()['error'] ?? ($response->json()['message'] ?? 'Gagal menghapus draf pengadaan.');
        return redirect('/kalab/procurements')->with('error', $msg);
    }

    // VIEW INVENTORY (jenis = 'inventaris')
    public function inventory()
    {
        $response = Http::get('http://127.0.0.1:5000/api/items');
        $items = [];
        
        if ($response->successful()) {
            $allItems = $response->json()['data'] ?? [];
            $items = array_filter($allItems, function($item) {
                return strtolower($item['jenis']) === 'inventaris';
            });
        }
        
        return view('kalab.inventory', compact('items'));
    }

    // VIEW CONSUMABLES (jenis = 'habis_pakai')
    public function consumables()
    {
        $response = Http::get('http://127.0.0.1:5000/api/items');
        $items = [];
        
        if ($response->successful()) {
            $allItems = $response->json()['data'] ?? [];
            $items = array_filter($allItems, function($item) {
                return strtolower($item['jenis']) === 'habis_pakai';
            });
        }
        
        return view('kalab.consumables', compact('items'));
    }
}
