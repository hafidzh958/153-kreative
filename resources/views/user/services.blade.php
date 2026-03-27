@extends('layouts.app')

@section('title', 'Layanan Kami - 153 Kreatif')

@push('styles')
<style>
    @verbatim
    /* Flex Zigzag Layout */
    .service-row {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 60px;
    }
    @media (min-width: 1024px) {
        .service-row {
            flex-direction: row;
        }
        .service-row.reverse {
            flex-direction: row-reverse;
        }
    }
    .service-row > .service-img,
    .service-row > .service-text {
        width: 100%;
    }
    @media (min-width: 1024px) {
        .service-row > .service-text {
            flex: 0 0 40%;
        }
        .service-row > .service-img {
            flex: 0 0 55%; /* using 55% to leave some auto gap */
        }
    }

    }
    @endverbatim
</style>
@endpush

@section('content')

@php
    $autoIcons = [
        '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>',
        '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>',
        '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
        '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
        '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>',
        '<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.069A1 1 0 0121 8.87V15.13a1 1 0 01-1.447.899L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>',
    ];
@endphp

{{-- 1. Header Section --}}
<section class="pt-32 pb-24 md:pt-40 md:pb-32 overflow-hidden relative">
    @if(isset($settings) && $settings->hero_image)
        <img 
            src="{{ asset('storage/'.$settings->hero_image) }}" 
            class="absolute inset-0 w-full h-full object-cover object-center"
            alt="Services Background"
        >
        <div class="absolute inset-0 bg-[#ff6a00]/80"></div>
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-[#ff6a00] to-[#ff8c3a]"></div>
    @endif
    
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <h1 data-aos="fade-up" data-aos-duration="1000" class="text-5xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight mb-6 drop-shadow-md" style="font-family: 'Montserrat', sans-serif;">
            {{ $settings->hero_title ?? 'Layanan Kami' }}
        </h1>
        <p data-aos="fade-up" data-aos-delay="200" class="text-xl sm:text-2xl text-amber-100 font-medium max-w-2xl mx-auto leading-relaxed" style="font-family: 'Inter', sans-serif;">
            {{ $settings->hero_subtitle ?? 'Integrated Event Solutions & Creative Production' }}
        </p>
    </div>
</section>

{{-- 2. Services Introduction --}}
<section class="py-16 bg-white border-b border-gray-100">
    <div data-aos="fade-up" class="max-w-4xl mx-auto px-4 text-center">
        <p class="text-xl md:text-2xl text-gray-700 leading-relaxed font-medium" style="font-family: 'Inter', sans-serif;">
            @if(isset($settings) && $settings->intro_text)
                {!! nl2br(e($settings->intro_text)) !!}
            @else
                <strong class="text-[#ff6a00]">153 Kreatif</strong> menyediakan solusi event terintegrasi yang mencakup manajemen acara, produksi kreatif, serta penyelenggaraan event komunitas untuk memperkuat kehadiran brand Anda.
            @endif
        </p>
    </div>
</section>

{{-- 3. Main Services (Zig-Zag from DB) --}}
@forelse($mainServices as $index => $service)
<section class="py-24 lg:py-32 overflow-hidden {{ $index % 2 === 0 ? 'bg-white' : 'bg-[#fff3ec]' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="service-row {{ $index % 2 !== 0 ? 'reverse' : '' }}">
            {{-- Image --}}
            <div data-aos="{{ $index % 2 === 0 ? 'fade-right' : 'fade-left' }}" class="service-img flex justify-center items-center group">
                @if($service->image)
                    <img
                        src="{{ asset('storage/'.$service->image) }}"
                        alt="{{ $service->name }}"
                        class="max-h-[420px] max-w-[500px] w-auto object-cover rounded-xl shadow-md transition duration-500 group-hover:scale-110"
                    />
                @else
                    <div class="max-h-[420px] max-w-[500px] w-full py-32 bg-gradient-to-br from-orange-50 to-orange-100 flex flex-col items-center justify-center gap-3 rounded-xl shadow-md transition duration-500 group-hover:scale-110">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-[#ff6a00]/10 rounded-2xl flex items-center justify-center text-[#ff6a00]">
                            {!! $autoIcons[$index % count($autoIcons)] !!}
                        </div>
                        <span class="text-sm text-orange-300 font-medium">{{ $service->name }}</span>
                    </div>
                @endif
            </div>

            {{-- Text --}}
            <div data-aos="{{ $index % 2 === 0 ? 'fade-left' : 'fade-right' }}" data-aos-delay="200" class="service-text space-y-4">
                <div class="inline-flex items-center justify-center w-10 h-10 opacity-80 {{ $index % 2 !== 0 ? 'bg-white shadow-sm' : 'bg-[#fff3ec]' }} rounded-xl text-[#ff6a00]">
                    {!! str_replace('w-7 h-7', 'w-5 h-5', $autoIcons[$index % count($autoIcons)]) !!}
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900" style="font-family: 'Montserrat', sans-serif;">{{ $service->name }}</h2>
                <div class="w-16 h-1 bg-[#ff6a00] rounded-full"></div>
                @if($service->description)
                    <p class="text-sm text-gray-600 leading-relaxed" style="font-family: 'Inter', sans-serif;">
                        {{ $service->description }}
                    </p>
                @endif

                @if($service->features->count())
                <ul class="space-y-3 text-sm text-gray-600 mt-2" style="font-family: 'Inter', sans-serif;">
                    @foreach($service->features as $feature)
                    <li class="flex items-start gap-3">
                        <div class="w-5 h-5 mt-0.5 flex-shrink-0 {{ $index % 2 !== 0 ? 'bg-white border text-[#ff6a00]' : 'bg-[#ff6a00] text-white shadow-sm' }} rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span>{{ $feature->text }}</span>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</section>
@empty
<section class="py-24 bg-white">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <p class="text-gray-400 text-lg">Konten layanan sedang dipersiapkan.</p>
    </div>
</section>
@endforelse

{{-- 4. Supporting Services Grid --}}
@if($supportingServices->count())
<section class="py-24 lg:py-32 bg-gray-50 border-t border-gray-100">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div data-aos="fade-up" class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4 pb-2" style="font-family: 'Montserrat', sans-serif;">Layanan Pendukung Lainnya</h2>
            <div class="w-16 h-1.5 bg-[#ff6a00] mx-auto rounded-full"></div>
        </div>

        <div class="flex flex-wrap justify-center gap-6 max-w-5xl mx-auto">
            @foreach($supportingServices as $index => $s)
            <div data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}" class="w-[220px] bg-white border border-gray-100 rounded-xl p-5 flex items-center justify-center text-center shadow-md transition duration-300 ease-in-out hover:scale-[1.05] hover:shadow-[0_10px_25px_-5px_rgba(255,106,0,0.2)] hover:border-orange-300 min-h-[80px]">
                <h4 class="text-base font-semibold text-gray-800 leading-snug" style="font-family: 'Montserrat', sans-serif;">{{ $s->name }}</h4>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- 5. Call To Action Section --}}
<section class="py-24 lg:py-32 bg-gradient-to-br from-white to-[#ffe6d6] relative overflow-hidden border-b border-orange-100">
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <h2 data-aos="fade-up" class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-900 mb-12 leading-tight drop-shadow-sm pb-2" style="font-family: 'Montserrat', sans-serif;">
            Let's Create Your Next Event With 153 Kreatif
        </h2>
        <a data-aos="zoom-in" data-aos-delay="200" href="{{ route('contact') }}" class="inline-block px-10 py-4 bg-gradient-to-r from-[#ff6a00] to-[#ff8c3a] text-white font-bold rounded-full text-xl shadow-[0_4px_14px_0_rgba(255,106,0,0.39)] transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_6px_20px_rgba(255,106,0,0.23)] hover:from-[#e65c00] hover:to-[#ff6a00]" style="font-family: 'Montserrat', sans-serif;">
            Hubungi Kami
        </a>
    </div>
</section>

@endsection
