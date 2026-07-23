<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <title>@yield('title', config('app.name', 'ME FOR YOU'))</title>

    <!-- ═══════════ OPEN GRAPH / SEO ═══════════ -->
    {{-- Basic OG tags --}}
    <meta property="og:title" content="@yield('og_title', 'ME FOR YOU | Professional Companion for Housing, Events & Transport')" />
    <meta property="og:description" content="@yield('og_description', 'From premium housing support to unforgettable events and reliable transport, ME FOR YOU helps you move through every milestone with confidence.')" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />

    {{-- Dynamic OG Image – override in child views using @section('og_image', $yourImageUrl) --}}
    <meta property="og:image" content="@yield('og_image', asset('android-chrome-512x512.png'))" />
    <meta property="og:image:secure_url" content="@yield('og_image', asset('android-chrome-512x512.png'))" />
    <meta property="og:image:alt" content="@yield('og_image_alt', 'ME FOR YOU logo')" />
    <meta property="og:image:width" content="@yield('og_image_width', '512')" />
    <meta property="og:image:height" content="@yield('og_image_height', '512')" />

    <meta property="og:site_name" content="ME FOR YOU" />
    <meta property="og:locale" content="en_US" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('og_title', 'ME FOR YOU | Professional Companion for Housing, Events & Transport')" />
    <meta name="twitter:description" content="@yield('og_description', 'Trusted housing, event management, and transport services in Kigali, Rwanda.')" />
    <meta name="twitter:image" content="@yield('og_image', asset('android-chrome-512x512.png'))" />
    <meta name="twitter:image:alt" content="@yield('og_image_alt', 'ME FOR YOU logo')" />

    <!-- SEO Meta -->
    <meta name="description" content="@yield('meta_description', 'ME FOR YOU offers trusted housing, event management, and transport services in Kigali, Rwanda. Your professional companion for every milestone.')" />
    <meta name="keywords" content="@yield('meta_keywords', 'ME FOR YOU, housing, event management, transport, Kigali, Rwanda, professional services, property, weddings, car rental')" />
    <meta name="robots" content="index, follow" />
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Styles -->
    <style>
        :root {
            --gold: #b87f3a;
            --gold-light: #d49d6a;
            --gold-dark: #8a6e22;
            --ink: #1a1714;
            --ink-mid: #3d3830;
            --sand: #f5f0e8;
            --font-display: "Cormorant Garamond", Georgia, serif;
            --font-body: "Inter", system-ui, sans-serif;
        }

        body {
            font-family: var(--font-body);
            color: var(--ink);
            background: #ffffff;
            padding-top: 72px;
            /* Space for fixed nav */
        }

        .font-display {
            font-family: var(--font-display);
        }

        .text-gold {
            color: var(--gold);
        }

        .text-gold-light {
            color: var(--gold-light);
        }

        .text-gold-dark {
            color: var(--gold-dark);
        }

        .bg-gold {
            background: var(--gold);
        }

        .bg-gold-dark {
            background: var(--gold-dark);
        }

        .bg-gold-light {
            background: var(--gold-light);
        }

        .bg-gold\/10 {
            background: rgba(184, 127, 58, 0.1);
        }

        .hover\:bg-gold-dark:hover {
            background: var(--gold-dark);
        }

        .hover\:text-gold:hover {
            color: var(--gold);
        }

        /* ─── STICKY NAV ─────────────────────────────────────────── */
        .nav-sticky {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.3s ease;
        }

        .nav-sticky.scrolled {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* Smooth scroll for anchor links */
        html {
            scroll-behavior: smooth;
        }

        /* ─── ACTIVE NAV LINK ─────────────────────────────────────── */
        .nav-link-active {
            color: var(--gold) !important;
            font-weight: 600;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <!--  STICKY NAV  -->
    <nav class="nav-sticky" id="mainNav">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo with Image -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('android-chrome-512x512.png') }}" alt="ME FOR YOU Logo"
                        class="w-10 h-10 object-contain transition-transform duration-300 group-hover:scale-105">
                    <span class="font-display text-2xl font-semibold text-gray-900">
                        ME <span class="text-gold">FOR</span> YOU
                    </span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    {{-- EVENTS – matches services.events* and services.event.* --}}
                    <a href="{{ route('services.events') }}"
                        class="text-gray-600 hover:text-gold transition-colors font-medium text-sm {{ request()->routeIs('services.events*') || request()->routeIs('services.event.*') ? 'nav-link-active' : '' }}">
                        Events
                    </a>

                    {{-- HOUSING – matches services.housing and services.house.* --}}
                    <a href="{{ route('services.housing') }}"
                        class="text-gray-600 hover:text-gold transition-colors font-medium text-sm {{ request()->routeIs('services.housing') || request()->routeIs('services.house.*') ? 'nav-link-active' : '' }}">
                        Housing
                    </a>

                    {{-- TRANSPORT – matches services.transport and services.car.* --}}
                    <a href="{{ route('services.transport') }}"
                        class="text-gray-600 hover:text-gold transition-colors font-medium text-sm {{ request()->routeIs('services.transport') || request()->routeIs('services.car.*') ? 'nav-link-active' : '' }}">
                        Transport
                    </a>

                    <a href="{{ route('about') }}"
                        class="text-gray-600 hover:text-gold transition-colors font-medium text-sm {{ request()->routeIs('about') ? 'nav-link-active' : '' }}">
                        About
                    </a>
                    <a href="{{ route('team') }}"
                        class="text-gray-600 hover:text-gold transition-colors font-medium text-sm {{ request()->routeIs('team*') ? 'nav-link-active' : '' }}">
                        Team
                    </a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-gold hover:text-gold-dark transition-colors font-medium text-sm {{ request()->routeIs('admin.*') ? 'nav-link-active' : '' }}">
                            Dashboard
                        </a>
                    @endauth
                    <a href="{{ route('contact') }}"
                        class="bg-gold text-white px-4 py-2 rounded-lg hover:bg-gold-dark transition-colors font-medium text-sm {{ request()->routeIs('contact') ? 'nav-link-active bg-gold-dark' : '' }}">
                        Contact
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-600 hover:text-gold transition-colors" id="mobileMenuBtn">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="md:hidden hidden bg-white border-t border-gray-100" id="mobileMenu">
            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="{{ route('services.events') }}"
                    class="block text-gray-600 hover:text-gold py-2.5 transition-colors font-medium {{ request()->routeIs('services.events*') || request()->routeIs('services.event.*') ? 'text-gold font-semibold' : '' }}">
                    Events
                </a>
                <a href="{{ route('services.housing') }}"
                    class="block text-gray-600 hover:text-gold py-2.5 transition-colors font-medium {{ request()->routeIs('services.housing') || request()->routeIs('services.house.*') ? 'text-gold font-semibold' : '' }}">
                    Housing
                </a>
                <a href="{{ route('services.transport') }}"
                    class="block text-gray-600 hover:text-gold py-2.5 transition-colors font-medium {{ request()->routeIs('services.transport') || request()->routeIs('services.car.*') ? 'text-gold font-semibold' : '' }}">
                    Transport
                </a>
                <a href="{{ route('about') }}"
                    class="block text-gray-600 hover:text-gold py-2.5 transition-colors font-medium {{ request()->routeIs('about') ? 'text-gold font-semibold' : '' }}">
                    About
                </a>
                <a href="{{ route('team') }}"
                    class="block text-gray-600 hover:text-gold py-2.5 transition-colors font-medium {{ request()->routeIs('team*') ? 'text-gold font-semibold' : '' }}">
                    Team
                </a>
                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="block text-gold hover:text-gold-dark py-2.5 transition-colors font-medium {{ request()->routeIs('admin.*') ? 'text-gold font-semibold' : '' }}">
                        Dashboard
                    </a>
                @endauth
                <a href="{{ route('contact') }}"
                    class="block bg-gold text-white text-center px-4 py-2.5 rounded-lg hover:bg-gold-dark transition-colors font-medium mt-2 {{ request()->routeIs('contact') ? 'bg-gold-dark' : '' }}">
                    Contact
                </a>
            </div>
        </div>
    </nav>

    <!-- ═══════════ MAIN CONTENT ═══════════ -->
    <main>
        @yield('content')
    </main>

    <!-- ═══════════ FOOTER ═══════════ -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('android-chrome-512x512.png') }}" alt="ME FOR YOU Logo"
                            class="w-10 h-10 object-contain">
                        <h3 class="font-display text-2xl font-semibold text-white">
                            ME <span class="text-gold">FOR</span> YOU
                        </h3>
                    </div>
                    <p class="text-sm leading-relaxed">Your professional companion for housing, events, and transport
                        services in Kigali, Rwanda.</p>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Services</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('services.events') }}"
                                class="hover:text-gold transition-colors">Events</a></li>
                        <li><a href="{{ route('services.housing') }}"
                                class="hover:text-gold transition-colors">Housing</a></li>
                        <li><a href="{{ route('services.transport') }}"
                                class="hover:text-gold transition-colors">Transport</a></li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-gold transition-colors">About Us</a>
                        </li>
                        <li><a href="{{ route('team') }}" class="hover:text-gold transition-colors">Our Team</a></li>
                        <li><a href="{{ route('gallery') }}" class="hover:text-gold transition-colors">Gallery</a>
                        </li>
                        <li><a href="{{ route('faq') }}" class="hover:text-gold transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2">
                            <i class="fa-brands fa-instagram text-gold"></i>
                            <a href="https://www.instagram.com/meforyou_rw/" target="_blank"
                                class="hover:text-gold transition-colors">@meforyou_rw</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-gold"></i>
                            <a href="mailto:info@meforyouadvisory.com"
                                class="hover:text-gold transition-colors">info@meforyouadvisory.com</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-phone text-gold"></i>
                            <a href="tel:+250788202209" class="hover:text-gold transition-colors">+250 788 202 209</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-location-dot text-gold"></i>
                            <span>Kigali, Rwanda</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
                <p>© {{ date('Y') }} ME FOR YOU. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- ═══════════ SCRIPTS ═══════════ -->
    <script>
        // Mobile menu toggle
        const mobileBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileBtn?.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu on link click
        document.querySelectorAll('#mobileMenu a').forEach(function(link) {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
            });
        });

        // Close mobile menu on outside click
        document.addEventListener('click', function(e) {
            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                if (!mobileMenu.contains(e.target) && !mobileBtn?.contains(e.target)) {
                    mobileMenu.classList.add('hidden');
                }
            }
        });

        // ─── Nav scroll shadow effect ──
        const nav = document.getElementById('mainNav');
        let ticking = false;

        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    nav.classList.toggle('scrolled', window.scrollY > 20);
                    ticking = false;
                });
                ticking = true;
            }
        });

        // ─── Close mobile menu on Escape key ──
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                mobileMenu?.classList.add('hidden');
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
