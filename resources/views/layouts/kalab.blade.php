<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Panel Kepala Laboratorium</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="fixed top-0 left-0 w-64 h-screen bg-slate-950 border-r border-slate-800 text-white flex flex-col justify-between">
        <div>
            <!-- Sidebar Header -->
            <div class="p-6 border-b border-slate-800 bg-gradient-to-r from-cyan-900 to-indigo-900">
                <h2 class="text-xl font-bold tracking-wide flex items-center gap-2">
                    <span class="text-cyan-400">🛡️</span> Inventaris Lab
                </h2>
                <p class="text-cyan-300 text-xs mt-1 uppercase font-semibold tracking-wider">
                    Kepala Laboratorium
                </p>
            </div>

            <!-- User Info Summary -->
            <div class="px-6 py-4 border-b border-slate-800/50 bg-slate-900/30 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-cyan-950 border border-cyan-800 flex items-center justify-center text-cyan-400 font-bold">
                    KL
                </div>
                <div>
                    <h4 class="text-sm font-medium text-slate-200">{{ session('user')['nama'] }}</h4>
                    <p class="text-xs text-slate-400">{{ session('user')['email'] }}</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1">
                <a href="/kalab/dashboard"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 {{ Request::is('kalab/dashboard') ? 'bg-cyan-950 text-cyan-400 border-l-4 border-cyan-400 font-medium' : 'text-slate-400 hover:text-slate-200' }}">
                    <span>📊</span> Dashboard
                </a>

                <a href="/kalab/procurements"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl transition duration-200 hover:bg-slate-800 {{ Request::is('kalab/procurements*') ? 'bg-cyan-950 text-cyan-400 border-l-4 border-cyan-400 font-medium' : 'text-slate-400 hover:text-slate-200' }}">
                    <span>📝</span> Pengadaan Barang
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer / Logout -->
        <div class="p-4 border-t border-slate-800">
            <a href="/logout"
               class="flex items-center gap-3 px-4 py-3 rounded-xl bg-red-950/20 text-red-400 hover:bg-red-900/30 hover:text-red-300 border border-red-900/30 transition duration-200">
                <span>🚪</span> Logout
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="ml-64 flex-1 flex flex-col min-h-screen">
        <!-- Top Navbar -->
        <header class="h-16 border-b border-slate-800 bg-slate-950/50 backdrop-blur-md sticky top-0 px-8 flex items-center justify-between z-10">
            <div class="flex items-center gap-2">
                <span class="text-slate-400">Home</span>
                <span class="text-slate-600">/</span>
                <span class="text-slate-200">@yield('page_title', 'Dashboard')</span>
            </div>
            
            <div class="text-slate-400 text-sm">
                Hari ini: <span class="text-slate-200 font-medium">{{ date('d M Y') }}</span>
            </div>
        </header>

        <!-- Main Body -->
        <main class="p-8 flex-1 bg-gradient-to-b from-slate-900 to-slate-950">
            @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-950/40 border border-emerald-800/50 text-emerald-300 flex items-center gap-3 shadow-lg shadow-emerald-950/20">
                    <span class="text-xl">✅</span>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-rose-950/40 border border-rose-800/50 text-rose-300 flex items-center gap-3 shadow-lg shadow-rose-950/20">
                    <span class="text-xl">⚠️</span>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
