@props(['title' => 'Page'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - Cheikh Keinde</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --accent: #f16529;
            --accent-soft: rgba(241, 101, 41, 0.12);
            --bg-color: #f3f4f6;
            --text-color: #000;
            --text-secondary: #333;
            --btn-bg: white;
            --btn-border: #bbb;
            --btn-primary-bg: #000;
            --btn-primary-text: #fff;
            --form-border: #ddd;
            --form-bg: #ffffff;
        }

        [data-theme="dark"] {
            --bg-color: #0a0a0a;
            --text-color: #fff;
            --text-secondary: #ccc;
            --btn-bg: #1a1a1a;
            --btn-border: #444;
            --btn-primary-bg: #fff;
            --btn-primary-text: #000;
            --form-border: #333;
            --form-bg: #111111;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: radial-gradient(circle at top left, rgba(241, 101, 41, 0.08), transparent 28%), var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            overflow-x: hidden;
            transition: background 0.4s ease, color 0.4s ease;
        }

        @media (pointer: fine) {
            body, body a, body button, body input, body textarea, body select, body label {
                cursor: none !important;
            }
            .cursor-dot {
                position: fixed;
                left: 0;
                top: 0;
                width: 8px;
                height: 8px;
                border-radius: 999px;
                background: var(--accent);
                box-shadow: 0 0 0 6px rgba(241, 101, 41, 0.14);
                pointer-events: none;
                z-index: 99999;
                transition: transform 0.18s ease, opacity 0.18s ease;
            }
            .cursor-ring {
                position: fixed;
                left: 0;
                top: 0;
                width: 34px;
                height: 34px;
                border-radius: 999px;
                border: 1.5px solid rgba(241, 101, 41, 0.55);
                pointer-events: none;
                z-index: 99998;
                transition: width 0.18s ease, height 0.18s ease, opacity 0.18s ease, border-color 0.18s ease;
            }
            .cursor-dot.is-active { transform: scale(1.6); }
            .cursor-ring.is-active {
                width: 48px;
                height: 48px;
                border-color: rgba(241, 101, 41, 0.9);
            }
        }

        /* Navbar fixed */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 28px 48px;
            background: var(--bg-color);
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        [data-theme="dark"] .navbar {
            border-bottom-color: rgba(255,255,255,0.05);
        }

        .logo { line-height: 1.15; text-decoration: none; }
        .logo-first {
            display: block;
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 400;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }
        .logo-last {
            display: block;
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 40px;
        }
        .nav-links a {
            position: relative;
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 400;
            color: var(--text-color);
            text-decoration: none;
            letter-spacing: 0.01em;
            transition: color 0.3s, opacity 0.3s;
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 100%;
            height: 2px;
            background: var(--accent);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.25s ease;
        }
        .nav-links a:hover {
            opacity: 1;
            color: var(--accent);
        }
        .nav-links a:hover::after { transform: scaleX(1); }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-connect {
            border: 1px solid var(--btn-border);
            background: var(--btn-bg);
            color: var(--text-color);
            padding: 10px 22px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.04em;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s;
            border-radius: 4px;
        }
        .btn-connect:hover {
            background: var(--accent);
            color: #111827;
            border-color: var(--accent);
        }

        /* Dark mode toggle */
        .theme-toggle {
            width: 40px;
            height: 40px;
            border: 1px solid var(--btn-border);
            background: var(--btn-bg);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        .theme-toggle:hover {
            border-color: var(--accent);
            background: rgba(241, 101, 41, 0.08);
        }
        .theme-toggle svg {
            width: 18px;
            height: 18px;
            fill: var(--text-color);
            transition: fill 0.3s;
        }
        .sun-icon { display: none; }
        .moon-icon { display: block; }
        [data-theme="dark"] .sun-icon { display: block; }
        [data-theme="dark"] .moon-icon { display: none; }

        /* Main content */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 120px 48px 80px;
        }

        .auth-content {
            width: 100%;
            max-width: 500px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 48px;
        }

        .auth-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 48px;
            font-weight: 400;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .auth-header p {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: var(--text-secondary);
            letter-spacing: 0.01em;
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--text-color);
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            padding: 12px 16px;
            border: 1px solid var(--form-border);
            background: var(--form-bg);
            color: var(--text-color);
            border-radius: 6px;
            transition: all 0.3s;
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: rgba(0, 0, 0, 0.5);
        }

        [data-theme="dark"] .form-group input::placeholder,
        [data-theme="dark"] .form-group textarea::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px var(--accent-soft);
        }

        [data-theme="dark"] .form-group input:focus,
        [data-theme="dark"] .form-group textarea:focus,
        [data-theme="dark"] .form-group select:focus {
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
            font-family: 'Inter', sans-serif;
        }

        .form-error {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: #d32f2f;
            margin-top: 4px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            flex-wrap: wrap;
        }

        .btn-primary-form {
            flex: 1;
            min-width: 150px;
            background: var(--btn-primary-bg);
            color: var(--btn-primary-text);
            padding: 14px 24px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-decoration: none;
            text-transform: uppercase;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }

        .btn-primary-form:hover {
            opacity: 0.85;
        }

        .btn-outline-form {
            flex: 1;
            min-width: 150px;
            border: 1px solid var(--btn-border);
            background: transparent;
            color: var(--text-color);
            padding: 14px 24px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.02em;
            text-decoration: none;
            text-transform: uppercase;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }

        .btn-outline-form:hover {
            border-color: var(--text-color);
            background: var(--bg-color);
        }

        .form-link {
            text-align: center;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            margin-top: 16px;
        }

        .form-link a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.3s;
        }

        .form-link a:hover {
            opacity: 0.6;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: var(--btn-primary-bg);
        }

        .checkbox-group label {
            font-size: 13px;
            font-weight: 400;
            text-transform: none;
            letter-spacing: 0;
            cursor: pointer;
            margin: 0;
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 20px 24px;
            }

            .nav-links {
                display: none;
            }

            .auth-container {
                padding: 100px 24px 60px;
            }

            .auth-content {
                max-width: 100%;
            }

            .auth-header h1 {
                font-size: 32px;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-primary-form,
            .btn-outline-form {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div id="cursor-dot" class="cursor-dot"></div>
    <div id="cursor-ring" class="cursor-ring"></div>
    <nav class="navbar">
        <a href="/" class="logo">
            <span class="logo-first">CHEIKH</span>
            <span class="logo-last">KEINDE</span>
        </a>

        <div class="nav-links">
            <a href="/#accueil">Accueil</a>
            <a href="/#apropos">À propos</a>
            <a href="/#cursus">Cursus</a>
            <a href="/#projets">Projets</a>
            <a href="/#contact">Contact</a>
        </div>

        <div class="nav-right">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-connect">Tableau de bord</a>
            @else
                <a href="{{ route('login') }}" class="btn-connect">Se connecter</a>
            @endauth
            <button class="theme-toggle" id="theme-toggle">
                <svg class="sun-icon" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                </svg>
                <svg class="moon-icon" viewBox="0 0 24 24">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                </svg>
            </button>
        </div>
    </nav>

    <div class="auth-container">
        <div class="auth-content">
            {{ $slot }}
        </div>
    </div>

    <script>
        // Theme toggle
        const themeToggle = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;

        // Check for saved theme preference
        const savedTheme = localStorage.getItem('theme') || 'light';
        if (savedTheme === 'dark') {
            htmlElement.setAttribute('data-theme', 'dark');
        }

        themeToggle.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            htmlElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });

        const cursorDot = document.getElementById('cursor-dot');
        const cursorRing = document.getElementById('cursor-ring');

        if (window.matchMedia('(pointer: fine)').matches && cursorDot && cursorRing) {
            let mouseX = window.innerWidth / 2;
            let mouseY = window.innerHeight / 2;
            let dotX = mouseX;
            let dotY = mouseY;

            document.addEventListener('mousemove', (event) => {
                mouseX = event.clientX;
                mouseY = event.clientY;
                cursorRing.style.left = (mouseX - cursorRing.offsetWidth / 2) + 'px';
                cursorRing.style.top = (mouseY - cursorRing.offsetHeight / 2) + 'px';
            });

            const animateCursor = () => {
                dotX += (mouseX - dotX) * 0.28;
                dotY += (mouseY - dotY) * 0.28;
                cursorDot.style.left = (dotX - cursorDot.offsetWidth / 2) + 'px';
                cursorDot.style.top = (dotY - cursorDot.offsetHeight / 2) + 'px';
                requestAnimationFrame(animateCursor);
            };

            animateCursor();

            document.querySelectorAll('a, button, input, textarea, select, label').forEach((element) => {
                element.addEventListener('mouseenter', () => {
                    cursorDot.classList.add('is-active');
                    cursorRing.classList.add('is-active');
                });
                element.addEventListener('mouseleave', () => {
                    cursorDot.classList.remove('is-active');
                    cursorRing.classList.remove('is-active');
                });
            });
        } else {
            cursorDot?.remove();
            cursorRing?.remove();
        }
    </script>
</body>
</html>
