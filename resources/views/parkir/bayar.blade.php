<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>

    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            text-align: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            margin-top: 100px;
            background: white;
            color: black;
            padding: 30px;
            border-radius: 20px;
            display: inline-block;
            width: 320px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.4);
        }

        h1 {
            color: #16a34a;
        }

        button {
            padding: 12px;
            width: 100%;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border: none;
            color: white;
            border-radius: 12px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            transform: scale(1.03);
        }

        .info {
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

<div class="card">

    <h3>💳 Pembayaran Parkir</h3>

    <div class="info">ID Tiket: <b>#{{ $parkir->id }}</b></div>
    <div class="info">Durasi: <b>{{ $durasi }} Jam</b></div>

    <h1>Rp {{ number_format($biaya) }}</h1>

    <!-- 🔥 FORM KE CONTROLLER -->
    <form action="{{ route('bayar', $parkir->id) }}" method="POST">
    @csrf
    <button>
        💰 Bayar Sekarang
    </button>
</form>

</div>

</body>
</html>