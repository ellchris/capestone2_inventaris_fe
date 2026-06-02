<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

<div class="flex">

    <aside class="fixed top-0 left-0 w-64 h-screen bg-slate-800 text-white">

        <div class="p-6 border-b border-slate-700">
            <h2 class="text-2xl font-bold">
                Inventaris Lab
            </h2>

            <p class="text-slate-300 text-sm mt-1">
                Administrator Panel
            </p>
        </div>

        <nav class="p-4">

            <a href="/admin"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 mb-2">
                Dashboard
            </a>

            <a href="/admin/users"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 mb-2">
                Kelola Pengguna
            </a>

            <a href="/admin/rooms"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 mb-2">
                Kelola Ruangan
            </a>

            <a href="/logout"
               class="block px-4 py-3 rounded-lg hover:bg-red-600">
                Logout
            </a>

        </nav>

    </aside>

    <main class="ml-64 flex-1 p-10">
        @yield('content')
    </main>

</div>

</body>
</html>