<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengadaan</title>

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

        <div class="bg-white rounded-2xl shadow-sm p-8">

            <div class="flex justify-between items-start mb-8">

                <div>

                    <h1 class="text-3xl font-bold text-slate-800">
                        Detail Pengadaan
                    </h1>

                    <p class="text-slate-500 mt-2">
                        Review draft pengadaan yang diajukan Kepala Laboratorium.
                    </p>

                </div>

                <a href="/kaprodi/procurements"
                   class="bg-slate-200 hover:bg-slate-300 px-5 py-3 rounded-xl font-semibold">
                    Kembali
                </a>

            </div>

            <div class="grid grid-cols-2 gap-6 mb-8">

                <div>
                    <label class="text-slate-500 text-sm">
                        ID Pengadaan
                    </label>

                    <p class="font-semibold text-lg">
                        {{ $procurement['id'] }}
                    </p>
                </div>

                <div>
                    <label class="text-slate-500 text-sm">
                        Tahun Anggaran
                    </label>

                    <p class="font-semibold text-lg">
                        {{ $procurement['tahun_anggaran'] }}
                    </p>
                </div>

                <div>
                    <label class="text-slate-500 text-sm">
                        Status Draft
                    </label>

                    <p class="font-semibold">
                        {{ ucfirst($procurement['status']) }}
                    </p>
                </div>

                <div>
                    <label class="text-slate-500 text-sm">
                        Status Persetujuan
                    </label>

                    <p class="font-semibold">
                        {{ ucfirst($procurement['approval_status']) }}
                    </p>
                </div>

            </div>

            <h2 class="text-xl font-bold mb-4">
                Daftar Barang Pengadaan
            </h2>

            <div class="overflow-x-auto">

                <table class="w-full border border-slate-200 rounded-xl overflow-hidden">

                    <thead class="bg-slate-100">

                        <tr>
                            <th class="p-4 text-left">Nama Barang</th>
                            <th class="p-4 text-left">Harga</th>
                            <th class="p-4 text-left">Jumlah</th>
                            <th class="p-4 text-left">Link Pembelian</th>
                            <th class="p-4 text-center">Pengganti</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($procurement['items'] as $item)

                        <tr class="border-t">

                            <td class="p-4">
                                {{ $item['nama_barang'] }}
                            </td>

                            <td class="p-4">
                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                            </td>

                            <td class="p-4">
                                {{ $item['jumlah'] }}
                            </td>

                            <td class="p-4">

                                <a href="{{ $item['link_pembelian'] }}"
                                   target="_blank"
                                   class="text-blue-600 hover:underline">

                                    Buka Link

                                </a>

                            </td>

                            <td class="p-4 text-center">

                                @if($item['is_replacement'])
                                    Ya
                                @else
                                    Tidak
                                @endif

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            @if(session('success'))

            <div class="mt-6 bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>

            @endif

            <div class="flex gap-3 mt-8">

                @if($procurement['approval_status'] == 'pending')

                <form action="/kaprodi/procurements/{{ $procurement['id'] }}/approve" method="POST">

                    @csrf
                    @method('PUT')

                    <button
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold">

                        Approve

                    </button>

                </form>

                <form action="/kaprodi/procurements/{{ $procurement['id'] }}/reject" method="POST">

                    @csrf
                    @method('PUT')

                    <button
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold">

                        Reject

                    </button>

                </form>

                @endif

                @if($procurement['approval_status'] == 'approved')

                <form action="/kaprodi/procurements/{{ $procurement['id'] }}/finalize" method="POST">

                    @csrf
                    @method('PUT')

                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold">

                        Finalize

                    </button>

                </form>

                @endif

            </div>

        </div>

    </main>

</div>

</body>
</html>