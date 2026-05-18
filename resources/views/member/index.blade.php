<x-app-layout>
    <x-slot name="header">Data Member</x-slot>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="m-0 fw-bold text-gray-800 dark:text-gray-100">Manajemen Member</h4>
            <a href="{{ route('member.create') }}" class="btn btn-primary shadow-sm" style="background-color: #3b82f6; border: none; border-radius: 8px;">
                <i class="fas fa-plus me-2"></i> Tambah Member
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 8px;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm" style="border-radius: 14px; border: 1px solid #e5e7eb;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background-color: #f8fafc;">
                            <tr>
                                <th class="text-secondary fw-semibold ps-4 py-3" style="font-size: 13px;">NAMA</th>
                                <th class="text-secondary fw-semibold py-3" style="font-size: 13px;">PLAT NOMOR</th>
                                <th class="text-secondary fw-semibold py-3" style="font-size: 13px;">KENDARAAN</th>
                                <th class="text-secondary fw-semibold py-3" style="font-size: 13px;">MASA AKTIF</th>
                                <th class="text-secondary fw-semibold text-center pe-4 py-3" style="font-size: 13px;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $m)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold text-gray-800 dark:text-gray-200">{{ $m->nama }}</div>
                                        <div class="text-muted" style="font-size: 12px;">{{ $m->nomor_hp }}</div>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge bg-light text-dark border px-2 py-1">{{ $m->plat_nomor }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge rounded-pill {{ $m->jenis_kendaraan == 'motor' ? 'bg-warning text-dark' : 'bg-info text-dark' }}">
                                            {{ ucfirst($m->jenis_kendaraan) }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        @php
                                            $isActive = \Carbon\Carbon::parse($m->masa_aktif_sampai)->isFuture();
                                        @endphp
                                        <div class="{{ $isActive ? 'text-success' : 'text-danger' }} fw-semibold" style="font-size: 13px;">
                                            {{ \Carbon\Carbon::parse($m->masa_aktif_sampai)->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="text-center pe-4 py-3">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('member.edit', $m->id) }}" class="btn btn-sm btn-light border text-primary" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('member.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus member ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light border text-danger" data-bs-toggle="tooltip" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-users mb-3 d-block" style="font-size: 32px; opacity: 0.3;"></i>
                                        Belum ada data member.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($members->hasPages())
                <div class="card-footer bg-white border-top py-3">
                    {{ $members->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
