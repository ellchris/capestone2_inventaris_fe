<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Inventaris Lab</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-slate-100">

    <div class="min-h-screen flex items-center justify-center px-4">

        <div class="w-full max-w-md">

            <div class="bg-white rounded-3xl shadow-xl p-8">

                <div class="text-center mb-8">

                    <div class="w-20 h-20 mx-auto mb-4 bg-slate-800 rounded-2xl flex items-center justify-center">

                        <span class="text-3xl text-white">🏢</span>

                    </div>

                    <h1 class="text-3xl font-bold text-slate-800">
                        Inventaris Lab
                    </h1>

                    <p class="text-slate-500 mt-2">
                        Silakan login untuk melanjutkan
                    </p>

                </div>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-xl mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="/login" method="POST">

                    @csrf

                    <div class="mb-5">

                        <label class="block text-slate-700 font-medium mb-2">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            placeholder="Masukkan email"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-700"
                            required
                        >

                    </div>

                    <div class="mb-6">

                        <label class="block text-slate-700 font-medium mb-2">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            placeholder="Masukkan password"
                            class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-700"
                            required
                        >

                    </div>

                    <button
                        type="submit"
                        class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold py-3 rounded-xl transition">

                        Login

                    </button>

                </form>

            </div>

            <div class="text-center mt-6 text-sm text-slate-500">

                Sistem Inventaris Laboratorium

            </div>

        </div>

    </div>

</body>
</html>