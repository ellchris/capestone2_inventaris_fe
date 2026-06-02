@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-8 max-w-3xl">

<form
action="/admin/users/update/{{ $user['id'] }}"
method="POST">

    @csrf
    @method('PUT')

    <div class="mb-4">

        <label>Nama</label>

        <input
            type="text"
            name="nama"
            value="{{ $user['nama'] }}"
            class="w-full border rounded-lg p-3">

    </div>

    <div class="mb-4">

        <label>Email</label>

        <input
            type="email"
            name="email"
            value="{{ $user['email'] }}"
            class="w-full border rounded-lg p-3">

    </div>

    <div class="mb-6">

        <label>Role</label>

        <select
            name="role"
            class="w-full border rounded-lg p-3">

            <option
                value="kepala_lab"
                {{ $user['role']=='kepala_lab' ? 'selected' : '' }}>
                Kepala Laboratorium
            </option>

            <option
                value="kaprodi"
                {{ $user['role']=='kaprodi' ? 'selected' : '' }}>
                Kaprodi
            </option>

            <option
                value="staff_admin"
                {{ $user['role']=='staff_admin' ? 'selected' : '' }}>
                Staff Administrasi
            </option>

            <option
                value="staff_lab"
                {{ $user['role']=='staff_lab' ? 'selected' : '' }}>
                Staff Laboratorium
            </option>

        </select>

    </div>

    <button
        type="submit"
        class="bg-blue-600 text-white px-6 py-3 rounded-xl">

        Update Pengguna

    </button>

</form>

</div>

@endsection