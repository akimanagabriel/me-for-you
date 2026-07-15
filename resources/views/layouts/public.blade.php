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

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-100">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo with Image -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <img src="{{ asset('android-chrome-512x512.png') }}" 
                         alt="ME FOR YOU Logo" 
                         class="w-10 h-10 object-contain transition-transform duration-300 group-hover:scale-105">
                    <span class="font-display text-2xl font-semibold text-gray-900">
                        ME <span class="text-gold">FOR</span> YOU
                    </span>
                </a>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('services.events') }}" class="text-gray-600 hover:text-gold transition-colors">Events</a>
                    <a href="{{ route('services.housing') }}" class="text-gray-600 hover:text-gold transition-colors">Housing</a>
                    <a href="{{ route('services.transport') }}" class="text-gray-600 hover:text-gold transition-colors">Transport</a>
                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-gold transition-colors">About</a>
                    <a href="{{ route('contact') }}" class="bg-gold text-white px-4 py-2 rounded-lg hover:bg-gold-dark transition-colors">Contact</a>
                </div>
                
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-600 hover:text-gold transition-colors" id="mobileMenuBtn">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div class="md:hidden hidden" id="mobileMenu">
            <div class="px-4 pt-2 pb-4 space-y-2 border-t border-gray-100">
                <a href="{{ route('services.events') }}" class="block text-gray-600 hover:text-gold py-2 transition-colors">Events</a>
                <a href="{{ route('services.housing') }}" class="block text-gray-600 hover:text-gold py-2 transition-colors">Housing</a>
                <a href="{{ route('services.transport') }}" class="block text-gray-600 hover:text-gold py-2 transition-colors">Transport</a>
                <a href="{{ route('about') }}" class="block text-gray-600 hover:text-gold py-2 transition-colors">About</a>
                <a href="{{ route('contact') }}" class="block bg-gold text-white text-center px-4 py-2 rounded-lg hover:bg-gold-dark transition-colors">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('android-chrome-512x512.png') }}" 
                             alt="ME FOR YOU Logo" 
                             class="w-10 h-10 object-contain">
                        <h3 class="font-display text-2xl font-semibold text-white">
                            ME <span class="text-gold">FOR</span> YOU
                        </h3>
                    </div>
                    <p class="text-sm">Your professional companion for housing, events, and transport services in Kigali, Rwanda.</p>
                </div>
                
                <!-- Services -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Services</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('services.events') }}" class="hover:text-gold transition-colors">Events</a></li>
                        <li><a href="{{ route('services.housing') }}" class="hover:text-gold transition-colors">Housing</a></li>
                        <li><a href="{{ route('services.transport') }}" class="hover:text-gold transition-colors">Transport</a></li>
                    </ul>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-gold transition-colors">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-gold transition-colors">Contact</a></li>
                        <li><a href="{{ route('gallery') }}" class="hover:text-gold transition-colors">Gallery</a></li>
                        <li><a href="{{ route('faq') }}" class="hover:text-gold transition-colors">FAQ</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2">
                            <i class="fab fa-instagram text-gold"></i>
                            <a href="https://www.instagram.com/meforyou_rw/" target="_blank" class="hover:text-gold transition-colors">@meforyou_rw</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-envelope text-gold"></i>
                            <a href="mailto:info@me-for-you.org" class="hover:text-gold transition-colors">info@me-for-you.org</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-phone text-gold"></i>
                            <a href="tel:+250788202209" class="hover:text-gold transition-colors">+250 788 202 209</a>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-gold"></i>
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

    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
        
        // Close mobile menu on link click
        document.querySelectorAll('#mobileMenu a').forEach(function(link) {
            link.addEventListener('click', function() {
                document.getElementById('mobileMenu').classList.add('hidden');
            });
        });
    </script>

    @stack('scripts')
</body>
</html>