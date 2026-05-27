<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Tambah Ruangan</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-md mx-auto bg-white p-6 rounded-2xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Ruangan Lab Baru</h2>
        
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        <form action="/admin/rooms/store" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Nama Ruangan</label>
                <input type="text" name="nama_ruangan" placeholder="Contoh: Lab Komputer 1" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-indigo-500" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Lokasi / Gedung</label>
                <input type="text" name="lokasi" placeholder="Contoh: Gedung H Lantai 2" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-indigo-500" required>
            </div>
            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold p-3 rounded-lg transition duration-200">
                Simpan Ruangan
            </button>
        </form>
    </div>
</body>
</html>