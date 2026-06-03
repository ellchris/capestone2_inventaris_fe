@extends('layouts.kalab')

@section('title', 'Edit Draf Pengadaan')
@section('page_title', 'Edit Draf Pengadaan')

@section('content')
<div class="space-y-6 max-w-6xl mx-auto">
    <!-- Back & Title -->
    <div class="flex items-center gap-3">
        <a href="/kalab/procurements" class="px-4 py-2.5 rounded-lg bg-slate-800 text-slate-300 hover:text-white transition text-sm">
            ⬅️ Kembali
        </a>
        <h1 class="text-2xl font-bold text-white">Edit Draf Pengadaan Tahunan</h1>
    </div>

    <!-- FORM CARD -->
    <form action="/kalab/procurements/update/{{ $procurement['id'] }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- General Settings Panel -->
        <div class="rounded-2xl bg-slate-950 border border-slate-800 p-6 space-y-4">
            <h3 class="text-lg font-semibold text-cyan-400">Informasi Umum</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="tahun_anggaran" class="block text-sm font-medium text-slate-300">Tahun Anggaran <span class="text-red-500">*</span></label>
                    <input type="number" 
                           id="tahun_anggaran" 
                           name="tahun_anggaran" 
                           value="{{ $procurement['tahun_anggaran'] }}" 
                           required 
                           min="2020" 
                           max="2100"
                           class="w-full px-4 py-3 rounded-xl bg-slate-900 border border-slate-800 focus:outline-none focus:border-cyan-500 text-white transition">
                </div>
            </div>
        </div>

        <!-- Procurement Items Table Panel -->
        <div class="rounded-2xl bg-slate-950 border border-slate-800 p-6 space-y-6">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-cyan-400">Daftar Barang yang Dibeli</h3>
                <button type="button" 
                        onclick="addRow()" 
                        class="px-4 py-2 rounded-lg bg-cyan-600/20 border border-cyan-500/50 hover:bg-cyan-600/30 text-cyan-400 transition font-medium text-sm flex items-center gap-2">
                    <span>➕</span> Tambah Baris
                </button>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse" id="items-table">
                    <thead>
                        <tr class="border-b border-slate-800 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                            <th class="pb-3 pr-4">Nama Barang <span class="text-red-500">*</span></th>
                            <th class="pb-3 pr-4 w-36">Harga (Rp) <span class="text-red-500">*</span></th>
                            <th class="pb-3 pr-4 w-24">Jumlah <span class="text-red-500">*</span></th>
                            <th class="pb-3 pr-4">Link Pembelian</th>
                            <th class="pb-3 pr-4 w-44">Gantikan Barang Lama?</th>
                            <th class="pb-3 pr-4">Barang yang Diganti</th>
                            <th class="pb-3 w-16 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-850" id="items-tbody">
                        <!-- Existing rows populated here -->
                    </tbody>
                </table>
            </div>

            <!-- Empty State Info inside Table -->
            <div id="empty-state-info" class="text-center py-8 text-slate-500 hidden">
                <p>Belum ada barang dalam daftar ini. Klik <strong>"Tambah Baris"</strong> di atas.</p>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end gap-4">
            <a href="/kalab/procurements" class="px-6 py-3.5 rounded-xl bg-slate-800 text-slate-300 hover:text-white transition font-medium">
                Batal
            </a>
            <button type="submit" class="px-6 py-3.5 rounded-xl bg-cyan-600 hover:bg-cyan-500 text-white font-medium shadow-md shadow-cyan-950/20 transition">
                📂 Perbarui Draf
            </button>
        </div>
    </form>
</div>

