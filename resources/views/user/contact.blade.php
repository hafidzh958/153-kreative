@extends('layouts.app')

@section('title', ($contact->hero_title ?? 'Hubungi Kami') . ' - 153 Kreatif')

@push('styles')
<style>
    /* ── Blobs ── */
    .blob { position:absolute; filter:blur(80px); z-index:0; opacity:0.4; }
    .blob-1 { background:#ff8c3a; width:300px; height:300px; border-radius:50%; top:-100px; right:-50px; }
    .blob-2 { background:#ff6a00; width:250px; height:250px; border-radius:50%; bottom:-50px; left:-50px; }

    /* ── Contact Info Cards ── */
    .info-card {
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .info-icon-bg {
        background-color: #fff3ec;
        color: #ff6a00;
        transition: background-color 0.3s, color 0.3s;
    }
    .info-card:hover .info-icon-bg {
        background-color: #ff6a00;
        color: #fff;
    }

    /* ── CTA Card ── */
    .cta-card {
        border-radius: 24px;
        background: #fff;
        box-shadow: 0 8px 40px rgba(0,0,0,0.09);
        transition: transform 0.3s ease;
    }

    /* ── WA Button ── */
    .btn-wa {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        width: 100%; padding: 16px 28px;
        background: #25D366; color: #fff;
        border-radius: 50px; font-weight: 700; font-size: 1.05rem;
        transition: background 0.25s, transform 0.25s, box-shadow 0.25s;
        box-shadow: 0 6px 24px rgba(37,211,102,0.35);
    }
    .btn-wa:hover { background: #1eba58; box-shadow: 0 12px 32px rgba(37,211,102,0.45); }

    /* ── Email Button ── */
    .btn-email {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        width: 100%; padding: 16px 28px;
        background: #fff; color: #374151;
        border: 2px solid #e5e7eb; border-radius: 50px; font-weight: 700; font-size: 1.05rem;
        transition: background 0.25s, border-color 0.25s, transform 0.25s, box-shadow 0.25s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .btn-email:hover { background: #f9fafb; border-color: #d1d5db; box-shadow: 0 6px 20px rgba(0,0,0,0.1); }

    /* ── Instagram Button ── */
    .btn-instagram {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        width: 100%; padding: 16px 28px;
        background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);
        color: #fff;
        border-radius: 50px; font-weight: 700; font-size: 1.05rem;
        transition: transform 0.25s, box-shadow 0.25s;
        box-shadow: 0 6px 20px rgba(220, 39, 67, 0.25);
    }
    .btn-instagram:hover { transform: scale(1.03); box-shadow: 0 10px 25px rgba(220, 39, 67, 0.35); color: #fff; }
</style>
@endpush

@section('content')

{{-- 1. HERO --}}
<section class="pt-32 pb-24 md:pt-40 md:pb-32 bg-gradient-to-br from-[#fff3ec] to-[#ffe6d6] overflow-hidden relative">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <h1 data-aos="fade-up" data-aos-duration="1000" class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-gray-900 tracking-tight mb-6 drop-shadow-sm pb-2" style="font-family:'Montserrat',sans-serif;">
            {{ $contact->hero_title ?? 'Hubungi Kami' }}
        </h1>
        @if(!empty(trim($contact->hero_subtitle)))
            <p data-aos="fade-up" data-aos-delay="200" class="text-xl sm:text-2xl text-gray-700 font-medium max-w-2xl mx-auto leading-relaxed" style="font-family:'Inter',sans-serif;">
                {{ $contact->hero_subtitle }}
            </p>
        @endif
    </div>
</section>

{{-- 2. CTA + CONTACT CARD (2-column) --}}
<section class="py-24 lg:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 lg:gap-20 items-center">

            {{-- KIRI: Teks CTA --}}
            <div data-aos="fade-right">
                @if(!empty(trim($contact->cta_title)))
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6 leading-tight pb-2" style="font-family:'Montserrat',sans-serif;">
                        {{ $contact->cta_title }}
                        @if(!empty(trim($contact->cta_description)))
                            <br><span class="text-[#ff6a00]">{{ $contact->cta_description }}</span>
                        @endif
                    </h2>
                @else
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6 leading-tight pb-2" style="font-family:'Montserrat',sans-serif;">
                        Punya Ide Brilian?<br>
                        <span class="text-[#ff6a00]">Mari bicarakan.</span>
                    </h2>
                    <p class="text-lg text-gray-600 leading-relaxed" style="font-family:'Inter',sans-serif;">
                        Tim ahli dari 153 Kreatif siap berdiskusi untuk mewujudkan event dan aktivasi brand Anda.
                    </p>
                @endif

                {{-- Info singkat di bawah teks --}}
                <div class="mt-10 flex flex-col gap-3">
                    @if($contact->whatsapp)
                        <div class="flex items-center gap-3 text-gray-600" style="font-family:'Inter',sans-serif;">
                            <div class="w-9 h-9 bg-green-50 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </div>
                            <span class="font-medium">+{{ $contact->whatsapp }}</span>
                        </div>
                    @endif
                    @if($contact->email)
                        <div class="flex items-center gap-3 text-gray-600" style="font-family:'Inter',sans-serif;">
                            <div class="w-9 h-9 bg-orange-50 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="font-medium break-all">{{ $contact->email }}</span>
                        </div>
                    @endif
                    @if($contact->address)
                        <div class="flex items-start gap-3 text-gray-600" style="font-family:'Inter',sans-serif;">
                            <div class="w-9 h-9 bg-blue-50 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <span class="leading-relaxed">{{ $contact->address }}</span>
                        </div>
                    @endif
                </div>
            </div>

            {{-- KANAN: Contact Card --}}
            <div data-aos="fade-left" data-aos-delay="200" class="cta-card p-8 lg:p-10 text-center flex flex-col justify-center min-h-[380px]">
                <div class="w-20 h-20 bg-[#fff3ec] rounded-full flex items-center justify-center mx-auto mb-6 text-[#ff6a00]">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-3" style="font-family:'Montserrat',sans-serif;">Hubungi Kami</h3>
                <p class="text-gray-500 mb-8 leading-relaxed" style="font-family:'Inter',sans-serif;">
                    Diskusikan kebutuhan event, pameran, atau aktivasi brand Anda langsung dengan tim kami.
                </p>

                <div class="flex flex-col gap-4">
                    {{-- WhatsApp Button (Dynamic) --}}
                    @php
                        $waNumber  = $contact->whatsapp ?? '6285711376797';
                        $waMessage = $contact->whatsapp_message ?? 'Halo, saya ingin menanyakan tentang layanan 153 Kreatif.';
                        $waUrl     = 'https://wa.me/' . $waNumber . '?text=' . urlencode($waMessage);
                    @endphp
                    <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="btn-wa transition duration-300 hover:scale-105" style="font-family:'Montserrat',sans-serif;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                        </svg>
                        Chat via WhatsApp
                    </a>

                    {{-- Instagram Button (Dynamic) --}}
                    <a href="{{ $contact->instagram_url ?? '#' }}" target="_blank" rel="noopener noreferrer" class="btn-instagram transition duration-300" style="font-family:'Montserrat',sans-serif;">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        Lihat Karya Kami di Instagram
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- 3. INFO CARDS (3 kolom horizontal, di bawah CTA) --}}
@if($contact->address || $contact->email || $contact->phone || $contact->whatsapp)
<section class="py-24 lg:py-32 bg-gradient-to-b from-white to-[#fff3ec]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Card: Alamat --}}
            @if($contact->address)
            <div data-aos="fade-up" data-aos-delay="100" class="info-card p-7 text-center transition duration-300 ease-in-out hover:scale-[1.03] hover:shadow-xl">
                <div class="info-icon-bg w-14 h-14 mx-auto rounded-full flex items-center justify-center mb-5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2" style="font-family:'Montserrat',sans-serif;">Alamat</h3>
                <p class="text-gray-500 text-sm leading-relaxed" style="font-family:'Inter',sans-serif;">{{ $contact->address }}</p>
            </div>
            @endif

            {{-- Card: Email --}}
            @if($contact->email)
            <div data-aos="fade-up" data-aos-delay="200" class="info-card p-7 text-center transition duration-300 ease-in-out hover:scale-[1.03] hover:shadow-xl">
                <div class="info-icon-bg w-14 h-14 mx-auto rounded-full flex items-center justify-center mb-5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2" style="font-family:'Montserrat',sans-serif;">Email</h3>
                <p class="text-sm break-all" style="font-family:'Inter',sans-serif;">
                    <a href="mailto:{{ $contact->email }}" class="text-gray-500 hover:text-[#ff6a00] transition-colors">{{ $contact->email }}</a>
                </p>
            </div>
            @endif

            {{-- Card: Telepon / WhatsApp --}}
            @if($contact->phone || $contact->whatsapp)
            <div data-aos="fade-up" data-aos-delay="300" class="info-card p-7 text-center transition duration-300 ease-in-out hover:scale-[1.03] hover:shadow-xl">
                <div class="info-icon-bg w-14 h-14 mx-auto rounded-full flex items-center justify-center mb-5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-2" style="font-family:'Montserrat',sans-serif;">Telepon / WhatsApp</h3>
                <p class="text-gray-500 text-sm" style="font-family:'Inter',sans-serif;">
                    @if($contact->phone){{ $contact->phone }}<br>@endif
                    @if($contact->whatsapp)+{{ $contact->whatsapp }}@endif
                </p>
            </div>
            @endif

        </div>
    </div>
</section>
@endif

{{-- 4. MAP (tampil jika ada latitude/longitude ATAU map_link) --}}
@if($contact->latitude && $contact->longitude || $contact->map_link)
<section class="py-24 lg:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div data-aos="fade-up" class="text-center mb-10">
            <h2 class="text-3xl font-extrabold text-gray-900 pb-2" style="font-family:'Montserrat',sans-serif;">Lokasi Kami</h2>
            <div class="w-16 h-1 bg-[#ff6a00] mx-auto mt-4 rounded-full"></div>
        </div>

        @php
            $openUrl = $contact->map_link ?? null;
            $embedSrc = null;

            if ($contact->latitude && $contact->longitude) {
                $embedSrc = 'https://www.google.com/maps?q=' . $contact->latitude . ',' . $contact->longitude . '&output=embed';
                if (!$openUrl) {
                    $openUrl = 'https://www.google.com/maps?q=' . $contact->latitude . ',' . $contact->longitude;
                }
            } else {
                // Selalu tampilkan map menggunakan text alamat jika lat/lng kosong
                $addressStr = strip_tags($contact->address ?? 'Jakarta, Indonesia');
                $embedSrc = 'https://www.google.com/maps?q=' . urlencode($addressStr) . '&output=embed';
                if (!$openUrl) {
                    $openUrl = 'https://www.google.com/maps?q=' . urlencode($addressStr);
                }
            }
        @endphp

        <div data-aos="fade-up" data-aos-delay="200">
            @if($embedSrc)
                {{-- Embedded Map iframe --}}
                <div class="overflow-hidden shadow-xl border border-gray-100 mb-6 transition duration-300 hover:scale-[1.02] hover:shadow-2xl"
                     style="border-radius:20px; height:440px;">
                    <iframe
                        src="{{ $embedSrc }}"
                        width="100%" height="100%"
                        style="border:0; filter:grayscale(10%) contrast(108%);"
                        allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            @else
                {{-- Placeholder (short link yang tidak bisa di-embed) --}}
                <div class="overflow-hidden shadow-xl border border-gray-100 mb-6 bg-gradient-to-br from-gray-50 to-gray-100 flex flex-col items-center justify-center"
                     style="border-radius:20px; height:260px;">
                    <div class="w-16 h-16 bg-[#fff3ec] rounded-full flex items-center justify-center mb-5 text-[#ff6a00]">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-600 font-semibold mb-1" style="font-family:'Montserrat',sans-serif;">Temukan Lokasi Kami</p>
                    <p class="text-gray-400 text-sm" style="font-family:'Inter',sans-serif;">Klik tombol di bawah untuk membuka Google Maps</p>
                </div>
            @endif

            {{-- Tombol Buka di Google Maps --}}
            @if($openUrl)
                <div class="text-center">
                    <a href="{{ $openUrl }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2.5 px-8 py-3.5 bg-[#ff6a00] text-white font-bold rounded-full transition duration-300 hover:bg-[#e55f00] hover:scale-105 hover:shadow-lg"
                       style="font-family:'Montserrat',sans-serif;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Buka di Google Maps
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
@endif

@endsection
