@extends('layouts.app')

@section('title', 'Home - 153 Creative')

@push('styles')
@endpush

@section('content')
{{-- 1. Hero Section --}}
<section class="relative min-h-[85vh] flex items-center justify-center bg-gray-900 overflow-hidden">
    <img
        src="{{ ($home && $home->hero_background_image) ? asset('storage/'.$home->hero_background_image) : 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=1920&q=80' }}"
        alt="Exhibition and Event"
        class="absolute inset-0 w-full h-full object-cover"
    />
    <div class="absolute inset-0" style="background: linear-gradient(135deg, rgba(255,106,0,0.85), rgba(255,140,58,0.85));"></div>
    <div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
        <h1 class="animate-fade-in-up text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight mb-4 drop-shadow-md" style="font-family: 'Montserrat', sans-serif;">
            {{ $home->hero_title ?? '153 Kreatif' }}
        </h1>
        <p class="animate-fade-in-up delay-1 text-2xl sm:text-3xl font-bold mb-4 drop-shadow-sm" style="font-family: 'Inter', sans-serif;">
            {{ $home->hero_subtitle ?? 'Integrated Event Solutions & Creative Production' }}
        </p>
        @if($home && $home->hero_description)
        <p class="animate-fade-in-up delay-2 text-white/90 text-lg sm:text-xl max-w-3xl mx-auto mb-10 leading-relaxed font-medium" style="font-family: 'Inter', sans-serif;">
            {{ $home->hero_description }}
        </p>
        @else
        <p class="animate-fade-in-up delay-2 text-white/90 text-lg sm:text-xl max-w-3xl mx-auto mb-10 leading-relaxed font-medium" style="font-family: 'Inter', sans-serif;">
            Solusi lengkap untuk event, exhibition, dan produksi kreatif yang memadukan strategi dengan eksekusi.
        </p>
        @endif
        <a
            href="{{ $home->hero_button_link ?? route('portfolio') }}"
            class="animate-fade-in-up delay-3 inline-block px-10 py-4 bg-white text-[#ff6a00] font-bold rounded-full text-lg shadow-md transition duration-300 hover:scale-105 hover:shadow-lg"
            style="font-family: 'Montserrat', sans-serif;"
        >
            {{ $home->hero_button_text ?? 'View Portfolio' }}
        </a>
    </div>
</section>

{{-- 2. About Preview Section --}}
<section class="py-24 lg:py-32 bg-[#fff3ec]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6" style="font-family: 'Montserrat', sans-serif;">
                    {{ $home->about_title ?? 'Tentang Kami' }}
                </h2>
                <div class="w-20 h-1 bg-[#ff6a00] mb-8"></div>
                <p class="text-gray-600 leading-relaxed text-lg" style="font-family: 'Inter', sans-serif;">
                    {{ $home->about_description ?? '153 Kreatif adalah perusahaan manajemen acara dan produksi kreatif yang menyediakan solusi pemasaran terpadu melalui event, exhibition, dan produksi visual. Kami membantu brand menghubungkan audiens dengan pengalaman yang memorable dan terukur.' }}
                </p>
            </div>
            <div class="relative rounded-lg overflow-hidden shadow-2xl aspect-[4/3] max-h-[450px] group">
                <img
                    src="{{ ($home && $home->about_image) ? asset('storage/'.$home->about_image) : 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=800&q=80' }}"
                    alt="Event production"
                    class="w-full h-full object-cover transition duration-500 group-hover:scale-110"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>
        </div>
    </div>
</section>

{{-- 3. Services Section --}}
@if($services->count() > 0)
<section class="py-24 lg:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 text-center mb-4" style="font-family: 'Montserrat', sans-serif;">Layanan Kami</h2>
        <div class="w-16 h-1 bg-[#ff6a00] mx-auto mb-6"></div>
        <p class="text-gray-600 text-center max-w-2xl mx-auto mb-14 text-lg" style="font-family: 'Inter', sans-serif;">Solusi terpadu dari konsep hingga eksekusi</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $service)
            <div class="service-card p-6 bg-white rounded-xl shadow-md transition duration-300 ease-in-out hover:scale-[1.03] hover:shadow-xl">
                <div class="service-icon mb-4">
                    <i class="bi bi-briefcase text-3xl text-[#ff6a00]"></i>
                </div>
                <h4 class="text-xl font-bold mb-3" style="font-family: 'Montserrat', sans-serif;">{{ $service->name }}</h4>
                <p class="text-gray-600 leading-relaxed">{{ \Illuminate\Support\Str::limit($service->description, 120) }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- 4. Portfolio Preview Section --}}
@if($projects->count() > 0)
<section class="py-24 lg:py-32 bg-[#f9fafb]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12">
            <div>
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900" style="font-family: 'Montserrat', sans-serif;">Featured Projects</h2>
                <div class="w-16 h-1 bg-[#ff6a00] mt-4 mb-4"></div>
                <p class="text-gray-600 text-lg" style="font-family: 'Inter', sans-serif;">Beberapa karya terbaru kami</p>
            </div>
            <a href="{{ route('portfolio') }}" class="text-gray-900 font-semibold hover:text-[#ff6a00] transition-colors inline-flex items-center gap-1 group" style="font-family: 'Montserrat', sans-serif;">
                Lihat Semua
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        {{-- Grid: 3 kolom, center jika tidak kelipatan 3 --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 place-items-center">
            @foreach($projects as $project)
            <div class="project-card w-full rounded-2xl overflow-hidden group shadow-md transition duration-300 ease-in-out hover:scale-[1.03] hover:shadow-xl">
                <div class="project-img-wrap relative aspect-[4/3] overflow-hidden">
                    @if($project->image)
                        <img
                            src="{{ asset('storage/'.$project->image) }}"
                            alt="{{ $project->title ?? 'Project' }}"
                            class="project-image img-loading w-full h-full object-cover transition duration-500 group-hover:scale-110"
                            loading="lazy"
                            onerror="this.src='/images/fallback.jpg'"
                            onload="this.classList.remove('img-loading'); this.classList.add('img-loaded')"
                        >
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="project-overlay">
                    <h3 style="font-family: 'Montserrat', sans-serif;">{{ $project->title }}</h3>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- 5. Contact CTA Section --}}
<section class="py-24 lg:py-32 bg-[#0f0f0f] relative overflow-hidden">
    <div class="absolute inset-0 bg-[#ff6a00]/5"></div>
    <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight" style="font-family: 'Montserrat', sans-serif;">Let's Create Your Next Event</h2>
        <p class="text-white/80 mb-10 text-lg sm:text-xl font-medium" style="font-family: 'Inter', sans-serif;">Siap berkolaborasi? Hubungi kami untuk diskusi project Anda.</p>
        <a href="{{ route('contact') }}" class="inline-block px-10 py-4 bg-[#ff6a00] text-white font-bold rounded-full shadow-md transition duration-300 hover:scale-105 hover:shadow-lg hover:bg-[#e65c00] text-lg" style="font-family: 'Montserrat', sans-serif;">
            Hubungi Kami
        </a>
    </div>
</section>
@endsection
