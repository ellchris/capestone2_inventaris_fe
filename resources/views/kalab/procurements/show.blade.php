@extends('layouts.kalab')

@section('title', 'Detail Pengadaan')
@section('page_title', 'Detail Pengadaan Barang')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Back & Title & Action (Lock if Draft) -->
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-3">
            <a href="/kalab/procurements" class="px-4 py-2.5 rounded-lg bg-slate-800 text-slate-300 hover:text-white transition text-sm">
                ⬅️ Kembali
            </a>
            <h1 class="text-2xl font-bold text-white">Detail Pengadaan TA {{ $procurement['tahun_anggaran'] }}</h1>
        </div>

        <div class="flex gap-2">
            @if($procurement['status'] === 'draft')
                <!-- Edit button -->
                <a href="/kalab/procurements/edit/{{ $procurement['id'] }}" 
                   class="px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-cyan-500 text-white font-medium shadow-md transition duration-200 text-sm">
                    ✍️ Edit Draf
                </a>
                
                <!-- Lock button -->
                <form action="/kalab/procurements/lock/{{ $procurement['id'] }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengunci draf pengadaan ini? Setelah dikunci, data tidak dapat diubah lagi.');">
                    @csrf
                    <button type="submit" 
                            class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-medium shadow-md transition duration-200 text-sm">
                        🔒 Kunci & Ajukan Draf
                    </button>
                </form>
            @else
                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold bg-emerald-950/40 border border-emerald-800/50 text-emerald-400">
                    🔒 Draf Terkunci (Locked)
                </span>
            @endif
        </div>
    </div>

    <!-- GENERAL INFO -->
    <div class="rounded-2xl bg-slate-950 border border-slate-800 p-6 space-y-4">
        <h3 class="text-lg font-semibold text-cyan-400">Informasi Umum</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
            <div>
                <span class="block text-slate-400 text-xs uppercase tracking-wider">Tahun Anggaran</span>
                <span class="text-white font-bold text-lg">TA {{ $procurement['tahun_anggaran'] }}</span>
            </div>
            <div>
                <span class="block text-slate-400 text-xs uppercase tracking-wider">Status Draf</span>
                <span class="mt-1 inline-block">
                    @if($procurement['status'] === 'draft')
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-950/40 border border-amber-800/50 text-amber-400">
                            Draft (Editable)
                        </span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-950/40 border border-emerald-800/50 text-emerald-400">
                            Locked (Submitted)
                        </span>
                    @endif
                </span>
            </div>
            <div>
                <span class="block text-slate-400 text-xs uppercase tracking-wider">Tanggal Dibuat</span>
                <span class="text-slate-200 font-medium text-base">{{ date('d M Y, H:i', strtotime($procurement['created_at'])) }}</span>
            </div>
        </div>
    </div>

    <!-- ITEMS LIST -->
    <div class="rounded-2xl bg-slate-950 border border-slate-800 p-6 space-y-4">
        <h3 class="text-lg font-semibold text-cyan-400">Daftar Barang</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-800 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                        <th class="pb-3 px-2">Nama Barang</th>
                        <th class="pb-3 px-2 text-right">Harga Satuan (Rp)</th>
                        <th class="pb-3 px-2 text-center">Jumlah</th>
                        <th class="pb-3 px-2 text-right">Total Harga (Rp)</th>
                        <th class="pb-3 px-2">Link Pembelian</th>
                        <th class="pb-3 px-2">Keterangan Penggantian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-850 text-slate-200">
                    @php $grandTotal = 0; @endphp
                    @forelse($procurement['items'] as $item)
                        @php 
                            $totalItemPrice = $item['harga'] * $item['jumlah'];
                            $grandTotal += $totalItemPrice;
                        @endphp
                        <tr class="hover:bg-slate-900/30">
                            <td class="py-4 px-2 font-medium text-white">{{ $item['nama_barang'] }}</td>
                            <td class="py-4 px-2 text-right text-slate-300">
                                {{ number_format($item['harga'], 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-2 text-center">{{ $item['jumlah'] }}</td>
                            <td class="py-4 px-2 text-right text-white font-semibold">
                                {{ number_format($totalItemPrice, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-2">
                                @if(!empty($item['link_pembelian']))
                                    <a href="{{ $item['link_pembelian'] }}" 
                                       target="_blank" 
                                       class="text-cyan-400 hover:text-cyan-300 underline text-sm inline-flex items-center gap-1">
                                        Buka Link 🔗
                                    </a>
                                @else
                                    <span class="text-slate-600">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-2">
                                @if($item['is_replacement'])
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs bg-cyan-950 text-cyan-300 border border-cyan-800">
                                        🔄 Ganti: {{ $item['replaced_item_name'] ?? 'Barang Lama' }}
                                    </span>
                                @else
                                    <span class="text-slate-500 text-xs">Barang Baru (Bukan Pengganti)</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-500">
                                Tidak ada item dalam pengadaan ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if(count($procurement['items']) > 0)
                    <tfoot>
                        <tr class="border-t border-slate-800 font-bold bg-slate-900/20 text-white">
                            <td colspan="3" class="py-4 px-2 text-right text-slate-400">Total Estimasi Anggaran:</td>
                            <td class="py-4 px-2 text-right text-cyan-400 text-lg">
                                Rp {{ number_format($grandTotal, 0, ',', '.') }}
                            </td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
