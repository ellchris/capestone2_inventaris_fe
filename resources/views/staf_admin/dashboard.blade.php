@extends('layouts.staf_admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">
        Dashboard Staf Administrasi
    </h1>
    <p class="text-slate-500 mt-2">
        Selamat datang kembali! Gunakan panel ini untuk mengelola penerimaan barang pengadaan yang disetujui Kaprodi dan melakukan registrasi serta pembaruan barang inventaris.
    </p>
</div>

<!-- STATS CARDS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Draf Disetujui -->
    <div class="bg-white rounded-2xl shadow-sm p-8 border border-slate-100">
        <h3 class="text-slate-500 text-sm font-semibold uppercase tracking-wider">
            Pengadaan Disetujui
        </h3>
        <h1 class="text-5xl font-bold text-blue-600 mt-4">
            {{ $totalApproved }}
        </h1>
        <p class="text-xs text-slate-400 mt-2">Menunggu kedatangan & registrasi barang</p>
    </div>

    <!-- Draf Difinalisasi -->
    <div class="bg-white rounded-2xl shadow-sm p-8 border border-slate-100">
        <h3 class="text-slate-500 text-sm font-semibold uppercase tracking-wider">
            Pengadaan Difinalisasi
        </h3>
        <h1 class="text-5xl font-bold text-green-600 mt-4">
            {{ $totalFinalized }}
        </h1>
        <p class="text-xs text-slate-400 mt-2">Pengadaan yang sudah diselesaikan</p>
    </div>

    <!-- Total Barang -->
    <div class="bg-white rounded-2xl shadow-sm p-8 border border-slate-100">
        <h3 class="text-slate-500 text-sm font-semibold uppercase tracking-wider">
            Total Aset / Inventaris
        </h3>
        <h1 class="text-5xl font-bold text-slate-800 mt-4">
            {{ $totalItems }}
        </h1>
        <p class="text-xs text-slate-400 mt-2">Seluruh barang terdaftar di laboratorium</p>
    </div>
</div>

<!-- QUICK ACTIONS -->
<div class="bg-white rounded-2xl shadow-sm p-8 border border-slate-100">
    <h3 class="text-xl font-semibold mb-6 text-slate-800">
        Tindakan Cepat
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="/staf-admin/procurements" 
           class="flex items-center justify-between p-5 rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-300 transition group">
            <div class="flex items-center gap-4">
                <span class="text-3xl">📦</span>
                <div class="text-left">
                    <h4 class="font-bold text-slate-800 group-hover:text-blue-600 transition">Penerimaan & Registrasi Barang</h4>
                    <p class="text-xs text-slate-500 mt-1">Input tanggal datang barang disetujui dan daftarkan ke inventaris</p>
                </div>
            </div>
            <span class="text-slate-400 group-hover:text-slate-600 transition text-lg">➔</span>
        </a>

        <a href="/staf-admin/inventory" 
           class="flex items-center justify-between p-5 rounded-xl border border-slate-200 hover:bg-slate-50 hover:border-slate-300 transition group">
            <div class="flex items-center gap-4">
                <span class="text-3xl">🏷️</span>
                <div class="text-left">
                    <h4 class="font-bold text-slate-800 group-hover:text-blue-600 transition">Kelola Inventaris</h4>
                    <p class="text-xs text-slate-500 mt-1">Update label QR, upload foto, atau edit data barang</p>
                </div>
            </div>
            <span class="text-slate-400 group-hover:text-slate-600 transition text-lg">➔</span>
        </a>
    </div>
</div>
@endsection
