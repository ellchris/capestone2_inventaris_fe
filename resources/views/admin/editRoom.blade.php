@extends('layouts.admin')

@section('title', 'Edit Ruangan')

@section('content')

<div class="bg-white rounded-2xl shadow-sm p-8 max-w-3xl">

<form
action="/admin/rooms/update/{{ $room['id'] }}"
method="POST">

    @csrf
    @method('PUT')

    <div class="mb-4">

        <label>Nama Ruangan</label>

        <input
            type="text"
            name="nama_ruangan"
            value="{{ $room['nama_ruangan'] }}"
            class="w-full border rounded-lg p-3">

    </div>

    <div class="mb-6">

        <label>Lokasi</label>

        <input
            type="text"
            name="lokasi"
            value="{{ $room['lokasi'] }}"
            class="w-full border rounded-lg p-3">

    </div>

    <button
        type="submit"
        class="bg-blue-600 text-white px-6 py-3 rounded-xl">

        Update Ruangan

    </button>

</form>

</div>

@endsection