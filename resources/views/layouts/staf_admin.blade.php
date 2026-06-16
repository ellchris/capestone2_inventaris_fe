<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Panel Staf Administrasi</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800">

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="fixed top-0 left-0 w-64 h-screen bg-slate-800 text-white">

        <div class="p-6 border-b border-slate-700">
            <h2 class="text-2xl font-bold">
                Inventaris Lab
            </h2>

            <p class="text-slate-300 text-sm mt-1">
                Staf Administrasi Panel
            </p>
        </div>

        <nav class="p-4 space-y-1">

            <a href="/staf-admin/dashboard"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition {{ Request::is('staf-admin/dashboard') ? 'bg-slate-900 font-semibold text-white' : 'text-slate-300' }}">
                Dashboard
            </a>

            <a href="/staf-admin/procurements"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition {{ Request::is('staf-admin/procurements*') ? 'bg-slate-900 font-semibold text-white' : 'text-slate-300' }}">
                Penerimaan Barang
            </a>

            <a href="/staf-admin/inventory"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 transition {{ Request::is('staf-admin/inventory*') || Request::is('staf-admin/items*') ? 'bg-slate-900 font-semibold text-white' : 'text-slate-300' }}">
                Kelola Inventaris
            </a>

            <a href="/logout"
               class="block px-4 py-3 rounded-lg hover:bg-red-650 hover:bg-red-600 transition text-red-300 hover:text-white mt-4">
                Logout
            </a>

        </nav>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="ml-64 flex-1 p-10 min-h-screen">
        
        <!-- Alerts -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="font-bold">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="font-bold">⚠</span>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

</div>

</body>
</html>
