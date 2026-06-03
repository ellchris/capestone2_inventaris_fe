@extends('layouts.kalab')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Header Hero Section -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-cyan-900 to-indigo-900 p-8 shadow-xl">
        <div class="absolute right-0 top-0 opacity-10 translate-x-12 -translate-y-12">
            <span class="text-[10rem]">🛡️</span>
        </div>
        <div class="relative z-10 max-w-2xl">
            <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                Selamat Datang, {{ session('user')['nama'] }}!
            </h1>
            <p class="mt-2 text-lg text-cyan-200">
                Gunakan panel ini untuk mengelola draf pengadaan barang tahunan laboratorium. Lakukan digitalisasi aset laboratorium dan BHP dengan mudah.
            </p>
        </div>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Total Drafts -->
        <div class="relative overflow-hidden rounded-2xl bg-slate-950 border border-slate-800 p-6 flex items-center justify-between shadow-md transition duration-300 hover:border-cyan-800/50 hover:shadow-cyan-950/10">
            <div class="space-y-2">
                <span class="text-sm font-semibold uppercase tracking-wider text-slate-400">Total Pengadaan</span>
                <h3 class="text-4xl font-bold text-white">{{ $totalDrafts }}</h3>
                <p class="text-xs text-slate-400">Semua draf tahunan yang dibuat</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-cyan-950/50 border border-cyan-800 flex items-center justify-center text-2xl">
                📋
            </div>
        </div>

        <!-- Card 2: Active Drafts (draft) -->
        <div class="relative overflow-hidden rounded-2xl bg-slate-950 border border-slate-800 p-6 flex items-center justify-between shadow-md transition duration-300 hover:border-amber-800/50 hover:shadow-amber-950/10">
            <div class="space-y-2">
                <span class="text-sm font-semibold uppercase tracking-wider text-slate-400">Draf Aktif (Editable)</span>
                <h3 class="text-4xl font-bold text-amber-400">{{ $activeDrafts }}</h3>
                <p class="text-xs text-slate-400">Masih dapat diedit & diperbarui</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-950/50 border border-amber-800 flex items-center justify-center text-2xl">
                ✍️
            </div>
        </div>

        <!-- Card 3: Locked Drafts -->
        <div class="relative overflow-hidden rounded-2xl bg-slate-950 border border-slate-800 p-6 flex items-center justify-between shadow-md transition duration-300 hover:border-emerald-800/50 hover:shadow-emerald-950/10">
            <div class="space-y-2">
                <span class="text-sm font-semibold uppercase tracking-wider text-slate-400">Draf Terkunci (Locked)</span>
                <h3 class="text-4xl font-bold text-emerald-400">{{ $lockedDrafts }}</h3>
                <p class="text-xs text-slate-400">Sudah diajukan & tidak dapat diganti</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-950/50 border border-emerald-800 flex items-center justify-center text-2xl">
                🔒
            </div>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="rounded-2xl bg-slate-950 border border-slate-800 p-6 space-y-4">
        <h3 class="text-lg font-semibold text-slate-200">Tindakan Cepat</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <a href="/kalab/procurements/create" 
               class="flex items-center justify-between p-4 rounded-xl bg-gradient-to-r from-cyan-950 to-slate-900 border border-cyan-800/30 hover:border-cyan-500/50 transition duration-200">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">➕</span>
                    <div class="text-left">
                        <h4 class="font-medium text-slate-100">Buat Pengadaan Baru</h4>
                        <p class="text-xs text-slate-400">Buat draf tahunan aset/BHP baru</p>
                    </div>
                </div>
                <span class="text-cyan-400 text-lg">➡️</span>
            </a>

            <a href="/kalab/procurements" 
               class="flex items-center justify-between p-4 rounded-xl bg-gradient-to-r from-indigo-950 to-slate-900 border border-indigo-800/30 hover:border-indigo-500/50 transition duration-200">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">🔍</span>
                    <div class="text-left">
                        <h4 class="font-medium text-slate-100">Lihat Semua Draf</h4>
                        <p class="text-xs text-slate-400">Lihat riwayat dan status draf pengadaan</p>
                    </div>
                </div>
                <span class="text-indigo-400 text-lg">➡️</span>
            </a>
        </div>
    </div>
</div>
@endsection
