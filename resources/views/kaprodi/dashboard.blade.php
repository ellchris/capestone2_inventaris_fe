<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Kaprodi</title>
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
                Ketua Program Studi
            </p>
        </div>

        <nav class="p-4">

            <a href="/kaprodi/dashboard"
               class="block px-4 py-3 rounded-lg bg-slate-700 mb-2">
                Dashboard
            </a>

            <a href="/kaprodi/procurements"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 mb-2">
                Review Pengadaan
            </a>

            <a href="/logout"
               class="block px-4 py-3 rounded-lg hover:bg-red-600">
                Logout
            </a>

        </nav>

    </aside>

    <main class="flex-1 p-10">

        <h1 class="text-3xl font-bold text-slate-800 mb-8">
            Dashboard Kaprodi
        </h1>

        <div class="grid grid-cols-4 gap-6">

            <div class="bg-white rounded-2xl p-6 shadow">
                <p class="text-slate-500">Total Draft</p>
                <h2 class="text-3xl font-bold mt-2">
                    {{ count($procurements) }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow">
                <p class="text-slate-500">Pending</p>
                <h2 class="text-3xl font-bold mt-2">
                    {{ collect($procurements)->where('approval_status','pending')->count() }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow">
                <p class="text-slate-500">Approved</p>
                <h2 class="text-3xl font-bold mt-2">
                    {{ collect($procurements)->where('approval_status','approved')->count() }}
                </h2>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow">
                <p class="text-slate-500">Rejected</p>
                <h2 class="text-3xl font-bold mt-2">
                    {{ collect($procurements)->where('approval_status','rejected')->count() }}
                </h2>
            </div>

        </div>

    </main>

</div>

</body>
</html>