<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', '153 Kreatif'))</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/153.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @verbatim
        html {
            scroll-behavior: smooth;
        }
        .logo-text {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 6px;
            font-family: 'Montserrat', sans-serif;
            text-transform: uppercase;
        }

        /* Global Entrance Animations */
        .animate-fade-in-up {
            opacity: 0;
            transform: translateY(24px);
        }
        .animate-fade-in-up.is-visible {
            animation: fadeInUp 0.8s ease-out forwards;
        }
        .animate-fade-in-up.delay-1 { animation-delay: 0.1s; }
        .animate-fade-in-up.delay-2 { animation-delay: 0.2s; }
        .animate-fade-in-up.delay-3 { animation-delay: 0.3s; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .scroll-fade {
            opacity: 0;
            transform: translateY(15px);
        }
        .scroll-fade.is-visible {
            animation: fadeScrollIn 1s ease-out forwards;
        }
        .scroll-fade.is-visible.delay-1 { animation-delay: 0.1s; }
        .scroll-fade.is-visible.delay-2 { animation-delay: 0.2s; }

        @keyframes fadeScrollIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Floating WhatsApp Button */
        .floating-wa {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 56px;
            height: 56px;
            background-color: #25D366;
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            z-index: 9999;
            transition: transform 0.3s ease, background-color 0.3s ease;
            animation: waFadeInUp 0.8s ease-out forwards;
            opacity: 0;
            animation-delay: 0.8s;
        }

        .floating-wa:hover {
            transform: scale(1.08);
            background-color: #20ba56;
        }

        @keyframes waFadeInUp {
            from { opacity: 0; transform: translateY(20px) scale(0.9); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .floating-wa-tooltip {
            position: absolute;
            right: 70px;
            top: 50%;
            transform: translateY(-50%) translateX(10px);
            background-color: #1f2937;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
            font-family: 'Inter', sans-serif;
            pointer-events: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Arrow for tooltip */
        .floating-wa-tooltip::after {
            content: '';
            position: absolute;
            top: 50%;
            right: -4px;
            transform: translateY(-50%);
            border-width: 5px 0 5px 5px;
            border-style: solid;
            border-color: transparent transparent transparent #1f2937;
        }

        .floating-wa:hover .floating-wa-tooltip {
            opacity: 1;
            visibility: visible;
            transform: translateY(-50%) translateX(0);
        }
        @endverbatim
    </style>

    @stack('styles')
</head>
<body class="min-h-screen flex flex-col bg-gray-50 text-gray-900">
    @include('components.navbar')

    <main class="flex-1">
        @yield('content')
    </main>

    @include('components.footer')

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6285711376797" target="_blank" rel="noopener noreferrer" class="floating-wa" aria-label="Hubungi Kami via WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 16 16">
            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
        </svg>
        <div class="floating-wa-tooltip">Hubungi Kami via WhatsApp</div>
    </a>

    <!-- Global JS Libraries & Helpers -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            AOS.init({
                duration: 800,
                once: true,
                offset: 50,
            });

            // Global Scroll Fade Animation Observer (Legacy fallback)
            const fadeElements = document.querySelectorAll('.scroll-fade, .animate-fade-in-up');
            
            const scrollObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        scrollObserver.unobserve(entry.target);
                    }
                });
            }, {
                rootMargin: '0px 0px -50px 0px',
                threshold: 0.1
            });

            fadeElements.forEach(el => scrollObserver.observe(el));
        });
    </script>

    @stack('scripts')
</body>
</html>
