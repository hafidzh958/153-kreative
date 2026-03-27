@extends('layouts.app')

@section('title', 'Home - 153 Creative')

@push('styles')
<style>
/* Marquee Animation */
.animate-marquee {
    animation: marquee 12s linear infinite;
}
.animate-marquee2 {
    animation: marquee2 12s linear infinite;
}
@keyframes marquee {
    0% { transform: translateX(0%); }
    100% { transform: translateX(-100%); }
}
@keyframes marquee2 {
    0% { transform: translateX(100%); }
    100% { transform: translateX(0%); }
}
</style>
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
        <h1 data-aos="fade-up" data-aos-duration="1000" class="text-5xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight mb-4 drop-shadow-md text-white" style="font-family: 'Montserrat', sans-serif;">
            {{ $home->hero_title ?? '153 Kreatif' }}
        </h1>
        <p data-aos="fade-up" data-aos-delay="100" class="text-2xl sm:text-3xl font-bold mb-4 drop-shadow-sm text-amber-100" style="font-family: 'Inter', sans-serif;">
            {{ $home->hero_subtitle ?? 'Integrated Event Solutions & Creative Production' }}
        </p>
        @if($home && $home->hero_description)
        <p data-aos="fade-up" data-aos-delay="200" class="text-white/90 text-lg sm:text-xl max-w-3xl mx-auto mb-10 leading-relaxed font-medium" style="font-family: 'Inter', sans-serif;">
            {{ $home->hero_description }}
        </p>
        @else
        <p data-aos="fade-up" data-aos-delay="200" class="text-white/90 text-lg sm:text-xl max-w-3xl mx-auto mb-10 leading-relaxed font-medium" style="font-family: 'Inter', sans-serif;">
            Solusi lengkap untuk event, exhibition, dan produksi kreatif yang memadukan strategi dengan eksekusi.
        </p>
        @endif
        <a data-aos="zoom-in" data-aos-delay="400"
            href="{{ $home->hero_button_link ?? route('portfolio') }}"
            class="inline-block px-10 py-4 bg-white text-[#ff6a00] font-bold rounded-full text-lg shadow-[0_8px_25px_rgba(0,0,0,0.15)] transition-all duration-300 hover:scale-[1.03] hover:shadow-[0_12px_30px_rgba(255,255,255,0.25)]"
            style="font-family: 'Montserrat', sans-serif;"
        >
            {{ $home->hero_button_text ?? 'View Portfolio' }}
        </a>
    </div>
</section>

{{-- 1.5. Trusted By (Client Logos) --}}
<section class="py-10 bg-white border-b border-gray-100 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4 text-center">
        <p class="text-xs sm:text-sm font-bold text-gray-400 tracking-widest uppercase" style="font-family: 'Montserrat', sans-serif;">Mitra yang telah bekerja sama dengan kami</p>
    </div>
    <div class="relative flex overflow-x-hidden group">
        @if($clients->count() > 0)
            <div class="py-4 animate-marquee whitespace-nowrap flex items-center gap-12 sm:gap-20 px-10">
                @foreach($clients as $client)
                    <img src="{{ asset('storage/'.$client->logo) }}" alt="{{ $client->name }}" title="{{ $client->name }}" class="h-10 sm:h-12 w-auto object-contain grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                @endforeach
            </div>
            <div class="absolute top-0 py-4 animate-marquee2 whitespace-nowrap flex items-center gap-12 sm:gap-20 px-10">
                @foreach($clients as $client)
                    <img src="{{ asset('storage/'.$client->logo) }}" alt="{{ $client->name }}" title="{{ $client->name }}" class="h-10 sm:h-12 w-auto object-contain grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                @endforeach
            </div>
        @else
            <div class="py-4 flex justify-center w-full">
                <span class="text-gray-400 text-sm italic">Belum ada logo mitra yang ditampilkan.</span>
            </div>
        @endif
    </div>
</section>

{{-- 2. About Preview Section --}}
<section class="py-24 lg:py-32 bg-[#fff3ec]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div data-aos="fade-right">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-6" style="font-family: 'Montserrat', sans-serif;">
                    {{ $home->about_title ?? 'Tentang Kami' }}
                </h2>
                <div class="w-20 h-1 bg-[#ff6a00] mb-8 rounded-full"></div>
                <p class="text-gray-600 leading-relaxed text-lg" style="font-family: 'Inter', sans-serif;">
                    {{ $home->about_description ?? '153 Kreatif adalah perusahaan manajemen acara dan produksi kreatif yang menyediakan solusi pemasaran terpadu melalui event, exhibition, dan produksi visual. Kami membantu brand menghubungkan audiens dengan pengalaman yang memorable dan terukur.' }}
                </p>
            </div>
            <div data-aos="fade-left" data-aos-delay="200" class="relative rounded-2xl overflow-hidden shadow-2xl aspect-[4/3] max-h-[450px] group border-4 border-white">
                <img
                    src="{{ ($home && $home->about_image) ? asset('storage/'.$home->about_image) : 'https://images.unsplash.com/photo-1505373877841-8d25f7d46678?w=800&q=80' }}"
                    alt="Event production"
                    class="w-full h-full object-cover transition duration-700 group-hover:scale-110"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>
        </div>
    </div>
