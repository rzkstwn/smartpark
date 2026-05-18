<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kendaraan Masuk - SmartPark</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: linear-gradient(135deg, #0a0f1e 0%, #0f1f3d 50%, #0a1628 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow-y: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px 12px;
        }

        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: radial-gradient(circle, rgba(59,130,246,.12) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none; z-index: 0;
        }

        .orb { position: fixed; border-radius: 50%; filter: blur(80px); pointer-events: none; z-index: 0; }
        .orb-1 { width:350px; height:350px; background:#3b82f6; opacity:.10; top:-80px; left:-80px; }
        .orb-2 { width:250px; height:250px; background:#6366f1; opacity:.08; bottom:-60px; right:-60px; }

        .form-card {
            position: relative; z-index: 10;
            width: 100%; max-width: 440px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 20px;
            padding: 24px 24px;
            box-shadow: 0 25px 60px rgba(0,0,0,.5), inset 0 1px 0 rgba(255,255,255,.06);
        }

        .brand-icon {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 10px;
            box-shadow: 0 8px 24px rgba(16,185,129,.35);
        }

        .brand-icon i { font-size: 18px; }

        .brand-title { font-size: 17px; font-weight: 700; color: #f1f5f9; text-align: center; letter-spacing: -.3px; }
        .brand-sub   { font-size: 11px; color: #475569; text-align: center; margin-top: 2px; margin-bottom: 16px; }

        .clock-row {
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.07);
            border-radius: 10px; padding: 8px 12px;
            margin-bottom: 16px;
            font-size: 11px;
        }
        .clock-row .ctime { font-weight: 700; color: #cbd5e1; font-variant-numeric: tabular-nums; }
        .clock-row .cdate { color: #475569; }

        .sec-label {
            font-size: 10px; font-weight: 600; color: #475569;
            text-transform: uppercase; letter-spacing: .7px;
            margin-bottom: 6px;
        }

        .vehicle-opts { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 14px; }
        .vehicle-opt input[type="radio"] { display: none; }
        .vehicle-opt label {
            display: flex; flex-direction: column; align-items: center;
            justify-content: center; gap: 4px;
            padding: 10px 8px;
            background: rgba(255,255,255,.04);
            border: 1.5px solid rgba(255,255,255,.08);
            border-radius: 12px; cursor: pointer;
            transition: all .2s; color: #64748b;
            font-size: 12px; font-weight: 500;
        }
        .vehicle-opt label .icon-box {
            width: 32px; height: 32px; border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; background: rgba(255,255,255,.06);
            transition: all .2s;
        }
        .vehicle-opt label:hover { border-color: rgba(255,255,255,.16); background: rgba(255,255,255,.07); color: #e2e8f0; }
        .vehicle-opt input[value="motor"]:checked + label { border-color: #f59e0b; background: rgba(245,158,11,.10); color: #fbbf24; }
        .vehicle-opt input[value="motor"]:checked + label .icon-box { background: rgba(245,158,11,.2); color: #f59e0b; }
        .vehicle-opt input[value="mobil"]:checked + label { border-color: #8b5cf6; background: rgba(139,92,246,.10); color: #a78bfa; }
        .vehicle-opt input[value="mobil"]:checked + label .icon-box { background: rgba(139,92,246,.2); color: #8b5cf6; }

        .form-input {
            width: 100%;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 10px;
            padding: 10px 40px 10px 36px;
            color: #f1f5f9; font-size: 12px;
            font-family: 'Inter', sans-serif;
            outline: none; transition: all .2s;
            letter-spacing: .5px;
            text-transform: uppercase;
        }
        .form-input::placeholder { color: #334155; text-transform: none; }
        .form-input:focus {
            border-color: #10b981;
            background: rgba(16,185,129,.06);
            box-shadow: 0 0 0 3px rgba(16,185,129,.12);
        }
        .input-wrap { position: relative; margin-bottom: 12px; }
        .input-wrap .input-icon {
            position: absolute; left: 12px; top: 50%;
            transform: translateY(-50%); color: #334155; font-size: 12px; pointer-events: none;
        }
        .btn-cam {
            position: absolute; right: 8px; top: 50%;
            transform: translateY(-50%); 
            background: rgba(255,255,255,0.1); border:none;
            color: #94a3b8; border-radius: 6px; padding: 4px 8px;
            cursor: pointer; transition: all 0.2s; font-size: 12px;
        }
        .btn-cam:hover { background: #3b82f6; color: white; }

        .input-hint { font-size: 10px; color: #475569; margin-top: -8px; margin-bottom: 14px; }

        .info-strip {
            background: rgba(16,185,129,.08); border: 1px solid rgba(16,185,129,.2);
            border-radius: 8px; padding: 8px 12px;
            display: flex; align-items: flex-start; gap: 8px;
            margin-bottom: 16px;
        }
        .info-strip i { color: #10b981; font-size: 12px; flex-shrink: 0; margin-top: 1px; }
        .info-strip p { font-size: 10px; color: #6ee7b7; margin: 0; line-height: 1.4; }

        .btn-submit {
            width: 100%; padding: 11px;
            background: linear-gradient(135deg, #10b981, #059669);
            border: none; border-radius: 10px;
            color: white; font-size: 13px; font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer; transition: all .2s;
            box-shadow: 0 4px 15px rgba(16,185,129,.3);
            margin-bottom: 8px;
        }
        .btn-submit:hover { background: linear-gradient(135deg,#059669,#047857); transform: translateY(-1px); }

        .btn-member {
            width: 100%; padding: 11px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none; border-radius: 10px;
            color: white; font-size: 13px; font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer; transition: all .2s;
            box-shadow: 0 4px 15px rgba(37,99,235,.3);
            margin-bottom: 8px;
        }
        .btn-member:hover { background: linear-gradient(135deg,#2563eb,#1d4ed8); transform: translateY(-1px); }

        .divider { display: flex; align-items: center; gap: 8px; margin: 8px 0; color: #1e293b; font-size: 10px; }
        .divider::before, .divider::after { content:''; flex:1; height:1px; background: rgba(255,255,255,.07); }

        .btn-outline {
            width: 100%; padding: 9px;
            background: rgba(255,255,255,.05);
            border: 1px solid rgba(255,255,255,.1);
            border-radius: 10px; color: #64748b;
            font-size: 12px; font-weight: 500;
            font-family: 'Inter', sans-serif;
            cursor: pointer; transition: all .2s;
            text-decoration: none; display: block; text-align: center;
            margin-bottom: 8px;
        }
        .btn-outline:hover { background: rgba(255,255,255,.08); color: #94a3b8; border-color: rgba(255,255,255,.15); }

        .link-back {
            display: block; text-align: center;
            font-size: 11px; color: #475569;
            text-decoration: none; transition: color .2s;
        }
        .link-back:hover { color: #60a5fa; }

        /* MODALS */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.8); z-index: 100;
            display: none; align-items: center; justify-content: center;
        }
        .modal-box {
            background: #1e293b; padding: 20px; border-radius: 16px;
            width: 90%; max-width: 400px; text-align: center;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .modal-box h5 { color: white; font-size: 16px; margin-bottom: 10px; }
        .modal-box p { color: #94a3b8; font-size: 12px; margin-bottom: 20px; }
        .video-container { width: 100%; border-radius: 12px; overflow: hidden; margin-bottom: 15px; background: #000; position:relative; }
        video { width: 100%; height: auto; display: block; }
        #canvasOverlay { position:absolute; top:0; left:0; width:100%; height:100%; pointer-events:none; }
    </style>
</head>
<body>

<div class="orb orb-1"></div>
<div class="orb orb-2"></div>

<div class="form-card">

    <div class="brand-icon">
        <i class="fas fa-sign-in-alt" style="color:white; font-size:20px;"></i>
    </div>
    <div class="brand-title">Kendaraan Masuk</div>
    <div class="brand-sub">Isi data kendaraan atau scan QR member</div>

    <div class="clock-row">
        <span class="cdate" id="dateNow">--/--/----</span>
        <span class="ctime" id="clockNow">--:--:--</span>
    </div>

    <!-- Alert for Member Portal -->
    <div id="memberAlert" class="alert alert-success d-none" style="font-size: 11px; padding: 10px;">
        <strong>✅ <span id="memberName"></span></strong> (Member)<br>
        Portal terbuka otomatis! Memproses tiket...
    </div>

    <form action="{{ route('parkir.masuk') }}" method="POST" id="formMasuk">
        @csrf
        <input type="hidden" name="qr_code" id="qrCodeInput">

        <div class="sec-label"><i class="fas fa-hashtag me-1"></i>Plat Nomor Kendaraan</div>
        <div class="input-wrap">
            <i class="fas fa-car input-icon"></i>
            <input type="text" name="plat_nomor" class="form-control form-input" placeholder="Contoh: B 1234 ABC" maxlength="15" autocomplete="off" id="platInput">
            <button type="button" class="btn-cam" onclick="openCameraModal()" title="Scan Plat Nomor"><i class="fas fa-camera"></i></button>
        </div>
        <p class="input-hint"><i class="fas fa-info-circle me-1"></i>Kosongkan jika tidak diketahui — akan diisi otomatis.</p>

        <div class="sec-label"><i class="fas fa-car-side me-1"></i>Jenis Kendaraan</div>
        <div class="vehicle-opts">
            <div class="vehicle-opt">
                <input type="radio" name="jenis_kendaraan" id="motor" value="motor" checked>
                <label for="motor">
                    <div class="icon-box"><i class="fas fa-motorcycle"></i></div>
                    Motor
                </label>
            </div>
            <div class="vehicle-opt">
                <input type="radio" name="jenis_kendaraan" id="mobil" value="mobil">
                <label for="mobil">
                    <div class="icon-box"><i class="fas fa-car"></i></div>
                    Mobil
                </label>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <i class="fas fa-ticket-alt me-2"></i> Generate Tiket Parkir
        </button>

        <button type="button" class="btn-member" onclick="openQrModal()">
            <i class="fas fa-qrcode me-2"></i> Scan QR Member
        </button>
    </form>

    <div class="divider">atau</div>

    <a href="{{ route('parkir.scan') }}" class="btn-outline">
        <i class="fas fa-qrcode me-2"></i> Scan QR Kendaraan Keluar
    </a>

    <a href="/dashboard" class="link-back">
        <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
    </a>

</div>

<!-- Camera Modal -->
<div class="modal-overlay" id="cameraModal">
    <div class="modal-box">
        <h5>Scan Plat Nomor</h5>
        <p>Arahkan kamera ke plat nomor kendaraan.</p>
        <div class="video-container">
            <video id="videoFeed" autoplay playsinline></video>
            <canvas id="canvasOverlay"></canvas>
        </div>
        <button class="btn btn-primary w-100 mb-2" onclick="captureAndScan()" id="btnCapture">
            <i class="fas fa-camera"></i> Scan Sekarang
        </button>
        <button class="btn btn-outline-light w-100" onclick="closeCameraModal()">Batal</button>
    </div>
</div>

<!-- QR Modal -->
<div class="modal-overlay" id="qrModal">
    <div class="modal-box">
        <i class="fas fa-qrcode mb-3" style="font-size: 30px; color: #3b82f6;"></i>
        <h5>Scan QR Member</h5>
        <p>Silakan scan QR Member Anda ke reader atau kamera.</p>
        
        <!-- Video placeholder for QR Scanner -->
        <div id="qr-reader" style="width: 100%; border-radius: 12px; overflow: hidden; margin-bottom: 15px; display: none;"></div>

        <!-- Invisible input to capture QR scanner keyboard strokes -->
        <input type="text" id="qrListener" style="opacity:0; position:absolute; z-index:-1;">
        
        <button class="btn btn-primary w-100 mb-2" onclick="startQrCamera()" id="btnStartQrCam">
            <i class="fas fa-camera"></i> Gunakan Kamera
        </button>
        <button class="btn btn-outline-light w-100 mt-2" onclick="closeQrModal()">Batal</button>
    </div>
</div>

<!-- Verifikasi Member Modal -->
<div class="modal fade" id="verifikasiMemberModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none; background: #0f172a; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
            <div id="vmHeader" style="background: linear-gradient(135deg, #10b981, #059669); padding: 15px; text-align: center; color: white;">
                <h5 class="mb-0 fw-bold"><i class="fas fa-check-circle me-2"></i>MEMBER TERDETEKSI</h5>
            </div>
            <div class="modal-body p-4 text-white">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between border-bottom pb-2" style="border-color: rgba(255,255,255,0.1) !important;">
                        <span class="text-secondary" style="font-size: 13px;">Nama</span>
                        <span class="fw-bold" id="vmNama">-</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-2" style="border-color: rgba(255,255,255,0.1) !important;">
                        <span class="text-secondary" style="font-size: 13px;">Plat Nomor</span>
                        <span class="fw-bold" id="vmPlat">-</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-2" style="border-color: rgba(255,255,255,0.1) !important;">
                        <span class="text-secondary" style="font-size: 13px;">Jenis Kendaraan</span>
                        <span class="fw-bold" id="vmJenis">-</span>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-2" style="border-color: rgba(255,255,255,0.1) !important;">
                        <span class="text-secondary" style="font-size: 13px;">Status</span>
                        <span class="badge" id="vmStatus" style="font-size: 12px;">-</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary" style="font-size: 13px;">Masa Aktif</span>
                        <span class="fw-bold" id="vmExpired">-</span>
                    </div>
                </div>

                <div id="vmExpiredAlert" class="mt-4 p-3 rounded text-center d-none" style="background: rgba(239,68,68,0.15); border: 1px solid rgba(239,68,68,0.3); color: #fca5a5;">
                    <i class="fas fa-exclamation-triangle me-2 mb-2" style="font-size: 24px;"></i><br>
                    <strong>Masa aktif member Anda telah habis.</strong><br>
                    <small>Silakan perpanjang atau gunakan parkir reguler.</small>
                </div>
                
                <div id="vmActiveAlert" class="mt-4 p-3 rounded text-center" style="background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.3); color: #6ee7b7;">
                    <i class="fas fa-shield-check me-2 mb-2" style="font-size: 24px;"></i><br>
                    <strong>Akses Parkir Diizinkan</strong><br>
                    <small>Portal terbuka otomatis...</small>
                </div>
            </div>
            <div class="modal-footer border-top-0 d-flex justify-content-center p-3 pb-4" id="vmFooter">
                <!-- Buttons injected dynamically -->
            </div>
        </div>
    </div>
</div>

<!-- Tesseract.js & Html5Qrcode & Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tesseract.js@4/dist/tesseract.min.js"></script>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    // Auto-uppercase plat
    const platInput = document.getElementById('platInput');
    platInput.addEventListener('input', function() {
        const pos = this.selectionStart;
        this.value = this.value.toUpperCase();
        this.setSelectionRange(pos, pos);
    });

    // Clock
    function updateClock() {
        const n = new Date();
        const p = v => String(v).padStart(2, '0');
        document.getElementById('clockNow').textContent = `${p(n.getHours())}:${p(n.getMinutes())}:${p(n.getSeconds())}`;
        document.getElementById('dateNow').textContent  = `${p(n.getDate())}/${p(n.getMonth()+1)}/${n.getFullYear()}`;
    }
    updateClock();
    setInterval(updateClock, 1000);

    /* --- CAMERA SCANNING LOGIC --- */
    let videoStream = null;
    const videoFeed = document.getElementById('videoFeed');

    function openCameraModal() {
        document.getElementById('cameraModal').style.display = 'flex';
        navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } })
            .then(stream => {
                videoStream = stream;
                videoFeed.srcObject = stream;
            })
            .catch(err => {
                alert("Tidak dapat mengakses kamera: " + err);
                closeCameraModal();
            });
    }

    function closeCameraModal() {
        document.getElementById('cameraModal').style.display = 'none';
        if (videoStream) {
            videoStream.getTracks().forEach(track => track.stop());
            videoStream = null;
        }
    }

    async function captureAndScan() {
        const btn = document.getElementById('btnCapture');
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Membaca...';
        btn.disabled = true;

        const canvas = document.createElement('canvas');
        canvas.width = videoFeed.videoWidth;
        canvas.height = videoFeed.videoHeight;
        canvas.getContext('2d').drawImage(videoFeed, 0, 0, canvas.width, canvas.height);

        try {
            const result = await Tesseract.recognize(canvas, 'eng');
            let text = result.data.text.replace(/[^A-Z0-9\s]/gi, '').trim().toUpperCase();
            
            if(text.length > 2) {
                document.getElementById('platInput').value = text;
                alert("Plat nomor berhasil dibaca: " + text);
            } else {
                alert("Plat nomor tidak terbaca jelas. Coba lagi.");
            }
        } catch (err) {
            alert("Error saat membaca gambar.");
        }

        btn.innerHTML = '<i class="fas fa-camera"></i> Scan Sekarang';
        btn.disabled = false;
        closeCameraModal();
    }

    /* --- QR LOGIC --- */
    let qrTimeout;
    const qrListener = document.getElementById('qrListener');
    let html5QrCode = null;

    function openQrModal() {
        document.getElementById('qrModal').style.display = 'flex';
        qrListener.value = '';
        qrListener.focus();
    }

    function closeQrModal() {
        document.getElementById('qrModal').style.display = 'none';
        if (html5QrCode) {
            html5QrCode.stop().then(() => {
                html5QrCode.clear();
                html5QrCode = null;
            }).catch(err => console.log(err));
        }
        document.getElementById('qr-reader').style.display = 'none';
        document.getElementById('btnStartQrCam').style.display = 'block';
    }

    function startQrCamera() {
        document.getElementById('qr-reader').style.display = 'block';
        document.getElementById('btnStartQrCam').style.display = 'none';
        
        html5QrCode = new Html5Qrcode("qr-reader");
        html5QrCode.start(
            { facingMode: "environment" }, 
            {
                fps: 10,
                qrbox: { width: 250, height: 250 }
            },
            (decodedText, decodedResult) => {
                if (html5QrCode) {
                    html5QrCode.stop().then((ignore) => {
                        html5QrCode.clear();
                        html5QrCode = null;
                    }).catch(err => console.log(err));
                }
                document.getElementById('qr-reader').style.display = 'none';
                document.getElementById('btnStartQrCam').style.display = 'block';
                processMemberCheck(decodedText);
            },
            (errorMessage) => {
                // ignore errors during scan
            })
        .catch((err) => {
            alert("Gagal mengakses kamera QR: " + err);
            document.getElementById('qr-reader').style.display = 'none';
            document.getElementById('btnStartQrCam').style.display = 'block';
        });
    }

    // Keep focus on hidden input when modal is open
    document.getElementById('qrModal').addEventListener('click', function(e) {
        if(e.target.id === 'qrModal') {
            qrListener.focus();
        }
    });

    qrListener.addEventListener('input', function() {
        clearTimeout(qrTimeout);
        qrTimeout = setTimeout(() => {
            const code = qrListener.value.trim();
            if(code.length > 3) {
                processMemberCheck(code);
            }
            qrListener.value = '';
        }, 300); // Wait 300ms after last stroke
    });

    function playTTS(text) {
        if ('speechSynthesis' in window) {
            window.speechSynthesis.cancel();
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'id-ID';
            utterance.rate = 1.0;
            window.speechSynthesis.speak(utterance);
        }
    }

    function processMemberCheck(code) {
        document.getElementById('qrCodeInput').value = code;
        closeQrModal();

        fetch('/api/member/check', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ identifier: code })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                const member = data.member;
                
                // Auto fill form
                document.getElementById('platInput').value = member.plat_nomor;
                document.getElementById(member.jenis_kendaraan).checked = true;

                // Setup Verifikasi Modal
                document.getElementById('vmNama').textContent = member.nama;
                document.getElementById('vmPlat').textContent = member.plat_nomor;
                document.getElementById('vmJenis').innerHTML = member.jenis_kendaraan === 'motor' ? '<i class="fas fa-motorcycle me-1"></i> Motor' : '<i class="fas fa-car me-1"></i> Mobil';
                document.getElementById('vmExpired').textContent = member.masa_aktif_sampai;
                
                const vmHeader = document.getElementById('vmHeader');
                const vmStatus = document.getElementById('vmStatus');
                const vmActiveAlert = document.getElementById('vmActiveAlert');
                const vmExpiredAlert = document.getElementById('vmExpiredAlert');
                const vmFooter = document.getElementById('vmFooter');

                var vmModal = new bootstrap.Modal(document.getElementById('verifikasiMemberModal'));

                if (member.is_active) {
                    // Active Member
                    vmHeader.style.background = 'linear-gradient(135deg, #10b981, #059669)';
                    vmHeader.innerHTML = '<h5 class="mb-0 fw-bold"><i class="fas fa-check-circle me-2"></i>MEMBER TERDETEKSI</h5>';
                    
                    vmStatus.className = 'badge bg-success';
                    vmStatus.textContent = 'AKTIF';
                    
                    vmActiveAlert.classList.remove('d-none');
                    vmExpiredAlert.classList.add('d-none');
                    
                    vmFooter.innerHTML = ''; // Auto submit doesn't need buttons usually, but we can add one just in case
                    
                    playTTS("Member valid, silakan masuk");
                    
                    vmModal.show();
                    
                    // Auto submit form to generate ticket after showing card
                    setTimeout(() => {
                        document.getElementById('formMasuk').submit();
                    }, 2500);
                    
                } else {
                    // Expired Member
                    vmHeader.style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
                    vmHeader.innerHTML = '<h5 class="mb-0 fw-bold"><i class="fas fa-times-circle me-2"></i>MEMBER EXPIRED</h5>';
                    
                    vmStatus.className = 'badge bg-danger';
                    vmStatus.textContent = 'EXPIRED';
                    
                    vmActiveAlert.classList.add('d-none');
                    vmExpiredAlert.classList.remove('d-none');
                    
                    vmFooter.innerHTML = `
                        <button type="button" class="btn btn-outline-light w-100 mb-2" onclick="document.getElementById('formMasuk').submit();">Masuk Reguler (Bayar)</button>
                        <button type="button" class="btn btn-danger w-100" data-bs-dismiss="modal">Tutup & Perpanjang</button>
                    `;
                    
                    playTTS("Masa aktif member habis. Silakan perpanjang atau gunakan parkir reguler.");
                    
                    vmModal.show();
                }
            } else {
                const vmHeader = document.getElementById('vmHeader');
                const vmStatus = document.getElementById('vmStatus');
                const vmActiveAlert = document.getElementById('vmActiveAlert');
                const vmExpiredAlert = document.getElementById('vmExpiredAlert');
                const vmFooter = document.getElementById('vmFooter');

                var vmModal = new bootstrap.Modal(document.getElementById('verifikasiMemberModal'));

                // Reset content
                document.getElementById('vmNama').textContent = '-';
                document.getElementById('vmPlat').textContent = '-';
                document.getElementById('vmJenis').textContent = '-';
                document.getElementById('vmExpired').textContent = '-';

                vmHeader.style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
                vmHeader.innerHTML = '<h5 class="mb-0 fw-bold"><i class="fas fa-times-circle me-2"></i>QR CODE TIDAK VALID</h5>';
                
                vmStatus.className = 'badge bg-secondary';
                vmStatus.textContent = 'TIDAK DITEMUKAN';
                
                vmActiveAlert.classList.add('d-none');
                
                vmExpiredAlert.className = 'mt-4 p-3 rounded text-center';
                vmExpiredAlert.innerHTML = `
                    <i class="fas fa-question-circle me-2 mb-2" style="font-size: 24px;"></i><br>
                    <strong>Data member tidak ditemukan.</strong><br>
                    <small>Silakan gunakan parkir reguler tanpa kartu member.</small>
                `;
                
                vmFooter.innerHTML = `
                    <button type="button" class="btn btn-outline-light w-100 mb-2" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary w-100" style="background: linear-gradient(135deg, #3b82f6, #2563eb); border: none;" onclick="document.getElementById('formMasuk').submit();">Generate Tiket Parkir (Reguler)</button>
                `;
                
                playTTS("QR code tidak valid atau data tidak ditemukan.");
                vmModal.show();
            }
        }).catch(err => {
            console.error(err);
            alert("Terjadi kesalahan jaringan.");
        });
    }
</script>

</body>
</html>