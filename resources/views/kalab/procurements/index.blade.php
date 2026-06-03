@extends('layouts.kalab')

@section('title', 'Draf Pengadaan')
@section('page_title', 'Draf Pengadaan Barang')

@section('content')
<div class="space-y-6">
    <!-- Header Page Actions -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-white">Draf Pengadaan Barang Tahunan</h1>
            <p class="text-sm text-slate-400">Daftar draf pengadaan inventaris laboratorium dan barang habis pakai (BHP).</p>
        </div>
        <a href="/kalab/procurements/create" 
           class="flex items-center gap-2 px-5 py-3 rounded-xl bg-cyan-600 hover:bg-cyan-500 text-white font-medium shadow-md shadow-cyan-950/20 transition duration-200">
            <span>➕</span> Tambah Draf Baru
        </a>
    </div>

    <!-- TABLE CARD -->
    <div class="rounded-2xl bg-slate-950 border border-slate-800 overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 border-b border-slate-800 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                        <th class="py-4 px-6">Tahun Anggaran</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6">Tanggal Pengajuan</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-850 text-slate-200">
                    @forelse($procurements as $proc)
                        <tr class="hover:bg-slate-900/50 transition">
                            <td class="py-4 px-6 font-bold text-white text-lg">
                                TA {{ $proc['tahun_anggaran'] }}
                            </td>
                            <td class="py-4 px-6">
                                @if($proc['status'] === 'draft')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-950/40 border border-amber-800/50 text-amber-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Draft (Editable)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-950/40 border border-emerald-800/50 text-emerald-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Locked (Submitted)
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-sm text-slate-400">
                                {{ date('d M Y, H:i', strtotime($proc['created_at'])) }}
                            </td>
                            <td class="py-4 px-6 text-right space-x-2">
                                <!-- VIEW DETAIL (always available) -->
                                <a href="/kalab/procurements/show/{{ $proc['id'] }}" 
                                   class="inline-flex items-center gap-1 px-3.5 py-2 rounded-lg bg-slate-900 border border-slate-800 text-slate-300 hover:text-white hover:border-slate-700 transition text-sm">
                                    <span>👁️</span> Detail
                                </a>

                                @if($proc['status'] === 'draft')
                                    <!-- EDIT DRAFT -->
                                    <a href="/kalab/procurements/edit/{{ $proc['id'] }}" 
                                       class="inline-flex items-center gap-1 px-3.5 py-2 rounded-lg bg-amber-950/10 border border-amber-900/40 text-amber-400 hover:bg-amber-950/20 hover:text-amber-300 transition text-sm">
                                        <span>✍️</span> Edit
                                    </a>

                                    <!-- LOCK DRAFT FORM -->
                                    <form action="/kalab/procurements/lock/{{ $proc['id'] }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin mengunci draf pengadaan ini? Setelah dikunci, data tidak dapat diubah lagi.');">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center gap-1 px-3.5 py-2 rounded-lg bg-emerald-950/10 border border-emerald-900/40 text-emerald-400 hover:bg-emerald-950/20 hover:text-emerald-300 transition text-sm">
                                            <span>🔒</span> Lock Draf
                                        </button>
                                    </form>
                                @else
                                    <button disabled 
                                            class="inline-flex items-center gap-1 px-3.5 py-2 rounded-lg bg-slate-950 border border-slate-900 text-slate-700 cursor-not-allowed text-sm">
                                        <span>🔒</span> Locked
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-slate-500">
                                <div class="text-4xl mb-3">📭</div>
                                Tidak ada draf pengadaan barang. Klik <strong>"Tambah Draf Baru"</strong> untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