</section>

{{-- 2.5 Key Statistics --}}
<section class="py-20 lg:py-28 bg-[#ff6a00] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-10 md:gap-12 text-center text-white">
            <div data-aos="fade-up" data-aos-delay="0">
                <h3 class="text-5xl md:text-6xl font-extrabold mb-2" style="font-family: 'Montserrat', sans-serif;">{{ $home->stat_1_number ?? '150+' }}</h3>
                <p class="text-white/90 font-medium text-lg" style="font-family: 'Inter', sans-serif;">{{ $home->stat_1_label ?? 'Event Sukses' }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-5xl md:text-6xl font-extrabold mb-2" style="font-family: 'Montserrat', sans-serif;">{{ $home->stat_2_number ?? '50+' }}</h3>
                <p class="text-white/90 font-medium text-lg" style="font-family: 'Inter', sans-serif;">{{ $home->stat_2_label ?? 'Brand Partner' }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-5xl md:text-6xl font-extrabold mb-2" style="font-family: 'Montserrat', sans-serif;">{{ $home->stat_3_number ?? '10+' }}</h3>
                <p class="text-white/90 font-medium text-lg" style="font-family: 'Inter', sans-serif;">{{ $home->stat_3_label ?? 'Tahun Pengalaman' }}</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="300">
                <h3 class="text-5xl md:text-6xl font-extrabold mb-2" style="font-family: 'Montserrat', sans-serif;">{{ $home->stat_4_number ?? '100%' }}</h3>
                <p class="text-white/90 font-medium text-lg" style="font-family: 'Inter', sans-serif;">{{ $home->stat_4_label ?? 'Klien Puas' }}</p>
            </div>
        </div>
    </div>
</section>

{{-- 3. Services Section --}}
@if($services->count() > 0)
<section class="py-24 lg:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 data-aos="fade-up" class="text-3xl sm:text-4xl font-extrabold text-gray-900 text-center mb-4" style="font-family: 'Montserrat', sans-serif;">Layanan Kami</h2>
        <div data-aos="zoom-in" class="w-16 h-1.5 bg-[#ff6a00] mx-auto mb-6 rounded-full"></div>
        <p data-aos="fade-up" data-aos-delay="100" class="text-gray-600 text-center max-w-2xl mx-auto mb-14 text-lg" style="font-family: 'Inter', sans-serif;">Solusi terpadu dari konsep hingga eksekusi</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($services as $index => $service)
            <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" class="service-card p-8 bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] transition-all duration-300 ease-in-out hover:-translate-y-2 hover:shadow-[0_12px_30px_-4px_rgba(255,106,0,0.15)] group relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#ff6a00] to-yellow-400 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                <div class="service-icon mb-6 w-14 h-14 bg-orange-50 rounded-xl flex items-center justify-center group-hover:bg-[#ff6a00] transition-colors duration-300">
                    <i class="bi {{ $service->icon ?? 'bi-briefcase' }} text-2xl text-[#ff6a00] group-hover:text-white transition-colors duration-300"></i>
                </div>
                <h4 class="text-xl font-bold mb-3 text-gray-900 group-hover:text-[#ff6a00] transition-colors duration-300" style="font-family: 'Montserrat', sans-serif;">{{ $service->title }}</h4>
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
            <div data-aos="fade-right">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900" style="font-family: 'Montserrat', sans-serif;">Featured Projects</h2>
                <div class="w-16 h-1.5 bg-[#ff6a00] mt-4 mb-4 rounded-full"></div>
                <p class="text-gray-600 text-lg font-medium" style="font-family: 'Inter', sans-serif;">Beberapa karya terbaru kami</p>
            </div>
            <div data-aos="fade-left">
                <a href="{{ route('portfolio') }}" class="text-gray-900 font-semibold hover:text-[#ff6a00] transition-colors inline-flex items-center gap-1 group bg-white px-5 py-2.5 rounded-full shadow-sm border border-gray-100 hover:shadow-md hover:border-orange-100" style="font-family: 'Montserrat', sans-serif;">
                    Lihat Semua
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        {{-- Grid: 3 kolom, center jika tidak kelipatan 3 --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 place-items-center">
            @foreach($projects as $index => $project)
            <div data-aos="fade-up" data-aos-delay="{{ $index * 150 }}" class="project-card w-full rounded-2xl overflow-hidden group shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] transition-all duration-300 ease-in-out hover:-translate-y-2 hover:shadow-[0_15px_30px_-5px_rgba(255,106,0,0.2)]">
                <div class="project-img-wrap relative aspect-[4/3] overflow-hidden">
                    @if($project->image)
                        <img
                            src="{{ asset('storage/'.$project->image) }}"
                            alt="{{ $project->title ?? 'Project' }}"
                            class="project-image img-loading w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
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
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                <div class="project-overlay absolute bottom-0 left-0 w-full p-6 translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <h3 class="text-white text-xl md:text-2xl font-bold drop-shadow-md" style="font-family: 'Montserrat', sans-serif;">{{ $project->title }}</h3>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- 4.8. Testimonials --}}
<section class="py-24 lg:py-32 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center mb-16">
        <h2 data-aos="fade-up" class="text-3xl sm:text-4xl font-extrabold text-gray-900 mb-4" style="font-family: 'Montserrat', sans-serif;">Kata Mereka</h2>
        <div data-aos="zoom-in" class="w-16 h-1.5 bg-[#ff6a00] mx-auto mb-6 rounded-full"></div>
    </div>
    
    <div class="max-w-6xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($testimonials as $index => $testi)
        <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}" class="bg-gray-50 p-8 rounded-2xl border border-gray-100 relative hover:shadow-xl transition-shadow duration-300 flex flex-col">
            <div class="text-[#ff6a00] mb-4">
                <svg class="w-10 h-10 opacity-30" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
            </div>
            <p class="text-gray-600 mb-6 italic leading-relaxed flex-1">"{{ $testi->quote }}"</p>
            <div class="flex items-center gap-4 mt-auto">
                @if($testi->client_photo)
                <div class="w-12 h-12 bg-gray-200 rounded-full overflow-hidden border-2 border-white shadow-sm flex-shrink-0">
                    <img src="{{ asset('storage/'.$testi->client_photo) }}" alt="{{ $testi->client_name }}" class="w-full h-full object-cover">
                </div>
                @else
                <div class="w-12 h-12 bg-orange-100 rounded-full border-2 border-white shadow-sm flex items-center justify-center text-orange-600 font-bold text-lg flex-shrink-0">
                    {{ substr($testi->client_name, 0, 1) }}
                </div>
                @endif
                <div>
                    <h5 class="font-bold text-gray-900" style="font-family: 'Montserrat', sans-serif;">{{ $testi->client_name }}</h5>
                    <p class="text-sm text-[#ff6a00] font-medium">{{ $testi->client_position ?? 'Client' }}</p>
                </div>
            </div>
        </div>
        @empty
            <div class="col-span-1 md:col-span-3 py-12 text-center">
                <p class="text-gray-400 italic">Belum ada testimonial.</p>
            </div>
        @endforelse
    </div>
</section>

{{-- 5. Contact CTA Section --}}
<section class="py-24 lg:py-32 bg-gradient-to-br from-white to-[#ffe6d6] relative overflow-hidden border-b border-orange-100">
    
    <div class="relative z-10 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 data-aos="fade-up" class="text-4xl sm:text-5xl lg:text-5xl font-extrabold text-gray-900 mb-6 leading-tight pb-2" style="font-family: 'Montserrat', sans-serif;">Let's Create Your Next Event</h2>
        <p data-aos="fade-up" data-aos-delay="100" class="text-gray-600 mb-10 text-lg sm:text-xl font-medium" style="font-family: 'Inter', sans-serif;">Siap berkolaborasi? Hubungi kami untuk diskusi project Anda.</p>
        <a data-aos="zoom-in" data-aos-delay="200" href="{{ route('contact') }}" class="inline-block px-10 py-4 bg-gradient-to-r from-[#ff6a00] to-[#ff8c3a] text-white font-bold rounded-full shadow-[0_4px_14px_0_rgba(255,106,0,0.39)] transition-all duration-300 hover:scale-[1.02] hover:shadow-[0_6px_20px_rgba(255,106,0,0.23)] hover:from-[#e65c00] hover:to-[#ff6a00] text-lg" style="font-family: 'Montserrat', sans-serif;">
            Hubungi Kami
        </a>
    </div>
</section>
@endsection
