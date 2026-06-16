@extends('layouts.staf_admin')

@section('title', 'Detail Penerimaan Barang')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Back & Title -->
    <div class="flex items-center mb-8 gap-3">
        <a href="/staf-admin/procurements" class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2.5 rounded-lg text-sm transition">
            Kembali
        </a>
        <h1 class="text-3xl font-bold text-slate-800">Detail Penerimaan TA {{ $procurement['tahun_anggaran'] }}</h1>
    </div>

    <!-- GENERAL INFO -->
    <div class="bg-white rounded-2xl shadow-sm p-8 border border-slate-100 mb-8">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Informasi Umum Pengadaan</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
            <div>
                <span class="block text-slate-400 text-xs uppercase font-bold tracking-wider">Tahun Anggaran</span>
                <span class="text-slate-800 font-bold text-lg">TA {{ $procurement['tahun_anggaran'] }}</span>
            </div>
            <div>
                <span class="block text-slate-400 text-xs uppercase font-bold tracking-wider">Status Persetujuan</span>
                <span class="mt-1 inline-block">
                    @if($procurement['approval_status'] === 'approved')
                        <span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-lg text-xs font-semibold">
                            Disetujui (Menunggu Penerimaan)
                        </span>
                    @else
                        <span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-lg text-xs font-semibold">
                            Difinalisasi (Selesai)
                        </span>
                    @endif
                </span>
            </div>
            <div>
                <span class="block text-slate-400 text-xs uppercase font-bold tracking-wider">Tanggal Pengajuan</span>
                <span class="text-slate-700 font-semibold text-base">{{ date('d M Y, H:i', strtotime($procurement['created_at'])) }}</span>
            </div>
        </div>
    </div>

    <!-- ITEMS LIST -->
    <div class="bg-white rounded-2xl shadow-sm p-8 border border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 mb-6">Daftar Penerimaan Barang</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-700 text-xs font-bold uppercase tracking-wider">
                        <th class="py-3 px-4 rounded-l-lg">Nama Barang</th>
                        <th class="py-3 px-4 text-center">Jumlah</th>
                        <th class="py-3 px-4">Link Pembelian</th>
                        <th class="py-3 px-4 w-72">Tanggal Penerimaan</th>
                        <th class="py-3 px-4 rounded-r-lg">Registrasi Inventaris</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($procurement['items'] as $item)
                        <tr class="hover:bg-slate-50">
                            <!-- Nama Barang -->
                            <td class="py-4 px-4">
                                <div class="font-semibold text-slate-800">{{ $item['nama_barang'] }}</div>
                                @if($item['is_replacement'])
                                    <div class="text-xs text-blue-600 mt-1">
                                        🔄 Pengganti barang ID: {{ $item['replaced_item_id'] }} ({{ $item['replaced_item_name'] ?? 'Barang Lama' }})
                                    </div>
                                @endif
                            </td>

                            <!-- Jumlah -->
                            <td class="py-4 px-4 text-center text-slate-700 font-medium">
                                {{ $item['jumlah'] }} unit
                            </td>

                            <!-- Link Pembelian -->
                            <td class="py-4 px-4">
                                @if(!empty($item['link_pembelian']))
                                    <a href="{{ $item['link_pembelian'] }}" 
                                       target="_blank" 
                                       class="text-blue-600 hover:text-blue-800 underline text-sm inline-flex items-center gap-1 font-semibold">
                                        Buka Link 🔗
                                    </a>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>

                            <!-- Tanggal Penerimaan -->
                            <td class="py-4 px-4">
                                @if($item['status_item'] === 'received')
                                    <span class="text-slate-700 font-semibold bg-slate-100 px-3 py-1.5 rounded-lg text-sm">
                                        📅 {{ date('d M Y', strtotime($item['tanggal_diterima'])) }}
                                    </span>
                                @else
                                    <form action="/staf-admin/procurements/item/{{ $item['id'] }}/receive" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="date" 
                                               name="tanggal_diterima" 
                                               value="{{ date('Y-m-d') }}" 
                                               required 
                                               class="border rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:border-blue-500">
                                        <button type="submit" 
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                            Terima
                                        </button>
                                    </form>
                                @endif
                            </td>

                            <!-- Registrasi Inventaris -->
                            <td class="py-4 px-4">
                                @if($item['status_item'] !== 'received')
                                    <span class="text-slate-450 text-xs italic text-slate-500">Menunggu barang datang</span>
                                @elseif(empty($item['registered_item_id']))
                                    <a href="/staf-admin/items/register/{{ $item['id'] }}?procurement_id={{ $procurement['id'] }}" 
                                       class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-xs font-semibold transition">
                                        Daftarkan Barang
                                    </a>
                                @else
                                    <div class="flex flex-col gap-1 items-start">
                                        <span class="text-green-700 text-xs font-bold bg-green-50 px-2 py-1 rounded border border-green-200">
                                            ✓ Terdaftar (ID: {{ $item['registered_item_id'] }})
                                        </span>
                                        <a href="/staf-admin/items/edit/{{ $item['registered_item_id'] }}" 
                                           class="text-blue-600 hover:text-blue-800 text-xs underline font-semibold">
                                            Edit Inventaris
                                        </a>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-500">
                                Tidak ada item dalam pengadaan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
