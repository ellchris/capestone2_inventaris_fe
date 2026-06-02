@extends('layouts.admin')

@section('title', 'Tambah Pengguna')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-6 mb-8">

    <h1 class="text-3xl font-bold text-slate-800">
        Tambah Pengguna
    </h1>

    <p class="text-slate-500 mt-2">
        Tambahkan pengguna baru ke sistem.
    </p>

</div>

<div class="bg-white rounded-2xl shadow-sm p-8 max-w-3xl">

<form action="/admin/users/store" method="POST">

    @csrf

    <div class="mb-4">

        <label class="block mb-2">
            Nama
        </label>

        <input
            type="text"
            name="nama"
            class="w-full border rounded-lg p-3"
            required>

    </div>

    <div class="mb-4">

        <label class="block mb-2">
            Email
        </label>

        <input
            type="email"
            name="email"
            class="w-full border rounded-lg p-3"
            required>

    </div>

    <div class="mb-4">

        <label class="block mb-2">
            Password
        </label>

        <input
            type="password"
            name="password"
            class="w-full border rounded-lg p-3"
            required>

    </div>

    <div class="mb-6">

        <label class="block mb-2">
            Role
        </label>

        <select
            name="role"
            class="w-full border rounded-lg p-3"
            required>

            <option value="kepala_lab">
                Kepala Laboratorium
            </option>

            <option value="kaprodi">
                Ketua Program Studi
            </option>

            <option value="staff_admin">
                Staff Administrasi
            </option>

            <option value="staff_lab">
                Staff Laboratorium
            </option>

        </select>

    </div>

    <button
        type="submit"
        class="bg-blue-600 text-white px-6 py-3 rounded-xl">

        Simpan Pengguna

    </button>

</form>

</div>

@endsection