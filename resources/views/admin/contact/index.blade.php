@extends('admin.layouts.app')

@section('title', 'Manage Contact Page')
@section('page-title', 'Contact Page')

@section('content')

@if(session('success'))
    <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4 text-sm font-medium">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm font-medium">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Terdapat kesalahan validasi. Periksa kembali isian form.
    </div>
@endif

<form action="{{ route('admin.contact.update') }}" method="POST" class="space-y-6" id="contactForm">
    @csrf
    @method('PUT')

    {{-- ─── SECTION 1: HERO ─── --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Section 1 — Hero Contact</h2>
                <p class="text-xs text-gray-500">Judul dan subjudul pada bagian atas halaman Contact.</p>
            </div>
        </div>
        <div class="p-6 grid grid-cols-1 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Hero Title <span class="text-red-500">*</span></label>
                <input type="text" name="hero_title"
                    value="{{ old('hero_title', $contact->hero_title ?? 'Hubungi Kami') }}"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors @error('hero_title') border-red-400 @enderror"
                    required placeholder="e.g. Hubungi Kami">
                @error('hero_title')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Hero Subtitle <span class="text-gray-400 text-xs font-normal">(opsional)</span></label>
                <textarea name="hero_subtitle" rows="2"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors resize-none"
                    placeholder="e.g. Kami siap membantu mewujudkan event Anda...">{{ old('hero_subtitle', $contact->hero_subtitle ?? '') }}</textarea>
            </div>
        </div>
    </div>

    {{-- ─── SECTION 2: INFO KONTAK ─── --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Section 2 — Informasi Kontak</h2>
                <p class="text-xs text-gray-500">WhatsApp & Email wajib diisi. Lainnya opsional.</p>
            </div>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- WhatsApp --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor WhatsApp <span class="text-red-500">*</span></label>
                <input type="text" name="whatsapp"
                    value="{{ old('whatsapp', $contact->whatsapp ?? '') }}"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors @error('whatsapp') border-red-400 @enderror"
                    required placeholder="628xxxxxxxxxxxx">
                <p class="mt-1 text-xs text-gray-400">Gunakan format internasional tanpa + (contoh: 6281234567890)</p>
                @error('whatsapp')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email"
                    value="{{ old('email', $contact->email ?? '') }}"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors @error('email') border-red-400 @enderror"
                    required placeholder="e.g. info@153kreatif.com">
                @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- WA Message --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Pesan Default WhatsApp <span class="text-gray-400 text-xs font-normal">(opsional)</span></label>
                <textarea name="whatsapp_message" rows="2"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors resize-none"
                    placeholder="e.g. Halo, saya ingin menanyakan tentang event...">{{ old('whatsapp_message', $contact->whatsapp_message ?? '') }}</textarea>
                <p class="mt-1 text-xs text-gray-400">Pesan ini akan muncul otomatis saat user klik tombol WhatsApp.</p>
            </div>

            {{-- Phone --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Telepon <span class="text-gray-400 text-xs font-normal">(opsional)</span></label>
                <input type="text" name="phone"
                    value="{{ old('phone', $contact->phone ?? '') }}"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors"
                    placeholder="e.g. (021) 1234-5678">
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat <span class="text-gray-400 text-xs font-normal">(opsional)</span></label>
                <textarea name="address" rows="2"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors resize-none"
                    placeholder="e.g. Jl. Contoh No. 123, Jakarta Selatan">{{ old('address', $contact->address ?? '') }}</textarea>
            </div>
        </div>
    </div>

    {{-- ─── SECTION 3: CTA ─── --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Section 3 — Call to Action</h2>
                <p class="text-xs text-gray-500">Teks ajakan di samping contact card. Semua opsional.</p>
            </div>
        </div>
        <div class="p-6 grid grid-cols-1 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul CTA <span class="text-gray-400 text-xs font-normal">(opsional)</span></label>
                <input type="text" name="cta_title"
                    value="{{ old('cta_title', $contact->cta_title ?? '') }}"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors"
                    placeholder="e.g. Punya Ide Brilian?">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi CTA <span class="text-gray-400 text-xs font-normal">(opsional)</span></label>
                <textarea name="cta_description" rows="3"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors resize-none"
                    placeholder="e.g. Tim ahli kami siap membantu mewujudkan event impian Anda.">{{ old('cta_description', $contact->cta_description ?? '') }}</textarea>
            </div>
        </div>
    </div>

    {{-- ─── SECTION 4: MAP ─── --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Section 4 — Map Lokasi</h2>
                <p class="text-xs text-gray-500">Opsional. Jika Latitude & Longitude diisi, map akan tampil langsung di halaman user.</p>
            </div>
        </div>
        <div class="p-6 space-y-5">

            {{-- Tips cara dapat koordinat --}}
            <div class="flex items-start gap-3 p-3 bg-blue-50 border border-blue-100 rounded-lg text-xs text-blue-700">
                <svg class="w-4 h-4 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span><strong>Cara dapat koordinat:</strong> Buka Google Maps → Klik kanan pada lokasi → Klik angka koordinat (contoh: <code class="bg-blue-100 px-1 rounded">-6.200000, 106.816666</code>) → otomatis tersalin.</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                {{-- Latitude --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Latitude <span class="text-gray-400 text-xs font-normal">(opsional)</span></label>
                    <input type="text" name="latitude"
                        value="{{ old('latitude', $contact->latitude ?? '') }}"
                        class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors"
                        placeholder="e.g. -6.200000">
                </div>
                {{-- Longitude --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Longitude <span class="text-gray-400 text-xs font-normal">(opsional)</span></label>
                    <input type="text" name="longitude"
                        value="{{ old('longitude', $contact->longitude ?? '') }}"
                        class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors"
                        placeholder="e.g. 106.816666">
                </div>
            </div>

            {{-- map_link (untuk tombol "Buka di Google Maps") --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Link Google Maps <span class="text-gray-400 text-xs font-normal">(untuk tombol "Buka di Maps" — opsional)</span>
                </label>
                <input type="text" name="map_link"
                    value="{{ old('map_link', $contact->map_link ?? '') }}"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors"
                    placeholder="https://maps.app.goo.gl/xxxxx atau https://www.google.com/maps?q=...">
                <p class="mt-1 text-xs text-gray-400">Paste link share dari Google Maps. Digunakan sebagai target tombol "Buka di Google Maps" di halaman user.</p>
            </div>

            {{-- Preview iframe jika lat/lng sudah terisi --}}
            @if($contact->latitude && $contact->longitude)
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-2">Preview Map (dari koordinat yang tersimpan):</p>
                    <div class="rounded-xl overflow-hidden border border-gray-200" style="height:240px;">
                        <iframe
                            src="https://www.google.com/maps?q={{ $contact->latitude }},{{ $contact->longitude }}&output=embed"
                            width="100%" height="240" style="border:0;" loading="lazy">
                        </iframe>
                    </div>
                    <p class="mt-1.5 text-xs text-gray-400">Koordinat: {{ $contact->latitude }}, {{ $contact->longitude }}</p>
                </div>
            @endif

        </div>
    </div>


    {{-- ─── SAVE BUTTON ─── --}}
    <div class="flex items-center gap-4 pt-2 pb-10">
        <button type="submit"
            class="inline-flex items-center gap-2 px-8 py-3 bg-[#f97316] text-white text-base font-bold rounded-lg hover:bg-orange-600 transition-colors shadow-lg hover:shadow-xl hover:-translate-y-0.5 transform">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Save Changes
        </button>
        <a href="{{ route('contact') }}" target="_blank"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Preview Halaman Contact
        </a>
    </div>
</form>

@endsection
