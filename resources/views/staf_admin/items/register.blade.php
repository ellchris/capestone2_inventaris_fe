@extends('layouts.staf_admin')

@section('title', 'Registrasi Barang Inventaris')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Back & Title -->
    <div class="flex items-center mb-8 gap-3">
        <a href="/staf-admin/procurements/{{ $procurementId }}" class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2.5 rounded-lg text-sm transition">
            Kembali
        </a>
        <h1 class="text-3xl font-bold text-slate-800">Registrasi Inventaris Baru</h1>
    </div>

    <!-- FORM CARD -->
    <div class="bg-white rounded-2xl shadow-sm p-8 border border-slate-100">
        <form action="/staf-admin/items/store-registered" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Hidden Inputs -->
            <input type="hidden" name="procurement_item_id" value="{{ $procurementItem['id'] }}">
            <input type="hidden" name="procurement_id" value="{{ $procurementId }}">
            <input type="hidden" name="nama_barang" value="{{ $procurementItem['nama_barang'] }}">
            <input type="hidden" name="stok" value="{{ $procurementItem['jumlah'] }}">
            @if($procurementItem['is_replacement'])
                <input type="hidden" name="replaced_item_id" value="{{ $procurementItem['replaced_item_id'] }}">
            @endif

            <!-- Item Name (Read Only) -->
            <div class="mb-4">
                <label class="block font-semibold mb-2 text-slate-700">Nama Barang</label>
                <input type="text" 
                       value="{{ $procurementItem['nama_barang'] }}" 
                       disabled 
                       class="w-full border rounded-lg p-3 bg-slate-50 text-slate-500 cursor-not-allowed">
            </div>

            <!-- Stok / Jumlah (Read Only) -->
            <div class="mb-4">
                <label class="block font-semibold mb-2 text-slate-700">Jumlah / Stok Awal</label>
                <input type="text" 
                       value="{{ $procurementItem['jumlah'] }} unit" 
                       disabled 
                       class="w-full border rounded-lg p-3 bg-slate-50 text-slate-500 cursor-not-allowed">
            </div>

            <!-- Replacement Warning Info -->
            @if($procurementItem['is_replacement'])
                <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-lg text-sm">
                    <p class="font-bold">🔄 Informasi Pergantian Barang:</p>
                    <p class="mt-1">
                        Barang ini ditandai untuk menggantikan barang lama: <strong>{{ $procurementItem['replaced_item_name'] ?? 'Barang Lama ID ' . $procurementItem['replaced_item_id'] }}</strong>.
                        Ketika form ini disimpan, status barang lama di inventaris akan otomatis diubah menjadi <strong>"Rusak"</strong>.
                    </p>
                </div>
            @endif

            <!-- Room ID (Select) -->
            <div class="mb-4">
                <label for="room_id" class="block font-semibold mb-2 text-slate-700">Lokasi Ruangan <span class="text-red-500">*</span></label>
                <select name="room_id" id="room_id" required class="w-full border rounded-lg p-3 focus:outline-none focus:border-blue-500">
                    <option value="">-- Pilih Ruangan --</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room['id'] }}">{{ $room['nama_ruangan'] }} ({{ $room['lokasi'] }})</option>
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
                       placeholder="Contoh: QR-COMP-001"
                       class="w-full border rounded-lg p-3 focus:outline-none focus:border-blue-500">
            </div>

            <!-- Jenis (Select) -->
            <div class="mb-4">
                <label for="jenis" class="block font-semibold mb-2 text-slate-700">Jenis Barang <span class="text-red-500">*</span></label>
                <select name="jenis" id="jenis" required class="w-full border rounded-lg p-3 focus:outline-none focus:border-blue-500">
                    <option value="inventaris" {{ !$procurementItem['is_replacement'] ? 'selected' : '' }}>Inventaris (Aset)</option>
                    <option value="habis_pakai">Barang Habis Pakai (BHP)</option>
                </select>
            </div>

            <!-- Status (Select) -->
            <div class="mb-4">
                <label for="status" class="block font-semibold mb-2 text-slate-700">Status Kondisi Awal <span class="text-red-500">*</span></label>
                <select name="status" id="status" required class="w-full border rounded-lg p-3 focus:outline-none focus:border-blue-500">
                    <option value="baik">Baik</option>
                    <option value="rusak">Rusak</option>
                </select>
            </div>

            <!-- Foto QR / Barcode (File Upload) -->
            <div class="mb-6">
                <label for="foto_qr" class="block font-semibold mb-2 text-slate-700">Foto QR Code / Barcode</label>
                <input type="file" 
                       name="foto_qr" 
                       id="foto_qr" 
                       accept="image/*"
                       class="w-full border rounded-lg p-2.5 text-slate-700 focus:outline-none focus:border-blue-500">
                <p class="text-xs text-slate-400 mt-1">Format: JPEG, PNG, JPG, GIF (Maks. 2MB)</p>
            </div>

            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold p-3.5 rounded-xl shadow-sm transition">
                Daftarkan Barang ke Inventaris
            </button>
        </form>
    </div>
</div>
@endsection
