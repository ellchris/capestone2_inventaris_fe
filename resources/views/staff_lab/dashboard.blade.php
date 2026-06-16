<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Staff Lab</title>
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
               class="block px-4 py-3 rounded-lg bg-slate-700 mb-2">
                Dashboard
            </a>

            <a href="/staf-lab/maintenances"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 mb-2">
                Maintenance
            </a>

            <a href="/logout"
               class="block px-4 py-3 rounded-lg hover:bg-red-600">
                Logout
            </a>

        </nav>

    </aside>

    <main class="flex-1 p-10">

        <h1 class="text-3xl font-bold text-slate-800 mb-8">
            Dashboard Staff Lab
        </h1>

        <div class="grid grid-cols-3 gap-6">

            <div class="bg-white rounded-2xl p-6 shadow">
                <p class="text-slate-500">
                    Total Inventaris
                </p>

                <h2 class="text-3xl font-bold mt-2">
                    {{ $totalInventories }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow">
                <p class="text-slate-500">
                    Total BHP
                </p>

                <h2 class="text-3xl font-bold mt-2">
                    {{ $totalBhps }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow">
                <p class="text-slate-500">
                    Total Maintenance
                </p>

                <h2 class="text-3xl font-bold mt-2">
                    {{ $totalMaintenances }}
                </h2>
            </div>

        </div>

        <div class="grid grid-cols-2 gap-6 mt-8">

    <div class="bg-white rounded-2xl shadow p-6">

        <h2 class="text-xl font-bold mb-4">
            Maintenance Terbaru
        </h2>

        <div class="space-y-3">

            @forelse($maintenances as $maintenance)

            <div class="border rounded-xl p-3">

                <p class="font-semibold">
                    {{ $maintenance['nama_barang'] }}
                </p>

                <p class="text-sm text-slate-500">
                    {{ $maintenance['deskripsi_kerusakan'] }}
                </p>

            </div>

            @empty

            <p class="text-slate-500">
                Belum ada maintenance
            </p>

            @endforelse

        </div>

            </div>

            <div class="bg-white rounded-2xl shadow p-6">

                <h2 class="text-xl font-bold mb-4">
                    Stok BHP
                </h2>

                <div class="space-y-3">

                    @forelse($bhps as $bhp)

                    <div class="flex justify-between border rounded-xl p-3">

                        <span>
                            {{ $bhp['nama_barang'] }}
                        </span>

                        <span class="font-bold">

                            {{ $bhp['stok'] }}

                            @if($bhp['stok'] < 5)

                            <span class="text-red-500">
                                ⚠
                            </span>

                            @endif

                        </span>

                    </div>

                    @empty

                    <p class="text-slate-500">
                        Belum ada data BHP
                    </p>

                    @endforelse

                </div>

            </div>

        </div>

    </main>

</div>

</body>
</html>