<!-- CLIENT JAVASCRIPT FOR DYNAMIC ROW MANAGEMENT -->
<script>
    let rowId = 0;
    
    // Convert php array to JS array to render the dropdown options
    const existingItems = @json($existingItems);
    const initialItems = @json($procurement['items']);

    function addRow(data = null) {
        document.getElementById('empty-state-info').classList.add('hidden');
        const tbody = document.getElementById('items-tbody');
        
        const row = document.createElement('tr');
        row.id = `row-${rowId}`;
        row.className = 'hover:bg-slate-900/20';
        
        let dropdownOptions = '<option value="">-- Pilih Barang --</option>';
        const selectedId = data ? data.replaced_item_id : '';
        
        existingItems.forEach(item => {
            const selected = item.id == selectedId ? 'selected' : '';
            dropdownOptions += `<option value="${item.id}" ${selected}>${item.nama_barang} (${item.uuid_qr || 'Tanpa QR'})</option>`;
        });

        const isReplacementChecked = data && (data.is_replacement == 1 || data.is_replacement === true);
        const nameVal = data ? data.nama_barang : '';
        const priceVal = data ? data.harga : '';
        const qtyVal = data ? data.jumlah : '1';
        const linkVal = data ? data.link_pembelian : '';
        
        row.innerHTML = `
            <td class="py-4 pr-4">
                <input type="text" name="items[${rowId}][nama_barang]" value="${nameVal}" required placeholder="Nama barang..." class="w-full px-3 py-2.5 rounded-lg bg-slate-900 border border-slate-800 focus:outline-none focus:border-cyan-500 text-white transition text-sm">
            </td>
            <td class="py-4 pr-4">
                <input type="number" name="items[${rowId}][harga]" value="${priceVal}" required min="0" placeholder="0" class="w-full px-3 py-2.5 rounded-lg bg-slate-900 border border-slate-800 focus:outline-none focus:border-cyan-500 text-white transition text-sm">
            </td>
            <td class="py-4 pr-4">
                <input type="number" name="items[${rowId}][jumlah]" value="${qtyVal}" required min="1" placeholder="1" class="w-full px-3 py-2.5 rounded-lg bg-slate-900 border border-slate-800 focus:outline-none focus:border-cyan-500 text-white transition text-sm">
            </td>
            <td class="py-4 pr-4">
                <input type="url" name="items[${rowId}][link_pembelian]" value="${linkVal}" placeholder="https://..." class="w-full px-3 py-2.5 rounded-lg bg-slate-900 border border-slate-800 focus:outline-none focus:border-cyan-500 text-white transition text-sm">
            </td>
            <td class="py-4 pr-4 text-center">
                <div class="flex items-center justify-start gap-2 h-10">
                    <input type="hidden" name="items[${rowId}][is_replacement]" value="0">
                    <input type="checkbox" name="items[${rowId}][is_replacement]" value="1" ${isReplacementChecked ? 'checked' : ''} onchange="toggleReplacement(${rowId}, this)" class="w-5 h-5 rounded bg-slate-900 border border-slate-800 text-cyan-600 focus:ring-cyan-500 cursor-pointer">
                    <label class="text-xs text-slate-400 select-none cursor-pointer">Ya, ganti barang</label>
                </div>
            </td>
            <td class="py-4 pr-4">
                <select name="items[${rowId}][replaced_item_id]" id="select-replace-${rowId}" class="w-full px-3 py-2.5 rounded-lg bg-slate-900 border border-slate-800 focus:outline-none focus:border-cyan-500 transition text-sm ${isReplacementChecked ? 'text-white' : 'text-slate-400 invisible'}" ${isReplacementChecked ? 'required' : ''}>
                    ${dropdownOptions}
                </select>
            </td>
            <td class="py-4 text-center">
                <button type="button" onclick="removeRow(${rowId})" class="w-8 h-8 rounded-lg bg-red-950/20 border border-red-900/30 text-red-400 hover:bg-red-900/40 transition flex items-center justify-center text-sm" title="Hapus baris">
                    ❌
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
            select.classList.remove('text-slate-400');
            select.classList.add('text-white');
        } else {
            select.classList.add('invisible');
            select.required = false;
            select.value = '';
        }
    }
    
    // Load initial items on startup
    window.onload = function() {
        if (initialItems && initialItems.length > 0) {
            initialItems.forEach(item => addRow(item));
        } else {
            addRow();
        }
    }
</script>
@endsection
