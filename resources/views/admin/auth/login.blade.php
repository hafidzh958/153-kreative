<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — 153 Kreatif</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }

        .panel-admin {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
        }
        .panel-finance {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
        }
        .glass {
            background: rgba(255,255,255,.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,.18);
        }

        /* Selector cards */
        .dash-card {
            cursor: pointer;
            border: 2px solid transparent;
            border-radius: 16px;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all .2s;
            background: #f8fafc;
        }
        .dash-card:hover { border-color: #f97316; background: #fff7ed; }
        .dash-card.selected { border-color: #f97316; background: #fff7ed; box-shadow: 0 0 0 3px rgba(249,115,22,.15); }
        .dash-card .card-icon {
            width: 44px; height: 44px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .dash-card .card-icon svg { width: 22px; height: 22px; }
        .dash-card .card-title { font-size: 14px; font-weight: 700; color: #0f172a; }
        .dash-card .card-desc { font-size: 12px; color: #64748b; margin-top: 2px; }
        .dash-card .card-check {
            margin-left: auto;
            width: 20px; height: 20px;
            border: 2px solid #cbd5e1;
            border-radius: 50%;
            flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            transition: all .2s;
        }
        .dash-card.selected .card-check {
            background: #f97316;
            border-color: #f97316;
        }
        .dash-card.selected .card-check::after {
            content: '';
            display: block;
            width: 6px; height: 6px;
            border-radius: 50%;
            background: white;
        }

        /* Animated bg blobs */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: .15;
            animation: float 8s ease-in-out infinite;
        }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-20px)} }
    </style>
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center p-4 sm:p-6 lg:p-8">

<div class="w-full max-w-5xl bg-white rounded-[2rem] shadow-2xl overflow-hidden flex flex-col lg:flex-row min-h-[580px]">

    {{-- ─── LEFT PANEL: Branding ────────────────────────────────── --}}
    <div id="brandPanel" class="panel-admin w-full lg:w-[45%] p-8 sm:p-12 flex flex-col justify-between order-2 lg:order-1 relative overflow-hidden transition-all duration-500">

        {{-- Blobs --}}
        <div class="blob w-64 h-64 bg-orange-400 top-0 left-0 -translate-x-20 -translate-y-20"></div>
        <div class="blob w-48 h-48 bg-blue-400 bottom-10 right-0 translate-x-10" style="animation-delay:4s"></div>

        <div class="relative z-10">
            {{-- Logo --}}
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span class="font-black text-white text-lg" style="font-family:'Montserrat',sans-serif;"><span class="text-orange-300">153</span> Kreatif</span>
            </div>

            {{-- Dynamic content based on selection --}}
            <div id="brandContent">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full glass text-white text-xs font-semibold mb-6">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    <span id="brandTag">Admin Panel</span>
                </div>
                <h2 id="brandTitle" class="text-3xl sm:text-4xl font-bold text-white mb-4 leading-tight" style="font-family:'Montserrat',sans-serif;">
                    Dashboard<br>Perusahaan
                </h2>
                <p id="brandDesc" class="text-white/70 text-sm sm:text-base leading-relaxed">
                    Kelola konten website, layanan, portofolio, dan identitas perusahaan 153 Kreatif secara terpusat.
                </p>

                <div id="brandFeatures" class="mt-8 space-y-3">
                    <div class="glass rounded-xl p-4 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <span class="text-white/90 text-sm font-medium">Manajemen Konten & Halaman</span>
                    </div>
                    <div class="glass rounded-xl p-4 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-white/90 text-sm font-medium">Portofolio & Layanan</span>
                    </div>
                    <div class="glass rounded-xl p-4 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        </div>
                        <span class="text-white/90 text-sm font-medium">Pesan & Kontak Klien</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative z-10 mt-6 text-white/40 text-xs">
            &copy; {{ date('Y') }} 153 Kreatif Techno. All rights reserved.
        </div>
    </div>

    {{-- ─── RIGHT PANEL: Form ───────────────────────────────────── --}}
    <div class="w-full lg:w-[55%] p-8 sm:p-12 flex flex-col justify-center order-1 lg:order-2 bg-white">
        <div class="max-w-md w-full mx-auto">

            {{-- Header --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-900 mb-1" style="font-family:'Montserrat',sans-serif;">Masuk ke Sistem</h1>
                <p class="text-sm text-gray-500">Pilih dashboard tujuan, lalu masukkan kredensial Anda</p>
            </div>

            {{-- Dashboard Selector --}}
            <div class="mb-6 space-y-3">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Masuk sebagai</label>

                <div class="dash-card selected" id="cardAdmin" onclick="selectDash('admin')">
                    <div class="card-icon" style="background:#e2e8f0;">
                        <svg fill="none" stroke="#1e293b" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H4a1 1 0 01-1-1V9.5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 21V12h6v9"/></svg>
                    </div>
                    <div>
                        <div class="card-title">Admin Perusahaan</div>
                        <div class="card-desc">Kelola website, portofolio & konten</div>
                    </div>
                    <div class="card-check"></div>
                </div>

                <div class="dash-card" id="cardFinance" onclick="selectDash('finance')">
                    <div class="card-icon" style="background:#fff7ed;">
                        <svg fill="none" stroke="#f97316" stroke-width="1.75" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <div class="card-title">Dashboard Keuangan</div>
                        <div class="card-desc">Invoice, anggaran, PO & kas</div>
                    </div>
                    <div class="card-check"></div>
                </div>
            </div>

            {{-- Form --}}
            <form id="loginForm" onsubmit="handleLogin(event)" class="space-y-4">
                @csrf
                <input type="hidden" name="redirect_to" id="redirectTo" value="admin">

                {{-- Error Alert --}}
                <div id="errorAlert" class="hidden bg-red-50 border border-red-200 text-red-700 rounded-xl p-3 text-sm flex items-center gap-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span id="errorMessage">Email atau password salah.</span>
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" required autocomplete="email"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all text-sm outline-none"
                        placeholder="email@153kreatif.com">
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required autocomplete="current-password"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition-all text-sm outline-none pr-11"
                            placeholder="••••••••">
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 px-3.5 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                            <svg id="icon-eye" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg id="icon-eye-off" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Remember --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-gray-300 text-orange-500 focus:ring-orange-400">
                    <label for="remember" class="text-sm text-gray-600 cursor-pointer">Ingat saya</label>
                </div>

                {{-- Submit --}}
                <button type="submit" id="submitBtn"
                    class="w-full py-3.5 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-all shadow-lg shadow-orange-500/25 flex justify-center items-center gap-2 text-sm">
                    <span id="btnText">Masuk</span>
                    <svg id="btnLoader" class="w-4 h-4 animate-spin hidden" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

</div>

<script>
// ── Dashboard selector ──────────────────────────────────
const brands = {
    admin: {
        tag: 'Admin Panel',
        title: 'Dashboard<br>Perusahaan',
        desc: 'Kelola konten website, layanan, portofolio, dan identitas perusahaan 153 Kreatif secara terpusat.',
        panelClass: 'panel-admin',
        features: [
            { icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', text: 'Manajemen Konten & Halaman' },
            { icon: 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', text: 'Portofolio & Layanan' },
            { icon: 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z', text: 'Pesan & Kontak Klien' },
        ],
        redirect: 'admin'
    },
    finance: {
        tag: 'Finance Module',
        title: 'Dashboard<br>Keuangan',
        desc: 'Kelola invoice, purchase order, anggaran, kas bank, dan komisi tim secara profesional.',
        panelClass: 'panel-finance',
        features: [
            { icon: 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', text: 'Invoice & Penagihan Klien' },
            { icon: 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z', text: 'Anggaran & Budget Event' },
            { icon: 'M3 10h18M3 14h18m-9-4V6m0 8v4M5 6l7-3 7 3M5 18h14', text: 'Bank, Kas & Mutasi' },
        ],
        redirect: 'finance'
    }
};

let activeDash = 'admin';

function selectDash(type) {
    activeDash = type;
    const b = brands[type];

    // Update cards
    document.getElementById('cardAdmin').classList.toggle('selected', type === 'admin');
    document.getElementById('cardFinance').classList.toggle('selected', type === 'finance');

    // Update hidden input
    document.getElementById('redirectTo').value = b.redirect;

    // Update left panel
    const panel = document.getElementById('brandPanel');
    panel.className = panel.className.replace(/panel-\w+/, b.panelClass);

    document.getElementById('brandTag').textContent = b.tag;
    document.getElementById('brandTitle').innerHTML = b.title;
    document.getElementById('brandDesc').textContent = b.desc;

    const featureContainer = document.getElementById('brandFeatures');
    featureContainer.innerHTML = b.features.map(f => `
        <div class="glass rounded-xl p-4 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${f.icon}"/>
                </svg>
            </div>
            <span class="text-white/90 text-sm font-medium">${f.text}</span>
        </div>
    `).join('');
}

// ── Password toggle ─────────────────────────────────────
function togglePassword() {
    const input = document.getElementById('password');
    const on = document.getElementById('icon-eye');
    const off = document.getElementById('icon-eye-off');
    if (input.type === 'password') {
        input.type = 'text'; on.classList.add('hidden'); off.classList.remove('hidden');
    } else {
        input.type = 'password'; on.classList.remove('hidden'); off.classList.add('hidden');
    }
}

// ── Login submit ────────────────────────────────────────
async function handleLogin(e) {
    e.preventDefault();
    const btn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const btnLoader = document.getElementById('btnLoader');
    const errorAlert = document.getElementById('errorAlert');
    const errorMessage = document.getElementById('errorMessage');

    btn.disabled = true;
    btnText.classList.add('hidden');
    btnLoader.classList.remove('hidden');
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
            // Redirect based on chosen dashboard
            const target = document.getElementById('redirectTo').value;
            if (target === 'finance') {
                window.location.href = '{{ route("admin.finance.index") }}';
            } else {
                window.location.href = data.redirect;
            }
        } else {
            errorAlert.classList.remove('hidden');
            errorMessage.textContent = data?.message || 'Terjadi kesalahan pada server.';
        }
    } catch (err) {
        errorAlert.classList.remove('hidden');
        errorMessage.textContent = 'Gagal terhubung ke server.';
    } finally {
        btn.disabled = false;
        btnText.classList.remove('hidden');
        btnLoader.classList.add('hidden');
    }
}
</script>
</body>
</html>