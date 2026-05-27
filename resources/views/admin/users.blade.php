<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Pengguna</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-2xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Daftar Pengguna Sistem (Multi-Role)</h2>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-800 text-white">
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Role</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 font-semibold">{{ $user['nama'] }}</td>
                    <td class="p-3 text-gray-600">{{ $user['email'] }}</td>
                    <td class="p-3">
                        <span class="px-3 py-1 text-xs font-bold rounded-full bg-indigo-100 text-indigo-700 uppercase">
                            {{ $user['role'] }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>