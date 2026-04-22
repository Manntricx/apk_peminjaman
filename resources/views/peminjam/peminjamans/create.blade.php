<x-peminjam-layout>
    <x-slot name="pageTitle">Ajukan Peminjaman</x-slot>

    <style>
        .page-hdr { margin-bottom: 24px; }
        .page-hdr h1 { font-size: 1.4rem; font-weight: 800; color: #e8eeff; letter-spacing: -0.5px; }
        .page-hdr p  { font-size: 0.82rem; color: #4e6080; margin-top: 3px; }

        .form-max { max-width: 820px; margin: 0 auto; }

        .form-grid-2 { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 18px; }
        .form-divider { margin: 28px 0; border: none; border-top: 1px dashed rgba(59,130,246,0.15); }

        /* Alat Row Card */
        .alat-row {
            background: rgba(59,130,246,0.04);
            border: 1px solid rgba(59,130,246,0.12);
            border-radius: 12px; overflow: hidden;
            margin-bottom: 10px;
        }
        .alat-row-body {
            padding: 16px; display: grid;
            grid-template-columns: 2fr 1fr; gap: 14px; align-items: end;
        }
        .sub-label {
            font-size: 0.68rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.5px; color: #3d5270; display: block; margin-bottom: 6px;
        }

        /* Add Row Button */
        .btn-add-row {
            width: 100%; padding: 12px;
            background: rgba(59,130,246,0.05);
            border: 1px dashed rgba(59,130,246,0.2);
            border-radius: 10px;
            color: #4e6080; font-size: 0.855rem; font-weight: 600;
            cursor: pointer; transition: all 0.2s; margin-top: 6px;
            font-family: inherit;
        }
        .btn-add-row:hover { background: rgba(59,130,246,0.1); color: #60a5fa; border-color: rgba(59,130,246,0.35); }

        /* Remove button inside row */
        .btn-remove-row {
            width: 40px; height: 44px; border-radius: 9px; flex-shrink: 0;
            background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.18);
            color: #f87171; cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .btn-remove-row:hover { background: rgba(239,68,68,0.18); }
        .btn-remove-row svg { width: 15px; height: 15px; }

        /* Ref Code input */
        .ref-input {
            font-family: 'Courier New', monospace !important;
            font-weight: 700 !important; color: #60a5fa !important;
            background: rgba(59,130,246,0.04) !important;
        }

        .form-footer { margin-top: 28px; display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap; }

        /* Dark Mode Select Options Fix */
        select.form-control {
            background-color: rgba(15, 23, 42, 0.4);
            color: #f1f5f9;
        }
        select.form-control option {
            background-color: #0d1e3b;
            color: #f1f5f9;
            padding: 12px;
        }
        
        .form-control:focus {
            border-color: #3b82f6;
            background-color: rgba(15, 23, 42, 0.6);
            box-shadow: 0 0 0 4px rgba(59,130,246,0.15);
        }

        .form-label {
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.85rem;
        }
    </style>

    <div class="page-hdr">
        <h1>Ajukan Peminjaman Alat</h1>
        <p>Lengkapi formulir di bawah ini. Permintaan Anda akan diverifikasi oleh petugas.</p>
    </div>

    {{-- Flash & Errors --}}
    @if(session('error'))
        <div class="alert alert-error">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-error">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <ul style="list-style:none; padding:0; margin:0;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="form-max">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Formulir Pengajuan</div>
                    <div class="card-subtitle">Isi detail peminjaman Anda</div>
                </div>
                <a href="{{ route('peminjam.peminjamans.index') }}" class="btn btn-outline btn-sm">← Batal</a>
            </div>
            <div class="card-body">
                <form action="{{ route('peminjam.peminjamans.store') }}" method="POST">
                    @csrf

                    {{-- Date & Code --}}
                    <div class="form-grid-2">
                        <div class="form-group">
                            <label class="form-label">Kode Referensi (Otomatis)</label>
                            <input type="text" name="kode_peminjaman" value="{{ $kode }}" readonly class="form-control ref-input">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="tgl_pinjam">Rencana Tanggal Pinjam</label>
                            <input type="date" name="tgl_pinjam" id="tgl_pinjam" value="{{ date('Y-m-d') }}" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tgl_kembali_rencana">Rencana Tanggal Pengembalian</label>
                        <input type="date" name="tgl_kembali_rencana" id="tgl_kembali_rencana" required class="form-control">
                    </div>

                    <hr class="form-divider">

                    {{-- Alat List --}}
                    <div class="form-group">
                        <label class="form-label" style="margin-bottom: 14px;">Daftar Alat yang Dipinjam</label>

                        <div id="alat-container">
                            <div class="alat-row">
                                <div class="alat-row-body">
                                    <div>
                                        <span class="sub-label">Pilih Aset dari Katalog</span>
                                        <select name="alat_id[]" required class="form-control">
                                            <option value="" disabled selected>Pilih aset…</option>
                                            @foreach($alats as $alat)
                                            <option value="{{ $alat->id }}" {{ request('alat_id') == $alat->id ? 'selected' : '' }}>
                                                [{{ optional($alat->kategori)->nama_kategori }}] {{ $alat->nama_alat }} — Tersedia: {{ $alat->stok_tersedia }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <span class="sub-label">Jumlah Unit</span>
                                        <input type="number" name="jumlah[]" value="1" min="1" required class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="addAlatRow()" class="btn-add-row">
                            + Tambah Aset Lainnya
                        </button>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="keterangan">Tujuan / Keterangan Peminjaman</label>
                        <textarea name="keterangan" id="keterangan" rows="3"
                            placeholder="Contoh: Digunakan untuk keperluan presentasi di Ruang Seminar."
                            class="form-control" style="resize: vertical;">{{ old('keterangan') }}</textarea>
                    </div>

                    <div class="form-footer">
                        <a href="{{ route('peminjam.alats') }}" class="btn btn-outline btn-sm">Lihat Katalog Alat</a>
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
    const alats = @json($alats->map(fn($a) => ['id' => $a->id, 'nama' => '[' . optional($a->kategori)->nama_kategori . '] ' . $a->nama_alat . ' — Tersedia: ' . $a->stok_tersedia]));

    function addAlatRow() {
        const opts = alats.map(a => `<option value="${a.id}">${a.nama}</option>`).join('');
        const row = document.createElement('div');
        row.className = 'alat-row';
        row.innerHTML = `
            <div class="alat-row-body" style="grid-template-columns: 2fr 1fr auto;">
                <div>
                    <span class="sub-label">Pilih Aset dari Katalog</span>
                    <select name="alat_id[]" required class="form-control">
                        <option value="" disabled selected>Pilih aset…</option>${opts}
                    </select>
                </div>
                <div>
                    <span class="sub-label">Jumlah Unit</span>
                    <input type="number" name="jumlah[]" value="1" min="1" required class="form-control">
                </div>
                <div style="padding-top:22px;">
                    <button type="button" onclick="this.closest('.alat-row').remove()" class="btn-remove-row">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>`;
        document.getElementById('alat-container').appendChild(row);
    }
    </script>

</x-peminjam-layout>
