<!DOCTYPE html>
<html>
<head>
    <title>Tambah Maintenance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-slate-800 text-white">

        <div class="p-6 border-b border-slate-700">
            <h2 class="text-xl font-bold">
                Inventaris Lab
            </h2>

            <p class="text-slate-300 text-sm">
                Staff Laboratorium
            </p>
        </div>

        <nav class="p-4">

            <a href="/staf-lab/dashboard"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 mb-2">
                Dashboard
            </a>

            <a href="/staf-lab/maintenances"
               class="block px-4 py-3 rounded-lg bg-slate-700 mb-2">
                Maintenance
            </a>

            <a href="/logout"
               class="block px-4 py-3 rounded-lg hover:bg-red-600">
                Logout
            </a>

        </nav>

    </aside>

    <!-- Content -->
    <main class="flex-1 p-10">

        <div class="bg-white rounded-2xl shadow-sm p-6 mb-8">

            <h1 class="text-3xl font-bold text-slate-800">
                Tambah Maintenance
            </h1>

            <p class="text-slate-500 mt-2">
                Catat proses maintenance inventaris laboratorium.
            </p>

        </div>

        <div class="bg-white rounded-2xl shadow-sm p-8 max-w-4xl">

            <form action="/staf-lab/maintenances/store" method="POST">

                @csrf

                <div class="mb-6">

                    <label class="block text-slate-700 font-medium mb-2">
                        Inventaris
                    </label>

                    <select
                        name="item_id"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3"
                        required>

                        <option value="">
                            Pilih Inventaris
                        </option>

                        @foreach($inventories as $item)

                        <option value="{{ $item['id'] }}">
                            {{ $item['nama_barang'] }}
                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-6">

                    <label class="block text-slate-700 font-medium mb-2">
                        Deskripsi Kerusakan
                    </label>

                    <textarea
                        name="deskripsi_kerusakan"
                        rows="4"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3"
                        required></textarea>

                </div>

                <div class="mb-6">

                    <label class="block text-slate-700 font-medium mb-2">
                        Solusi
                    </label>

                    <textarea
                        name="solusi"
                        rows="4"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3"
                        required></textarea>

                </div>

                <div class="mb-6">

                    <label class="block text-slate-700 font-medium mb-2">
                        BHP Yang Digunakan
                    </label>

                    <select
                        name="bhp_item_id"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                        <option value="">
                            Pilih BHP
                        </option>

                        @foreach($bhps as $bhp)

                        <option value="{{ $bhp['id'] }}">
                            {{ $bhp['nama_barang'] }}
                            (Stok: {{ $bhp['stok'] }})
                        </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-8">

                    <label class="block text-slate-700 font-medium mb-2">
                        Jumlah BHP Dipakai
                    </label>

                    <input
                        type="number"
                        name="jumlah_terpakai"
                        min="0"
                        class="w-full border border-slate-300 rounded-xl px-4 py-3">

                </div>

                <div class="flex gap-3">

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold">

                        Simpan Maintenance

                    </button>

                    <a
                        href="/staf-lab/maintenances"
                        class="bg-slate-200 hover:bg-slate-300 px-6 py-3 rounded-xl font-semibold">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </main>

</div>

</body>
</html>