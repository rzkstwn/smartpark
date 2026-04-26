<!DOCTYPE html>
<html>
<head>
    <title>Parkir Masuk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome (Icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border-radius: 20px;
            background: rgba(30, 41, 59, 0.9);
            color: white;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border: none;
            border-radius: 12px;
            font-weight: bold;
        }

        .btn-primary:hover {
            transform: scale(1.02);
            opacity: 0.95;
        }

        .btn-back {
            background: #374151;
            border-radius: 10px;
            color: white;
            padding: 6px 12px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-back:hover {
            background: #4b5563;
        }

        select {
            background: #0f172a !important;
            color: white !important;
            border-radius: 10px;
            border: 1px solid #374151;
        }

        h3 {
            font-weight: bold;
        }

        .link-bottom a {
            text-decoration: none;
        }

        .link-bottom a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card p-4 w-100" style="max-width: 420px;">


        <!-- TITLE -->
        <h3 class="text-center mb-4">🚗 Kendaraan Masuk</h3>

        <!-- FORM -->
        <form action="{{ route('parkir.masuk') }}" method="POST">
            @csrf

            <!-- JENIS KENDARAAN -->
            <div class="mb-4">
                <label class="mb-2">Jenis Kendaraan</label>
                <select name="jenis_kendaraan" class="form-control">
                    <option value="motor">🏍 Motor</option>
                    <option value="mobil">🚗 Mobil</option>
                </select>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa fa-ticket-alt"></i> Generate Tiket Parkir
            </button>
        </form>

        <!-- NAVIGASI -->
        <div class="text-center mt-4 link-bottom">
            <a href="/scan" class="text-info">
                <i class="fa fa-qrcode"></i> Scan QR Kendaraan Keluar
            </a>
        </div>
        <!-- 🔙 BACK BUTTON -->
        <div class="text-center btn w-100">
            <a href="/dashboard" class="btn-back">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

    </div>

</div>

</body>
</html>