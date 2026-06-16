@extends('layouts.kalab')

@section('title', 'Detail Pengadaan')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Back & Title & Action -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-3">
            <a href="/kalab/procurements" class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2.5 rounded-lg text-sm transition">
                Kembali
            </a>
            <h1 class="text-3xl font-bold text-slate-800">Detail Pengadaan TA {{ $procurement['tahun_anggaran'] }}</h1>
        </div>

        <div class="flex gap-2">
            @if($procurement['status'] === 'draft')
                <!-- Edit button -->
                <a href="/kalab/procurements/edit/{{ $procurement['id'] }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition">
                    Edit Draf
                </a>
                
                <!-- Lock button -->
                <form action="/kalab/procurements/lock/{{ $procurement['id'] }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengunci draf pengadaan ini? Setelah dikunci, data tidak dapat diubah lagi.');">
                    @csrf
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition">
                        Kunci & Ajukan Draf
                    </button>
                </form>
            @else
                <span class="bg-emerald-100 text-emerald-800 px-4 py-2.5 rounded-lg text-sm font-semibold">
                    🔒 Draf Terkunci (Locked)
                </span>
            @endif
        </div>
    </div>

    <!-- GENERAL INFO -->
    <div class="bg-white rounded-2xl shadow-sm p-8 border border-slate-100 mb-8">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Informasi Umum</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
            <div>
                <span class="block text-slate-400 text-xs uppercase font-bold tracking-wider">Tahun Anggaran</span>
                <span class="text-slate-800 font-bold text-lg">TA {{ $procurement['tahun_anggaran'] }}</span>
            </div>
            <div>
                <span class="block text-slate-400 text-xs uppercase font-bold tracking-wider">Status Draf</span>
                <span class="mt-1 inline-block">
                    @if($procurement['status'] === 'draft')
                        <span class="bg-amber-100 text-amber-800 px-2.5 py-0.5 rounded-lg text-xs font-semibold">
                            Draft (Editable)
                        </span>
                    @else
                        <span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-lg text-xs font-semibold">
                            Locked (Submitted)
                        </span>
                    @endif
                </span>
            </div>
            <div>
                <span class="block text-slate-400 text-xs uppercase font-bold tracking-wider">Tanggal Dibuat</span>
                <span class="text-slate-700 font-semibold text-base">{{ date('d M Y, H:i', strtotime($procurement['created_at'])) }}</span>
            </div>
        </div>
    </div>

    <!-- ITEMS LIST -->
    <div class="bg-white rounded-2xl shadow-sm p-8 border border-slate-100">
        <h3 class="text-lg font-bold text-slate-800 mb-6">Daftar Barang</h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-100 text-slate-700 text-xs font-bold uppercase tracking-wider">
                        <th class="py-3 px-4 rounded-l-lg">Nama Barang</th>
                        <th class="py-3 px-4 text-right">Harga Satuan (Rp)</th>
                        <th class="py-3 px-4 text-center">Jumlah</th>
                        <th class="py-3 px-4 text-right">Total Harga (Rp)</th>
                        <th class="py-3 px-4">Link Pembelian</th>
                        <th class="py-3 px-4 rounded-r-lg">Keterangan Penggantian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php $grandTotal = 0; @endphp
                    @forelse($procurement['items'] as $item)
                        @php 
                            $totalItemPrice = $item['harga'] * $item['jumlah'];
                            $grandTotal += $totalItemPrice;
                        @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="py-4 px-4 font-semibold text-slate-800">{{ $item['nama_barang'] }}</td>
                            <td class="py-4 px-4 text-right text-slate-600">
                                {{ number_format($item['harga'], 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-4 text-center text-slate-650">{{ $item['jumlah'] }}</td>
                            <td class="py-4 px-4 text-right text-slate-800 font-semibold">
                                {{ number_format($totalItemPrice, 0, ',', '.') }}
                            </td>
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
                            <td class="py-4 px-4">
                                @if($item['is_replacement'])
                                    <span class="bg-blue-50 text-blue-700 px-2.5 py-1 rounded text-xs border border-blue-150 font-semibold">
                                        🔄 Ganti: {{ $item['replaced_item_name'] ?? 'Barang Lama' }}
                                    </span>
                                @else
                                    <span class="text-slate-400 text-xs">Barang Baru</span>
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
                        <tr class="font-bold bg-slate-50 text-slate-800">
                            <td colspan="3" class="py-4 px-4 text-right text-slate-500 rounded-l-lg">Total Estimasi Anggaran:</td>
                            <td class="py-4 px-4 text-right text-blue-600 text-lg">
                                Rp {{ number_format($grandTotal, 0, ',', '.') }}
                            </td>
                            <td colspan="2" class="rounded-r-lg"></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
