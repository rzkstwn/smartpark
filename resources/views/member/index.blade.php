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
                                <th class="text-secondary fw-semibold text-center ps-4 py-3" style="font-size: 13px; width: 100px;">AKSI</th>
                                <th class="text-secondary fw-semibold py-3" style="font-size: 13px;">NAMA</th>
                                <th class="text-secondary fw-semibold py-3" style="font-size: 13px;">PLAT NOMOR</th>
                                <th class="text-secondary fw-semibold py-3" style="font-size: 13px;">KENDARAAN</th>
                                <th class="text-secondary fw-semibold pe-4 py-3" style="font-size: 13px;">MASA AKTIF</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $m)
                                @php
                                    $isActive = \Carbon\Carbon::parse($m->masa_aktif_sampai)->isFuture();
                                @endphp
                                <tr>
                                    <td class="text-center ps-4 py-3">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-sm btn-light border text-success" data-bs-toggle="tooltip" title="Lihat Kartu" onclick="showMemberCard('{{ $m->qr_code }}', '{{ addslashes($m->nama) }}', '{{ $m->plat_nomor }}', '{{ ucfirst($m->jenis_kendaraan) }}', '{{ \Carbon\Carbon::parse($m->masa_aktif_sampai)->format('d M Y') }}', '{{ $isActive ? 'Aktif' : 'Nonaktif' }}')">
                                                <i class="fas fa-id-card"></i>
                                            </button>
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
                                    <td class="py-3">
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
                                    <td class="pe-4 py-3">
                                        <div class="{{ $isActive ? 'text-success' : 'text-danger' }} fw-semibold" style="font-size: 13px;">
                                            {{ \Carbon\Carbon::parse($m->masa_aktif_sampai)->format('d M Y') }}
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

    <!-- Modal Kartu Member -->
    <div class="modal fade" id="memberCardModal" tabindex="-1" aria-labelledby="memberCardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 16px; border: none; background: transparent;">
                
                <div class="modal-body p-0 d-flex justify-content-center">
                    
                    <!-- KARTU MEMBER DESIGN -->
                    <div id="memberCard" style="width: 400px; background: linear-gradient(135deg, #0f172a, #1e293b); border-radius: 20px; overflow: hidden; position: relative; box-shadow: 0 20px 40px rgba(0,0,0,0.4); border: 1px solid rgba(255,255,255,0.1); font-family: 'Inter', sans-serif;">
                        <!-- Decorative Orbs -->
                        <div style="position: absolute; top: -50px; left: -50px; width: 150px; height: 150px; background: #3b82f6; filter: blur(60px); opacity: 0.4;"></div>
                        <div style="position: absolute; bottom: -50px; right: -50px; width: 150px; height: 150px; background: #10b981; filter: blur(60px); opacity: 0.3;"></div>
                        
                        <div class="p-4" style="position: relative; z-index: 10;">
                            <!-- Header -->
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3" style="border-color: rgba(255,255,255,0.1) !important;">
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(16,185,129,0.3);">
                                        <i class="fas fa-parking text-white" style="font-size: 18px;"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0 text-white fw-bold" style="letter-spacing: -0.5px;">SmartPark</h5>
                                        <div style="font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-top: -2px;">Member Card</div>
                                    </div>
                                </div>
                                <span id="cardStatus" class="badge bg-success" style="font-size: 10px; padding: 5px 10px; border-radius: 6px;">AKTIF</span>
                            </div>

                            <!-- Body -->
                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Info -->
                                <div style="color: #f8fafc; flex: 1;">
                                    <div class="mb-3">
                                        <div style="font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px;">Nama Member</div>
                                        <div id="cardName" style="font-size: 16px; font-weight: 600; line-height: 1.2;">John Doe</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <div style="font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px;">Kendaraan</div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span id="cardPlat" style="background: rgba(255,255,255,0.1); padding: 4px 8px; border-radius: 6px; font-size: 14px; font-weight: 600; border: 1px solid rgba(255,255,255,0.05); font-variant-numeric: tabular-nums;">B 1234 ABC</span>
                                            <span id="cardJenis" style="font-size: 12px; color: #cbd5e1;"><i class="fas fa-car me-1"></i>Mobil</span>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div style="font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px;">Masa Aktif</div>
                                        <div id="cardExpiry" style="font-size: 13px; font-weight: 500; color: #38bdf8;">12 Dec 2026</div>
                                    </div>
                                </div>

                                <!-- QR -->
                                <div style="background: white; padding: 10px; border-radius: 12px; box-shadow: 0 10px 20px rgba(0,0,0,0.2);">
                                    <div id="qrcodeCard"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END KARTU MEMBER -->

                </div>
                
                <div class="modal-footer justify-content-center border-top-0 pt-0 mt-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-info text-white rounded-pill px-4 shadow" onclick="printCard()" style="background: linear-gradient(135deg, #0ea5e9, #0284c7); border: none;">
                        <i class="fas fa-print me-2"></i> Cetak Kartu
                    </button>
                    <button type="button" class="btn btn-primary rounded-pill px-4 shadow" onclick="downloadCard()" style="background: linear-gradient(135deg, #3b82f6, #2563eb); border: none;">
                        <i class="fas fa-download me-2"></i> Download Kartu
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        let qrcodeCard = null;

        function showMemberCard(code, name, plat, jenis, expiry, status) {
            document.getElementById('cardName').innerText = name;
            document.getElementById('cardPlat').innerText = plat;
            document.getElementById('cardExpiry').innerText = expiry;
            
            let icon = jenis.toLowerCase() === 'motor' ? '<i class="fas fa-motorcycle me-1"></i>' : '<i class="fas fa-car me-1"></i>';
            document.getElementById('cardJenis').innerHTML = icon + jenis;
            
            let statusBadge = document.getElementById('cardStatus');
            if(status === 'Aktif') {
                statusBadge.className = 'badge bg-success';
                statusBadge.innerText = 'AKTIF';
            } else {
                statusBadge.className = 'badge bg-danger';
                statusBadge.innerText = 'NONAKTIF';
            }
            
            // Generate QR Code
            document.getElementById('qrcodeCard').innerHTML = "";
            qrcodeCard = new QRCode(document.getElementById("qrcodeCard"), {
                text: code,
                width: 100,
                height: 100,
                colorDark : "#0f172a",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
            
            var myModal = new bootstrap.Modal(document.getElementById('memberCardModal'));
            myModal.show();
        }

        function downloadCard() {
            const card = document.getElementById('memberCard');
            const btn = event.currentTarget;
            const originalHTML = btn.innerHTML;
            
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
            btn.disabled = true;

            html2canvas(card, {
                scale: 3, // High resolution
                backgroundColor: null,
                useCORS: true
            }).then(canvas => {
                let link = document.createElement('a');
                link.download = 'MemberCard_' + document.getElementById('cardName').innerText.replace(/\s+/g, '_') + '.png';
                link.href = canvas.toDataURL("image/png");
                link.click();
                
                btn.innerHTML = '<i class="fas fa-check me-2"></i> Berhasil';
                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;
                }, 2000);
            }).catch(err => {
                alert("Gagal mengunduh kartu.");
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            });
        }

        function printCard() {
            const cardElement = document.getElementById('memberCard');
            
            // Render to canvas first so it retains exact styling
            html2canvas(cardElement, {
                scale: 2,
                useCORS: true
            }).then(canvas => {
                const imgData = canvas.toDataURL("image/png");
                
                // Create a popup window for printing
                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Cetak Kartu Member - ${document.getElementById('cardName').innerText}</title>
                            <style>
                                body { 
                                    margin: 0; 
                                    display: flex; 
                                    justify-content: center; 
                                    align-items: center; 
                                    min-height: 100vh; 
                                    background: white; 
                                }
                                img {
                                    max-width: 100%;
                                    height: auto;
                                    border-radius: 12px;
                                }
                                @media print {
                                    @page { margin: 0; size: auto; }
                                    body { margin: 1cm; align-items: flex-start; }
                                }
                            </style>
                        </head>
                        <body>
                            <img src="${imgData}" onload="window.print(); window.close();" />
                        </body>
                    </html>
                `);
                printWindow.document.close();
            });
        }
    </script>
    @endpush
</x-app-layout>
