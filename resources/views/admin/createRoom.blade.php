@extends('layouts.admin')

@section('title', 'Tambah Ruangan')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-6 mb-8">

    <h1 class="text-3xl font-bold text-slate-800">
        Tambah Ruangan
    </h1>

    <p class="text-slate-500 mt-2">
        Tambahkan data ruangan laboratorium baru.
    </p>

</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-2xl shadow-sm p-8 max-w-3xl">

    <form action="/admin/rooms/store" method="POST">

        @csrf

        <div class="mb-6">

            <label class="block text-slate-700 font-medium mb-2">
                Nama Ruangan
            </label>

            <input
                type="text"
                name="nama_ruangan"
                placeholder="Contoh: Lab Komputer 1"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >

        </div>

        <div class="mb-8">

            <label class="block text-slate-700 font-medium mb-2">
                Lokasi / Gedung
            </label>

            <input
                type="text"
                name="lokasi"
                placeholder="Contoh: Gedung H Lantai 2"
                class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                required
            >

        </div>

        <div class="flex gap-3">

            <button
                type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold">
                Simpan Ruangan
            </button>

            <a
                href="/admin/rooms"
                class="bg-slate-200 hover:bg-slate-300 px-6 py-3 rounded-xl font-semibold">
                Kembali
            </a>

        </div>

    </form>

</div>

@endsection