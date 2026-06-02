@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')

<div class="flex justify-between items-center mb-8">

    <div>
        <h1 class="text-3xl font-bold text-slate-800">
            Kelola Pengguna
        </h1>

        <p class="text-slate-500 mt-1">
            Daftar seluruh pengguna sistem inventaris laboratorium.
        </p>
    </div>

    <a
    href="/admin/users/create"
    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold">

        + Tambah Pengguna

    </a>

</div>

<div class="bg-white rounded-2xl shadow-sm overflow-hidden">

    <table class="w-full">

        <thead class="bg-slate-100">

            <tr>
                <th class="text-left px-6 py-4">ID</th>
                <th class="text-left px-6 py-4">Nama</th>
                <th class="text-left px-6 py-4">Email</th>
                <th class="text-left px-6 py-4">Role</th>
                <th class="text-center px-6 py-4">Aksi</th>
            </tr>

        </thead>

        <tbody>

            @forelse($users as $user)

            <tr class="border-t hover:bg-slate-50">

                <td class="px-6 py-4">
                    {{ $user['id'] }}
                </td>

                <td class="px-6 py-4 font-medium">
                    {{ $user['nama'] }}
                </td>

                <td class="px-6 py-4 text-slate-600">
                    {{ $user['email'] }}
                </td>

                <td class="px-6 py-4">

                    <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-lg text-sm">
                        {{ $user['role'] }}
                    </span>

                </td>

                <td class="px-6 py-4 text-center">

                    <a
                    href="/admin/users/edit/{{ $user['id'] }}"
                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg mr-2">

                        Edit

                    </a>

                    <form
                        action="/admin/users/delete/{{ $user['id'] }}"
                        method="POST"
                        class="inline">

                        @csrf
                        @method('DELETE')

                        <button
                            onclick="return confirm('Yakin hapus pengguna ini?')"
                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg">

                            Hapus

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="5" class="text-center py-10 text-slate-500">
                    Belum ada data pengguna
                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection