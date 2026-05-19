<!DOCTYPE html>
<html>
<head>
    <title>Pembayaran</title>
    <!-- Midtrans Snap JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY', 'SB-Mid-client-YOUR_CLIENT_KEY') }}"></script>

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
        
        button:disabled {
            background: #94a3b8;
            cursor: not-allowed;
            transform: none;
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

    @if($parkir->member && \Carbon\Carbon::parse($parkir->member->masa_aktif_sampai)->isFuture())
        <div class="info" style="color: #10b981; font-weight: bold; margin-top:10px;">✅ Status: Member Aktif</div>
        <div class="info" style="color: #f59e0b; font-size:12px;">Portal akan terbuka otomatis</div>
        <h1 style="color: #10b981;">GRATIS</h1>
    @else
        <h1>Rp {{ number_format($biaya) }}</h1>
    @endif

    <!-- 🔥 FORM KE CONTROLLER -->
    <form id="payment-form" action="{{ route('bayar', $parkir->id) }}" method="POST">
        @csrf
        <button type="button" id="pay-button">
            @if($parkir->member && \Carbon\Carbon::parse($parkir->member->masa_aktif_sampai)->isFuture())
                🚀 Lanjutkan (Buka Portal)
            @else
                💰 Bayar Sekarang
            @endif
        </button>
    </form>

</div>

<script type="text/javascript">
    document.getElementById('pay-button').onclick = function () {
        @if(isset($snapToken) && $snapToken)
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    /* You may add your own implementation here */
                    document.getElementById('pay-button').innerHTML = 'Memproses...';
                    document.getElementById('pay-button').disabled = true;
                    document.getElementById('payment-form').submit();
                },
                onPending: function(result){
                    /* You may add your own implementation here */
                    alert("Menunggu pembayaran Anda!"); console.log(result);
                },
                onError: function(result){
                    /* You may add your own implementation here */
                    alert("Pembayaran gagal!"); console.log(result);
                },
                onClose: function(){
                    /* You may add your own implementation here */
                    alert('Anda menutup popup sebelum menyelesaikan pembayaran');
                }
            });
        @else
            // Jika gratis (misal member), langsung submit
            document.getElementById('pay-button').innerHTML = 'Memproses...';
            document.getElementById('pay-button').disabled = true;
            document.getElementById('payment-form').submit();
        @endif
    };
</script>

</body>
</html>