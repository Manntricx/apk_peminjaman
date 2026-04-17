<x-peminjam-layout>
    <x-slot name="pageTitle">Ajukan Peminjaman</x-slot>

    <div class="page-header">
        <h1>Ajukan Peminjaman</h1>
        <p>Lengkapi formulir di bawah ini untuk mengajukan peminjaman aset. Permintaan Anda akan segera diverifikasi oleh petugas.</p>
    </div>

    @if(session('error'))
        <div class="alert alert-error">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <ul style="list-style: none; padding: 0;">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="max-width: 800px; margin: 0 auto;">
        <div class="card">
            <div class="card-header" style="background: #f8fafc;">
                <h2 class="card-title">Formulir Pengajuan Aset</h2>
                <a href="{{ route('peminjam.peminjamans.index') }}" class="btn btn-outline btn-sm">Batal</a>
            </div>
            <div class="card-body">
                <form action="{{ route('peminjam.peminjamans.store') }}" method="POST">
                    @csrf

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px;">
                        <div class="form-group">
                            <label class="form-label">Kode Referensi</label>
                            <input type="text" name="kode_peminjaman" value="{{ $kode }}" readonly class="form-control" style="background: #f1f5f9; font-family: monospace; font-weight: 700; color: var(--primary);">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="tgl_pinjam">Rencana Pinjam</label>
                            <input type="date" name="tgl_pinjam" id="tgl_pinjam" value="{{ date('Y-m-d') }}" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tgl_kembali_rencana">Rencana Pengembalian</label>
                        <input type="date" name="tgl_kembali_rencana" id="tgl_kembali_rencana" required class="form-control">
                    </div>

                    <div style="margin: 32px 0; border-top: 1px dashed var(--border);"></div>

                    <div class="form-group">
                        <label class="form-label" style="margin-bottom: 16px;">Daftar Alat yang Dipilih</label>
                        
                        <div id="alat-container" style="display: flex; flex-direction: column; gap: 16px;">
                            <div class="card" style="margin-bottom: 0; background: #fdfdfd; border-style: solid;">
                                <div class="card-body" style="padding: 20px; display: grid; grid-template-columns: 2fr 1fr; gap: 16px;">
                                    <div>
                                        <label class="form-label" style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted);">Pilih Aset</label>
                                        <select name="alat_id[]" required class="form-control">
                                            <option value="" disabled selected>Pilih aset dari katalog...</option>
                                            @foreach($alats as $alat)
                                            <option value="{{ $alat->id }}" {{ request('alat_id') == $alat->id ? 'selected' : '' }}>
                                                [{{ $alat->kategori->nama_kategori }}] {{ $alat->nama_alat }} (Tersedia: {{ $alat->stok_tersedia }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="form-label" style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted);">Unit</label>
                                        <input type="number" name="jumlah[]" value="1" min="1" required class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="addAlatRow()" style="margin-top: 12px; width: 100%; padding: 12px; background: #f8fafc; border: 1px dashed var(--border); border-radius: var(--radius); color: var(--text-muted); font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                            + Tambah Aset Lainnya
                        </button>
                    </div>

                    <div class="form-group" style="margin-top: 32px;">
                        <label class="form-label" for="keterangan">Tujuan Peminjaman</label>
                        <textarea name="keterangan" id="keterangan" rows="3" placeholder="Contoh: Digunakan untuk keperluan presentasi di Ruang Seminar." class="form-control" style="resize: vertical;">{{ old('keterangan') }}</textarea>
                    </div>

                    <div style="margin-top: 32px; display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn btn-primary">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            Kirim Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    const alats = @json($alats->map(fn($a) => ['id' => $a->id, 'nama' => '[' . $a->kategori->nama_kategori . '] ' . $a->nama_alat . ' (Tersedia: ' . $a->stok_tersedia . ')']));

    function addAlatRow() {
        const options = alats.map(a => `<option value="${a.id}">${a.nama}</option>`).join('');
        const row = document.createElement('div');
        row.className = 'card';
        row.style.cssText = 'margin-bottom: 0; background: #fdfdfd; border-style: solid;';
        row.innerHTML = `
            <div class="card-body" style="padding: 20px; display: grid; grid-template-columns: 2fr 1fr; gap: 16px;">
                <div>
                    <label class="form-label" style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted);">Pilih Aset</label>
                    <select name="alat_id[]" required class="form-control">
                        <option value="" disabled selected>Pilih aset dari katalog...</option>
                        ${options}
                    </select>
                </div>
                <div>
                    <label class="form-label" style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted);">Unit</label>
                    <div style="display: flex; gap: 8px;">
                        <input type="number" name="jumlah[]" value="1" min="1" required class="form-control">
                        <button type="button" onclick="this.closest('.card').remove()" style="background: #fee2e2; color: #b91c1c; border: none; padding: 0 12px; border-radius: 8px; cursor: pointer;">
                            <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
            </div>`;
        document.getElementById('alat-container').appendChild(row);
    }
    </script>
</x-peminjam-layout>
