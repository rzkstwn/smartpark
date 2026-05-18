<x-app-layout>
    <x-slot name="header">Edit Member</x-slot>

    <div class="container-fluid" style="max-width: 800px;">
        <div class="card shadow-sm" style="border-radius: 14px; border: 1px solid #e5e7eb;">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h5 class="fw-bold m-0 text-gray-800 dark:text-gray-100">Form Edit Member</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('member.update', $member->id) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px;">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ $member->nama }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px;">Nomor HP</label>
                            <input type="text" name="nomor_hp" class="form-control" value="{{ $member->nomor_hp }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px;">Plat Nomor</label>
                            <input type="text" name="plat_nomor" class="form-control" value="{{ $member->plat_nomor }}" required style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px;">Jenis Kendaraan</label>
                            <select name="jenis_kendaraan" class="form-select" required>
                                <option value="motor" {{ $member->jenis_kendaraan == 'motor' ? 'selected' : '' }}>Motor</option>
                                <option value="mobil" {{ $member->jenis_kendaraan == 'mobil' ? 'selected' : '' }}>Mobil</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size: 13px;">Masa Aktif Sampai</label>
                            <input type="date" name="masa_aktif_sampai" class="form-control" value="{{ $member->masa_aktif_sampai }}" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                        <a href="{{ route('member.index') }}" class="btn btn-light border px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4" style="background-color: #3b82f6; border: none;">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
