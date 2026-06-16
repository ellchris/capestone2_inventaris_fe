@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="mb-8">

    <h1 class="text-3xl font-bold text-slate-800">
        Dashboard Administrator
    </h1>

    <p class="text-slate-500 mt-2">
        Ringkasan data sistem inventaris laboratorium.
    </p>

</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="bg-white rounded-2xl shadow-sm p-8">

        <h3 class="text-slate-500 text-lg">
            Total Pengguna
        </h3>

        <h1 class="text-5xl font-bold text-slate-800 mt-4">
            {{ $totalUsers }}
        </h1>

    </div>

    <div class="bg-white rounded-2xl shadow-sm p-8">

        <h3 class="text-slate-500 text-lg">
            Total Ruangan
        </h3>

        <h1 class="text-5xl font-bold text-slate-800 mt-4">
            {{ $totalRooms }}
        </h1>

    </div>

</div>

<div class="bg-white rounded-2xl shadow-sm p-8 mt-8">

    <h3 class="text-xl font-semibold mb-4">
        Role Pengguna Sistem
    </h3>

    <div class="flex flex-wrap gap-3">

        <span class="bg-slate-100 px-4 py-2 rounded-lg">
            Administrator
        </span>

        <span class="bg-slate-100 px-4 py-2 rounded-lg">
            Kepala Laboratorium
        </span>

        <span class="bg-slate-100 px-4 py-2 rounded-lg">
            Ketua Program Studi
        </span>

        <span class="bg-slate-100 px-4 py-2 rounded-lg">
            Staff Administrasi
        </span>

        <span class="bg-slate-100 px-4 py-2 rounded-lg">
            Staff Laboratorium
        </span>

    </div>

</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">

    <div class="bg-white rounded-2xl shadow-sm p-8">

        <h3 class="text-xl font-semibold mb-4">
            Daftar Pengguna
        </h3>

        @foreach($users as $user)

        <div class="flex justify-between py-2 border-b">

            <span>
                {{ $user['nama'] }}
            </span>

            <span class="text-slate-500">
                {{ $user['role'] }}
            </span>

        </div>

        @endforeach

    </div>

    <div class="bg-white rounded-2xl shadow-sm p-8">

        <h3 class="text-xl font-semibold mb-4">
            Daftar Ruangan
        </h3>

        @foreach($rooms as $room)

        <div class="py-2 border-b">

            {{ $room['nama_ruangan'] }}

        </div>

        @endforeach

    </div>

</div>

@endsection