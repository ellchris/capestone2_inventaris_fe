@extends('layouts.kalab')

@section('title', 'Buat Draf Pengadaan')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Back & Title -->
    <div class="flex items-center mb-8 gap-3">
        <a href="/kalab/procurements" class="bg-slate-500 hover:bg-slate-600 text-white px-4 py-2.5 rounded-lg text-sm transition">
            Kembali
        </a>
        <h1 class="text-3xl font-bold text-slate-800">Buat Draf Pengadaan Tahunan</h1>
    </div>

    <!-- FORM -->
    <form action="/kalab/procurements/store" method="POST" class="space-y-6">
        @csrf

        <!-- General Settings Panel -->
        <div class="bg-white rounded-2xl shadow-sm p-8 border border-slate-100">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Informasi Umum</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="tahun_anggaran" class="block font-semibold mb-2 text-slate-700">Tahun Anggaran <span class="text-red-500">*</span></label>
                    <input type="number" 
                           id="tahun_anggaran" 
                           name="tahun_anggaran" 
                           value="{{ date('Y') }}" 
                           required 
                           min="2020" 
                           max="2100"
                           class="w-full border rounded-lg p-3 focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>
        </div>

        <!-- Procurement Items Table Panel -->
        <div class="bg-white rounded-2xl shadow-sm p-8 border border-slate-100">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-slate-800">Daftar Barang yang Dibeli</h3>
                <button type="button" 
                        onclick="addRow()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold text-sm transition">
                    + Tambah Baris
                </button>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" id="items-table">
                    <thead>
                        <tr class="bg-slate-100 text-slate-700 text-xs font-bold uppercase tracking-wider">
                            <th class="py-3 px-4 rounded-l-lg">Nama Barang <span class="text-red-500">*</span></th>
                            <th class="py-3 px-4 w-36">Harga (Rp) <span class="text-red-500">*</span></th>
                            <th class="py-3 px-4 w-24">Jumlah <span class="text-red-500">*</span></th>
                            <th class="py-3 px-4">Link Pembelian</th>
                            <th class="py-3 px-4 w-44">Gantikan Barang?</th>
                            <th class="py-3 px-4">Barang yang Diganti</th>
                            <th class="py-3 px-4 rounded-r-lg text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="items-tbody">
                        <!-- Rows will be injected here dynamically -->
                    </tbody>
                </table>
            </div>

            <!-- Empty State Info inside Table -->
            <div id="empty-state-info" class="text-center py-8 text-slate-500 hidden">
                <p>Belum ada barang dalam daftar ini. Klik <strong>"+ Tambah Baris"</strong> di atas.</p>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end gap-4">
            <a href="/kalab/procurements" class="bg-slate-300 hover:bg-slate-400 text-slate-700 px-6 py-3 rounded-xl font-semibold transition">
                Batal
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold shadow-sm transition">
                Simpan sebagai Draf
            </button>
        </div>
    </form>
</div>

<!-- CLIENT JAVASCRIPT FOR DYNAMIC ROW MANAGEMENT -->
<script>
    let rowId = 0;
    
    // Convert php array to JS array to render the dropdown options
    const existingItems = @json($existingItems);

    function addRow() {
        document.getElementById('empty-state-info').classList.add('hidden');
        const tbody = document.getElementById('items-tbody');
        
        const row = document.createElement('tr');
        row.id = `row-${rowId}`;
        row.className = 'border-b hover:bg-slate-50 transition';
        
        let dropdownOptions = '<option value="">-- Pilih Barang --</option>';
        existingItems.forEach(item => {
            dropdownOptions += `<option value="${item.id}">${item.nama_barang} (${item.uuid_qr || 'Tanpa QR'})</option>`;
        });
        
        row.innerHTML = `
            <td class="py-4 px-2">
                <input type="text" name="items[${rowId}][nama_barang]" required placeholder="Nama barang..." class="w-full border rounded-lg p-2.5 text-sm focus:outline-none focus:border-blue-500 transition">
            </td>
            <td class="py-4 px-2">
                <input type="number" name="items[${rowId}][harga]" required min="0" placeholder="0" class="w-full border rounded-lg p-2.5 text-sm focus:outline-none focus:border-blue-500 transition">
            </td>
            <td class="py-4 px-2">
                <input type="number" name="items[${rowId}][jumlah]" required min="1" placeholder="1" class="w-full border rounded-lg p-2.5 text-sm focus:outline-none focus:border-blue-500 transition">
            </td>
            <td class="py-4 px-2">
                <input type="url" name="items[${rowId}][link_pembelian]" placeholder="https://..." class="w-full border rounded-lg p-2.5 text-sm focus:outline-none focus:border-blue-500 transition">
            </td>
            <td class="py-4 px-4 text-center">
                <div class="flex items-center justify-start gap-2 h-10">
                    <input type="hidden" name="items[${rowId}][is_replacement]" value="0">
                    <input type="checkbox" name="items[${rowId}][is_replacement]" value="1" onchange="toggleReplacement(${rowId}, this)" class="w-5 h-5 rounded border-slate-350 text-blue-600 focus:ring-blue-500 cursor-pointer">
                    <label class="text-xs text-slate-500 select-none cursor-pointer">Ya, ganti</label>
                </div>
            </td>
            <td class="py-4 px-2">
                <select name="items[${rowId}][replaced_item_id]" id="select-replace-${rowId}" class="w-full border rounded-lg p-2.5 text-sm text-slate-800 focus:outline-none focus:border-blue-500 transition invisible">
                    ${dropdownOptions}
                </select>
            </td>
            <td class="py-4 text-center">
                <button type="button" onclick="removeRow(${rowId})" class="bg-red-100 hover:bg-red-200 text-red-650 text-red-600 font-semibold px-2 py-1 rounded-lg transition" title="Hapus baris">
                    Hapus
                </button>
            </td>
        `;
        
        tbody.appendChild(row);
        rowId++;
    }

    function removeRow(id) {
        const row = document.getElementById(`row-${id}`);
        row.remove();
        
        const tbody = document.getElementById('items-tbody');
        if (tbody.children.length === 0) {
            document.getElementById('empty-state-info').classList.remove('hidden');
        }
    }

    function toggleReplacement(id, checkbox) {
        const select = document.getElementById(`select-replace-${id}`);
        if (checkbox.checked) {
            select.classList.remove('invisible');
            select.required = true;
        } else {
            select.classList.add('invisible');
            select.required = false;
            select.value = '';
        }
    }
    
    // Add first row on load
    window.onload = function() {
        addRow();
    }
</script>
@endsection
