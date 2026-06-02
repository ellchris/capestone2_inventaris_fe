@extends('layouts.admin')

@section('title', 'Kelola Ruangan')

@section('content')

<div class="flex justify-between items-center mb-8">

    <div>
        <h1 class="text-3xl font-bold text-slate-800">
            Kelola Ruangan
        </h1>

        <p class="text-slate-500 mt-1">
            Daftar seluruh ruangan laboratorium.
        </p>
    </div>

    <a href="/admin/rooms/create"
       class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold">
        + Tambah Ruangan
    </a>

</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">

    <table class="w-full">

        <thead class="bg-slate-100">

            <tr>

                <th class="text-left px-6 py-4">
                    ID
                </th>

                <th class="text-left px-6 py-4">
                    Nama Ruangan
                </th>

                <th class="text-left px-6 py-4">
                    Lokasi
                </th>

                <th class="text-center px-6 py-4">
                    Aksi
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($rooms as $room)

            <tr class="border-t">

                <td class="px-6 py-4">
                    {{ $room['id'] }}
                </td>

                <td class="px-6 py-4">
                    {{ $room['nama_ruangan'] }}
                </td>

                <td class="px-6 py-4">
                    {{ $room['lokasi'] }}
                </td>

                <td class="px-6 py-4 text-center">

                    <a
                    href="/admin/rooms/edit/{{ $room['id'] }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg mr-2">

                        Edit

                    </a>

                    <form
                    action="/admin/rooms/delete/{{ $room['id'] }}"
                    method="POST"
                    class="inline">

                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Yakin hapus ruangan ini?')"
                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg">

                            Hapus

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>
                <td colspan="4" class="text-center py-8 text-slate-500">
                    Belum ada data ruangan
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection