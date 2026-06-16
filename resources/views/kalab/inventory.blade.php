@extends('layouts.kalab')

@section('title', 'Daftar Inventaris')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-slate-800">
        Daftar Inventaris Laboratorium
    </h1>
    <p class="text-slate-500 mt-1">
        Daftar aset dan barang inventaris (non-consumable) yang terdaftar di sistem laboratorium.
    </p>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-100">
    <table class="w-full">
        <thead class="bg-slate-100">
            <tr>
                <th class="text-left px-6 py-4">ID</th>
                <th class="text-left px-6 py-4">Kode / QR Code</th>
                <th class="text-left px-6 py-4">Nama Barang</th>
                <th class="text-left px-6 py-4">Stok</th>
                <th class="text-left px-6 py-4">Status Kondisi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($items as $item)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 text-slate-700">
                        {{ $item['id'] }}
                    </td>
                    <td class="px-6 py-4 text-slate-600 font-mono text-sm">
                        {{ $item['uuid_qr'] ?? '-' }}
                    </td>
                    <td class="px-6 py-4 font-semibold text-slate-800">
                        {{ $item['nama_barang'] }}
                    </td>
                    <td class="px-6 py-4 text-slate-600">
                        {{ $item['stok'] !== null ? $item['stok'] : '-' }}
                    </td>
                    <td class="px-6 py-4">
                        @if(strtolower($item['status']) === 'baik')
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-lg text-xs font-semibold uppercase">
                                Baik
                            </span>
                        @elseif(strtolower($item['status']) === 'rusak')
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-lg text-xs font-semibold uppercase">
                                Rusak
                            </span>
                        @else
                            <span class="bg-slate-100 text-slate-800 px-3 py-1 rounded-lg text-xs font-semibold uppercase">
                                {{ $item['status'] }}
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-12 text-slate-500">
                        Belum ada data inventaris.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
