<!DOCTYPE html>
<html>
<head>
    <title>Maintenance Inventaris</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">

<div class="flex min-h-screen">

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

    <main class="flex-1 p-10">

        <div class="flex justify-between items-center mb-8">

            <div>

                <h1 class="text-3xl font-bold text-slate-800">
                    Maintenance Inventaris
                </h1>

                <p class="text-slate-500 mt-2">
                    Kelola data maintenance barang inventaris laboratorium.
                </p>

            </div>

            <a href="/staf-lab/maintenances/create"
               class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold">
                + Tambah Maintenance
            </a>

        </div>

        @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-6">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr>
                        <th class="text-left px-6 py-4">Barang</th>
                        <th class="text-left px-6 py-4">Kerusakan</th>
                        <th class="text-left px-6 py-4">Solusi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($maintenances as $maintenance)

                    <tr class="border-t">

                        <td class="px-6 py-4">
                            {{ $maintenance['nama_barang'] }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $maintenance['deskripsi_kerusakan'] }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $maintenance['solusi'] }}
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="3"
                            class="text-center py-8 text-slate-500">
                            Belum ada data maintenance
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </main>

</div>

</body>
</html>