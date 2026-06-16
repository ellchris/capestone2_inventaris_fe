@extends('layouts.staf_admin')

@section('title', 'Kelola Inventaris')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-bold text-slate-800">
            Kelola Inventaris
        </h1>
        <p class="text-slate-500 mt-1">
            Daftar seluruh barang inventaris laboratorium dan barang habis pakai (BHP).
        </p>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-100">
    <table class="w-full">
        <thead class="bg-slate-100">
            <tr>
                <th class="text-left px-6 py-4">ID</th>
                <th class="text-left px-6 py-4">Foto QR/Barcode</th>
                <th class="text-left px-6 py-4">Kode / QR Label</th>
                <th class="text-left px-6 py-4">Nama Barang</th>
                <th class="text-left px-6 py-4">Ruangan</th>
                <th class="text-left px-6 py-4">Jenis</th>
                <th class="text-left px-6 py-4">Stok</th>
                <th class="text-left px-6 py-4">Kondisi</th>
                <th class="text-center px-6 py-4">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($items as $item)
                <tr class="hover:bg-slate-50">
                    <!-- ID -->
                    <td class="px-6 py-4 text-slate-700">
                        {{ $item['id'] }}
                    </td>

                    <!-- Foto QR/Barcode -->
                    <td class="px-6 py-4">
                        @if(!empty($item['foto_qr']))
                            <img src="{{ asset($item['foto_qr']) }}" 
                                 alt="QR/Barcode" 
                                 class="w-12 h-12 rounded object-cover border border-slate-200 cursor-pointer hover:scale-150 transition duration-150">
                        @else
                            <span class="text-slate-400 italic text-xs">No Photo</span>
                        @endif
                    </td>

                    <!-- Kode / QR Code -->
                    <td class="px-6 py-4 font-mono text-sm text-slate-800">
                        {{ $item['uuid_qr'] }}
                    </td>

                    <!-- Nama Barang -->
                    <td class="px-6 py-4 font-semibold text-slate-800">
                        {{ $item['nama_barang'] }}
                    </td>

                    <!-- Ruangan -->
                    <td class="px-6 py-4 text-slate-600">
                        {{ $rooms[$item['room_id']] ?? 'Unknown Room (ID: ' . $item['room_id'] . ')' }}
                    </td>

                    <!-- Jenis -->
                    <td class="px-6 py-4 text-slate-600">
                        @if($item['jenis'] === 'inventaris')
                            <span class="bg-blue-50 text-blue-700 px-2.5 py-1 rounded-lg text-xs font-semibold uppercase">
                                Inventaris
                            </span>
                        @else
                            <span class="bg-purple-50 text-purple-700 px-2.5 py-1 rounded-lg text-xs font-semibold uppercase">
                                BHP
                            </span>
                        @endif
                    </td>

                    <!-- Stok -->
                    <td class="px-6 py-4 text-slate-700">
                        {{ $item['stok'] !== null ? $item['stok'] : '-' }}
                    </td>

                    <!-- Status Kondisi -->
                    <td class="px-6 py-4">
                        @if(strtolower($item['status']) === 'baik')
                            <span class="bg-green-100 text-green-800 px-2.5 py-1 rounded-lg text-xs font-semibold uppercase">
                                Baik
                            </span>
                        @elseif(strtolower($item['status']) === 'rusak')
                            <span class="bg-red-100 text-red-800 px-2.5 py-1 rounded-lg text-xs font-semibold uppercase">
                                Rusak
                            </span>
                        @else
                            <span class="bg-slate-100 text-slate-800 px-2.5 py-1 rounded-lg text-xs font-semibold uppercase">
                                {{ $item['status'] }}
                            </span>
                        @endif
                    </td>

                    <!-- Aksi -->
                    <td class="px-6 py-4 text-center">
                        <a href="/staf-admin/items/edit/{{ $item['id'] }}" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-sm mr-2 transition">
                            Edit
                        </a>

                        <form action="/staf-admin/items/delete/{{ $item['id'] }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini dari inventaris?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm transition">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center py-12 text-slate-500">
                        Belum ada barang di inventaris.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
