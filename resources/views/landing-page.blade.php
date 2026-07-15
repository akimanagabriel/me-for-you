<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description"
          content="ME FOR YOU offers trusted housing, event management, and transport services in Kigali, Rwanda." />
    <meta name="theme-color" content="#b87f3a" />

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="ME FOR YOU | Professional Companion for Housing, Events & Transport" />
    <meta property="og:description"
          content="From premium housing support to unforgettable events and reliable transport, ME FOR YOU helps you move through every milestone with confidence." />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:image" content="{{ asset('android-chrome-512x512.png') }}" />
    <meta property="og:image:alt" content="ME FOR YOU logo" />
    <meta property="og:site_name" content="ME FOR YOU" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="ME FOR YOU | Professional Companion for Housing, Events & Transport" />
    <meta name="twitter:description"
          content="Trusted housing, event management, and transport services in Kigali, Rwanda." />
    <meta name="twitter:image" content="{{ asset('android-chrome-512x512.png') }}" />
    <meta name="twitter:image:alt" content="ME FOR YOU logo" />

    <title>ME FOR YOU Your Professional Companion</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600&display=swap"
          rel="stylesheet" />

    <style>
        /* ─── TOKENS ──────────────────────────────────────────────── */
        :root {
            --gold: #b87f3a;
            --gold-light: #d49d6a;
            --gold-dark: #8a6e22;
            --ink: #1a1714;
            --ink-mid: #3d3830;
            --sand: #f5f0e8;
            --sand-dark: #ede7d8;
            --white: #ffffff;
            --muted: #7a7268;
            --font-display: "Cormorant Garamond", Georgia, serif;
            --font-body: "Inter", system-ui, sans-serif;
            --radius-sm: 6px;
            --radius-md: 12px;
            --radius-lg: 20px;
            --max-w: 1200px;
            --section-py: 80px;
        }

        /* ─── RESET ──────────────────────────────────────────────── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-body);
            background: var(--white);
            color: var(--ink);
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        img {
            display: block;
            max-width: 100%;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        /* ─── UTILITY ─────────────────────────────────────────────── */
        .container {
            max-width: var(--max-w);
            margin: 0 auto;
            padding: 0 24px;
        }

        .section-label {
            font-family: var(--font-body);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 12px;
        }

        .section-title {
            font-family: var(--font-display);
            font-size: clamp(32px, 4vw, 52px);
            font-weight: 600;
            line-height: 1.15;
            color: var(--ink);
        }

        .section-title em {
            font-style: italic;
            color: var(--gold);
        }

        .section-body {
            font-size: 16px;
            color: var(--muted);
            line-height: 1.75;
            max-width: 540px;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--gold);
            color: var(--white);
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.04em;
            padding: 14px 28px;
            border-radius: var(--radius-sm);
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: var(--gold-dark);
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: var(--white);
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.04em;
            padding: 13px 27px;
            border-radius: var(--radius-sm);
            border: 1.5px solid rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
        }

        .btn-outline:hover {
            border-color: var(--white);
            background: rgba(255, 255, 255, 0.08);
        }

        /* ─── IMAGE OPTIMIZATION ───────────────────────────────────── */
        .img-wrapper {
            position: relative;
            overflow: hidden;
            background: var(--sand-dark);
            width: 100%;
            height: 100%;
        }

        .img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
            will-change: transform;
        }

        .img-wrapper img:hover {
            transform: scale(1.05);
        }

        .img-wrapper .fallback {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-body);
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--gold-dark);
            background: repeating-linear-gradient(45deg,
                    transparent,
                    transparent 10px,
                    rgba(184, 153, 58, 0.06) 10px,
                    rgba(184, 153, 58, 0.06) 20px);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .img-wrapper img:not([src])+.fallback,
        .img-wrapper img[src=""]+.fallback {
            opacity: 1;
        }

        /* ─── NAV ─────────────────────────────────────────────────── */
        .nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 0 24px;
            transition: background 0.3s, box-shadow 0.3s;
            will-change: background;
        }

        .nav.scrolled {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 1px 0 rgba(0, 0, 0, 0.08);
        }

        .nav-inner {
            max-width: var(--max-w);
            margin: 0 auto;
            height: 72px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 600;
            color: var(--white);
            letter-spacing: 0.02em;
            transition: color 0.3s;
            z-index: 2;
        }

        .nav-logo__img {
            width: 40px;
            height: 40px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .nav-logo__text {
            line-height: 1;
            color: inherit;
        }

        .nav-logo__text span {
            color: var(--gold);
        }

        .nav.scrolled .nav-logo {
            color: var(--ink);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .nav-links a {
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.04em;
            color: rgba(255, 255, 255, 0.85);
            transition: color 0.2s;
        }

        .nav.scrolled .nav-links a {
            color: var(--ink-mid);
        }

        .nav-links a:hover {
            color: var(--gold);
        }

        .nav-cta {
            font-size: 13px;
            font-weight: 500;
            padding: 9px 20px;
            border-radius: var(--radius-sm);
            background: var(--gold) !important;
            color: var(--white) !important;
            transition: background 0.2s !important;
        }

        .nav-cta:hover {
            background: var(--gold-dark) !important;
        }

        .nav-hamburger {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            width: 40px;
            height: 40px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            z-index: 2;
        }

        .nav-hamburger span {
            display: block;
            width: 24px;
            height: 2px;
            background: var(--white);
            border-radius: 2px;
            transition: background 0.3s, transform 0.3s, opacity 0.3s;
        }

        .nav.scrolled .nav-hamburger span {
            background: var(--ink);
        }

        .nav-hamburger.open span:nth-child(1) {
            transform: translateY(7px) rotate(45deg);
        }

        .nav-hamburger.open span:nth-child(2) {
            opacity: 0;
            transform: scaleX(0);
        }

        .nav-hamburger.open span:nth-child(3) {
            transform: translateY(-7px) rotate(-45deg);
        }

        .nav-mobile {
            display: none;
            position: fixed;
            top: 72px;
            left: 0;
            right: 0;
            background: rgba(26, 23, 20, 0.97);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 0 24px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s ease, padding 0.35s ease;
            z-index: 99;
        }

        .nav-mobile.open {
            max-height: 400px;
            padding: 16px 24px 28px;
        }

        .nav-mobile a {
            display: block;
            font-size: 15px;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.8);
            padding: 13px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            letter-spacing: 0.03em;
            transition: color 0.2s;
        }

        .nav-mobile a:last-child {
            border-bottom: none;
        }

        .nav-mobile a:hover {
            color: var(--gold-light);
        }

        .nav-mobile .nav-mobile-cta {
            margin-top: 16px;
            display: block;
            text-align: center;
            background: var(--gold);
            color: var(--white) !important;
            border-radius: var(--radius-sm);
            padding: 13px 20px;
            font-weight: 600;
            border-bottom: none !important;
        }

        .nav-mobile .nav-mobile-cta:hover {
            background: var(--gold-dark);
        }

        /* ─── HERO ────────────────────────────────────────────────── */
        .hero {
            position: relative;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
        }

        .hero-left {
            position: relative;
            z-index: 2;
            background: var(--ink);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 120px 64px 80px;
        }

        .hero-left::after {
            content: "";
            position: absolute;
            right: -1px;
            top: 0;
            bottom: 0;
            width: 60px;
            background: var(--ink);
            clip-path: polygon(0 0, 0 100%, 100% 100%);
            z-index: 3;
        }

        .hero-tagline {
            font-family: var(--font-body);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 20px;
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(40px, 5vw, 68px);
            font-weight: 600;
            line-height: 1.1;
            color: var(--white);
            margin-bottom: 20px;
        }

        .hero-title em {
            font-style: italic;
            color: var(--gold-light);
        }

        .hero-sub {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.7;
            max-width: 400px;
            margin-bottom: 40px;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .hero-services {
            display: flex;
            gap: 24px;
            margin-top: 56px;
            padding-top: 32px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hero-service-pill {
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.06em;
            color: rgba(255, 255, 255, 0.5);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .hero-service-pill::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
        }

        .hero-right {
            display: grid;
            grid-template-rows: 60% 40%;
            position: relative;
        }

        .hero-img-top {
            position: relative;
            overflow: hidden;
        }

        .hero-img-bottom {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .hero-img-cell {
            position: relative;
            overflow: hidden;
        }

        .hero-img-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 60%, rgba(0, 0, 0, 0.3));
            pointer-events: none;
        }

        .hero-badge {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            font-size: 11px;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        /* ─── STATS BAR ───────────────────────────────────────────── */
        .stats-bar {
            background: var(--gold);
            padding: 28px 24px;
        }

        .stats-inner {
            max-width: var(--max-w);
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            text-align: center;
        }

        .stat-num {
            font-family: var(--font-display);
            font-size: 36px;
            font-weight: 600;
            color: var(--white);
            line-height: 1;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.75);
            margin-top: 4px;
            text-transform: uppercase;
        }

        .stat-divider {
            border-left: 1px solid rgba(255, 255, 255, 0.25);
        }

        /* ─── ABOUT ────────────────────────────────────────────────── */
        .about {
            padding: var(--section-py) 24px;
        }

        .about-inner {
            max-width: var(--max-w);
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .about-img-wrap {
            position: relative;
            height: 520px;
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .about-accent {
            position: absolute;
            bottom: -20px;
            right: -20px;
            width: 160px;
            height: 160px;
            border-radius: var(--radius-lg);
            border: 3px solid var(--gold);
            z-index: -1;
        }

        .about-values {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-top: 40px;
        }

        .value-card {
            background: var(--sand);
            border-radius: var(--radius-md);
            padding: 20px;
            border-left: 3px solid var(--gold);
        }

        .value-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 4px;
        }

        .value-desc {
            font-size: 13px;
            color: var(--muted);
            line-height: 1.55;
        }

        /* ─── SERVICES ─────────────────────────────────────────────── */
        .services {
            background: var(--sand);
            padding: var(--section-py) 24px;
        }

        .services-header {
            max-width: var(--max-w);
            margin: 0 auto 56px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .services-grid {
            max-width: var(--max-w);
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }

        .service-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            overflow: hidden;
            transition: transform 0.25s, box-shadow 0.25s;
            will-change: transform;
        }

        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.1);
        }

        .service-img {
            height: 240px;
            position: relative;
            overflow: hidden;
        }

        .service-img .img-wrapper {
            height: 100%;
        }

        .service-chip {
            position: absolute;
            top: 16px;
            left: 16px;
            background: var(--white);
            border-radius: 99px;
            padding: 6px 14px;
            font-size: 11px;
            font-weight: 600;
            color: var(--gold-dark);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            z-index: 2;
        }

        .service-body {
            padding: 28px;
        }

        .service-name {
            font-family: var(--font-display);
            font-size: 26px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 10px;
        }

        .service-desc {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.65;
            margin-bottom: 20px;
        }

        .service-features {
            margin-bottom: 24px;
        }

        .service-feature {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--ink-mid);
            padding: 5px 0;
        }

        .service-feature::before {
            content: "";
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--gold);
            flex-shrink: 0;
        }

        .service-link {
            font-size: 13px;
            font-weight: 600;
            color: var(--gold-dark);
            letter-spacing: 0.04em;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .service-link::after {
            content: "→";
        }

        /* ─── GALLERY ──────────────────────────────────────────────── */
        .gallery {
            padding: var(--section-py) 24px;
        }

        .gallery-header {
            max-width: var(--max-w);
            margin: 0 auto 48px;
            text-align: center;
        }

        .gallery-header .section-body {
            margin: 12px auto 0;
        }

        .gallery-grid {
            max-width: var(--max-w);
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: 280px 200px;
            gap: 12px;
        }

        .gal-item {
            position: relative;
            border-radius: var(--radius-md);
            overflow: hidden;
            cursor: pointer;
        }

        .gal-item:nth-child(1) {
            grid-column: 1;
            grid-row: 1;
        }

        .gal-item:nth-child(2) {
            grid-column: 2;
            grid-row: 1;
        }

        .gal-item:nth-child(3) {
            grid-column: 3;
            grid-row: 1 / 3;
        }

        .gal-item:nth-child(4) {
            grid-column: 1;
            grid-row: 2;
        }

        .gal-item:nth-child(5) {
            grid-column: 2;
            grid-row: 2;
        }

        .gal-item .img-wrapper {
            height: 100%;
            transition: transform 0.4s ease;
            will-change: transform;
        }

        .gal-item:hover .img-wrapper {
            transform: scale(1.06);
        }

        .gal-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(26, 23, 20, 0.75) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s;
            display: flex;
            align-items: flex-end;
            padding: 20px;
            pointer-events: none;
        }

        .gal-item:hover .gal-overlay {
            opacity: 1;
        }

        .gal-label {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 600;
            color: var(--white);
        }

        /* ─── TESTIMONIALS ─────────────────────────────────────────── */
        .testimonials {
            background: var(--ink);
            padding: var(--section-py) 24px;
        }

        .testimonials .section-title {
            color: var(--white);
        }

        .testimonials-header {
            max-width: var(--max-w);
            margin: 0 auto 48px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .testimonials-grid {
            max-width: var(--max-w);
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .testi-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-lg);
            padding: 32px;
            transition: background 0.25s;
        }

        .testi-card:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .testi-stars {
            display: flex;
            gap: 3px;
            margin-bottom: 20px;
            color: var(--gold);
            font-size: 14px;
        }

        .testi-quote {
            font-family: var(--font-display);
            font-size: 18px;
            font-style: italic;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .testi-author {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .testi-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            background: var(--ink-mid);
        }

        .testi-avatar .img-wrapper {
            border-radius: 50%;
        }

        .testi-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--white);
        }

        .testi-role {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.45);
            margin-top: 2px;
        }

        /* ─── CTA BANNER ───────────────────────────────────────────── */
        .cta-banner {
            background: var(--sand);
            padding: var(--section-py) 24px;
        }

        .cta-inner {
            max-width: var(--max-w);
            margin: 0 auto;
            background: var(--gold);
            border-radius: var(--radius-lg);
            padding: 64px 72px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 48px;
            align-items: center;
        }

        .cta-title {
            font-family: var(--font-display);
            font-size: clamp(28px, 3vw, 44px);
            font-weight: 600;
            color: var(--white);
            line-height: 1.2;
        }

        .cta-title em {
            font-style: italic;
            opacity: 0.8;
        }

        .cta-sub {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.75);
            margin-top: 10px;
            line-height: 1.6;
        }

        .cta-actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            align-items: flex-end;
        }

        .btn-cta-white {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--white);
            color: var(--gold-dark);
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 0.04em;
            padding: 14px 28px;
            border-radius: var(--radius-sm);
            border: none;
            cursor: pointer;
            white-space: nowrap;
            transition: opacity 0.2s;
        }

        .btn-cta-white:hover {
            opacity: 0.9;
        }

        /* ─── FOOTER ───────────────────────────────────────────────── */
        .footer {
            background: var(--ink);
            padding: 60px 24px 32px;
            color: rgba(255, 255, 255, 0.6);
        }

        .footer-inner {
            max-width: var(--max-w);
            margin: 0 auto;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 48px;
            padding-bottom: 48px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 32px;
        }

        .footer-brand-name {
            font-family: var(--font-display);
            font-size: 26px;
            font-weight: 600;
            color: var(--white);
            margin-bottom: 12px;
        }

        .footer-brand-name span {
            color: var(--gold);
        }

        .footer-brand-desc {
            font-size: 14px;
            line-height: 1.7;
            max-width: 280px;
            margin-bottom: 24px;
        }

        .footer-social {
            display: flex;
            gap: 12px;
        }

        .footer-social a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            transition: background 0.2s, color 0.2s;
        }

        .footer-social a:hover {
            background: var(--gold);
            color: var(--white);
        }

        .footer-col-title {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--white);
            margin-bottom: 20px;
        }

        .footer-col a {
            display: block;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.5);
            padding: 5px 0;
            transition: color 0.2s;
        }

        .footer-col a:hover {
            color: var(--gold-light);
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
        }

        .footer-bottom a {
            color: var(--gold-light);
        }

        /* ─── LIGHTBOX ─────────────────────────────────────────────── */
        .lightbox {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.92);
            z-index: 200;
            align-items: center;
            justify-content: center;
        }

        .lightbox.open {
            display: flex;
        }

        .lightbox-img {
            max-width: 90vw;
            max-height: 85vh;
            object-fit: contain;
            border-radius: var(--radius-md);
        }

        .lightbox-close {
            position: absolute;
            top: 24px;
            right: 32px;
            font-size: 32px;
            color: var(--white);
            cursor: pointer;
            font-weight: 300;
            line-height: 1;
        }

        /* ─── SCROLL REVEAL (optimized) ───────────────────────────── */
        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
            will-change: opacity, transform;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ─── RESPONSIVE ───────────────────────────────────────────── */
        @media (max-width: 900px) {
            .nav-hamburger {
                display: flex;
            }

            .nav-links {
                display: none;
            }

            .nav-mobile {
                display: block;
            }

            .hero {
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .hero-left {
                padding: 100px 32px 48px;
            }

            .hero-left::after {
                display: none;
            }

            .hero-right {
                height: 380px;
                grid-template-rows: 1fr;
            }

            .hero-img-bottom {
                display: none;
            }

            .hero-img-top {
                height: 100%;
            }

            .stats-inner {
                grid-template-columns: repeat(2, 1fr);
            }

            .about-inner {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .about-img-wrap {
                height: 320px;
            }

            .services-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .gallery-grid {
                grid-template-columns: 1fr 1fr;
                grid-template-rows: auto;
            }

            .gal-item {
                position: relative;
                height: 180px;
            }

            .gal-item:nth-child(n) {
                grid-column: auto;
                grid-row: auto;
            }

            .testimonials-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }

            .testimonials-grid {
                grid-template-columns: 1fr;
            }

            .cta-inner {
                grid-template-columns: 1fr;
                padding: 40px 32px;
            }

            .cta-actions {
                align-items: flex-start;
            }

            .footer-top {
                grid-template-columns: 1fr 1fr;
                gap: 32px;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .hero-left {
                padding: 90px 20px 40px;
            }

            .hero-services {
                gap: 16px;
                flex-wrap: wrap;
            }

            .stats-inner {
                grid-template-columns: 1fr 1fr;
                gap: 16px;
            }

            .stat-divider {
                border-left: none;
            }

            .about-values {
                grid-template-columns: 1fr;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .gal-item {
                height: 200px;
            }

            .cta-inner {
                padding: 32px 20px;
            }

            .footer-top {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- ═══════════ NAV ═══════════ -->
    <nav class="nav" id="mainNav">
        <div class="nav-inner">
            <a href="{{ route('home') }}" class="nav-logo" aria-label="ME FOR YOU home">
                <img src="{{ asset('android-chrome-512x512.png') }}" alt="ME FOR YOU Logo" class="nav-logo__img" />
                <span class="nav-logo__text">ME <span>FOR</span> YOU</span>
            </a>
            <ul class="nav-links">
                <li><a href="{{ route('about') }}">About</a></li>
                <li><a href="{{ route('services.events') }}">Services</a></li>
                <li><a href="{{ route('gallery') }}">Our Work</a></li>
                <li><a href="{{ route('faq') }}">FAQ</a></li>
                <li><a href="{{ route('contact') }}" class="nav-cta">Get in Touch</a></li>
            </ul>
            <button class="nav-hamburger" id="navHamburger" aria-label="Open menu" aria-expanded="false">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>

    <!-- Mobile drawer -->
    <div class="nav-mobile" id="navMobile">
        <a href="{{ route('about') }}" onclick="closeMenu()">About</a>
        <a href="{{ route('services.events') }}" onclick="closeMenu()">Services</a>
        <a href="{{ route('gallery') }}" onclick="closeMenu()">Our Work</a>
        <a href="{{ route('faq') }}" onclick="closeMenu()">FAQ</a>
        <a href="{{ route('contact') }}" class="nav-mobile-cta" onclick="closeMenu()">Get in Touch</a>
    </div>

    <!-- ═══════════ HERO ═══════════ -->
    <section class="hero" id="home">
        <div class="hero-left">
            <p class="hero-tagline">Kigali, Rwanda</p>
            <h1 class="hero-title">Your Professional<br /><em>Companion</em></h1>
            <p class="hero-sub">
                Housing, events, and transport expertly managed so you can focus on
                what matters most. One trusted partner for every milestone.
            </p>
            <div class="hero-actions">
                <a href="{{ route('services.events') }}" class="btn-primary">Explore Services</a>
                <a href="{{ route('contact') }}" class="btn-outline">Book a Consultation</a>
            </div>
            <div class="hero-services">
                <a href="{{ route('services.housing') }}" class="hero-service-pill" style="text-decoration:none;">Housing</a>
                <a href="{{ route('services.events') }}" class="hero-service-pill" style="text-decoration:none;">Events</a>
                <a href="{{ route('services.transport') }}" class="hero-service-pill" style="text-decoration:none;">Transport</a>
            </div>
        </div>

        <div class="hero-right">
            <div class="hero-img-top">
                <div class="img-wrapper">
                    @if($featuredEvents->isNotEmpty())
                        <img src="{{ $featuredEvents->first()->cover_image ?? asset('assets/events/hero-event.webp') }}" alt="ME FOR YOU Events" loading="lazy" decoding="async" />
                    @else
                        <img src="{{ asset('assets/events/hero-event.webp') }}" alt="ME FOR YOU Events" loading="lazy" decoding="async" />
                    @endif
                    <div class="fallback">Events Photo</div>
                </div>
                <div class="hero-img-overlay"></div>
                <a href="{{ route('services.events') }}" class="hero-badge" style="text-decoration:none;">Events</a>
            </div>
            <div class="hero-img-bottom">
                <div class="hero-img-cell">
                    <div class="img-wrapper">
                        @if($featuredHouses->isNotEmpty())
                            <img src="{{ $featuredHouses->first()->cover_image ?? asset('assets/housing/hero-house.webp') }}" alt="ME FOR YOU Housing" loading="lazy" decoding="async" />
                        @else
                            <img src="{{ asset('assets/housing/hero-house.webp') }}" alt="ME FOR YOU Housing" loading="lazy" decoding="async" />
                        @endif
                        <div class="fallback">Housing Photo</div>
                    </div>
                    <a href="{{ route('services.housing') }}" class="hero-badge" style="font-size:10px; text-decoration:none;">Housing</a>
                </div>
                <div class="hero-img-cell">
                    <div class="img-wrapper">
                        @if($featuredCars->isNotEmpty())
                            <img src="{{ $featuredCars->first()->cover_image ?? asset('assets/transport/hero-car.webp') }}" alt="ME FOR YOU Transport" loading="lazy" decoding="async" />
                        @else
                            <img src="{{ asset('assets/transport/hero-car.webp') }}" alt="ME FOR YOU Transport" loading="lazy" decoding="async" />
                        @endif
                        <div class="fallback">Transport Photo</div>
                    </div>
                    <a href="{{ route('services.transport') }}" class="hero-badge" style="font-size:10px; text-decoration:none;">Transport</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════ STATS ═══════════ -->
    <div class="stats-bar">
        <div class="stats-inner">
            <div class="stat-item">
                <div class="stat-num">{{ number_format($stats['clients']) }}+</div>
                <div class="stat-label">Happy Clients</div>
            </div>
            <div class="stat-item stat-divider">
                <div class="stat-num">{{ number_format($stats['properties']) }}+</div>
                <div class="stat-label">Properties Listed</div>
            </div>
            <div class="stat-item stat-divider">
                <div class="stat-num">{{ number_format($stats['events']) }}+</div>
                <div class="stat-label">Events Managed</div>
            </div>
            <div class="stat-item stat-divider">
                <div class="stat-num">{{ $stats['rating'] }}</div>
                <div class="stat-label">Client Rating</div>
            </div>
        </div>
    </div>

    <!-- ═══════════ ABOUT ═══════════ -->
    <section class="about" id="about">
        <div class="about-inner">
            <div style="position:relative;">
                <div class="about-img-wrap">
                    <div class="img-wrapper">
                        <img src="{{ asset('assets/gallery/about-brand.webp') }}" alt="ME FOR YOU team" loading="lazy" decoding="async" />
                        <div class="fallback">Brand / Team Photo</div>
                    </div>
                </div>
                <div class="about-accent"></div>
            </div>

            <div>
                <p class="section-label">Who We Are</p>
                <h2 class="section-title">One Company,<br /><em>Every Need</em></h2>
                <p class="section-body" style="margin-top:16px;">
                    ME FOR YOU is a Kigali-based professional services company dedicated
                    to empowering individuals and businesses through personalized,
                    expert services tailored to their unique needs. We believe that
                    great experiences start with great partnerships.
                </p>
                <p class="section-body" style="margin-top:16px;">
                    Whether you're finding your next home, planning a memorable
                    celebration, or need reliable transport we handle it with
                    professionalism, affordability, and care.
                </p>
                <div class="about-values">
                    <div class="value-card reveal">
                        <div class="value-title">Professionalism</div>
                        <div class="value-desc">Expert service at every touchpoint, from first call to final delivery.</div>
                    </div>
                    <div class="value-card reveal">
                        <div class="value-title">Affordability</div>
                        <div class="value-desc">Premium quality without premium prices value you can trust.</div>
                    </div>
                    <div class="value-card reveal">
                        <div class="value-title">Trustworthiness</div>
                        <div class="value-desc">We show up, deliver, and stand behind everything we promise.</div>
                    </div>
                    <div class="value-card reveal">
                        <div class="value-title">Personal Touch</div>
                        <div class="value-desc">Every client receives bespoke attention and tailored solutions.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════ SERVICES ═══════════ -->
    <section class="services" id="services">
        <div class="services-header">
            <div>
                <p class="section-label">What We Offer</p>
                <h2 class="section-title">Housing, Events<br />& <em>Transport</em></h2>
            </div>
            <a href="{{ route('contact') }}" class="btn-primary">Get a Free Quote</a>
        </div>

        <div class="services-grid">
            <!-- Events -->
            <div class="service-card reveal">
                <div class="service-img">
                    <div class="img-wrapper">
                        @if($featuredEvents->isNotEmpty())
                            <img src="{{ $featuredEvents->first()->cover_image ?? asset('assets/events/event-01.webp') }}" alt="ME FOR YOU Event Management" loading="lazy" decoding="async" />
                        @else
                            <img src="{{ asset('assets/events/event-01.webp') }}" alt="ME FOR YOU Event Management" loading="lazy" decoding="async" />
                        @endif
                        <div class="fallback">Event Photo</div>
                    </div>
                    <div class="service-chip">Events</div>
                </div>
                <div class="service-body">
                    <h3 class="service-name">Event Management</h3>
                    <p class="service-desc">
                        From intimate weddings to large corporate functions, we design,
                        coordinate, and execute flawless events that your guests will talk
                        about for years.
                    </p>
                    <ul class="service-features">
                        <li class="service-feature">Weddings & ceremonies</li>
                        <li class="service-feature">Corporate events & conferences</li>
                        <li class="service-feature">Décor & venue setup</li>
                        <li class="service-feature">Catering coordination</li>
                    </ul>
                    <a href="{{ route('services.events') }}" class="service-link">Plan Your Event</a>
                </div>
            </div>

            <!-- Housing -->
            <div class="service-card reveal">
                <div class="service-img">
                    <div class="img-wrapper">
                        @if($featuredHouses->isNotEmpty())
                            <img src="{{ $featuredHouses->first()->cover_image ?? asset('assets/housing/property-01.webp') }}" alt="ME FOR YOU Housing Services" loading="lazy" decoding="async" />
                        @else
                            <img src="{{ asset('assets/housing/property-01.webp') }}" alt="ME FOR YOU Housing Services" loading="lazy" decoding="async" />
                        @endif
                        <div class="fallback">Housing Photo</div>
                    </div>
                    <div class="service-chip">Housing</div>
                </div>
                <div class="service-body">
                    <h3 class="service-name">Housing Services</h3>
                    <p class="service-desc">
                        Find your perfect home or investment property in Kigali. We handle
                        listings, viewings, negotiations, and paperwork so you move in
                        with confidence.
                    </p>
                    <ul class="service-features">
                        <li class="service-feature">Residential & commercial listings</li>
                        <li class="service-feature">Property inspections & valuation</li>
                        <li class="service-feature">Rental management</li>
                        <li class="service-feature">Relocation assistance</li>
                    </ul>
                    <a href="{{ route('services.housing') }}" class="service-link">Find a Property</a>
                </div>
            </div>

            <!-- Transport -->
            <div class="service-card reveal">
                <div class="service-img">
                    <div class="img-wrapper">
                        @if($featuredCars->isNotEmpty())
                            <img src="{{ $featuredCars->first()->cover_image ?? asset('assets/transport/car-01.webp') }}" alt="ME FOR YOU Transport Services" loading="lazy" decoding="async" />
                        @else
                            <img src="{{ asset('assets/transport/car-01.webp') }}" alt="ME FOR YOU Transport Services" loading="lazy" decoding="async" />
                        @endif
                        <div class="fallback">Car Photo</div>
                    </div>
                    <div class="service-chip">Transport</div>
                </div>
                <div class="service-body">
                    <h3 class="service-name">Transport Services</h3>
                    <p class="service-desc">
                        Reliable, comfortable, and affordable car rental for personal or
                        business use. Well-maintained vehicles with professional drivers
                        available on request.
                    </p>
                    <ul class="service-features">
                        <li class="service-feature">Short & long-term car rental</li>
                        <li class="service-feature">Airport transfers</li>
                        <li class="service-feature">Event transport & chauffeur</li>
                        <li class="service-feature">Corporate fleet services</li>
                    </ul>
                    <a href="{{ route('services.transport') }}" class="service-link">Book a Vehicle</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════ GALLERY ═══════════ -->
    <section class="gallery" id="gallery">
        <div class="gallery-header">
            <p class="section-label">Our Work</p>
            <h2 class="section-title">Moments We've <em>Created</em></h2>
            <p class="section-body">
                A glimpse into the properties we've placed, events we've produced, and
                journeys we've made comfortable.
            </p>
        </div>

        <div class="gallery-grid">
            @foreach($galleryImages as $index => $image)
                <div class="gal-item reveal" onclick="openLightbox('{{ $image['src'] }}','{{ $image['alt'] }}')">
                    <div class="img-wrapper">
                        <img src="{{ $image['src'] }}" alt="{{ $image['alt'] }}" loading="lazy" decoding="async" />
                        <div class="fallback">{{ $image['label'] }}</div>
                    </div>
                    <div class="gal-overlay"><span class="gal-label">{{ $image['label'] }}</span></div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox" onclick="closeLightbox()">
        <span class="lightbox-close" onclick="closeLightbox()">×</span>
        <img class="lightbox-img" id="lightboxImg" src="" alt="" />
    </div>

    <!-- ═══════════ TESTIMONIALS ═══════════ -->
    <section class="testimonials" id="testimonials">
        <div class="testimonials-header">
            <div>
                <p class="section-label" style="color:var(--gold-light);">Client Reviews</p>
                <h2 class="section-title">What Our Clients <em style="color:var(--gold-light);">Say</em></h2>
            </div>
            <a href="https://www.instagram.com/meforyou_rw/" target="_blank" rel="noopener" class="btn-outline">Follow Us on Instagram</a>
        </div>

        <div class="testimonials-grid">
            @forelse($testimonials as $testimonial)
                <div class="testi-card reveal">
                    <div class="testi-stars">
                        @for($i = 0; $i < $testimonial['stars']; $i++)
                            ★
                        @endfor
                    </div>
                    <p class="testi-quote">"{{ $testimonial['quote'] }}"</p>
                    <div class="testi-author">
                        <div class="testi-avatar">
                            <div class="img-wrapper">
                                <img src="{{ asset($testimonial['avatar']) }}" alt="{{ $testimonial['name'] }}" loading="lazy" decoding="async" />
                                <div class="fallback">{{ substr($testimonial['name'], 0, 2) }}</div>
                            </div>
                        </div>
                        <div>
                            <div class="testi-name">{{ $testimonial['name'] }}</div>
                            <div class="testi-role">{{ $testimonial['role'] }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="testi-card reveal">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-quote">"ME FOR YOU found us the perfect apartment in Kigali within a week. The whole process was smooth, transparent, and stress-free. Highly recommended!"</p>
                    <div class="testi-author">
                        <div class="testi-avatar">
                            <div class="img-wrapper">
                                <img src="{{ asset('assets/testimonials/client-01.webp') }}" alt="Amina K." loading="lazy" decoding="async" />
                                <div class="fallback">AK</div>
                            </div>
                        </div>
                        <div>
                            <div class="testi-name">Amina K.</div>
                            <div class="testi-role">Housing client, Kigali</div>
                        </div>
                    </div>
                </div>

                <div class="testi-card reveal">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-quote">"Our wedding was absolutely magical. The décor, coordination, and transport everything was handled perfectly. Thank you ME FOR YOU!"</p>
                    <div class="testi-author">
                        <div class="testi-avatar">
                            <div class="img-wrapper">
                                <img src="{{ asset('assets/testimonials/client-02.webp') }}" alt="Jean-Pierre & Grace M." loading="lazy" decoding="async" />
                                <div class="fallback">JG</div>
                            </div>
                        </div>
                        <div>
                            <div class="testi-name">Jean-Pierre & Grace M.</div>
                            <div class="testi-role">Wedding clients</div>
                        </div>
                    </div>
                </div>

                <div class="testi-card reveal">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-quote">"We used ME FOR YOU for our company's annual conference transport. Professional drivers, clean vehicles, and always on time. Outstanding service."</p>
                    <div class="testi-author">
                        <div class="testi-avatar">
                            <div class="img-wrapper">
                                <img src="{{ asset('assets/testimonials/client-03.webp') }}" alt="David N." loading="lazy" decoding="async" />
                                <div class="fallback">DN</div>
                            </div>
                        </div>
                        <div>
                            <div class="testi-name">David N.</div>
                            <div class="testi-role">Corporate client, Kigali</div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <!-- ═══════════ CTA ═══════════ -->
    <section class="cta-banner" id="contact">
        <div class="cta-inner">
            <div>
                <h2 class="cta-title">Ready to experience<br /><em>the ME FOR YOU difference?</em></h2>
                <p class="cta-sub">
                    Housing, Events & Transport all in one place.<br />
                    Let us be your professional companion.
                </p>
            </div>
            <div class="cta-actions">
                <a href="https://wa.me/+250788202209" class="btn-cta-white" target="_blank" rel="noopener">Get in Touch →</a>
            </div>
        </div>
    </section>

    <!-- ═══════════ FOOTER ═══════════ -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-top">
                <div>
                    <div class="footer-brand-name">ME <span>FOR</span> YOU</div>
                    <p class="footer-brand-desc">
                        Your professional companion for housing, events, and transport
                        services in Kigali, Rwanda. Trusted by individuals and businesses
                        across the country.
                    </p>
                    <div class="footer-social">
                        <a href="https://www.instagram.com/meforyou_rw/" target="_blank" rel="noopener" aria-label="Instagram">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="2" y="2" width="20" height="20" rx="5" />
                                <circle cx="12" cy="12" r="4" />
                                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="footer-col">
                    <p class="footer-col-title">Services</p>
                    <a href="{{ route('services.housing') }}">Housing</a>
                    <a href="{{ route('services.events') }}">Event Management</a>
                    <a href="{{ route('services.transport') }}">Transport</a>
                    <a href="{{ route('contact') }}">Corporate Packages</a>
                </div>

                <div class="footer-col">
                    <p class="footer-col-title">Company</p>
                    <a href="{{ route('about') }}">About Us</a>
                    <a href="{{ route('gallery') }}">Our Work</a>
                    <a href="{{ route('faq') }}">FAQ</a>
                    <a href="{{ route('contact') }}">Contact</a>
                </div>

                <div class="footer-col">
                    <p class="footer-col-title">Contact</p>
                    <a href="https://www.instagram.com/meforyou_rw/" target="_blank" rel="noopener">@meforyou_rw</a>
                    <a href="mailto:info@me-for-you.org">info@me-for-you.org</a>
                    <a href="tel:+250788202209">+250 788 202 209</a>
                    <a>Kigali, Rwanda</a>
                </div>
            </div>
            <div class="footer-bottom">
                <span>© {{ date('Y') }} ME FOR YOU. All rights reserved.</span>
                <span>Empowering Rwanda, one service at a time.</span>
            </div>
        </div>
    </footer>

    <script>
        /* ── Nav scroll effect ── */
        const nav = document.getElementById("mainNav");
        let ticking = false;

        window.addEventListener("scroll", () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    nav.classList.toggle("scrolled", window.scrollY > 40);
                    ticking = false;
                });
                ticking = true;
            }
        });

        /* ── Mobile menu toggle ── */
        const hamburger = document.getElementById("navHamburger");
        const mobileMenu = document.getElementById("navMobile");

        hamburger.addEventListener("click", () => {
            const isOpen = mobileMenu.classList.toggle("open");
            hamburger.classList.toggle("open", isOpen);
            hamburger.setAttribute("aria-expanded", isOpen);
            document.body.style.overflow = isOpen ? "hidden" : "";
        });

        function closeMenu() {
            mobileMenu.classList.remove("open");
            hamburger.classList.remove("open");
            hamburger.setAttribute("aria-expanded", "false");
            document.body.style.overflow = "";
        }

        document.addEventListener("click", (e) => {
            if (!nav.contains(e.target) && !mobileMenu.contains(e.target)) {
                closeMenu();
            }
        });

        /* ── Lightbox ── */
        function openLightbox(src, alt) {
            const lb = document.getElementById("lightbox");
            const img = document.getElementById("lightboxImg");
            img.src = src;
            img.alt = alt;
            lb.classList.add("open");
            document.body.style.overflow = "hidden";
        }

        function closeLightbox() {
            document.getElementById("lightbox").classList.remove("open");
            document.body.style.overflow = "";
        }

        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                closeLightbox();
                closeMenu();
            }
        });

        /* ── Optimized Scroll Reveal ── */
        const revealObserver = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("visible");
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: "0px 0px -50px 0px"
            }
        );

        document.querySelectorAll(".reveal").forEach((el) => {
            revealObserver.observe(el);
        });

        /* ── Image error fallback ── */
        document.querySelectorAll(".img-wrapper img").forEach((img) => {
            img.addEventListener("error", function() {
                this.style.display = "none";
                const fallback = this.parentElement.querySelector(".fallback");
                if (fallback) fallback.style.opacity = "1";
            });
        });
    </script>
</body>

</html>