<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GEORYTHM</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Dark mode no-flash initializer -->
    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
    <style>
        :root {
            --bg-page: #f8f9fa;
            --bg-card: #ffffff;
            --border-color: #e0e0e0;
            --text-main: #333;
            --text-title: #1a1a1a;
            --text-muted: #888;
            --input-bg: #fff;
            --input-border: #ccc;
            --btn-bg: #000;
            --btn-text: #fff;
            --btn-hover: #333;
        }

        html.dark {
            --bg-page: #111827;
            --bg-card: #1f2937;
            --border-color: #374151;
            --text-main: #e5e7eb;
            --text-title: #ffffff;
            --text-muted: #9ca3af;
            --input-bg: #374151;
            --input-border: #4b5563;
            --btn-bg: #FFEA00;
            --btn-text: #000;
            --btn-hover: #e6d400;
        }

        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-page);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            transition: background-color 0.3s, color 0.3s;
            color: var(--text-main);
        }

        /* Theme toggle button */
        #theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-main);
            font-size: 20px;
            transition: all 0.3s;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }
        #theme-toggle:hover {
            transform: scale(1.1);
            border-color: #FFEA00;
        }

        .login-container {
            width: 100%;
            max-width: 600px;
            padding: 60px 40px;
            border: 1px solid var(--border-color);
            box-sizing: border-box;
            background-color: var(--bg-card);
            text-align: center;
            border-radius: 12px;
            transition: all 0.3s;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 30px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .logo .geo {
            color: var(--text-title);
        }

        .logo .rythm {
            color: #FFEA00;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 30px;
            font-weight: 700;
            color: var(--text-title);
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
            border: 1px solid var(--input-border);
            border-radius: 8px;
            font-size: 16px;
            background-color: var(--input-bg);
            box-sizing: border-box;
            color: var(--text-main);
            transition: all 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #FFEA00;
        }

        input::placeholder {
            color: var(--text-muted);
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
            color: var(--text-main);
        }

        .footer-links a {
            color: #FFEA00;
            font-weight: 700;
            text-decoration: none;
        }

        .login-btn {
            background-color: var(--btn-bg);
            color: var(--btn-text);
            border: none;
            border-radius: 8px;
            padding: 15px 40px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }

        .login-btn:hover {
            background-color: var(--btn-hover);
        }

        .error-message {
            color: #ef4444;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <button id="theme-toggle" title="Toggle theme">
        <i id="icon-sun" class="fa-solid fa-sun" style="display:none;"></i>
        <i id="icon-moon" class="fa-solid fa-moon"></i>
    </button>

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
                <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                <button type="submit" class="login-btn">Login</button>
            </div>
        </form>
    </div>

    <script>
        (function() {
            const btn      = document.getElementById('theme-toggle');
            const iconSun  = document.getElementById('icon-sun');
            const iconMoon = document.getElementById('icon-moon');
            const html     = document.documentElement;

            function applyTheme(isDark) {
                if (isDark) {
                    html.classList.add('dark');
                    iconSun.style.display  = 'inline';
                    iconMoon.style.display = 'none';
                } else {
                    html.classList.remove('dark');
                    iconSun.style.display  = 'none';
                    iconMoon.style.display = 'inline';
                }
            }

            // Sync icon on load
            applyTheme(html.classList.contains('dark'));

            btn.addEventListener('click', function() {
                const isDark = !html.classList.contains('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                applyTheme(isDark);
            });
        })();
    </script>
</body>
</html>
