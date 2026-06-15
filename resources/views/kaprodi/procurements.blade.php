<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Pengadaan</title>

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

            <p class="text-slate-300 text-sm mt-1">
                Ketua Program Studi
            </p>
        </div>

        <nav class="p-4">

            <a href="/kaprodi/dashboard"
               class="block px-4 py-3 rounded-lg hover:bg-slate-700 mb-2">
                Dashboard
            </a>

            <a href="/kaprodi/procurements"
               class="block px-4 py-3 rounded-lg bg-slate-700 mb-2">
                Review Pengadaan
            </a>

            <a href="/logout"
               class="block px-4 py-3 rounded-lg hover:bg-red-600">
                Logout
            </a>

        </nav>

    </aside>

    <!-- Content -->
    <main class="flex-1 p-10">

        <div class="flex justify-between items-center mb-8">

            <div>

                <h1 class="text-3xl font-bold text-slate-800">
                    Review Draft Pengadaan
                </h1>

                <p class="text-slate-500 mt-2">
                    Daftar draft pengadaan yang memerlukan persetujuan Kaprodi.
                </p>

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <table class="w-full">

                <thead class="bg-slate-100">

                    <tr>

                        <th class="px-6 py-4 text-left">
                            ID
                        </th>

                        <th class="px-6 py-4 text-left">
                            Tahun Anggaran
                        </th>

                        <th class="px-6 py-4 text-left">
                            Status Draft
                        </th>

                        <th class="px-6 py-4 text-left">
                            Approval Status
                        </th>

                        <th class="px-6 py-4 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($procurements as $item)

                    <tr class="border-t hover:bg-slate-50">

                        <td class="px-6 py-4">
                            {{ $item['id'] }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $item['tahun_anggaran'] }}
                        </td>

                        <td class="px-6 py-4">

                            @if($item['status'] == 'locked')
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm">
                                    Locked
                                </span>
                            @else
                                <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm">
                                    {{ ucfirst($item['status']) }}
                                </span>
                            @endif

                        </td>

                        <td class="px-6 py-4">

                            @if($item['approval_status'] == 'pending')
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                                    Pending
                                </span>

                            @elseif($item['approval_status'] == 'approved')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                    Approved
                                </span>

                            @elseif($item['approval_status'] == 'rejected')
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                    Rejected
                                </span>

                            @elseif($item['approval_status'] == 'finalized')
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                                    Finalized
                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4 text-center">

                            <a href="/kaprodi/procurements/{{ $item['id'] }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium">

                                Review

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5"
                            class="text-center py-10 text-slate-500">

                            Belum ada draft pengadaan

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