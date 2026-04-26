<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Berhasil</title>

    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            text-align: center;
            font-family: 'Segoe UI', sans-serif;
            margin-top: 120px;
        }

        h2 {
            color: #22c55e;
            animation: pop 0.5s ease;
        }

        p {
            color: #94a3b8;
        }

        @keyframes pop {
            from { transform: scale(0.5); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .loader {
            margin: 20px auto;
            border: 5px solid #334155;
            border-top: 5px solid #22c55e;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>

<body>

    <h2>✅ Transaksi Berhasil</h2>
    <p>Mengarahkan ke struk...</p>

    <div class="loader"></div>

   <script>
    setTimeout(() => {
        window.location.href = "/struk/{{ $parkir->id }}";
    }, 2000);
</script>

</body>
</html>