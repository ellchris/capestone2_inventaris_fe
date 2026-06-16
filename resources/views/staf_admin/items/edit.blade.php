@extends('layouts.staf_admin')

@section('title', 'Edit Barang Inventaris')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Back & Title -->
    <div class="flex items-center mb-8 gap-3">
        <a href="/staf-admin/inventory" class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2.5 rounded-lg text-sm transition">
            Kembali
        </a>
        <h1 class="text-3xl font-bold text-slate-800">Edit Barang Inventaris</h1>
    </div>

    <!-- FORM CARD -->
    <div class="bg-white rounded-2xl shadow-sm p-8 border border-slate-100">
        <form action="/staf-admin/items/update/{{ $item['id'] }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Hidden Input for Existing Photo -->
            <input type="hidden" name="existing_foto_qr" value="{{ $item['foto_qr'] }}">

            <!-- Item Name -->
            <div class="mb-4">
                <label for="nama_barang" class="block font-semibold mb-2 text-slate-700">Nama Barang <span class="text-red-500">*</span></label>
                <input type="text" 
                       name="nama_barang"
                       id="nama_barang"
                       value="{{ $item['nama_barang'] }}" 
                       required
                       class="w-full border rounded-lg p-3 focus:outline-none focus:border-blue-500">
            </div>

            <!-- Stok / Jumlah -->
            <div class="mb-4">
                <label for="stok" class="block font-semibold mb-2 text-slate-700">Stok Barang <span class="text-red-500">*</span></label>
                <input type="number" 
                       name="stok"
                       id="stok"
                       value="{{ $item['stok'] }}" 
                       required
                       min="0"
                       class="w-full border rounded-lg p-3 focus:outline-none focus:border-blue-500">
            </div>

            <!-- Room ID (Select) -->
            <div class="mb-4">
                <label for="room_id" class="block font-semibold mb-2 text-slate-700">Lokasi Ruangan <span class="text-red-500">*</span></label>
                <select name="room_id" id="room_id" required class="w-full border rounded-lg p-3 focus:outline-none focus:border-blue-500">
                    <option value="">-- Pilih Ruangan --</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room['id'] }}" {{ $item['room_id'] == $room['id'] ? 'selected' : '' }}>
                            {{ $room['nama_ruangan'] }} ({{ $room['lokasi'] }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- QR / Label (Text) -->
            <div class="mb-4">
                <label for="uuid_qr" class="block font-semibold mb-2 text-slate-700">Nomor Label / QR Code <span class="text-red-500">*</span></label>
                <input type="text" 
                       name="uuid_qr" 
                       id="uuid_qr" 
                       required 
                       value="{{ $item['uuid_qr'] }}"
                       class="w-full border rounded-lg p-3 focus:outline-none focus:border-blue-500">
            </div>

            <!-- Jenis (Select) -->
            <div class="mb-4">
                <label for="jenis" class="block font-semibold mb-2 text-slate-700">Jenis Barang <span class="text-red-500">*</span></label>
                <select name="jenis" id="jenis" required class="w-full border rounded-lg p-3 focus:outline-none focus:border-blue-500">
                    <option value="inventaris" {{ $item['jenis'] === 'inventaris' ? 'selected' : '' }}>Inventaris (Aset)</option>
                    <option value="habis_pakai" {{ $item['jenis'] === 'habis_pakai' ? 'selected' : '' }}>Barang Habis Pakai (BHP)</option>
                </select>
            </div>

            <!-- Status (Select) -->
            <div class="mb-4">
                <label for="status" class="block font-semibold mb-2 text-slate-700">Status Kondisi <span class="text-red-500">*</span></label>
                <select name="status" id="status" required class="w-full border rounded-lg p-3 focus:outline-none focus:border-blue-500">
                    <option value="baik" {{ strtolower($item['status']) === 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="rusak" {{ strtolower($item['status']) === 'rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>

            <!-- Current Foto QR View -->
            @if(!empty($item['foto_qr']))
                <div class="mb-4">
                    <label class="block font-semibold mb-2 text-slate-700">Foto QR Code Saat Ini</label>
                    <img src="{{ asset($item['foto_qr']) }}" 
                         alt="QR Code" 
                         class="w-32 h-32 rounded object-cover border border-slate-200">
                </div>
            @endif

            <!-- Foto QR / Barcode (File Upload) -->
            <div class="mb-6">
                <label for="foto_qr" class="block font-semibold mb-2 text-slate-700">Upload Foto QR Baru (Opsional)</label>
                <input type="file" 
                       name="foto_qr" 
                       id="foto_qr" 
                       accept="image/*"
                       class="w-full border rounded-lg p-2.5 text-slate-700 focus:outline-none focus:border-blue-500">
                <p class="text-xs text-slate-400 mt-1">Format: JPEG, PNG, JPG, GIF (Maks. 2MB). Kosongkan jika tidak ingin mengganti.</p>
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold p-3.5 rounded-xl shadow-sm transition">
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>
@endsection
