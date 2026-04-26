<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Kendaraan</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- HTML5 QR -->
    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            font-family: 'Segoe UI', sans-serif;
            color: white;
        }

        .container-box {
            max-width: 500px;
            margin: auto;
            margin-top: 50px;
        }

        .card-scan {
            background: rgba(255,255,255,0.05);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            backdrop-filter: blur(10px);
            text-align: center;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 13px;
            color: #cbd5e1;
        }

        #reader {
            border-radius: 15px;
            overflow: hidden;
            margin-top: 15px;
        }

        #reader video {
            width: 100% !important;
            height: 300px !important;
            object-fit: cover;
        }

        .btn-back {
            background: #ef4444;
            color: white;
            border-radius: 10px;
        }

        .btn-back:hover {
            background: #dc2626;
        }

        .footer-text {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 10px;
        }
    </style>
</head>

<body>

<div class="container container-box">

    <!-- Tombol Kembali -->
    <a href="/dashboard" class="btn btn-back mb-3">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>

    <!-- Card -->
    <div class="card-scan">

        <div class="title">📷 Scan QR Kendaraan</div>
        <div class="subtitle">Arahkan kamera ke QR tiket parkir</div>

        <!-- Scanner -->
        <div id="reader"></div>

        <div id="status" class="footer-text">
            Menunggu scan QR...
        </div>

    </div>

</div>

<!-- FORM HIDDEN -->
<form id="formKeluar" action="/parkir/keluar" method="POST">
    @csrf
    <input type="hidden" name="qr_code" id="qr_code">
</form>

<script>
let sudahScan = false;

function onScanSuccess(decodedText) {

    if (sudahScan) return; // biar ga double scan
    sudahScan = true;

    document.getElementById('qr_code').value = decodedText;

    // 🔊 suara sukses
    let audio = new Audio('https://www.soundjay.com/buttons/sounds/button-3.mp3');
    audio.play();

    // ubah status
    document.getElementById('status').innerHTML = "QR berhasil di-scan, memproses...";

    // kirim form
    setTimeout(() => {
        document.getElementById('formKeluar').submit();
    }, 1000);
}

function onScanError(error) {
    // bisa dikosongkan
}

new Html5QrcodeScanner(
    "reader",
    {
        fps: 10,
        qrbox: 250
    }
).render(onScanSuccess, onScanError);
</script>

</body>
</html>