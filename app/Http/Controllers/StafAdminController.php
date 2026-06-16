<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StafAdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            function ($request, $next) {
                if (!session()->has('user') || !in_array(session('user')['role'], ['staf_admin', 'staff_admin'])) {
                    return redirect('/login')->with('error', 'Silakan login sebagai Staf Administrasi terlebih dahulu.');
                }
                return $next($request);
            }
        ];
    }

    // DASHBOARD
    public function dashboard()
    {
        $procResponse = Http::get('http://127.0.0.1:5000/api/procurements');
        $itemResponse = Http::get('http://127.0.0.1:5000/api/items');

        $totalApproved = 0;
        $totalFinalized = 0;
        $totalItems = 0;

        if ($procResponse->successful()) {
            $procurements = $procResponse->json()['data'] ?? [];
            $totalApproved = count(array_filter($procurements, function($p) {
                return $p['approval_status'] === 'approved';
            }));
            $totalFinalized = count(array_filter($procurements, function($p) {
                return $p['approval_status'] === 'finalized';
            }));
        }

        if ($itemResponse->successful()) {
            $totalItems = count($itemResponse->json()['data'] ?? []);
        }

        return view('staf_admin.dashboard', compact('totalApproved', 'totalFinalized', 'totalItems'));
    }

    // LIST APPROVED PROCUREMENTS
    public function procurements()
    {
        $response = Http::get('http://127.0.0.1:5000/api/procurements');
        $procurements = [];

        if ($response->successful()) {
            $all = $response->json()['data'] ?? [];
            // Filter only approved or finalized procurements
            $procurements = array_filter($all, function($p) {
                return in_array($p['approval_status'], ['approved', 'finalized']);
            });
        }

        return view('staf_admin.procurements.index', compact('procurements'));
    }

    // SHOW APPROVED PROCUREMENT ITEMS FOR RECEIPT
    public function showProcurement($id)
    {
        $response = Http::get("http://127.0.0.1:5000/api/procurements/$id");
        if (!$response->successful()) {
            return redirect('/staf-admin/procurements')->with('error', 'Pengadaan tidak ditemukan.');
        }

        $procurement = $response->json()['data'];
        return view('staf_admin.procurements.show', compact('procurement'));
    }

    // INPUT TANGGAL DATANG / TERIMA BARANG
    public function receiveItem(Request $request, $id)
    {
        $request->validate([
            'tanggal_diterima' => 'required|date'
        ]);

        $response = Http::put("http://127.0.0.1:5000/api/procurement-items/$id/receive", [
            'tanggal_diterima' => $request->tanggal_diterima
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Tanggal penerimaan barang berhasil disimpan.');
        }

        return back()->with('error', 'Gagal memproses penerimaan barang.');
    }

    // FORM REGISTRASI KE INVENTARIS
    public function registerItemForm(Request $request, $procurement_item_id)
    {
        $procurementId = $request->query('procurement_id');
        if (!$procurementId) {
            return redirect('/staf-admin/procurements')->with('error', 'Parameter pengadaan tidak lengkap.');
        }

        $procResponse = Http::get("http://127.0.0.1:5000/api/procurements/$procurementId");
        $roomsResponse = Http::get("http://127.0.0.1:5000/api/rooms");

        if (!$procResponse->successful() || !$roomsResponse->successful()) {
            return redirect('/staf-admin/procurements')->with('error', 'Gagal memuat data registrasi.');
        }

        $procurement = $procResponse->json()['data'];
        $rooms = $roomsResponse->json();

        // Find the specific item
        $procurementItem = null;
        foreach ($procurement['items'] as $item) {
            if ($item['id'] == $procurement_item_id) {
                $procurementItem = $item;
                break;
            }
        }

        if (!$procurementItem) {
            return redirect('/staf-admin/procurements')->with('error', 'Barang pengadaan tidak ditemukan.');
        }

        return view('staf_admin.items.register', compact('procurementItem', 'rooms', 'procurementId'));
    }

    // STORE REGISTRASI INVENTARIS
    public function storeRegisteredItem(Request $request)
    {
        $request->validate([
            'procurement_item_id' => 'required',
            'room_id' => 'required',
            'uuid_qr' => 'required',
            'nama_barang' => 'required',
            'jenis' => 'required',
            'stok' => 'required|integer',
            'status' => 'required',
            'foto_qr' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $foto_qr = null;
        if ($request->hasFile('foto_qr')) {
            $file = $request->file('foto_qr');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/qr_codes'), $filename);
            $foto_qr = 'uploads/qr_codes/' . $filename;
        }

        // 1. Post to items table
        $itemResponse = Http::post('http://127.0.0.1:5000/api/items', [
            'room_id' => intval($request->room_id),
            'uuid_qr' => $request->uuid_qr,
            'nama_barang' => $request->nama_barang,
            'jenis' => $request->jenis,
            'stok' => intval($request->stok),
            'status' => $request->status,
            'foto_qr' => $foto_qr
        ]);

        if (!$itemResponse->successful()) {
            return back()->with('error', 'Gagal mendaftarkan barang ke inventaris.')->withInput();
        }

        $newItemId = $itemResponse->json()['insertId'];

        // 2. Link item back to procurement item
        Http::put("http://127.0.0.1:5000/api/procurement-items/" . $request->procurement_item_id . "/link-item", [
            'registered_item_id' => $newItemId
        ]);

        // 3. Handle Replacement (If replacing an old item, mark old item as rusak)
        if ($request->filled('replaced_item_id')) {
            $oldId = $request->replaced_item_id;
            $oldItemResponse = Http::get("http://127.0.0.1:5000/api/items/$oldId");
            if ($oldItemResponse->successful()) {
                $oldItem = $oldItemResponse->json()['data'];
                // Update status of old item to 'rusak'
                Http::put("http://127.0.0.1:5000/api/items/$oldId", [
                    'room_id' => $oldItem['room_id'],
                    'uuid_qr' => $oldItem['uuid_qr'],
                    'nama_barang' => $oldItem['nama_barang'],
                    'jenis' => $oldItem['jenis'],
                    'stok' => $oldItem['stok'],
                    'status' => 'rusak',
                    'foto_qr' => $oldItem['foto_qr']
                ]);
            }
        }

        $procurementId = $request->procurement_id;
        return redirect("/staf-admin/procurements/$procurementId")->with('success', 'Barang berhasil didaftarkan ke inventaris.');
    }

    // VIEW INVENTORY
    public function inventory()
    {
        $itemResponse = Http::get('http://127.0.0.1:5000/api/items');
        $roomsResponse = Http::get('http://127.0.0.1:5000/api/rooms');

        $items = [];
        $rooms = [];

        if ($itemResponse->successful()) {
            $items = $itemResponse->json()['data'] ?? [];
        }

        if ($roomsResponse->successful()) {
            $rawRooms = $roomsResponse->json();
            foreach ($rawRooms as $r) {
                $rooms[$r['id']] = $r['nama_ruangan'];
            }
        }

        return view('staf_admin.items.index', compact('items', 'rooms'));
    }

    // EDIT INVENTORY ITEM
    public function editItem($id)
    {
        $itemResponse = Http::get("http://127.0.0.1:5000/api/items/$id");
        $roomsResponse = Http::get("http://127.0.0.1:5000/api/rooms");

        if (!$itemResponse->successful() || !$roomsResponse->successful()) {
            return redirect('/staf-admin/inventory')->with('error', 'Barang tidak ditemukan.');
        }

        $item = $itemResponse->json()['data'];
        $rooms = $roomsResponse->json();

        return view('staf_admin.items.edit', compact('item', 'rooms'));
    }

    // UPDATE INVENTORY ITEM
    public function updateItem(Request $request, $id)
    {
        $request->validate([
            'room_id' => 'required',
            'uuid_qr' => 'required',
            'nama_barang' => 'required',
            'jenis' => 'required',
            'stok' => 'required|integer',
            'status' => 'required',
            'foto_qr' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $foto_qr = $request->existing_foto_qr;
        if ($request->hasFile('foto_qr')) {
            $file = $request->file('foto_qr');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/qr_codes'), $filename);
            $foto_qr = 'uploads/qr_codes/' . $filename;
        }

        $response = Http::put("http://127.0.0.1:5000/api/items/$id", [
            'room_id' => intval($request->room_id),
            'uuid_qr' => $request->uuid_qr,
            'nama_barang' => $request->nama_barang,
            'jenis' => $request->jenis,
            'stok' => intval($request->stok),
            'status' => $request->status,
            'foto_qr' => $foto_qr
        ]);

        if ($response->successful()) {
            return redirect('/staf-admin/inventory')->with('success', 'Barang inventaris berhasil diperbarui.');
        }

        return back()->with('error', 'Gagal memperbarui barang.');
    }

    // DELETE INVENTORY ITEM
    public function deleteItem($id)
    {
        $response = Http::delete("http://127.0.0.1:5000/api/items/$id");
        if ($response->successful()) {
            return redirect('/staf-admin/inventory')->with('success', 'Barang inventaris berhasil dihapus.');
        }
        return redirect('/staf-admin/inventory')->with('error', 'Gagal menghapus barang.');
    }
}
