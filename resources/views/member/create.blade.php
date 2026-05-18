<x-app-layout>
    <x-slot name="header">Tambah Member</x-slot>

    <div class="container-fluid" style="max-width: 800px;">
        <div class="card shadow-sm" style="border-radius: 14px; border: 1px solid #e5e7eb;">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold m-0 text-gray-800 dark:text-gray-100">Form Tambah Member</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('member.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px;">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px;">Nomor HP</label>
                            <input type="text" name="nomor_hp" class="form-control" placeholder="08xxxxxxxxxx">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px;">Plat Nomor</label>
                            <input type="text" name="plat_nomor" class="form-control" placeholder="B 1234 ABC" required style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px;">Jenis Kendaraan</label>
                            <select name="jenis_kendaraan" class="form-select" required>
                                <option value="motor">Motor</option>
                                <option value="mobil">Mobil</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px;">Kode RFID (Opsional)</label>
                            <input type="text" name="rfid_code" class="form-control" placeholder="Tap kartu di sini">
                            <small class="text-muted" style="font-size: 11px;">Tap kartu pada reader untuk mengisi otomatis.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px;">Masa Aktif Sampai</label>
                            <input type="date" name="masa_aktif_sampai" class="form-control" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('member.index') }}" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4" style="background-color: #3b82f6; border: none;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
