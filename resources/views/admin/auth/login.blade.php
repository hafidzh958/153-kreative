<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - 153 Kreatif</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .branding-bg {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

    <div
        class="w-full max-w-6xl bg-white rounded-[2rem] shadow-2xl overflow-hidden flex flex-col lg:flex-row min-h-[600px]">

        {{-- PANEL KANAN (Form Mobile-First: di atas saat mobile, di kanan saat desktop) --}}
        <div
            class="w-full lg:w-2/5 p-8 sm:p-12 lg:p-16 flex flex-col justify-center order-1 lg:order-2 bg-white relative z-10">
            <div class="max-w-md w-full mx-auto">
                <div class="mb-10 lg:mb-12 text-center lg:text-left">
                    {{-- Logo Placeholder or Text --}}
                    <div class="inline-flex h-12 mb-4">
                        <h2 class="text-2xl font-black tracking-tight text-gray-900"
                            style="font-family: 'Montserrat', sans-serif;">
                            <span class="text-[#f97316]">153</span> Kreatif.
                        </h2>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2"
                        style="font-family: 'Montserrat', sans-serif;">Masuk ke Dashboard</h1>
                    <p class="text-gray-500 text-sm">Gunakan akun admin untuk mengakses sistem</p>
                </div>

                <form id="loginForm" onsubmit="handleLogin(event)" class="space-y-6">
                    @csrf
                    {{-- Error Summary Alert --}}
                    <div id="errorAlert"
                        class="hidden bg-red-50 border border-red-200 text-red-600 rounded-xl p-4 text-sm flex items-start gap-3">
                        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span id="errorMessage">Username atau password salah.</span>
                    </div>

                    {{-- Username --}}
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                        <input type="text" id="username" name="username" required
                            class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all text-sm outline-none"
                            placeholder="Enter your username"
                            value="{{ app()->environment('local') ? 'kreatif153' : '' }}">
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required
                                class="w-full px-4 py-3.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all text-sm outline-none pr-12"
                                placeholder="••••••••" value="{{ app()->environment('local') ? '153kreatif' : '' }}">
                            <button type="button" onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                                <svg id="icon-eye" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="icon-eye-off" class="w-5 h-5 hidden" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember & Forgot --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2.5 cursor-pointer">
                            <input type="checkbox" name="remember"
                                class="w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                            <span class="text-sm text-gray-600">Remember Me</span>
                        </label>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" id="submitBtn"
                        class="w-full py-3.5 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all shadow-lg shadow-orange-500/30 flex justify-center items-center gap-2">
                        <span id="btnText">Sign In</span>
                        <svg id="btnLoader" class="w-5 h-5 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </button>

                    <p class="text-center text-xs text-gray-400 mt-6 pt-4 border-t border-gray-100">
                        Secure access for <strong>153 Kreatif</strong> internal operations.
                    </p>
                </form>
            </div>
        </div>

        {{-- PANEL KIRI (Branding Banner Info) --}}
        <div
            class="w-full lg:w-3/5 branding-bg p-8 sm:p-12 lg:p-16 flex flex-col justify-between order-2 lg:order-1 relative overflow-hidden">
            {{-- Decorative circles --}}
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-20">
                <div class="absolute -top-24 -left-24 w-96 h-96 rounded-full bg-white opacity-20 blur-3xl"></div>
                <div class="absolute bottom-10 right-10 w-72 h-72 rounded-full bg-orange-300 opacity-20 blur-2xl"></div>
            </div>

            <div class="relative z-10 flex-1 flex flex-col justify-center max-w-lg mx-auto lg:mx-0">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full glass-panel text-white text-xs font-semibold mb-8 w-max tracking-wide uppercase">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    Admin Panel
                </div>

                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight"
                    style="font-family: 'Montserrat', sans-serif;">
                    Welcome to <span class="text-white/90">153 Kreatif</span>
                </h2>

                <p class="text-orange-50 text-base sm:text-lg mb-12 leading-relaxed font-medium">
                    Platform internal untuk mengelola konten website, layanan, dan portofolio secara terpusat.
                </p>

                <div class="space-y-4">
                    {{-- Feature 1 --}}
                    <div
                        class="glass-panel rounded-2xl p-5 flex items-start gap-4 transition-transform hover:-translate-y-1 duration-300">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold text-sm mb-1">Manajemen Konten</h4>
                            <p class="text-orange-100 text-xs leading-relaxed">Kelola layanan, portfolio, dan seluruh
                                halaman website dengan mudah di satu tempat.</p>
                        </div>
                    </div>

                    {{-- Feature 2 --}}
                    <div
                        class="glass-panel rounded-2xl p-5 flex items-start gap-4 transition-transform hover:-translate-y-1 duration-300">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold text-sm mb-1">Akses Cepat</h4>
                            <p class="text-orange-100 text-xs leading-relaxed">Dashboard ringan dan cepat untuk
                                mendukung segala kebutuhan operasional harian.</p>
                        </div>
                    </div>

                    {{-- Feature 3 --}}
                    <div
                        class="glass-panel rounded-2xl p-5 flex items-start gap-4 transition-transform hover:-translate-y-1 duration-300">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-white font-semibold text-sm mb-1">Terintegrasi</h4>
                            <p class="text-orange-100 text-xs leading-relaxed">Seluruh sistem, galeri, dan pengelolaan
                                pesan terhubung dalam sebuah platform tunggal.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center lg:text-left text-orange-200/80 text-xs relative z-10">
                &copy; {{ date('Y') }} 153 Kreatif Internal Systems. All rights reserved.
            </div>
        </div>
    </div>

    {{-- Script untuk Handle Form & Password Toggle --}}
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const eye = document.getElementById('icon-eye');
            const eyeOff = document.getElementById('icon-eye-off');

            if (input.type === 'password') {
                input.type = 'text';
                eye.classList.add('hidden');
                eyeOff.classList.remove('hidden');
            } else {
                input.type = 'password';
                eye.classList.remove('hidden');
                eyeOff.classList.add('hidden');
            }
        }

        async function handleLogin(e) {
            e.preventDefault();
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');
            const errorAlert = document.getElementById('errorAlert');
            const errorMessage = document.getElementById('errorMessage');

            // Reset state
            btn.disabled = true;
            btnText.classList.add('hidden');
            btnLoader.classList.remove('hidden');
            btn.classList.add('opacity-90');
            errorAlert.classList.add('hidden');

            const fd = new FormData(e.target);

            try {
                const res = await fetch('{{ route("admin.login.submit") }}', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: fd
                });

                const data = await res.json().catch(() => null);

                if (res.ok && data?.success) {
                    window.location.href = data.redirect;
                } else {
                    errorAlert.classList.remove('hidden');
                    errorMessage.textContent = data?.message || "Terjadi kesalahan pada server.";

                    // Re-enable button
                    btn.disabled = false;
                    btnText.classList.remove('hidden');
                    btnLoader.classList.add('hidden');
                    btn.classList.remove('opacity-90');
                }
            } catch (err) {
                errorAlert.classList.remove('hidden');
                errorMessage.textContent = "Gagal terhubung ke server.";

                btn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoader.classList.add('hidden');
                btn.classList.remove('opacity-90');
            }
        }
    </script>
</body>

</html>