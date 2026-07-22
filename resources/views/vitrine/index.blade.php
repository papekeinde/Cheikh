<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>if(localStorage.getItem('theme')==='dark')document.documentElement.setAttribute('data-theme','dark');</script>

    <title>{{ optional($user)->nom ?? 'Cheikh Keinde' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { overflow-x: clip; scroll-behavior: smooth; }

        :root {
            --accent: #f16529;
            --bg-color: #f3f4f6;
            --text-color: #000;
            --text-secondary: #333;
            --btn-bg: white;
            --btn-border: #bbb;
            --btn-primary-bg: #000;
            --btn-primary-text: #fff;
        }

        [data-theme="dark"] {
            --bg-color: #0a0a0a;
            --text-color: #fff;
            --text-secondary: #ccc;
            --btn-bg: #1a1a1a;
            --btn-border: #444;
            --btn-primary-bg: #fff;
            --btn-primary-text: #000;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            overflow-x: hidden;
            transition: background 0.4s ease, color 0.4s ease;
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
        }

        .logo { line-height: 1.15; }
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

        /* === HERO === */
        .hero {
            height: 100vh;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 0 48px 40px 48px;
            overflow: visible;
        }

        /* Scroll sections */
        .scroll-section {
            height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* GPU-accelerate fixed overlay sections */
        #projets,
        #contact,
        .about-content,
        .cursus-text,
        .cursus-content,
        .stacks-section {
            will-change: transform, opacity;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .hero-photo {
            position: absolute;
            left: 0; top: 0;
            width: 45%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .hero-bottom {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            width: 100%;
        }

        /* Boutons gauche */
        .hero-cta {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex-shrink: 0;
        }
        .btn-outline {
            display: block;
            border: 1px solid var(--btn-border);
            background: var(--btn-bg);
            color: var(--text-color);
            padding: 13px 30px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
            text-decoration: none;
            letter-spacing: 0.02em;
            transition: all 0.3s;
        }
        .btn-outline:hover { border-color: var(--text-color); }

        .btn-primary {
            display: block;
            background: var(--btn-primary-bg);
            color: var(--btn-primary-text);
            padding: 13px 30px;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            letter-spacing: 0.02em;
            transition: all 0.3s;
        }
        .btn-primary:hover { opacity: 0.85; }

        /* Texte droite */
        .hero-text {
            display: inline-block;
            text-align: right;
            will-change: transform;
        }
        .hero-text.is-morphing {
            position: fixed;
            z-index: 30;
            text-align: left;
        }
        /* Wrapper clip pour le split couleur sur dark overlay */
        .hero-text-clip-wrapper {
            position: fixed;
            top: 0;
            right: 0;
            width: 0%;
            height: 100vh;
            overflow: hidden;
            z-index: 250;
            pointer-events: none;
        }
        .hero-text-clone {
            position: absolute;
            display: inline-block;
            text-align: left;
            pointer-events: none;
        }
        .hero-text-clone .hero-title,
        .hero-text-clone .hero-subtitle {
            display: block;
            width: 100%;
            color: #fff !important;
            opacity: 1 !important;
            transform: none !important;
        }
        .hero-text-clone .hero-char {
            transform: none !important;
        }
        .hero-title {
            display: block;
            width: 100%;
            font-family: 'Inter', sans-serif;
            font-size: clamp(5rem, 12vw, 14rem);
            font-weight: 900;
            line-height: 0.88;
            letter-spacing: -0.03em;
            text-transform: uppercase;
            opacity: 0;
            white-space: nowrap;
        }
        .hero-title .hero-char,
        .hero-subtitle .hero-char {
            display: inline-block;
            will-change: transform;
            transition: none;
        }
        .hero-subtitle {
            display: block;
            width: 100%;
            font-family: 'Playfair Display', serif;
            font-size: clamp(5rem, 12vw, 14rem);
            font-weight: 400;
            line-height: 0.88;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            margin-top: 4px;
            opacity: 0;
            white-space: nowrap;
        }

        /* Animation classes */
        .hero-cta a { opacity: 0; }
        .nav-links a, .logo, .nav-right { opacity: 0; }

        /* About text - appears after dark overlay */
        .about-text {
            position: fixed;
            z-index: 250;
            pointer-events: none;
            white-space: nowrap;
            opacity: 0;
        }
        .about-text .about-char {
            display: inline-block;
            font-family: 'Playfair Display', serif;
            font-size: clamp(4rem, 10vw, 11rem);
            font-weight: 400;
            line-height: 0.88;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            color: #fff;
        }

        /* About section content */
        .about-content {
            position: fixed;
            top: 50%;
            right: 48px;
            transform: translateY(-50%);
            z-index: 260;
            width: 42vw;
            max-width: 680px;
            opacity: 1;
            pointer-events: none;
        }
        .about-content p {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.1rem, 1.8vw, 1.55rem);
            font-weight: 400;
            line-height: 1.75;
            color: #fff;
            letter-spacing: 0.015em;
        }
        .about-word {
            display: inline-block;
            opacity: 0;
            transform: translateY(18px);
            will-change: opacity, transform;
        }

        /* Cursus text - same style as about text */
        .cursus-text {
            position: fixed;
            right: 48px;
            z-index: 265;
            pointer-events: none;
            white-space: nowrap;
            opacity: 0;
            overflow: visible;
        }
        .cursus-text .cursus-char {
            display: inline-block;
            font-family: 'Playfair Display', serif;
            font-size: clamp(4rem, 10vw, 11rem);
            font-weight: 400;
            line-height: 0.88;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            color: #fff;
        }

        /* Cursus section content */
        .cursus-content {
            position: fixed;
            top: 50%;
            left: 48px;
            transform: translateY(-50%);
            z-index: 260;
            width: 46vw;
            max-width: 750px;
            opacity: 0;
            pointer-events: none;
            max-height: 80vh;
            overflow-y: auto;
        }
        .cursus-content::-webkit-scrollbar { width: 4px; }
        .cursus-content::-webkit-scrollbar-track { background: transparent; }
        .cursus-content::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 2px; }
        .cursus-content h3 {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: rgba(255,255,255,0.5);
            margin-bottom: 20px;
        }
        .timeline-item {
            position: relative;
            padding-left: 24px;
            margin-bottom: 28px;
            border-left: 2px solid rgba(255,255,255,0.15);
        }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -5px;
            top: 6px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #fff;
        }
        .timeline-year {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: rgba(255,255,255,0.6);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .timeline-title {
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 2px;
        }
        .timeline-subtitle {
            font-family: 'Playfair Display', serif;
            font-size: 14px;
            font-style: italic;
            color: rgba(255,255,255,0.7);
            margin-bottom: 6px;
        }
        .timeline-desc {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 400;
            color: rgba(255,255,255,0.55);
            line-height: 1.6;
        }

        /* White wipe overlay (like dark overlay but from left) */
        .white-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 100vh;
            background: var(--bg-color);
            z-index: 280;
            pointer-events: none;
        }

        /* Stacks section */
        .stacks-section {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 290;
            pointer-events: none;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow: hidden;
            background: var(--bg-color);
            transform: translateY(100%);
        }
        .stacks-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(3rem, 8vw, 8rem);
            font-weight: 400;
            color: var(--text-color);
            text-transform: uppercase;
            letter-spacing: 0.02em;
            line-height: 1;
            padding: 0 48px;
            margin-bottom: 60px;
        }

        /* Marquee container */
        .marquee-wrapper {
            width: 100%;
            overflow: hidden;
            opacity: 0;
        }
        .marquee-track {
            display: flex;
            gap: 32px;
            width: max-content;
            animation: marquee-scroll 25s linear infinite;
        }
        .marquee-track:hover {
            animation-play-state: paused;
        }
        @keyframes marquee-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .stack-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 20px 32px;
            border: 1px solid #e5e5e5;
            border-radius: 60px;
            background: #fafafa;
            white-space: nowrap;
            flex-shrink: 0;
            transition: box-shadow 0.3s, border-color 0.3s;
            cursor: pointer;
            pointer-events: auto;
        }
        .stack-item:hover {
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            border-color: #ccc;
        }
        [data-theme="dark"] .stack-item {
            background: #1a1a1a;
            border-color: #333;
        }
        [data-theme="dark"] .stack-item:hover {
            border-color: #555;
            box-shadow: 0 8px 30px rgba(0,0,0,0.3);
        }
        .stack-item svg, .stack-item img {
            width: 32px;
            height: 32px;
            flex-shrink: 0;
        }
        .stack-item span {
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--text-color);
            letter-spacing: 0.02em;
        }

        /* Second marquee row — reverse direction */
        .marquee-track-reverse {
            display: flex;
            gap: 32px;
            width: max-content;
            animation: marquee-scroll-reverse 30s linear infinite;
            margin-top: 24px;
        }
        .marquee-track-reverse:hover {
            animation-play-state: paused;
        }
        @keyframes marquee-scroll-reverse {
            0% { transform: translateX(-50%); }
            100% { transform: translateX(0); }
        }

        /* Projects section */
        .projets-section {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 300;
            pointer-events: none;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background: #F16529;
            transform: translateY(100%);
            padding-top: 80px;
            box-sizing: border-box;
        }
        .projets-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 48px;
            margin-bottom: 16px;
            flex-shrink: 0;
        }
        .projets-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2rem, 5vw, 4.5rem);
            font-weight: 400;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            line-height: 1;
            margin: 0;
            flex-shrink: 0;
        }
        .projets-filters {
            display: flex;
            gap: 10px;
            flex-shrink: 0;
            pointer-events: auto;
        }
        .projets-filter-btn {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 8px 20px;
            border-radius: 30px;
            border: 2px solid #000;
            background: transparent;
            color: #000;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .projets-filter-btn:hover {
            background: rgba(0,0,0,0.1);
        }
        .projets-filter-btn.active {
            background: #000;
            color: #F16529;
        }
        .projets-filter-btn svg {
            width: 14px;
            height: 14px;
            fill: currentColor;
        }
        .projets-filter-count {
            font-size: 10px;
            font-weight: 800;
            background: rgba(241,101,41,0.3);
            color: #000;
            padding: 2px 7px;
            border-radius: 10px;
            margin-left: 2px;
        }
        .projets-filter-btn.active .projets-filter-count {
            background: rgba(241,101,41,0.6);
            color: #fff;
        }
        .projets-showcase {
            flex: 1;
            min-height: 0;
            display: flex;
            align-items: center;
            padding: 0 48px 32px;
            gap: 48px;
            pointer-events: auto;
        }
        .projet-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: 0;
            overflow-y: auto;
        }
        .projet-name {
            font-family: 'Inter', sans-serif;
            font-size: clamp(1.3rem, 2.5vw, 2.2rem);
            font-weight: 700;
            color: #000;
            margin-bottom: 16px;
            flex-shrink: 0;
        }
        .projet-desc {
            font-family: 'Playfair Display', serif;
            font-size: clamp(0.95rem, 1.3vw, 1.15rem);
            color: #fff;
            line-height: 1.7;
            margin-bottom: 20px;
            flex-shrink: 0;
        }
        .projet-type-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 5px 14px;
            border-radius: 30px;
            background: #000;
            color: #F16529;
            margin-bottom: 14px;
            flex-shrink: 0;
            width: fit-content;
        }
        .projet-type-badge svg {
            width: 14px;
            height: 14px;
            fill: currentColor;
        }
        .projet-complexite {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 16px;
            margin-bottom: 8px;
            flex-shrink: 0;
        }
        .projet-complexite-label {
            font-family: 'Inter', sans-serif;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #000;
            white-space: nowrap;
        }
        .projet-complexite-bar {
            flex: 1;
            height: 6px;
            background: rgba(0,0,0,0.15);
            border-radius: 3px;
            overflow: hidden;
            max-width: 200px;
        }
        .projet-complexite-fill {
            height: 100%;
            width: 0%;
            border-radius: 3px;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .projet-complexite-value {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 700;
            color: #000;
        }
        .projet-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .projet-tag {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 30px;
            border: 1px solid #fff;
            color: #fff;
            background: transparent;
            letter-spacing: 0.02em;
        }
        .projet-image {
            position: relative;
            flex: 1;
            max-width: 45%;
            aspect-ratio: 16/10;
            background: #fff;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            cursor: none;
        }
        .projet-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .projet-image:hover img {
            opacity: 0;
        }
        .projet-image .webgl-canvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2;
        }
        .projet-image:hover .webgl-canvas {
            opacity: 1;
        }
        .projet-image-placeholder {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            color: #ccc;
            font-style: italic;
        }
        .projet-image-console {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }
        .projet-image-console svg {
            width: 80px;
            height: 80px;
            fill: #F16529;
            opacity: 0.7;
        }
        .projet-image-console span {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: #999;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .projet-links {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
            flex-shrink: 0;
        }
        .projet-link {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 700;
            padding: 10px 22px;
            border-radius: 30px;
            text-decoration: none;
            letter-spacing: 0.04em;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .projet-link--site {
            background: #000;
            color: #fff;
            border: 2px solid #000;
        }
        .projet-link--site:hover {
            background: transparent;
            color: #000;
        }
        .projet-link--github {
            background: transparent;
            color: #fff;
            border: 2px solid #fff;
        }
        .projet-link--github:hover {
            background: #fff;
            color: #000;
        }
        .projet-link svg {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }
        .projet-counter {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: #000;
            letter-spacing: 0.05em;
            flex-shrink: 0;
        }
        .projet-nav {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 20px;
            flex-shrink: 0;
        }
        .projet-nav-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 2px solid #000;
            background: transparent;
            color: #000;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
        }
        .projet-nav-btn:hover {
            background: #000;
            color: #F16529;
        }
        .projet-nav-btn svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }
        .projet-nav-btn:disabled {
            opacity: 0.3;
            cursor: default;
        }
        .projet-nav-btn:disabled:hover {
            background: transparent;
            color: #000;
        }
        .projets-progress-bar {
            width: calc(100% - 96px);
            height: 2px;
            background: rgba(0,0,0,0.2);
            margin: 0 48px 16px;
            border-radius: 3px;
            overflow: hidden;
            flex-shrink: 0;
        }
        .projets-progress-fill {
            height: 100%;
            width: 0%;
            background: #000;
            border-radius: 3px;
            transition: width 0.4s ease;
        }

        /* Mouse cursor blob */
        .cursor-blob {
            position: fixed;
            width: 30px;
            height: 30px;
            background: #fff;
            border-radius: 50%;
            pointer-events: none;
            z-index: 9999;
            mix-blend-mode: difference;
        }
        .cursor-blob.on-projets {
            background: #fff;
            mix-blend-mode: difference;
        }

        /* Dark mode horizontal wipe overlay */
        .dark-overlay {
            position: fixed;
            top: 0;
            right: 0;
            width: 0%;
            height: 100vh;
            background: #0a0a0a;
            z-index: 40;
            pointer-events: none;
        }

        /* Navbar blend mode during dark overlay */
        .navbar.is-blending {
            background: transparent !important;
            mix-blend-mode: difference;
        }
        .navbar.is-blending .logo-first,
        .navbar.is-blending .logo-last,
        .navbar.is-blending .nav-links a,
        .navbar.is-blending .btn-connect {
            color: #fff !important;
        }
        .navbar.is-blending .btn-connect,
        .navbar.is-blending .theme-toggle {
            background: transparent !important;
            border-color: #fff !important;
        }
        .navbar.is-blending .theme-toggle svg {
            fill: #fff !important;
        }

        /* Navbar blend mode during white wipe (inverse) */
        .navbar.is-blending-white {
            background: transparent !important;
            mix-blend-mode: difference;
        }
        .navbar.is-blending-white .logo-first,
        .navbar.is-blending-white .logo-last,
        .navbar.is-blending-white .nav-links a,
        .navbar.is-blending-white .btn-connect {
            color: #fff !important;
        }
        .navbar.is-blending-white .btn-connect,
        .navbar.is-blending-white .theme-toggle {
            background: transparent !important;
            border-color: #fff !important;
        }
        .navbar.is-blending-white .theme-toggle svg {
            fill: #fff !important;
        }

        /* Contact section */
        .contact-section {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 310;
            pointer-events: none;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            background: var(--bg-color);
            transform: translateY(100%);
            overflow-y: auto;
            overflow-x: hidden;
        }
        .contact-section.active {
            pointer-events: auto;
        }
        .contact-inner {
            display: flex;
            width: 100%;
            max-width: 1200px;
            padding: 80px 48px 60px;
            gap: 80px;
            align-items: flex-start;
            flex: 1;
        }
        .contact-left {
            flex: 1;
        }
        .contact-left h2 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 6vw, 5rem);
            font-weight: 400;
            color: var(--text-color);
            text-transform: uppercase;
            letter-spacing: 0.02em;
            line-height: 1.1;
            margin-bottom: 24px;
        }
        .contact-left p {
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            color: var(--text-secondary);
            line-height: 1.7;
            max-width: 480px;
        }
        .contact-left .contact-links {
            margin-top: 28px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            max-width: 480px;
        }
        .contact-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px 28px;
            border: 1px solid var(--btn-border);
            border-radius: 16px;
            background: var(--btn-bg);
            transition: box-shadow 0.3s, border-color 0.3s, transform 0.3s;
            text-decoration: none;
            color: var(--text-color);
            pointer-events: auto;
        }
        .contact-item:hover {
            box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            border-color: #999;
            transform: translateY(-2px);
        }
        .contact-item svg {
            width: 28px;
            height: 28px;
            flex-shrink: 0;
            fill: var(--text-color);
        }
        .contact-item-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .contact-item-label {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-secondary);
            opacity: 0.6;
        }
        .contact-item-value {
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            font-weight: 500;
            color: var(--text-color);
        }
        .contact-form {
            display: flex;
            flex-direction: column;
            gap: 16px;
            padding: 28px;
            border: 1px solid var(--btn-border);
            border-radius: 20px;
            background: var(--btn-bg);
            pointer-events: auto;
        }
        .contact-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }
        .contact-form input,
        .contact-form textarea {
            width: 100%;
            border: 1px solid var(--btn-border);
            border-radius: 14px;
            background: transparent;
            color: var(--text-color);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            padding: 14px 16px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: #F16529;
            box-shadow: 0 0 0 3px rgba(241, 101, 41, 0.12);
        }
        .contact-form textarea {
            min-height: 140px;
            resize: vertical;
        }
        .contact-form button {
            align-self: flex-start;
            border: none;
            border-radius: 999px;
            background: #F16529;
            color: #000;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 14px 22px;
            cursor: pointer;
            transition: transform 0.2s, background 0.2s;
        }
        .contact-form button:hover {
            background: #d65420;
            transform: translateY(-1px);
        }
        .contact-form-status {
            padding: 14px 16px;
            border-radius: 14px;
            font-size: 14px;
            line-height: 1.5;
        }
        .contact-form-status.success {
            background: rgba(34, 197, 94, 0.12);
            color: #22c55e;
        }
        .contact-form-status.error {
            background: rgba(239, 68, 68, 0.12);
            color: #ef4444;
        }

        /* ===== FOOTER ===== */
        .site-footer {
            width: 100%;
            border-top: 1px solid rgba(128, 128, 128, 0.15);
            padding: 40px 48px 28px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 24px;
            flex-shrink: 0;
        }
        .footer-top {
            display: flex;
            width: 100%;
            max-width: 1200px;
            justify-content: space-between;
            align-items: flex-start;
            gap: 40px;
        }
        .footer-brand {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .footer-brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-color);
            letter-spacing: 0.04em;
        }
        .footer-brand-role {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: var(--text-secondary);
            opacity: 0.7;
        }
        .footer-nav {
            display: flex;
            gap: 28px;
            flex-wrap: wrap;
        }
        .footer-nav a {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            transition: color 0.2s;
        }
        .footer-nav a:hover {
            color: #F16529;
        }
        .footer-socials {
            display: flex;
            gap: 14px;
        }
        .footer-socials a {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(128, 128, 128, 0.25);
            border-radius: 50%;
            color: var(--text-color);
            text-decoration: none;
            transition: border-color 0.2s, transform 0.2s, background 0.2s;
        }
        .footer-socials a:hover {
            border-color: #F16529;
            background: rgba(241, 101, 41, 0.08);
            transform: translateY(-2px);
        }
        .footer-socials a svg {
            width: 16px;
            height: 16px;
            fill: var(--text-color);
        }
        .footer-bottom {
            width: 100%;
            max-width: 1200px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(128, 128, 128, 0.1);
        }
        .footer-copy {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: var(--text-secondary);
            opacity: 0.5;
        }
        .footer-made {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: var(--text-secondary);
            opacity: 0.5;
        }
        .footer-made span {
            color: #F16529;
        }

        /* ===== SCROLL HINT ===== */
        .scroll-hint {
            position: fixed;
            bottom: 32px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9998;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.6s ease;
        }
        .scroll-hint.visible { opacity: 1; }
        .scroll-hint span {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-color);
            background: var(--btn-bg);
            padding: 8px 18px;
            border-radius: 30px;
            border: 1px solid var(--btn-border);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .scroll-hint-arrow {
            width: 20px;
            height: 20px;
            border-right: 2px solid var(--text-color);
            border-bottom: 2px solid var(--text-color);
            transform: rotate(45deg);
            animation: scrollBounce 1.5s ease-in-out infinite;
        }
        @keyframes scrollBounce {
            0%, 100% { transform: rotate(45deg) translateY(0); opacity: 1; }
            50% { transform: rotate(45deg) translateY(6px); opacity: 0.5; }
        }

        /* ===== HAMBURGER MENU ===== */
        .hamburger {
            display: none;
            flex-direction: column;
            justify-content: center;
            gap: 5px;
            width: 28px;
            height: 28px;
            cursor: pointer;
            z-index: 1002;
            background: none;
            border: none;
            padding: 0;
        }
        .hamburger span {
            display: block;
            width: 100%;
            height: 2px;
            background: var(--text-color);
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        .hamburger.active span:nth-child(1) { transform: rotate(45deg) translate(5px, 5px); }
        .hamburger.active span:nth-child(2) { opacity: 0; }
        .hamburger.active span:nth-child(3) { transform: rotate(-45deg) translate(5px, -5px); }

        .mobile-menu-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: var(--bg-color);
            z-index: 1000;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 32px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .mobile-menu-overlay.open { display: flex; opacity: 1; }
        .mobile-menu-overlay a {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 400;
            color: var(--text-color);
            text-decoration: none;
            letter-spacing: 0.02em;
            transition: color 0.3s;
        }
        .mobile-menu-overlay a:hover { color: var(--accent); }

        /* ===== RESPONSIVE ===== */

        /* --- Tablet landscape --- */
        @media (max-width: 1024px) {
            .navbar { padding: 20px 28px; }
            .hero { padding: 0 28px 30px 28px; }
            .about-content { right: 28px; width: 48vw; }
            .cursus-content { left: 28px; width: 50vw; }
            .stacks-title { padding: 0 28px; margin-bottom: 40px; }
            .projets-section { padding-top: 70px; }
            .projets-header { padding: 0 28px; }
            .projets-showcase { padding: 0 28px 24px; gap: 28px; }
            .projets-progress-bar { width: calc(100% - 56px); margin: 0 28px 12px; }
            .contact-inner { padding: 80px 28px 48px; gap: 48px; }
        }

        /* --- Tablet portrait / Mobile large --- */
        @media (max-width: 768px) {
            /* Navbar */
            .nav-links { display: none; }
            .hamburger { display: flex; }
            .navbar { padding: 14px 20px; }
            .btn-connect { padding: 7px 14px; font-size: 11px; }
            .theme-toggle { width: 36px; height: 36px; }
            .theme-toggle svg { width: 16px; height: 16px; }

            /* Hero */
            .hero { padding: 0 20px 20px 20px; overflow: hidden; }
            .hero-photo { width: 100%; height: 55%; opacity: 0.25; }
            .hero-title { font-size: clamp(2.8rem, 14vw, 5rem) !important; white-space: normal !important; word-break: break-word; }
            .hero-subtitle { font-size: clamp(2.8rem, 14vw, 5rem) !important; white-space: normal !important; word-break: break-word; }
            .hero-bottom {
                flex-direction: column-reverse;
                align-items: flex-start;
                gap: 20px;
            }
            .hero-text { text-align: left; }
            .hero-cta { flex-direction: row; gap: 8px; }
            .btn-outline, .btn-primary { padding: 11px 22px; font-size: 11px; }

            /* About */
            .about-text { max-width: 100vw; overflow: hidden; }
            .about-text .about-char { font-size: clamp(2rem, 9vw, 3.5rem) !important; }
            .about-content {
                right: 16px;
                left: 16px;
                width: auto;
                max-width: 100%;
                top: 50%;
                bottom: auto;
                transform: translateY(-50%);
            }
            .about-content p {
                font-size: clamp(0.9rem, 3.2vw, 1.15rem);
                line-height: 1.7;
                text-align: center;
            }

            /* Cursus */
            .cursus-text { max-width: 100vw; overflow: hidden; }
            .cursus-text .cursus-char { font-size: clamp(2rem, 9vw, 3.5rem) !important; }
            .cursus-content {
                left: 16px;
                right: 16px;
                width: auto;
                max-width: 100%;
                top: 50%;
                transform: translateY(-50%);
                max-height: 70vh;
            }
            .cursus-content h3 {
                font-size: 11px;
                margin-bottom: 16px;
                letter-spacing: 0.15em;
                padding-bottom: 8px;
                border-bottom: 1px solid rgba(255,255,255,0.12);
            }
            .timeline-item { margin-bottom: 22px; padding-left: 18px; }
            .timeline-title { font-size: 14px; }
            .timeline-subtitle { font-size: 13px; }
            .timeline-desc { font-size: 12px; line-height: 1.7; }

            /* Stacks */
            .stacks-section {
                justify-content: center;
                padding: 0;
            }
            .stacks-title {
                font-size: clamp(1.8rem, 7vw, 3.5rem);
                padding: 0 20px;
                margin-bottom: 32px;
                text-align: center;
            }
            .stack-item { padding: 10px 16px; gap: 8px; }
            .stack-item span { font-size: 11px; }
            .stack-item svg, .stack-item img { width: 20px; height: 20px; }
            .marquee-track { gap: 12px; }
            .marquee-track-reverse { gap: 12px; margin-top: 12px; }

            /* Projets */
            .projets-section { padding-top: 56px; }
            .projets-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                padding: 0 16px;
            }
            .projets-title { font-size: clamp(1.3rem, 6vw, 2rem); }
            .projets-filters { flex-wrap: wrap; gap: 6px; }
            .projets-filter-btn { font-size: 10px; padding: 5px 12px; }
            .projets-filter-btn svg { width: 12px; height: 12px; }
            .projets-showcase {
                flex-direction: column;
                padding: 0 16px 12px;
                gap: 12px;
                overflow-y: auto;
            }
            .projet-image {
                max-width: 100%;
                width: 100%;
                flex: none;
                aspect-ratio: 16/9;
                max-height: 30vh;
                border-radius: 12px;
            }
            .projet-info {
                width: 100%;
                flex: none;
            }
            .projet-name { font-size: clamp(1rem, 4.5vw, 1.4rem); margin-bottom: 6px; }
            .projet-desc {
                font-size: clamp(0.8rem, 2.8vw, 0.95rem);
                margin-bottom: 10px;
                line-height: 1.5;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            .projet-tags { gap: 6px; }
            .projet-tag { font-size: 10px; padding: 4px 10px; }
            .projet-complexite { margin-top: 10px; margin-bottom: 6px; }
            .projet-links { gap: 6px; margin-top: 12px; }
            .projet-link { font-size: 11px; padding: 8px 16px; }
            .projet-nav { margin-top: 10px; gap: 12px; }
            .projet-nav-btn { width: 36px; height: 36px; }
            .projet-nav-btn svg { width: 16px; height: 16px; }
            .projets-progress-bar { width: calc(100% - 32px); margin: 0 16px 8px; }

            /* Disable WebGL/hover effects on touch */
            .projet-image { cursor: auto; }
            .projet-image:hover img { opacity: 1; }
            .projet-image:hover .webgl-canvas { opacity: 0; }

            /* Contact */
            .contact-section { overflow-y: auto; }
            .contact-inner {
                flex-direction: column;
                gap: 28px;
                padding: 64px 16px 32px;
                min-height: auto;
            }
            .contact-left { text-align: center; }
            .contact-left h2 { font-size: clamp(1.8rem, 7vw, 2.8rem); margin-bottom: 16px; }
            .contact-left p { max-width: 100%; font-size: 14px; line-height: 1.6; }
            .contact-left .contact-links { max-width: 100%; }
            .contact-item { padding: 14px 16px; gap: 14px; border-radius: 12px; }
            .contact-item svg { width: 22px; height: 22px; }
            .contact-item-value { font-size: 14px; }
            .contact-form-grid { grid-template-columns: 1fr; }
            .contact-form { padding: 16px; border-radius: 14px; }
            .contact-form input,
            .contact-form textarea { padding: 12px 14px; font-size: 13px; border-radius: 10px; }
            .contact-form textarea { min-height: 100px; }
            .contact-form button { padding: 12px 20px; font-size: 12px; }

            /* Footer */
            .site-footer { padding: 28px 16px 20px; }
            .footer-top { flex-direction: column; align-items: center; text-align: center; gap: 20px; }
            .footer-brand { align-items: center; }
            .footer-nav { justify-content: center; gap: 16px; }
            .footer-socials { justify-content: center; }
            .footer-bottom { flex-direction: column; text-align: center; gap: 8px; }

            /* Cursor blob: hidden on touch devices */
            .cursor-blob { display: none !important; }

            /* Reduce scroll length on mobile: transition & exit sections shorter */
            .scroll-section { height: 50vh; }
            #scrollSection1, #scrollSection2, #scrollSection3 { height: 30vh; }
            #apropos, #cursus { height: 50vh; }
            #scrollSection5, #scrollSectionCursusContent { height: 50vh; }
            #scrollSectionAboutExit, #scrollSectionCursusExit { height: 25vh; }
            #scrollSection6, #scrollSection7, #scrollSection8 { height: 20vh; }
            #scrollSectionContact { height: 30vh; }

            /* Scroll hint */
            .scroll-hint { bottom: 20px; }
            .scroll-hint span { font-size: 11px; padding: 6px 14px; }

            /* Mobile menu must be above all fixed sections */
            .mobile-menu-overlay { z-index: 1100; }
            .hamburger { z-index: 1101; }
        }

        /* --- Small phone --- */
        @media (max-width: 480px) {
            .navbar { padding: 12px 14px; }
            .logo-first, .logo-last { font-size: 12px; }
            .btn-connect { padding: 6px 12px; font-size: 10px; }
            .nav-right { gap: 10px; }
            .theme-toggle { width: 32px; height: 32px; }
            .theme-toggle svg { width: 14px; height: 14px; }

            .hero { padding: 0 14px 16px 14px; overflow: hidden; }
            .hero-title { font-size: clamp(2.2rem, 16vw, 3.5rem) !important; white-space: normal !important; }
            .hero-subtitle { font-size: clamp(2.2rem, 16vw, 3.5rem) !important; white-space: normal !important; }
            .btn-outline, .btn-primary { padding: 10px 18px; font-size: 10px; }
            .hero-cta { gap: 6px; }

            .about-text { max-width: 100vw; overflow: hidden; }
            .about-text .about-char { font-size: clamp(1.6rem, 8vw, 2.5rem) !important; }
            .about-content { top: 50%; bottom: auto; transform: translateY(-50%); }
            .about-content p { font-size: 0.85rem; text-align: center; }

            .cursus-text { max-width: 100vw; overflow: hidden; }
            .cursus-text .cursus-char { font-size: clamp(1.6rem, 8vw, 2.5rem) !important; }
            .cursus-content { max-height: 65vh; }
            .timeline-item { margin-bottom: 16px; }
            .timeline-title { font-size: 13px; }
            .timeline-desc { font-size: 11px; }

            .stacks-title { font-size: clamp(1.5rem, 6vw, 2.5rem); padding: 0 14px; margin-bottom: 18px; }
            .stack-item { padding: 10px 14px; gap: 8px; }
            .stack-item span { font-size: 11px; }
            .stack-item svg, .stack-item img { width: 18px; height: 18px; }
            .marquee-track { gap: 10px; }
            .marquee-track-reverse { gap: 10px; margin-top: 10px; }

            .projets-section { padding-top: 48px; }
            .projets-header { padding: 0 14px; gap: 8px; }
            .projets-title { font-size: clamp(1.1rem, 5.5vw, 1.6rem); }
            .projets-filter-btn { font-size: 9px; padding: 4px 10px; }
            .projets-filter-count { font-size: 8px; padding: 1px 5px; }
            .projets-showcase { padding: 0 14px 10px; gap: 10px; }
            .projet-image { max-height: 22vh; border-radius: 10px; }
            .projet-name { font-size: clamp(0.9rem, 4vw, 1.2rem); }
            .projet-desc { font-size: 0.78rem; -webkit-line-clamp: 2; }
            .projet-tag { font-size: 9px; padding: 3px 8px; }
            .projet-link { font-size: 10px; padding: 6px 14px; }
            .projet-nav-btn { width: 32px; height: 32px; }
            .projets-progress-bar { width: calc(100% - 28px); margin: 0 14px 6px; }

            .contact-inner { padding: 52px 14px 24px; gap: 20px; }
            .contact-left h2 { font-size: clamp(1.5rem, 6vw, 2.2rem); margin-bottom: 12px; }
            .contact-left p { font-size: 13px; }
            .contact-item { padding: 12px 14px; gap: 12px; }
            .contact-item svg { width: 20px; height: 20px; }
            .contact-item-label { font-size: 10px; }
            .contact-item-value { font-size: 13px; }
            .contact-form { padding: 14px; gap: 12px; }
            .contact-form input,
            .contact-form textarea { padding: 10px 12px; font-size: 12px; }
            .contact-form textarea { min-height: 80px; }
            .contact-form button { padding: 10px 18px; font-size: 11px; }

            /* Footer */
            .site-footer { padding: 24px 14px 16px; gap: 16px; }
            .footer-brand-name { font-size: 1.2rem; }
            .footer-nav { gap: 12px; }
            .footer-nav a { font-size: 11px; }
            .footer-socials a { width: 32px; height: 32px; }
            .footer-socials a svg { width: 14px; height: 14px; }
            .footer-copy, .footer-made { font-size: 11px; }

            .mobile-menu-overlay a { font-size: 22px; }
            .mobile-menu-overlay { gap: 24px; }

            /* Scroll hint */
            .scroll-hint { bottom: 14px; }
            .scroll-hint span { font-size: 10px; padding: 5px 12px; }
        }
    </style>
</head>
<body>

    <!-- Mouse Cursor Blob -->
    <div class="cursor-blob" id="cursorBlob"></div>

    <!-- Scroll Hint -->
    <div class="scroll-hint" id="scrollHint">
        <span>Scroll pour découvrir</span>
        <div class="scroll-hint-arrow"></div>
    </div>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenuOverlay">
        <a href="#accueil" class="mobile-nav-link">Accueil</a>
        <a href="#apropos" class="mobile-nav-link">A propos</a>
        <a href="#cursus" class="mobile-nav-link">Cursus</a>
        <a href="#projets" class="mobile-nav-link">Projets</a>
        <a href="#contact" class="mobile-nav-link">Contact</a>
    </div>

    @php
        $nomComplet = optional($user)->nom ?? 'CHEIKH KEINDE';
        $parts = explode(' ', $nomComplet);
    @endphp

    <!-- Dark mode horizontal wipe -->
    <div class="dark-overlay" id="darkOverlay"></div>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div class="logo">
            <span class="logo-first">{{ strtoupper($parts[0] ?? '') }}</span>
            <span class="logo-last">{{ strtoupper($parts[1] ?? '') }}</span>
        </div>

        <div class="nav-links">
            <a href="#accueil">Accueil</a>
            <a href="#apropos">A propos</a>
            <a href="#cursus">Cursus</a>
            <a href="#projets">Projets</a>
            <a href="#contact">Contact</a>
        </div>

        <div class="nav-right">
            <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode">
                <svg class="moon-icon" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                <svg class="sun-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3" stroke="currentColor" stroke-width="2"/><line x1="12" y1="21" x2="12" y2="23" stroke="currentColor" stroke-width="2"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64" stroke="currentColor" stroke-width="2"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78" stroke="currentColor" stroke-width="2"/><line x1="1" y1="12" x2="3" y2="12" stroke="currentColor" stroke-width="2"/><line x1="21" y1="12" x2="23" y2="12" stroke="currentColor" stroke-width="2"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36" stroke="currentColor" stroke-width="2"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22" stroke="currentColor" stroke-width="2"/></svg>
            </button>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-connect">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-connect">se connecter</a>
            @endauth
            <button class="hamburger" id="hamburgerBtn" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    {{-- HERO --}}
    <section class="hero" id="accueil">

        @if(optional($user)->photo && optional($user)->photo !== 'default-avatar.jpg')
            <img src="{{ asset('storage/' . optional($user)->photo) }}" alt="{{ optional($user)->nom ?? 'Photo profil' }}" class="hero-photo">
        @endif

        <div class="hero-bottom">

            <div class="hero-cta" id="hero-buttons">
                <a href="#projets" class="btn-outline">mes projets</a>
                @auth
                    <a href="{{ route('dashboard.projects.create') }}" class="btn-primary">work with me</a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary">work with me</a>
                @endauth
            </div>

            <div class="hero-text" id="hero-text">
                <h1 class="hero-title" data-split>{{ strtoupper($parts[0] ?? 'CHEIKH') }}</h1>
                <p class="hero-subtitle" data-split>{{ strtoupper($parts[1] ?? 'KEINDE') }}</p>
            </div>

        </div>
    </section>

    <!-- Scroll sections -->
    <section class="scroll-section" id="scrollSection1"></section>
    <section class="scroll-section" id="scrollSection2"></section>
    <section class="scroll-section" id="scrollSection3"></section>
    <section class="scroll-section" id="apropos"></section>
    <section class="scroll-section" id="scrollSection5"></section>
    <section class="scroll-section" id="scrollSectionAboutExit"></section>
    <section class="scroll-section" id="cursus"></section>
    <section class="scroll-section" id="scrollSectionCursusContent"></section>
    <section class="scroll-section" id="scrollSectionCursusExit"></section>
    <section class="scroll-section" id="scrollSection6"></section>
    <section class="scroll-section" id="scrollSection7"></section>
    <section class="scroll-section" id="scrollSection8"></section>
    <section class="scroll-section" id="scrollSection9"></section>
    <section class="scroll-section" id="scrollSectionContact"></section>

    <!-- White wipe overlay -->
    <div class="white-overlay" id="whiteOverlay"></div>

    <!-- Stacks section -->
    <div class="stacks-section" id="stacksSection">
        <h2 class="stacks-title">Stacks</h2>
        <div class="marquee-wrapper" id="marqueeRow1">
            <div class="marquee-track">
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vuejs/vuejs-original.svg" alt="Vue.js"><span>Vue.js</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg" alt="Laravel"><span>Laravel</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" alt="JavaScript"><span>JavaScript</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/python/python-original.svg" alt="Python"><span>Python</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/csharp/csharp-original.svg" alt="C#"><span>C# / .NET</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" alt="MySQL"><span>MySQL</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/microsoftsqlserver/microsoftsqlserver-plain.svg" alt="SQL Server"><span>SQL Server</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/oracle/oracle-original.svg" alt="Oracle"><span>Oracle DB</span></div>
                <!-- Duplicate for seamless loop -->
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vuejs/vuejs-original.svg" alt="Vue.js"><span>Vue.js</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg" alt="Laravel"><span>Laravel</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg" alt="JavaScript"><span>JavaScript</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/python/python-original.svg" alt="Python"><span>Python</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/csharp/csharp-original.svg" alt="C#"><span>C# / .NET</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" alt="MySQL"><span>MySQL</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/microsoftsqlserver/microsoftsqlserver-plain.svg" alt="SQL Server"><span>SQL Server</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/oracle/oracle-original.svg" alt="Oracle"><span>Oracle DB</span></div>
            </div>
        </div>
        <div class="marquee-wrapper" id="marqueeRow2">
            <div class="marquee-track-reverse">
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/windows8/windows8-original.svg" alt="Windows Server"><span>Windows Server</span></div>
                <div class="stack-item"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/><circle cx="9.5" cy="7" r="3" stroke="currentColor" stroke-width="1.8" fill="none"/><path d="M20 8v6M17 11h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg><span>AD DS</span></div>
                <div class="stack-item"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8" fill="none"/><path d="M3 12h18M12 3a15 15 0 0 1 0 18M12 3a15 15 0 0 0 0 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" fill="none"/></svg><span>DNS</span></div>
                <div class="stack-item"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="6" rx="2" stroke="currentColor" stroke-width="1.8" fill="none"/><rect x="3" y="13" width="18" height="6" rx="2" stroke="currentColor" stroke-width="1.8" fill="none"/><path d="M7 8h.01M7 16h.01M11 8h6M11 16h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" fill="none"/></svg><span>DHCP</span></div>
                <div class="stack-item"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 12a9 9 0 0 1-15.36 6.36L3 16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path d="M3 12A9 9 0 0 1 18.36 5.64L21 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path d="M21 3v5h-5M3 21v-5h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg><span>WSUS</span></div>
                <div class="stack-item"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" fill="none"/><path d="m7 10 5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/><rect x="4" y="17" width="16" height="4" rx="1.5" stroke="currentColor" stroke-width="1.8" fill="none"/></svg><span>WDS</span></div>
                <div class="stack-item"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 6 5.5v5.5c0 4 2.6 7.4 6 8.5 3.4-1.1 6-4.5 6-8.5V5.5L12 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" fill="none"/><path d="m9.5 11.5 1.7 1.7 3.3-3.7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg><span>CA</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/linux/linux-original.svg" alt="Linux"><span>Linux</span></div>
                <!-- Duplicate for seamless loop -->
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/windows8/windows8-original.svg" alt="Windows Server"><span>Windows Server</span></div>
                <div class="stack-item"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/><circle cx="9.5" cy="7" r="3" stroke="currentColor" stroke-width="1.8" fill="none"/><path d="M20 8v6M17 11h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg><span>AD DS</span></div>
                <div class="stack-item"><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8" fill="none"/><path d="M3 12h18M12 3a15 15 0 0 1 0 18M12 3a15 15 0 0 0 0 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" fill="none"/></svg><span>DNS</span></div>
                <div class="stack-item"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="6" rx="2" stroke="currentColor" stroke-width="1.8" fill="none"/><rect x="3" y="13" width="18" height="6" rx="2" stroke="currentColor" stroke-width="1.8" fill="none"/><path d="M7 8h.01M7 16h.01M11 8h6M11 16h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" fill="none"/></svg><span>DHCP</span></div>
                <div class="stack-item"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21 12a9 9 0 0 1-15.36 6.36L3 16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path d="M3 12A9 9 0 0 1 18.36 5.64L21 8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/><path d="M21 3v5h-5M3 21v-5h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg><span>WSUS</span></div>
                <div class="stack-item"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" fill="none"/><path d="m7 10 5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/><rect x="4" y="17" width="16" height="4" rx="1.5" stroke="currentColor" stroke-width="1.8" fill="none"/></svg><span>WDS</span></div>
                <div class="stack-item"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 6 5.5v5.5c0 4 2.6 7.4 6 8.5 3.4-1.1 6-4.5 6-8.5V5.5L12 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" fill="none"/><path d="m9.5 11.5 1.7 1.7 3.3-3.7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg><span>CA</span></div>
                <div class="stack-item"><img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/linux/linux-original.svg" alt="Linux"><span>Linux</span></div>
            </div>
        </div>
    </div>

    <!-- Projets section -->
    <div class="projets-section" id="projets" data-anchor="projets" aria-label="Section projets">
        <div class="projets-header">
            <h2 class="projets-title" id="projetsTitle">Mes Projets</h2>
            <div class="projets-filters" id="projetsFilters">
            <button class="projets-filter-btn active" data-filter="all">
                Tous <span class="projets-filter-count" id="countAll"></span>
            </button>
            <button class="projets-filter-btn" data-filter="Web">
                <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                Web <span class="projets-filter-count" id="countWeb"></span>
            </button>
            <button class="projets-filter-btn" data-filter="Desktop">
                <svg viewBox="0 0 24 24"><path d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7l-2 3v1h8v-1l-2-3h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 12H3V4h18v10z"/></svg>
                Desktop <span class="projets-filter-count" id="countDesktop"></span>
            </button>
            <button class="projets-filter-btn" data-filter="Console">
                <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM7.41 14.41L6 15l-4-4 4-4 1.41 1.41L4.83 11l2.58 2.41zM10 17l-1.56-.56 4-12L14 4l-4 12h0zm6.59-.41L18 15l4-4-4-4-1.41 1.41L19.17 11l-2.58 2.59z"/></svg>
                Console <span class="projets-filter-count" id="countConsole"></span>
            </button>
            </div>
        </div>
        <div class="projets-progress-bar">
            <div class="projets-progress-fill" id="projetsProgressFill"></div>
        </div>
        <div class="projets-showcase" id="projetsShowcase">
            <div class="projet-info">
                <div class="projet-type-badge" id="projetType"></div>
                <h3 class="projet-name" id="projetName"></h3>
                <p class="projet-desc" id="projetDesc"></p>
                <div class="projet-tags" id="projetTags"></div>
                <div class="projet-complexite" id="projetComplexite">
                    <span class="projet-complexite-label">Complexité</span>
                    <div class="projet-complexite-bar">
                        <div class="projet-complexite-fill" id="projetComplexiteFill"></div>
                    </div>
                    <span class="projet-complexite-value" id="projetComplexiteValue"></span>
                </div>
                <div class="projet-links" id="projetLinks"></div>
                <div class="projet-nav">
                    <button class="projet-nav-btn" id="projetPrev" aria-label="Projet précédent">
                        <svg viewBox="0 0 24 24"><path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
                    </button>
                    <span class="projet-counter" id="projetCounter"></span>
                    <button class="projet-nav-btn" id="projetNext" aria-label="Projet suivant">
                        <svg viewBox="0 0 24 24"><path d="M8.59 16.59L10 18l6-6-6-6-1.41 1.41L13.17 12z"/></svg>
                    </button>
                </div>
            </div>
            <div class="projet-image" id="projetImage">
                <span class="projet-image-placeholder">image</span>
            </div>
        </div>
    </div>

    <!-- Contact section -->
    <div class="contact-section" id="contact">
        <div class="contact-inner">
            <div class="contact-left">
                <h2>Contact</h2>
                <p>Un projet, une idée, un poste à pourvoir ? Écrivez-moi, je réponds vite.</p>
                <div class="contact-links">
                    <a href="mailto:pkeinde6@gmail.com" class="contact-item">
                        <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        <div class="contact-item-text">
                            <span class="contact-item-label">Email</span>
                            <span class="contact-item-value">pkeinde6@gmail.com</span>
                        </div>
                    </a>
                    <a href="tel:+221772756581" class="contact-item">
                        <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                        <div class="contact-item-text">
                            <span class="contact-item-label">Téléphone (Sénégal)</span>
                            <span class="contact-item-value">+221 77 275 65 81</span>
                        </div>
                    </a>
                    <a href="tel:+14384658983" class="contact-item">
                        <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                        <div class="contact-item-text">
                            <span class="contact-item-label">Téléphone (Canada)</span>
                            <span class="contact-item-value">+1 438 465 8983</span>
                        </div>
                    </a>
                    <div class="contact-item">
                        <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        <div class="contact-item-text">
                            <span class="contact-item-label">Localisation</span>
                            <span class="contact-item-value">Dakar, Sénégal</span>
                        </div>
                    </div>
                    <a href="https://www.linkedin.com/in/pape-cheikh-keinde-b6612a2a0/" target="_blank" rel="noopener noreferrer" class="contact-item">
                        <svg viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        <div class="contact-item-text">
                            <span class="contact-item-label">LinkedIn</span>
                            <span class="contact-item-value">Pape Cheikh Keinde</span>
                        </div>
                    </a>
                    <a href="https://github.com/Pkeinde6" target="_blank" rel="noopener noreferrer" class="contact-item">
                        <svg viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
                        <div class="contact-item-text">
                            <span class="contact-item-label">GitHub</span>
                            <span class="contact-item-value">Pkeinde6</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="contact-right">
                @if (session('contact_success'))
                    <div class="contact-form-status success">{{ session('contact_success') }}</div>
                @endif

                @if ($errors->has('name') || $errors->has('email') || $errors->has('subject') || $errors->has('message'))
                    <div class="contact-form-status error">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" class="contact-form" id="contactForm">
                    @csrf
                    <div class="contact-form-grid">
                        <input type="text" name="name" placeholder="Votre nom" value="{{ old('name') }}" required>
                        <input type="email" name="email" placeholder="Votre email" value="{{ old('email') }}" required>
                    </div>
                    <input type="text" name="subject" placeholder="Sujet" value="{{ old('subject') }}" required>
                    <textarea name="message" placeholder="Votre message..." required>{{ old('message') }}</textarea>
                    <button type="submit">Envoyer</button>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <footer class="site-footer">
            <div class="footer-top">
                <div class="footer-brand">
                    <span class="footer-brand-name">{{ strtoupper(optional($user)->nom ?? 'CHEIKH KEINDE') }}</span>
                    <span class="footer-brand-role">{{ optional($user)->poste ?? 'Développeur Full-Stack' }}</span>
                </div>
                <nav class="footer-nav">
                    <a href="#accueil">Accueil</a>
                    <a href="#apropos">A propos</a>
                    <a href="#cursus">Cursus</a>
                    <a href="#projets">Projets</a>
                    <a href="#contact">Contact</a>
                </nav>
                <div class="footer-socials">
                    <a href="https://www.linkedin.com/in/pape-cheikh-keinde-b6612a2a0/" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                    </a>
                    <a href="https://github.com/Pkeinde6" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
                        <svg viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg>
                    </a>
                    <a href="mailto:pkeinde6@gmail.com" aria-label="Email">
                        <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    </a>
                </div>
            </div>
            <div class="footer-bottom">
                <span class="footer-copy">&copy; {{ date('Y') }} {{ optional($user)->nom ?? 'Cheikh Keinde' }}. Tous droits réservés.</span>
            </div>
        </footer>
    </div>

    <script>
        window.__projets = @json($projets);
    </script>

    <!-- About text (fixed, animated via JS) -->
    <div class="about-text" id="aboutText">A PROPOS</div>

    <!-- About content (right side) -->
    <div class="about-content" id="aboutContent">
        <p>Basé à Dakar, je code en fullstack depuis bientôt 3 ans. Vue.js et Laravel pour le web, C#/.NET et Java côté back, Python aussi. J'ai construit des quiz interactifs, un système de gestion scolaire, ce portfolio entre autres — et ce qui me plaît surtout, c'est le moment où une idée commence à tourner pour de vrai.</p>
    </div>

    <!-- Cursus text (fixed, animated via JS like about) -->
    <div class="cursus-text" id="cursusText">CURSUS</div>

    <!-- Cursus content (right side) -->
    <div class="cursus-content" id="cursusContent">
        <h3>Formation</h3>
        <div class="timeline-item">
            <div class="timeline-year">2023 – 2026</div>
            <div class="timeline-title">Licence en Informatique</div>
            <div class="timeline-subtitle">Groupe IAM</div>
            <div class="timeline-desc">Microsoft SQL Server, PHP et développement fullstack : Laravel, Vue.js, Java, C#/.NET, bases de données, gestion de projet agile.</div>
        </div>
        <div class="timeline-item">
            <div class="timeline-year">2020 – 2023</div>
            <div class="timeline-title">Baccalauréat scientifique</div>
            <div class="timeline-subtitle">Cours Sainte Marie de Hann</div>
            <div class="timeline-desc">Sciences biologiques, sciences physiques et sciences mathématiques.</div>
        </div>
    </div>

    <!-- GSAP CDN + ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <script>
        // Prevent scroll restoration on refresh — ensures animations always start fresh
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        window.scrollTo(0, 0);

        // Dark Mode Toggle
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;

        // Check saved theme — default is always light
        const savedTheme = localStorage.getItem('theme');

        if (savedTheme === 'dark') {
            html.setAttribute('data-theme', 'dark');
        } else {
            html.removeAttribute('data-theme');
        }

        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            if (newTheme === 'dark') {
                html.setAttribute('data-theme', 'dark');
            } else {
                html.removeAttribute('data-theme');
            }
            localStorage.setItem('theme', newTheme);
        });

        // Mouse Cursor Blob with GSAP (desktop only)
        const cursorBlob = document.getElementById('cursorBlob');
        let mouseX = 0, mouseY = 0;
        let blobX = 0, blobY = 0;
        let prevBlobX = 0, prevBlobY = 0;
        let smoothVx = 0, smoothVy = 0;

        const isTouch = window.matchMedia('(max-width: 768px)').matches || 'ontouchstart' in window;

        if (!isTouch) {
        document.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
        });

        // Use GSAP ticker for smooth blob animation
        gsap.ticker.add(() => {
            // Smooth following via GSAP lerp
            blobX += (mouseX - blobX) * 0.12;
            blobY += (mouseY - blobY) * 0.12;

            // Smoothed velocity
            const vx = blobX - prevBlobX;
            const vy = blobY - prevBlobY;
            smoothVx += (vx - smoothVx) * 0.2;
            smoothVy += (vy - smoothVy) * 0.2;
            prevBlobX = blobX;
            prevBlobY = blobY;

            const velocity = Math.sqrt(smoothVx * smoothVx + smoothVy * smoothVy);
            const angle = Math.atan2(smoothVy, smoothVx) * (180 / Math.PI);
            const stretch = Math.min(velocity * 0.04, 0.6);
            const squeeze = stretch * 0.5;
            const skew = Math.min(velocity * 0.3, 8);

            // Organic border-radius deformation
            const r1 = 50 - stretch * 15;
            const r2 = 50 + stretch * 10;
            const r3 = 50 - stretch * 8;
            const r4 = 50 + stretch * 12;

            gsap.set(cursorBlob, {
                left: blobX,
                top: blobY,
                rotation: angle,
                scaleX: 1 + stretch,
                scaleY: 1 - squeeze,
                skewX: skew,
                xPercent: -50,
                yPercent: -50
            });

            if (!cursorBlob.classList.contains('text-hover')) {
                cursorBlob.style.borderRadius = `${r1}% ${r2}% ${r3}% ${r4}%`;
            }
        });

        // Expand on interactive elements with GSAP
        document.querySelectorAll('a, button, .stack-item').forEach(el => {
            el.addEventListener('mouseenter', () => {
                gsap.to(cursorBlob, { width: 80, height: 80, duration: 0.3, ease: 'power2.out' });
            });
            el.addEventListener('mouseleave', () => {
                gsap.to(cursorBlob, { width: 30, height: 30, duration: 0.3, ease: 'power2.out' });
            });
        });

        // Magnetic button deformation with GSAP
        document.querySelectorAll('.btn-outline, .btn-primary, .btn-connect, .stack-item, .projet-link, .projet-nav-btn, .projets-filter-btn').forEach(btn => {
            btn.style.willChange = 'transform';

            btn.addEventListener('mousemove', (e) => {
                const rect = btn.getBoundingClientRect();
                const btnCenterX = rect.left + rect.width / 2;
                const btnCenterY = rect.top + rect.height / 2;
                const dx = e.clientX - btnCenterX;
                const dy = e.clientY - btnCenterY;

                const isStack = btn.classList.contains('stack-item');
                const moveFactor = isStack ? 0.5 : 0.3;
                const scaleXFactor = isStack ? 0.002 : 0.001;
                const scaleYFactor = isStack ? 0.004 : 0.002;

                gsap.to(btn, {
                    x: dx * moveFactor,
                    y: dy * moveFactor,
                    scaleX: 1 + Math.abs(dx) * scaleXFactor,
                    scaleY: 1 + Math.abs(dy) * scaleYFactor,
                    duration: 0.3,
                    ease: 'power2.out'
                });
            });

            btn.addEventListener('mouseleave', () => {
                gsap.to(btn, {
                    x: 0,
                    y: 0,
                    scaleX: 1,
                    scaleY: 1,
                    duration: 0.5,
                    ease: 'elastic.out(1, 0.4)'
                });
            });
        });

        // Special effect on hero text with GSAP
        document.querySelectorAll('.hero-title, .hero-subtitle').forEach(el => {
            el.addEventListener('mouseenter', () => {
                cursorBlob.classList.add('text-hover');
                gsap.to(cursorBlob, { width: 120, height: 120, borderRadius: '30%', duration: 0.3, ease: 'power2.out' });
            });
            el.addEventListener('mouseleave', () => {
                cursorBlob.classList.remove('text-hover');
                gsap.to(cursorBlob, { width: 30, height: 30, borderRadius: '50%', duration: 0.3, ease: 'power2.out' });
            });
        });
        } // end if (!isTouch)

        // Smooth scroll for ALL anchor links (navbar + hero button + mobile menu)
        // Map fixed-position sections to their ScrollTrigger trigger elements
        const anchorToTrigger = {
            '#projets': '#scrollSection8',
            '#contact': '#scrollSectionContact',
        };
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();
                const href = anchor.getAttribute('href');
                const triggerSelector = anchorToTrigger[href];
                const target = triggerSelector
                    ? document.querySelector(triggerSelector)
                    : document.querySelector(href);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // GSAP Animations
        document.addEventListener('DOMContentLoaded', () => {
            // Split hero title & subtitle into individual character spans for magnetic effect
            document.querySelectorAll('.hero-title, .hero-subtitle').forEach(el => {
                const text = el.textContent;
                el.textContent = '';
                text.split('').forEach(char => {
                    const span = document.createElement('span');
                    span.className = 'hero-char';
                    span.textContent = char === ' ' ? '\u00A0' : char;
                    el.appendChild(span);
                });
            });

            // Collect all hero chars for magnetic repulsion
            const heroChars = document.querySelectorAll('.hero-char');

            // Match KEINDE width to CHEIKH width by adjusting letter-spacing
            const heroTitle = document.querySelector('.hero-title');
            const heroSubtitle = document.querySelector('.hero-subtitle');
            function matchSubtitleWidth() {
                heroSubtitle.style.letterSpacing = '0.02em';
                const titleW = heroTitle.scrollWidth;
                const subW = heroSubtitle.scrollWidth;
                const subChars = heroSubtitle.textContent.length;
                if (subChars > 1 && subW > 0) {
                    const extraPerChar = (titleW - subW) / (subChars - 1);
                    heroSubtitle.style.letterSpacing = `calc(0.02em + ${extraPerChar}px)`;
                }
            }
            matchSubtitleWidth();
            window.addEventListener('resize', matchSubtitleWidth);

            const MAGNETIC_RADIUS = 150; // px — distance of influence
            const MAGNETIC_STRENGTH = 35; // max displacement in px

            // Add magnetic text repulsion to the existing GSAP ticker
            gsap.ticker.add(() => {
                heroChars.forEach(char => {
                    const rect = char.getBoundingClientRect();
                    const charCenterX = rect.left + rect.width / 2;
                    const charCenterY = rect.top + rect.height / 2;

                    const dx = charCenterX - mouseX;
                    const dy = charCenterY - mouseY;
                    const dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist < MAGNETIC_RADIUS) {
                        const force = (1 - dist / MAGNETIC_RADIUS);
                        const angle = Math.atan2(dy, dx);
                        const pushX = Math.cos(angle) * force * MAGNETIC_STRENGTH;
                        const pushY = Math.sin(angle) * force * MAGNETIC_STRENGTH;
                        const rotate = (pushX * 0.15);
                        const scale = 1 + force * 0.08;

                        gsap.set(char, {
                            x: pushX,
                            y: pushY,
                            rotation: rotate,
                            scale: scale
                        });
                    } else {
                        gsap.set(char, { x: 0, y: 0, rotation: 0, scale: 1 });
                    }
                });
            });

            // Set initial states for animation
            gsap.set('.logo, .nav-links a, .nav-right', { y: -20, opacity: 0 });
            gsap.set('.hero-title, .hero-subtitle', { y: -20, opacity: 0 });
            gsap.set('.hero-cta a', { x: -30, opacity: 0 });

            const tl = gsap.timeline({ defaults: { ease: "power3.out" } });

            // Navbar animation
            tl.to('.logo', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                delay: 0.3
            })
            .to('.nav-links a', {
                opacity: 1,
                y: 0,
                duration: 0.6,
                stagger: 0.1
            }, "-=0.4")
            .to('.nav-right', {
                opacity: 1,
                y: 0,
                duration: 0.6
            }, "-=0.4")

            // Hero title
            .to('.hero-title', {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: "power3.out"
            }, "-=0.2")

            // Hero subtitle
            .to('.hero-subtitle', {
                opacity: 1,
                y: 0,
                duration: 0.6,
                ease: "power3.out"
            }, "-=0.4")

            // CTA buttons
            .to('.hero-cta a', {
                opacity: 1,
                x: 0,
                duration: 0.6,
                stagger: 0.15
            }, "-=0.4");

            // === SCROLL ANIMATIONS - LAYOUT MORPH ===
            gsap.registerPlugin(ScrollTrigger);

            const heroText = document.getElementById('hero-text');
            const heroCta = document.getElementById('hero-buttons');

            // Store initial position after page load
            let initialRect = heroText.getBoundingClientRect();
            let initialX = initialRect.left + initialRect.width / 2;
            let initialY = initialRect.top + initialRect.height / 2;

            // Recalculate on resize
            window.addEventListener('resize', () => {
                if (!heroText.classList.contains('is-morphing')) {
                    initialRect = heroText.getBoundingClientRect();
                    initialX = initialRect.left + initialRect.width / 2;
                    initialY = initialRect.top + initialRect.height / 2;
                }
            });

            // Create wrapper + white text clone for color split
            const clipWrapper = document.createElement('div');
            clipWrapper.className = 'hero-text-clip-wrapper';
            document.body.appendChild(clipWrapper);

            const heroTextClone = heroText.cloneNode(true);
            heroTextClone.id = 'hero-text-clone';
            heroTextClone.className = 'hero-text-clone';
            // Clear GSAP inline styles from cloned children
            heroTextClone.querySelectorAll('.hero-title, .hero-subtitle, .hero-char').forEach(el => {
                el.removeAttribute('style');
            });
            clipWrapper.appendChild(heroTextClone);

            // Shared morph state
            let currentMorphX = 0;
            let currentMorphY = 0;
            let currentMorphScale = 1;
            let overlayProgress = 0;

            // Phase 1: Text scales up + moves to left
            const startX = initialRect.left;
            const startY = initialRect.top + initialRect.height / 2;

            ScrollTrigger.create({
                trigger: '#scrollSection1',
                start: 'top bottom',
                end: 'top top',
                scrub: 1.0,
                onLeaveBack: () => {
                    heroText.classList.remove('is-morphing');
                    gsap.set(heroText, { clearProps: 'all' });
                    gsap.set(heroCta, { clearProps: 'opacity' });
                },
                onUpdate: (self) => {
                    const progress = self.progress;
                    const mob = window.innerWidth < 768;

                    if (progress > 0.01) {
                        heroText.classList.add('is-morphing');

                        // Target: left padding, vertically centered
                        const targetX = mob ? 16 : 48;
                        const targetY = window.innerHeight / 2;

                        currentMorphX = startX + (targetX - startX) * progress;
                        currentMorphY = startY + (targetY - startY) * progress;
                        currentMorphScale = 1 + progress * (mob ? 0.15 : 0.6);

                        gsap.set(heroText, {
                            left: currentMorphX,
                            top: currentMorphY,
                            yPercent: -50,
                            scale: currentMorphScale,
                            transformOrigin: 'left center'
                        });

                        // Fade out CTA buttons
                        gsap.set(heroCta, { opacity: 1 - progress * 1.5 });
                    } else {
                        heroText.classList.remove('is-morphing');
                        gsap.set(heroText, { clearProps: 'all' });
                    }
                }
            });

            // Phase 2: Dark overlay wipe + wrapper clip
            const darkOverlay = document.getElementById('darkOverlay');
            const navbar = document.querySelector('.navbar');

            ScrollTrigger.create({
                trigger: '#scrollSection2',
                start: 'top bottom',
                end: 'center center',
                scrub: 1.0,
                onUpdate: (self) => {
                    const progress = self.progress;
                    overlayProgress = progress;

                    // Dark overlay from right
                    darkOverlay.style.width = (progress * 100) + '%';
                    // Wrapper matches overlay exactly
                    clipWrapper.style.width = (progress * 100) + '%';

                    // Navbar blend
                    if (progress > 0.01) {
                        navbar.classList.add('is-blending');
                    } else {
                        navbar.classList.remove('is-blending');
                    }

                    // Position clone inside wrapper
                    const wrapperLeftPx = window.innerWidth * (1 - progress);
                    const cloneLeft = currentMorphX - wrapperLeftPx;
                    gsap.set(heroTextClone, {
                        left: cloneLeft,
                        top: currentMorphY,
                        yPercent: -50,
                        scale: currentMorphScale,
                        transformOrigin: 'left center'
                    });
                },
                onLeaveBack: () => {
                    overlayProgress = 0;
                    darkOverlay.style.width = '0%';
                    clipWrapper.style.width = '0%';
                    navbar.classList.remove('is-blending');
                    gsap.set(heroTextClone, { clearProps: 'left,top' });
                }
            });

            // === Phase 3: BIDDEW text exits to the left ===
            ScrollTrigger.create({
                trigger: '#scrollSection3',
                start: 'top bottom',
                end: 'top center',
                scrub: 1.0,
                onUpdate: (self) => {
                    const progress = self.progress;
                    const totalExit = window.innerWidth + 500;
                    const exitOffset = totalExit * progress;
                    gsap.set(heroText, { left: currentMorphX - exitOffset });

                    // Clone also exits
                    const wrapperLeftPx = window.innerWidth * (1 - overlayProgress);
                    const cloneLeft = currentMorphX - wrapperLeftPx - exitOffset;
                    gsap.set(heroTextClone, {
                        left: cloneLeft,
                        top: currentMorphY,
                        yPercent: -50,
                        scale: currentMorphScale,
                        transformOrigin: 'left center'
                    });

                    // Hide completely when fully exited
                    if (progress >= 0.99) {
                        heroText.style.display = 'none';
                        clipWrapper.style.display = 'none';
                    } else {
                        heroText.style.display = '';
                        clipWrapper.style.display = '';
                    }
                },
                onLeaveBack: () => {
                    heroText.style.display = '';
                    clipWrapper.style.display = '';
                    gsap.set(heroText, { left: currentMorphX });
                }
            });

            // === Phase 4: "A PROPOS" text split from top-right ===
            const aboutText = document.getElementById('aboutText');
            const aboutString = aboutText.textContent;
            aboutText.textContent = '';
            aboutString.split('').forEach(char => {
                const span = document.createElement('span');
                span.className = 'about-char';
                span.textContent = char === ' ' ? '\u00A0' : char;
                aboutText.appendChild(span);
            });
            const aboutChars = aboutText.querySelectorAll('.about-char');

            ScrollTrigger.create({
                trigger: '#apropos',
                start: 'top bottom',
                end: 'top top',
                scrub: 1.0,
                onUpdate: (self) => {
                    const progress = self.progress;
                    const mob = window.innerWidth < 768;

                    if (progress > 0.01) {
                        aboutText.style.opacity = '1';

                        // Layout morph: position + scale transition
                        const startAboutX = mob ? window.innerWidth * 0.5 : window.innerWidth - 200;
                        const endAboutX = mob ? 16 : 48;
                        const startAboutY = 90;
                        const endAboutY = mob ? window.innerHeight * 0.35 : window.innerHeight / 2;

                        const currentAboutX = startAboutX + (endAboutX - startAboutX) * progress;
                        const currentAboutY = startAboutY + (endAboutY - startAboutY) * progress;
                        const currentScale = 0.85 + 0.15 * progress;

                        gsap.set(aboutText, {
                            left: currentAboutX,
                            top: currentAboutY,
                            yPercent: -50,
                            scale: currentScale,
                            transformOrigin: 'left center'
                        });

                        // Progressive character reveal — opacity only (no translateY = no wrapping glitch)
                        const totalChars = aboutChars.length;
                        aboutChars.forEach((char, i) => {
                            const charProgress = Math.max(0, Math.min(1, (progress * totalChars - i) * 2));
                            char.style.opacity = charProgress;
                        });
                    } else {
                        aboutText.style.opacity = '0';
                        gsap.set(aboutText, { scale: 0.85 });
                    }
                },
                onLeaveBack: () => {
                    aboutText.style.opacity = '0';
                }
            });

            // === Phase 5: About content — WORD TEXT SPLIT reveal ===
            const aboutContent = document.getElementById('aboutContent');

            // Split the <p> text into individual word spans
            const aboutPara = aboutContent.querySelector('p');
            const aboutWords = aboutPara.textContent.trim().split(/\s+/);
            aboutPara.textContent = '';
            aboutWords.forEach((word, i) => {
                const span = document.createElement('span');
                span.className = 'about-word';
                span.textContent = word;
                aboutPara.appendChild(span);
                // Add a space after each word except the last
                if (i < aboutWords.length - 1) {
                    aboutPara.appendChild(document.createTextNode(' '));
                }
            });
            const aboutWordEls = aboutPara.querySelectorAll('.about-word');

            ScrollTrigger.create({
                trigger: '#scrollSection5',
                start: 'top bottom',
                end: 'center center',
                scrub: 1.0,
                onUpdate: (self) => {
                    const progress = self.progress;

                    if (progress < 0.01) {
                        aboutWordEls.forEach(w => {
                            w.style.opacity = '0';
                            w.style.transform = 'translateY(18px)';
                        });
                        if (window.innerWidth < 768) {
                            aboutContent.style.transform = `translateY(calc(-50% + 40px))`;
                        } else {
                            aboutContent.style.transform = `translateY(calc(-50% + 40px))`;
                        }
                        return;
                    }

                    // Container slides up
                    const slideUp = (1 - progress) * 40;
                    if (window.innerWidth < 768) {
                        aboutContent.style.transform = `translateY(calc(-50% + ${slideUp}px))`;
                    } else {
                        aboutContent.style.transform = `translateY(calc(-50% + ${slideUp}px))`;
                    }

                    // Word-by-word reveal staggered across scroll progress
                    const total = aboutWordEls.length;
                    aboutWordEls.forEach((word, i) => {
                        const wordStart = (i / total) * 0.7;
                        const wordEnd = wordStart + 0.4;
                        const wordProgress = Math.max(0, Math.min(1, (progress - wordStart) / (wordEnd - wordStart)));
                        word.style.opacity = String(wordProgress);
                        word.style.transform = `translateY(${(1 - wordProgress) * 18}px)`;
                    });
                },
                onLeaveBack: () => {
                    aboutWordEls.forEach(w => {
                        w.style.opacity = '0';
                        w.style.transform = 'translateY(18px)';
                    });
                    aboutContent.style.transform = `translateY(calc(-50% + 40px))`;
                }
            });

            // === Phase 5b: About text + content slide out to the LEFT ===
            ScrollTrigger.create({
                trigger: '#scrollSectionAboutExit',
                start: 'top bottom',
                end: 'top center',
                scrub: 1.0,
                onUpdate: (self) => {
                    const progress = self.progress;
                    const fadeOut = 1 - progress;
                    const slideLeft = -progress * (window.innerWidth + 200);

                    // About text slides to the left
                    aboutText.style.opacity = String(Math.max(0, fadeOut));
                    gsap.set(aboutText, {
                        x: slideLeft
                    });

                    // About content also slides to the left (slide container + fade words)
                    gsap.set(aboutContent, { x: slideLeft * 0.8 });
                    aboutWordEls.forEach(w => {
                        w.style.opacity = String(Math.max(0, fadeOut));
                    });
                },
                onLeaveBack: () => {
                    // restored by Phase 4/5
                    gsap.set(aboutText, { x: 0 });
                    gsap.set(aboutContent, { x: 0 });
                }
            });

            // === Phase 5c: "CURSUS" text split from RIGHT (mirror of A PROPOS) ===
            const cursusText = document.getElementById('cursusText');
            const cursusString = cursusText.textContent;
            cursusText.textContent = '';
            cursusString.split('').forEach(char => {
                const span = document.createElement('span');
                span.className = 'cursus-char';
                span.textContent = char === ' ' ? '\u00A0' : char;
                cursusText.appendChild(span);
            });
            const cursusChars = cursusText.querySelectorAll('.cursus-char');

            // Start x-offset (off-screen to the right relative to natural right:48px position)
            const CURSUS_START_X = window.innerWidth < 768 ? window.innerWidth + 100 : window.innerWidth + 300;

            ScrollTrigger.create({
                trigger: '#cursus',
                start: 'top bottom',
                end: 'top top',
                scrub: 1.0,
                onUpdate: (self) => {
                    const progress = self.progress;

                    if (progress > 0.01) {
                        cursusText.style.opacity = '1';

                        // Mirror of A PROPOS: starts top-right offset, slides to center-right
                        // CSS already sets right:48px, so we only animate top + x offset
                        const currentX = CURSUS_START_X * (1 - progress); // from +offset to 0
                        const startY = 90;
                        const endY = window.innerHeight / 2;
                        const currentY = startY + (endY - startY) * progress;
                        const currentScale = 0.85 + 0.15 * progress;

                        gsap.set(cursusText, {
                            x: currentX,
                            top: currentY,
                            yPercent: -50,
                            scale: currentScale,
                            transformOrigin: 'right center'
                        });

                        // Progressive character reveal — each char slides in from right
                        const totalChars = cursusChars.length;
                        cursusChars.forEach((char, i) => {
                            const charStart = i / totalChars;
                            const charEnd = (i + 1) / totalChars;
                            const charProgress = Math.max(0, Math.min(1, (progress - charStart) / (charEnd - charStart)));
                            char.style.opacity = charProgress;
                            char.style.transform = `translateX(${(1 - charProgress) * 40}px)`;
                        });
                    } else {
                        cursusText.style.opacity = '0';
                        gsap.set(cursusText, { x: CURSUS_START_X, scale: 0.85 });
                        cursusChars.forEach(char => {
                            char.style.opacity = '0';
                            char.style.transform = 'translateX(40px)';
                        });
                    }
                },
                onLeaveBack: () => {
                    cursusText.style.opacity = '0';
                    gsap.set(cursusText, { x: CURSUS_START_X, scale: 0.85 });
                    cursusChars.forEach(char => {
                        char.style.opacity = '0';
                        char.style.transform = 'translateX(40px)';
                    });
                }
            });

            // === Phase 5d: Cursus content appears (same as about content) ===
            const cursusContent = document.getElementById('cursusContent');

            ScrollTrigger.create({
                trigger: '#scrollSectionCursusContent',
                start: 'top bottom',
                end: 'center center',
                scrub: 1.0,
                onUpdate: (self) => {
                    const progress = self.progress;

                    if (progress < 0.01) {
                        cursusContent.style.opacity = '0';
                        cursusContent.style.transform = `translateY(calc(-50% + 40px))`;
                        return;
                    }

                    const slideUp = (1 - progress) * 40;
                    cursusContent.style.opacity = String(Math.min(1, progress * 2.5));
                    cursusContent.style.transform = `translateY(calc(-50% + ${slideUp}px))`;
                },
                onLeaveBack: () => {
                    cursusContent.style.opacity = '0';
                    cursusContent.style.transform = `translateY(calc(-50% + 40px))`;
                }
            });

            // === Phase 5e: Keep cursus visible; stacks will mask it by sliding over ===
            ScrollTrigger.create({
                trigger: '#scrollSectionCursusExit',
                start: 'top bottom',
                end: 'top center',
                scrub: 1.0,
                onUpdate: () => {
                    cursusText.style.opacity = '1';
                    cursusContent.style.opacity = '1';
                    gsap.set(cursusText, { x: 0 });
                    gsap.set(cursusContent, { x: 0 });
                },
                onLeaveBack: () => {
                    gsap.set(cursusText, { x: 0 });
                    gsap.set(cursusContent, { x: 0 });
                    cursusText.style.opacity = '1';
                    cursusContent.style.opacity = '1';
                }
            });

            // === Phase 6: Stacks section slides up from bottom (inverse of Phase 1) ===
            const whiteOverlay = document.getElementById('whiteOverlay');
            const stacksSection = document.getElementById('stacksSection');
            const stacksTitle = stacksSection.querySelector('.stacks-title');
            const marqueeRow1 = document.getElementById('marqueeRow1');
            const marqueeRow2 = document.getElementById('marqueeRow2');

            // Helper to clear navbar inline styles
            function resetNavbarStyles() {
                navbar.style.background = '';
                navbar.style.mixBlendMode = '';
                navbar.querySelectorAll('.logo-first, .logo-last, .nav-links a, .btn-connect').forEach(el => {
                    el.style.color = '';
                });
                const btn = navbar.querySelector('.btn-connect');
                const toggle = navbar.querySelector('.theme-toggle');
                if (btn) { btn.style.borderColor = ''; btn.style.background = ''; }
                if (toggle) { toggle.style.borderColor = ''; toggle.style.background = ''; }
                navbar.querySelectorAll('.theme-toggle svg').forEach(s => s.style.fill = '');
            }

            ScrollTrigger.create({
                trigger: '#scrollSection6',
                start: 'top bottom',
                end: 'top top',
                scrub: 1.0,
                onUpdate: (self) => {
                    const progress = self.progress;

                    if (progress < 0.01) {
                        stacksSection.style.transform = 'translateY(100%)';
                        navbar.classList.add('is-blending');
                        resetNavbarStyles();
                        return;
                    }

                    // Stacks panel slides up from 100% to 0%
                    const slideUp = (1 - progress) * 100;
                    stacksSection.style.transform = `translateY(${slideUp}%)`;

                    // Navbar keeps mix-blend-mode:difference during slide
                    // This makes it readable on BOTH dark and light backgrounds automatically
                    navbar.classList.add('is-blending');

                    // Only when panel fully covers the screen (progress > 0.95),
                    // switch to normal navbar with light-mode colors
                    if (progress > 0.95) {
                        navbar.classList.remove('is-blending');
                        navbar.style.mixBlendMode = 'normal';
                        navbar.style.background = 'var(--bg-color)';
                        navbar.querySelectorAll('.logo-first, .logo-last, .nav-links a, .btn-connect').forEach(el => {
                            el.style.color = 'var(--text-color)';
                        });
                        const btn = navbar.querySelector('.btn-connect');
                        const toggle = navbar.querySelector('.theme-toggle');
                        if (btn) { btn.style.borderColor = 'var(--btn-border)'; btn.style.background = 'var(--btn-bg)'; }
                        if (toggle) { toggle.style.borderColor = 'var(--btn-border)'; toggle.style.background = 'var(--btn-bg)'; }
                        navbar.querySelectorAll('.theme-toggle svg').forEach(s => s.style.fill = 'var(--text-color)');
                    } else {
                        resetNavbarStyles();
                    }
                },
                onLeaveBack: () => {
                    stacksSection.style.transform = 'translateY(100%)';
                    navbar.classList.add('is-blending');
                    resetNavbarStyles();
                }
            });

            // === Phase 7: Stacks content scroll-reveal morph ===
            ScrollTrigger.create({
                trigger: '#scrollSection7',
                start: 'top bottom',
                end: 'center center',
                scrub: 1.0,
                onUpdate: (self) => {
                    const progress = self.progress;

                    // Phase A (0 → 0.4): Title morphs in from below
                    const titleProgress = Math.min(1, progress / 0.4);
                    gsap.set(stacksTitle, {
                        opacity: titleProgress,
                        y: (1 - titleProgress) * 60
                    });

                    // Phase B (0.3 → 0.7): First marquee row slides in from right
                    const row1Progress = Math.max(0, Math.min(1, (progress - 0.3) / 0.4));
                    gsap.set(marqueeRow1, {
                        opacity: row1Progress,
                        x: (1 - row1Progress) * 120
                    });

                    // Phase C (0.5 → 0.9): Second marquee row slides in from left
                    const row2Progress = Math.max(0, Math.min(1, (progress - 0.5) / 0.4));
                    gsap.set(marqueeRow2, {
                        opacity: row2Progress,
                        x: (1 - row2Progress) * -120
                    });
                },
                onLeaveBack: () => {
                    gsap.set(stacksTitle, { opacity: 0, y: 60 });
                    gsap.set(marqueeRow1, { opacity: 0, x: 120 });
                    gsap.set(marqueeRow2, { opacity: 0, x: -120 });
                }
            });

            // === Phase 8: Projets section slides up over stacks ===
            const projetsSection = document.getElementById('projets');

            ScrollTrigger.create({
                trigger: '#scrollSection8',
                start: 'top bottom',
                end: 'top top',
                scrub: 1.0,
                onUpdate: (self) => {
                    const progress = self.progress;

                    if (progress < 0.01) {
                        projetsSection.style.transform = 'translateY(100%)';
                        return;
                    }

                    const slideUp = (1 - progress) * 100;
                    projetsSection.style.transform = `translateY(${slideUp}%)`;

                    // Navbar blend during slide
                    navbar.classList.add('is-blending');

                    if (progress > 0.95) {
                        navbar.classList.remove('is-blending');
                        navbar.style.mixBlendMode = 'normal';
                        navbar.style.background = 'transparent';
                        navbar.querySelectorAll('.logo-first, .logo-last, .nav-links a, .btn-connect').forEach(el => {
                            el.style.color = '#fff';
                        });
                        const btn = navbar.querySelector('.btn-connect');
                        const toggle = navbar.querySelector('.theme-toggle');
                        if (btn) { btn.style.borderColor = 'rgba(255,255,255,0.4)'; btn.style.background = 'transparent'; }
                        if (toggle) { toggle.style.borderColor = 'rgba(255,255,255,0.4)'; toggle.style.background = 'transparent'; }
                        navbar.querySelectorAll('.theme-toggle svg').forEach(s => s.style.fill = '#fff');
                        cursorBlob.classList.add('on-projets');
                    } else {
                        resetNavbarStyles();
                        cursorBlob.classList.remove('on-projets');
                    }
                },
                onLeaveBack: () => {
                    projetsSection.style.transform = 'translateY(100%)';
                    cursorBlob.classList.remove('on-projets');
                    // Restore stacks navbar state
                    navbar.classList.remove('is-blending');
                    navbar.style.mixBlendMode = 'normal';
                    navbar.style.background = 'var(--bg-color)';
                    navbar.querySelectorAll('.logo-first, .logo-last, .nav-links a, .btn-connect').forEach(el => {
                        el.style.color = 'var(--text-color)';
                    });
                    const btn = navbar.querySelector('.btn-connect');
                    const toggle = navbar.querySelector('.theme-toggle');
                    if (btn) { btn.style.borderColor = 'var(--btn-border)'; btn.style.background = 'var(--btn-bg)'; }
                    if (toggle) { toggle.style.borderColor = 'var(--btn-border)'; toggle.style.background = 'var(--btn-bg)'; }
                    navbar.querySelectorAll('.theme-toggle svg').forEach(s => s.style.fill = 'var(--text-color)');
                }
            });

            // === Phase 9: Scroll through projects ===
            const allProjets = window.__projets || [];
            let activeFilter = 'all';
            let projets = [...allProjets];

            // Compute filter counts
            const countAll = allProjets.length;
            const countWeb = allProjets.filter(p => (p.type || 'Web').includes('Web')).length;
            const countDesktop = allProjets.filter(p => (p.type || '').includes('Desktop')).length;
            const countConsole = allProjets.filter(p => (p.type || '').includes('Console')).length;
            document.getElementById('countAll').textContent = countAll;
            document.getElementById('countWeb').textContent = countWeb;
            document.getElementById('countDesktop').textContent = countDesktop;
            document.getElementById('countConsole').textContent = countConsole;

            function applyFilter(filter) {
                activeFilter = filter;
                if (filter === 'all') {
                    projets = [...allProjets];
                } else {
                    projets = allProjets.filter(p => (p.type || 'Web').includes(filter));
                }
                document.querySelectorAll('.projets-filter-btn').forEach(btn => {
                    btn.classList.toggle('active', btn.dataset.filter === filter);
                });
                currentProjetIndex = -1;
                if (projets.length > 0) {
                    showProjet(0);
                    progressFill.style.width = (1 / projets.length * 100) + '%';
                }
            }

            document.querySelectorAll('.projets-filter-btn').forEach(btn => {
                btn.addEventListener('click', () => applyFilter(btn.dataset.filter));
            });
            const projetName = document.getElementById('projetName');
            const projetDesc = document.getElementById('projetDesc');
            const projetTags = document.getElementById('projetTags');
            const projetImage = document.getElementById('projetImage');
            const projetCounter = document.getElementById('projetCounter');
            const projetPrev = document.getElementById('projetPrev');
            const projetNext = document.getElementById('projetNext');
            const projetLinks = document.getElementById('projetLinks');
            const projetType = document.getElementById('projetType');
            const projetComplexiteFill = document.getElementById('projetComplexiteFill');
            const projetComplexiteValue = document.getElementById('projetComplexiteValue');
            const progressFill = document.getElementById('projetsProgressFill');
            let currentProjetIndex = -1;

            const typeIcons = {
                'Web': '<svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>',
                'Desktop': '<svg viewBox="0 0 24 24"><path d="M21 2H3c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h7l-2 3v1h8v-1l-2-3h7c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 12H3V4h18v10z"/></svg>',
                'Console': '<svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zM7.41 14.41L6 15l-4-4 4-4 1.41 1.41L4.83 11l2.58 2.41zM10 17l-1.56-.56 4-12L14 4l-4 12h0zm6.59-.41L18 15l4-4-4-4-1.41 1.41L19.17 11l-2.58 2.59z"/></svg>',
            };

            function getComplexiteColor(val) {
                if (val >= 75) return '#000';
                if (val >= 50) return '#333';
                if (val >= 30) return '#555';
                return '#777';
            }

            function setProjet(index) {
                if (!projets[index]) return;
                const p = projets[index];

                // Type badge
                const pType = p.type || 'Web';
                const mainType = pType.split(' / ')[0].trim();
                const icon = typeIcons[mainType] || typeIcons['Web'];
                projetType.innerHTML = icon + ' ' + pType;

                projetName.textContent = p.titre;
                projetDesc.textContent = p.description;

                // Complexite bar
                const cplx = p.complexite || 50;
                projetComplexiteFill.style.width = cplx + '%';
                projetComplexiteFill.style.background = getComplexiteColor(cplx);
                projetComplexiteValue.textContent = cplx + '%';

                projetTags.innerHTML = '';
                const tags = Array.isArray(p.tags) ? p.tags : JSON.parse(p.tags || '[]');
                tags.forEach(tag => {
                    const span = document.createElement('span');
                    span.className = 'projet-tag';
                    span.textContent = tag;
                    projetTags.appendChild(span);
                });
                projetLinks.innerHTML = '';
                if (p.lien) {
                    const a = document.createElement('a');
                    a.href = p.lien;
                    a.target = '_blank';
                    a.rel = 'noopener noreferrer';
                    a.className = 'projet-link projet-link--site';
                    const isDownload = p.lien.includes('/releases/');
                    a.innerHTML = isDownload
                        ? '<svg viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg> Télécharger'
                        : '<svg viewBox="0 0 24 24"><path d="M14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/><path d="M5 5v14h14v-7h-2v5H7V7h5V5H5z"/></svg> Voir le site';
                    projetLinks.appendChild(a);
                }
                if (p.github) {
                    const a = document.createElement('a');
                    a.href = p.github;
                    a.target = '_blank';
                    a.rel = 'noopener noreferrer';
                    a.className = 'projet-link projet-link--github';
                    a.innerHTML = '<svg viewBox="0 0 24 24"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0 0 24 12c0-6.63-5.37-12-12-12z"/></svg> GitHub';
                    projetLinks.appendChild(a);
                }
                projetCounter.textContent = (index + 1) + ' / ' + projets.length;
                projetPrev.disabled = (index === 0);
                projetNext.disabled = (index === projets.length - 1);
                if (p.image) {
                    projetImage.innerHTML = '<img src="/' + p.image + '" alt="' + p.titre + '">';
                } else {
                    const pType = (p.type || 'Web').toLowerCase();
                    if (pType.includes('console')) {
                        projetImage.innerHTML = '<div class="projet-image-console"><svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8h16v12zM6 10l4 4-4 4h2l3-3 1-1-1-1-3-3H6zm6 6h4v2h-4v-2z"/></svg><span>Application Console</span></div>';
                    } else {
                        projetImage.innerHTML = '<span class="projet-image-placeholder">image</span>';
                    }
                }
            }

            function showProjet(index) {
                if (index === currentProjetIndex || !projets[index]) return;
                const direction = index > currentProjetIndex ? 1 : -1;
                currentProjetIndex = index;

                progressFill.style.width = ((index + 1) / projets.length * 100) + '%';

                gsap.to('.projet-info', { opacity: 0, x: -40 * direction, duration: 0.3, ease: 'power2.in', onComplete: () => {
                    setProjet(index);
                    gsap.fromTo('.projet-info', { opacity: 0, x: 40 * direction }, { opacity: 1, x: 0, duration: 0.45, ease: 'power2.out' });
                }});

                gsap.to('#projetImage', { opacity: 0, scale: 0.92, duration: 0.3, ease: 'power2.in', onComplete: () => {
                    gsap.fromTo('#projetImage', { opacity: 0, scale: 0.92 }, { opacity: 1, scale: 1, duration: 0.45, ease: 'power2.out' });
                }});
            }

            // Set first project immediately (no animation)
            if (projets.length > 0) {
                setProjet(0);
                currentProjetIndex = 0;
                progressFill.style.width = (1 / projets.length * 100) + '%';
            }

            projetPrev.addEventListener('click', () => {
                if (currentProjetIndex > 0) showProjet(currentProjetIndex - 1);
            });
            projetNext.addEventListener('click', () => {
                if (currentProjetIndex < projets.length - 1) showProjet(currentProjetIndex + 1);
            });

            // Dynamically set scroll height based on project count for smooth pacing
            const scrollSection9 = document.getElementById('scrollSection9');
            const isMobile = window.innerWidth <= 768;
            const vhPerProject = isMobile ? 18 : 30;
            scrollSection9.style.height = Math.max(200, projets.length * vhPerProject) + 'vh';

            ScrollTrigger.create({
                trigger: '#scrollSection9',
                start: 'top top',
                end: 'bottom bottom',
                scrub: 1.2,
                onUpdate: (self) => {
                    const progress = self.progress;
                    const count = projets.length;
                    if (count <= 1) {
                        progressFill.style.width = '100%';
                        return;
                    }
                    const idx = Math.min(Math.floor(progress * count), count - 1);
                    showProjet(idx);
                    progressFill.style.width = ((idx + 1) / count * 100) + '%';
                }
            });

            // === Phase 10: Contact section slides up over projets ===
            const contactSection = document.getElementById('contact');

            ScrollTrigger.create({
                trigger: '#scrollSectionContact',
                start: 'top bottom',
                end: 'top top',
                scrub: 1.0,
                onUpdate: (self) => {
                    const progress = self.progress;

                    if (progress < 0.01) {
                        contactSection.style.transform = 'translateY(100%)';
                        contactSection.classList.remove('active');
                        return;
                    }

                    const slideUp = (1 - progress) * 100;
                    contactSection.style.transform = `translateY(${slideUp}%)`;

                    if (progress > 0.95) {
                        contactSection.classList.add('active');
                        navbar.classList.remove('is-blending');
                        navbar.style.mixBlendMode = 'normal';
                        navbar.style.background = 'var(--bg-color)';
                        navbar.querySelectorAll('.logo-first, .logo-last, .nav-links a, .btn-connect').forEach(el => {
                            el.style.color = 'var(--text-color)';
                        });
                        const btn = navbar.querySelector('.btn-connect');
                        const toggle = navbar.querySelector('.theme-toggle');
                        if (btn) { btn.style.borderColor = 'var(--btn-border)'; btn.style.background = 'var(--btn-bg)'; }
                        if (toggle) { toggle.style.borderColor = 'var(--btn-border)'; toggle.style.background = 'var(--btn-bg)'; }
                        navbar.querySelectorAll('.theme-toggle svg').forEach(s => s.style.fill = 'var(--text-color)');
                        cursorBlob.classList.remove('on-projets');
                    } else {
                        contactSection.classList.remove('active');
                    }
                },
                onLeaveBack: () => {
                    contactSection.style.transform = 'translateY(100%)';
                    contactSection.classList.remove('active');
                    // Restore projets navbar state
                    navbar.style.background = 'transparent';
                    navbar.querySelectorAll('.logo-first, .logo-last, .nav-links a, .btn-connect').forEach(el => {
                        el.style.color = '#fff';
                    });
                    const btn = navbar.querySelector('.btn-connect');
                    const toggle = navbar.querySelector('.theme-toggle');
                    if (btn) { btn.style.borderColor = 'rgba(255,255,255,0.4)'; btn.style.background = 'transparent'; }
                    if (toggle) { toggle.style.borderColor = 'rgba(255,255,255,0.4)'; toggle.style.background = 'transparent'; }
                    navbar.querySelectorAll('.theme-toggle svg').forEach(s => s.style.fill = '#fff');
                    cursorBlob.classList.add('on-projets');
                }
            });

            // WebGL Image Deformation on project image (from monTerrain)
            class WebGLImageDeform {
                constructor(container) {
                    this.container = container;
                    this.img = container.querySelector('img');
                    this.canvas = null;
                    this.gl = null;
                    this.program = null;
                    this.mouse = { x: 0.5, y: 0.5 };
                    this.targetMouse = { x: 0.5, y: 0.5 };
                    this.prevMouse = { x: 0.5, y: 0.5 };
                    this.velocity = 0;
                    this.hover = 0;
                    this.targetHover = 0;
                    this.raf = null;
                    this.textureReady = false;
                    this.uMouse = null;
                    this.uHover = null;
                    this.uTime = null;
                    this.uVelocity = null;
                    this.uResolution = null;
                }

                init() {
                    this.img = this.container.querySelector('img');
                    if (!this.img) return;
                    // Remove old canvas
                    const oldCanvas = this.container.querySelector('.webgl-canvas');
                    if (oldCanvas) oldCanvas.remove();

                    this.canvas = document.createElement('canvas');
                    this.canvas.className = 'webgl-canvas';
                    this.container.appendChild(this.canvas);

                    this.gl = this.canvas.getContext('webgl', { premultipliedAlpha: false, alpha: true });
                    if (!this.gl) return;

                    this.mouse = { x: 0.5, y: 0.5 };
                    this.targetMouse = { x: 0.5, y: 0.5 };
                    this.prevMouse = { x: 0.5, y: 0.5 };
                    this.velocity = 0;
                    this.hover = 0;
                    this.targetHover = 0;
                    this.textureReady = false;

                    this.resize();
                    this.createShader();
                    this.createTexture();
                    this.addListeners();
                }

                resize() {
                    const rect = this.container.getBoundingClientRect();
                    this.canvas.width = rect.width * window.devicePixelRatio;
                    this.canvas.height = rect.height * window.devicePixelRatio;
                    if (this.gl) this.gl.viewport(0, 0, this.canvas.width, this.canvas.height);
                }

                createShader() {
                    const gl = this.gl;
                    const vertSrc = `
                        attribute vec2 a_position;
                        attribute vec2 a_texCoord;
                        varying vec2 v_texCoord;
                        void main() {
                            gl_Position = vec4(a_position, 0.0, 1.0);
                            v_texCoord = a_texCoord;
                        }
                    `;
                    const fragSrc = `
                        precision highp float;
                        varying vec2 v_texCoord;
                        uniform sampler2D u_texture;
                        uniform vec2 u_mouse;
                        uniform float u_hover;
                        uniform float u_time;
                        uniform float u_velocity;
                        uniform vec2 u_resolution;

                        vec2 pixelate(vec2 uv, float blockSize) {
                            return floor(uv / blockSize) * blockSize;
                        }
                        float hash(vec2 p) {
                            return fract(sin(dot(p, vec2(127.1, 311.7))) * 43758.5453);
                        }
                        void main() {
                            vec2 uv = v_texCoord;
                            vec2 aspect = vec2(u_resolution.x / u_resolution.y, 1.0);
                            float dist = distance(uv * aspect, u_mouse * aspect);
                            float radius = 0.35 + u_velocity * 0.15;
                            float falloff = smoothstep(radius, 0.0, dist);
                            float strength = falloff * u_hover;

                            float blockSize = mix(0.008, 0.04, 1.0 - falloff) + u_velocity * 0.02;
                            vec2 blockUV = pixelate(uv, blockSize);

                            float rnd = hash(blockUV * 100.0 + floor(u_time * 2.0));
                            float rnd2 = hash(blockUV * 73.0 + 45.0);
                            vec2 dir = uv - u_mouse;
                            vec2 blockDir = normalize(dir + 0.0001);

                            float displaceAmount = strength * 0.08 * (0.5 + rnd * 0.5);
                            displaceAmount += u_velocity * strength * 0.06;

                            vec2 offset = vec2(0.0);
                            if (rnd > 0.5) {
                                offset.x = blockDir.x * displaceAmount * (rnd2 > 0.5 ? 1.0 : -0.6);
                            } else {
                                offset.y = blockDir.y * displaceAmount * (rnd2 > 0.3 ? 1.0 : -0.6);
                            }

                            vec2 displaced = uv + offset;
                            float chromaAmount = strength * 0.006 + u_velocity * strength * 0.004;
                            vec2 chromaOffset = blockDir * chromaAmount;

                            float r = texture2D(u_texture, displaced + chromaOffset).r;
                            float g = texture2D(u_texture, displaced).g;
                            float b = texture2D(u_texture, displaced - chromaOffset).b;
                            float a = texture2D(u_texture, displaced).a;

                            float glow = smoothstep(0.25, 0.0, dist) * u_hover * 0.12;
                            vec3 col = vec3(r, g, b) + glow;
                            gl_FragColor = vec4(col, a);
                        }
                    `;

                    const vs = gl.createShader(gl.VERTEX_SHADER);
                    gl.shaderSource(vs, vertSrc);
                    gl.compileShader(vs);
                    const fs = gl.createShader(gl.FRAGMENT_SHADER);
                    gl.shaderSource(fs, fragSrc);
                    gl.compileShader(fs);

                    this.program = gl.createProgram();
                    gl.attachShader(this.program, vs);
                    gl.attachShader(this.program, fs);
                    gl.linkProgram(this.program);
                    gl.useProgram(this.program);

                    // Positions
                    const posBuf = gl.createBuffer();
                    gl.bindBuffer(gl.ARRAY_BUFFER, posBuf);
                    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1,-1, 1,-1, -1,1, 1,1]), gl.STATIC_DRAW);
                    const aPos = gl.getAttribLocation(this.program, 'a_position');
                    gl.enableVertexAttribArray(aPos);
                    gl.vertexAttribPointer(aPos, 2, gl.FLOAT, false, 0, 0);

                    // Tex coords
                    const texBuf = gl.createBuffer();
                    gl.bindBuffer(gl.ARRAY_BUFFER, texBuf);
                    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([0,1, 1,1, 0,0, 1,0]), gl.STATIC_DRAW);
                    const aTex = gl.getAttribLocation(this.program, 'a_texCoord');
                    gl.enableVertexAttribArray(aTex);
                    gl.vertexAttribPointer(aTex, 2, gl.FLOAT, false, 0, 0);

                    // Uniforms
                    this.uMouse = gl.getUniformLocation(this.program, 'u_mouse');
                    this.uHover = gl.getUniformLocation(this.program, 'u_hover');
                    this.uTime = gl.getUniformLocation(this.program, 'u_time');
                    this.uVelocity = gl.getUniformLocation(this.program, 'u_velocity');
                    this.uResolution = gl.getUniformLocation(this.program, 'u_resolution');
                }

                createTexture() {
                    const gl = this.gl;
                    const tex = gl.createTexture();
                    gl.bindTexture(gl.TEXTURE_2D, tex);
                    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE);
                    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE);
                    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);
                    gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);

                    const loadTex = () => {
                        gl.bindTexture(gl.TEXTURE_2D, tex);
                        gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, this.img);
                        this.textureReady = true;
                    };

                    if (this.img.complete && this.img.naturalWidth > 0) {
                        loadTex();
                    } else {
                        this.img.addEventListener('load', loadTex, { once: true });
                    }
                }

                addListeners() {
                    this.container.addEventListener('mouseenter', () => {
                        this.targetHover = 1;
                        this.canvas.style.opacity = '1';
                        this.img.style.opacity = '0';
                        this.startRender();
                        gsap.to(cursorBlob, { width: 80, height: 80, duration: 0.3, ease: 'power2.out' });
                    });
                    this.container.addEventListener('mouseleave', () => {
                        this.targetHover = 0;
                        setTimeout(() => {
                            if (this.targetHover === 0) {
                                this.canvas.style.opacity = '0';
                                this.img.style.opacity = '1';
                            }
                        }, 500);
                        gsap.to(cursorBlob, { width: 30, height: 30, duration: 0.3, ease: 'power2.out' });
                    });
                    this.container.addEventListener('mousemove', (e) => {
                        const rect = this.container.getBoundingClientRect();
                        this.targetMouse.x = (e.clientX - rect.left) / rect.width;
                        this.targetMouse.y = (e.clientY - rect.top) / rect.height;
                    });
                }

                startRender() {
                    if (!this.raf) this.render();
                }

                render() {
                    const gl = this.gl;
                    if (!gl) return;

                    this.mouse.x += (this.targetMouse.x - this.mouse.x) * 0.15;
                    this.mouse.y += (this.targetMouse.y - this.mouse.y) * 0.15;
                    this.hover += (this.targetHover - this.hover) * 0.1;

                    const dx = this.mouse.x - this.prevMouse.x;
                    const dy = this.mouse.y - this.prevMouse.y;
                    const rawVel = Math.sqrt(dx * dx + dy * dy);
                    this.velocity += (rawVel - this.velocity) * 0.15;
                    this.prevMouse.x = this.mouse.x;
                    this.prevMouse.y = this.mouse.y;

                    if (this.textureReady) {
                        gl.useProgram(this.program);
                        gl.uniform2f(this.uMouse, this.mouse.x, this.mouse.y);
                        gl.uniform1f(this.uHover, this.hover);
                        gl.uniform1f(this.uTime, performance.now() * 0.001);
                        gl.uniform1f(this.uVelocity, Math.min(this.velocity * 40, 1.0));
                        gl.uniform2f(this.uResolution, this.canvas.width, this.canvas.height);
                        gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);
                    }

                    if (this.hover > 0.001 || this.targetHover > 0) {
                        this.raf = requestAnimationFrame(() => this.render());
                    } else {
                        this.raf = null;
                    }
                }

                destroy() {
                    if (this.raf) cancelAnimationFrame(this.raf);
                    if (this.canvas) this.canvas.remove();
                    this.gl = null;
                    this.textureReady = false;
                }
            }

            // Initialize WebGL deform on project image
            const projetImageEl = document.getElementById('projetImage');
            let webglDeform = new WebGLImageDeform(projetImageEl);

            // Re-init WebGL when project changes (image swaps)
            const origSetProjet = setProjet;
            setProjet = function(index) {
                if (webglDeform) webglDeform.destroy();
                origSetProjet(index);
                // Wait for new img to be in DOM
                requestAnimationFrame(() => {
                    const img = projetImageEl.querySelector('img');
                    if (img) {
                        webglDeform = new WebGLImageDeform(projetImageEl);
                        if (img.complete && img.naturalWidth > 0) {
                            webglDeform.init();
                        } else {
                            img.addEventListener('load', () => webglDeform.init(), { once: true });
                        }
                    }
                });
            };

            // Refresh ScrollTrigger after setup (recalculate positions once fonts are loaded)
            document.fonts.ready.then(() => ScrollTrigger.refresh());

            // ===== SCROLL HINT: show after inactivity =====
            const scrollHint = document.getElementById('scrollHint');
            let scrollHintTimer = null;
            let scrollHintShown = false;
            const HINT_DELAY = 5000; // 5 seconds of inactivity

            function hideScrollHint() {
                if (scrollHint) scrollHint.classList.remove('visible');
                scrollHintShown = false;
            }

            function resetScrollHintTimer() {
                if (scrollHintTimer) clearTimeout(scrollHintTimer);
                hideScrollHint();
                // Don't show hint if user has scrolled past the hero
                if (window.scrollY > window.innerHeight * 0.5) return;
                scrollHintTimer = setTimeout(() => {
                    if (window.scrollY < window.innerHeight * 0.5 && scrollHint) {
                        scrollHint.classList.add('visible');
                        scrollHintShown = true;
                    }
                }, HINT_DELAY);
            }

            // Start timer on page load
            resetScrollHintTimer();
            // Reset on user activity
            ['scroll', 'mousemove', 'touchstart', 'keydown'].forEach(evt => {
                window.addEventListener(evt, () => {
                    if (scrollHintShown) hideScrollHint();
                    resetScrollHintTimer();
                }, { passive: true });
            });

            // ===== HAMBURGER MENU =====
            const hamburger = document.getElementById('hamburgerBtn');
            const mobileOverlay = document.getElementById('mobileMenuOverlay');

            if (hamburger && mobileOverlay) {
                hamburger.addEventListener('click', () => {
                    hamburger.classList.toggle('active');
                    mobileOverlay.classList.toggle('open');
                    document.body.style.overflow = mobileOverlay.classList.contains('open') ? 'hidden' : '';
                });

                // Close menu on link click
                mobileOverlay.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        hamburger.classList.remove('active');
                        mobileOverlay.classList.remove('open');
                        document.body.style.overflow = '';
                        const target = document.querySelector(link.getAttribute('href'));
                        if (target) {
                            setTimeout(() => target.scrollIntoView({ behavior: 'smooth' }), 100);
                        }
                    });
                });
            }
        });
    </script>

</body>
</html>
