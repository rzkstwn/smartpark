<!DOCTYPE html>
<html>
<head>
    <title>Verifikasi OTP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            background: #0f172a;
            color: white;
            font-family: sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background: #1e293b;
            padding: 30px;
            border-radius: 20px;
            text-align: center;
        }

        input {
            padding: 10px;
            border-radius: 10px;
            border: none;
            margin: 10px 0;
            width: 100%;
        }

        button {
            padding: 10px;
            background: #22c55e;
            border: none;
            color: white;
            border-radius: 10px;
            width: 100%;
        }
    </style>
</head>
<body>

<div class="card">
    <h3>🔐 Masukkan OTP</h3>

    <form method="POST" action="/verify-otp">
        @csrf
        <input type="text" name="otp" placeholder="Masukkan OTP">
        <button type="submit">Verifikasi</button>
    </form>

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif
</div>

</body>
</html>