<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GEORYTHM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            width: 100%;
            max-width: 600px;
            padding: 60px 40px;
            border: 1px solid #1a1a1a;
            box-sizing: border-box;
            background-color: #fff;
            text-align: center;
        }

        .logo {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 30px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .logo .geo {
            color: #000;
        }

        .logo .rythm {
            color: #FFEA00;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 30px;
            font-weight: 700;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            position: relative;
        }

        input {
            width: 100%;
            padding: 15px 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background-color: #fff;
            box-sizing: border-box;
            color: #333;
        }

        input:focus {
            outline: none;
            border-color: #000;
        }

        input::placeholder {
            color: #999;
        }

        .footer-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            font-size: 14px;
        }

        .footer-links p {
            margin: 0;
            color: #333;
        }

        .footer-links a {
            color: #000;
            font-weight: 700;
            text-decoration: none;
        }

        .login-btn {
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 15px 40px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-btn:hover {
            background-color: #333;
        }

        .error-message {
            color: #ff0000;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <span class="geo">GEO</span><span class="rythm">RYTHM</span>
        </div>
        
        <h2>Login</h2>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="footer-links">
                <p>you haven't account? <a href="{{ route('register') }}">Register here</a></p>
                <button type="submit" class="login-btn">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
