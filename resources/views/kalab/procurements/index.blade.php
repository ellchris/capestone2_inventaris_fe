@extends('layouts.kalab')

@section('title', 'Draf Pengadaan')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-800">
            Draf Pengadaan Barang
        </h1>
        <p class="text-slate-500 mt-1">
            Daftar draf pengadaan inventaris laboratorium dan barang habis pakai (BHP) tahunan.
        </p>
    </div>
    <a href="/kalab/procurements/create" 
       class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold shadow-sm transition">
        + Tambah Draf Baru
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-100">
    <table class="w-full">
        <thead class="bg-slate-100">
            <tr>
                <th class="text-left px-6 py-4">Tahun Anggaran</th>
                <th class="text-left px-6 py-4">Status</th>
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
                        @if($proc['status'] === 'draft')
                            <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-lg text-sm font-medium">
                                Draft (Editable)
                            </span>
                        @else
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-lg text-sm font-medium">
                                Locked (Submitted)
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-slate-600">
                        {{ date('d M Y, H:i', strtotime($proc['created_at'])) }}
                    </td>
                    <td class="px-6 py-4 text-center space-x-1">
                        <!-- VIEW DETAIL -->
                        <a href="/kalab/procurements/show/{{ $proc['id'] }}" 
                           class="bg-slate-500 hover:bg-slate-600 text-white px-3 py-2 rounded-lg text-sm transition">
                            Detail
                        </a>

                        @if($proc['status'] === 'draft')
                            <!-- EDIT DRAFT -->
                            <a href="/kalab/procurements/edit/{{ $proc['id'] }}" 
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-sm transition">
                                Edit
                            </a>

                            <!-- LOCK DRAFT FORM -->
                            <form action="/kalab/procurements/lock/{{ $proc['id'] }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin mengunci draf pengadaan ini? Setelah dikunci, data tidak dapat diubah lagi.');">
                                @csrf
                                <button type="submit" 
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm transition">
                                    Lock Draf
                                </button>
                            </form>

                            <!-- DELETE DRAFT FORM -->
                            <form action="/kalab/procurements/delete/{{ $proc['id'] }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus draf pengadaan ini? Semua barang terkait draf ini juga akan terhapus.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-605 bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm transition">
                                    Hapus
                                </button>
                            </form>
                        @else
                            <button disabled 
                                    class="bg-slate-200 text-slate-400 px-3 py-2 rounded-lg text-sm cursor-not-allowed">
                                Locked
                            </button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-12 text-slate-500">
                        Tidak ada draf pengadaan barang. Klik <strong>"Tambah Draf Baru"</strong> untuk memulai.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
