@extends('layouts.staf_admin')

@section('title', 'Penerimaan Barang')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">
        Penerimaan & Registrasi Barang
    </h1>
    <p class="text-slate-500 mt-1">
        Daftar draf pengadaan barang tahunan yang telah disetujui oleh Ketua Program Studi.
    </p>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-100">
    <table class="w-full">
        <thead class="bg-slate-100">
            <tr>
                <th class="text-left px-6 py-4">Tahun Anggaran</th>
                <th class="text-left px-6 py-4">Status Persetujuan</th>
                <th class="text-left px-6 py-4">Tanggal Pengajuan</th>
                <th class="text-center px-6 py-4">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($procurements as $proc)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-bold text-slate-800 text-base">
                        TA {{ $proc['tahun_anggaran'] }}
                    </td>
                    <td class="px-6 py-4">
                        @if($proc['approval_status'] === 'approved')
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-lg text-sm font-medium">
                                Disetujui (Menunggu Penerimaan)
                            </span>
                        @elseif($proc['approval_status'] === 'finalized')
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-lg text-sm font-medium">
                                Difinalisasi (Selesai)
                            </span>
                        @else
                            <span class="bg-slate-100 text-slate-800 px-3 py-1 rounded-lg text-sm font-medium">
                                {{ $proc['approval_status'] }}
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-600">
                        {{ date('d M Y, H:i', strtotime($proc['created_at'])) }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="/staf-admin/procurements/{{ $proc['id'] }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                            Detail Penerimaan
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-12 text-slate-500">
                        Belum ada draf pengadaan barang yang disetujui oleh Ketua Program Studi.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
