<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SmartPark</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            width: 380px;
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            color: white;
        }

        .form-control {
            background: rgba(255,255,255,0.1);
            border: none;
            color: white;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.15);
            color: white;
            box-shadow: none;
        }

        .btn-login {
            background: #3b82f6;
            border: none;
        }

        .btn-login:hover {
            background: #2563eb;
        }

        .btn-google {
            background: #ea4335;
            border: none;
        }

        .btn-google:hover {
            background: #d33c2d;
        }

        .logo {
            font-size: 40px;
            text-align: center;
            margin-bottom: 10px;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
        }

        a {
            color: #93c5fd;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
        .login-card:hover {
    transform: scale(1.02);
    transition: 0.3s;
}
    </style>
</head>
<body>

<div class="login-card">

    <div class="logo">🚗</div>
    <h4 class="title">SmartPark Login</h4>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="d-flex justify-content-between mb-3">
            <div>
                <input type="checkbox" name="remember"> Remember
            </div>
            <a href="{{ route('password.request') }}">Forgot?</a>
        </div>

        <button class="btn btn-login w-100 mb-3">Login</button>

    </form>

    <div class="text-center mb-2">atau</div>

    <a href="{{ route('google.login') }}" 
   class="btn btn-google w-100 d-flex align-items-center justify-content-center gap-2">

    <!-- ICON GOOGLE -->
    <svg width="20" height="20" viewBox="0 0 48 48">
        <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.8 32.9 29.4 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3 0 5.7 1.1 7.8 2.9l5.7-5.7C34.5 6.1 29.6 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.7-.4-3.5z"/>
        <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 16.1 18.9 13 24 13c3 0 5.7 1.1 7.8 2.9l5.7-5.7C34.5 6.1 29.6 4 24 4 16.3 4 9.7 8.4 6.3 14.7z"/>
        <path fill="#4CAF50" d="M24 44c5.3 0 10.2-2 13.9-5.3l-6.4-5.2C29.5 35.3 26.9 36 24 36c-5.4 0-9.9-3.1-11.5-7.6l-6.6 5.1C9.6 39.6 16.3 44 24 44z"/>
        <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-1.1 3.1-3.3 5.7-6.1 7.3l6.4 5.2C39.5 36.9 44 30.9 44 24c0-1.3-.1-2.7-.4-3.5z"/>
    </svg>

    Login with Google
</a>

</div>

</body>
</html>