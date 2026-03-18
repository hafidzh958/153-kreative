@extends('layouts.app')

@section('title', 'Tentang Kami - 153 Kreatif')

@section('content')

{{-- 1. Title Section --}}
<section class="pt-32 pb-24 md:pt-40 md:pb-32 bg-gradient-to-b from-[#fff3ec] to-white overflow-hidden">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h1 class="animate-fade-in-up text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 tracking-tight mb-6" style="font-family: 'Montserrat', sans-serif;">
            {!! $about->hero_title ?? 'Tentang 153 Kreatif' !!}
        </h1>
        <p class="animate-fade-in-up delay-1 text-xl sm:text-2xl text-gray-600 font-medium max-w-2xl mx-auto leading-relaxed" style="font-family: 'Inter', sans-serif;">
            {{ $about->hero_subtitle ?? 'Integrated Event Solutions & Creative Production' }}
        </p>
    </div>
</section>

{{-- 2. Company Story Section --}}
<section class="py-24 lg:py-32 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-fade">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            {{-- Image Panel --}}
            <div class="order-1 lg:order-1 w-full relative group">
                <div class="absolute inset-0 bg-gradient-to-br from-[#fff3ec] to-transparent rounded-2xl transform -translate-x-3 translate-y-3 -z-10 group-hover:translate-x-0 group-hover:translate-y-0 transition-transform duration-500"></div>
                <img
                    src="{{ $about->story_image ? asset('storage/'.$about->story_image) : 'https://images.unsplash.com/photo-1475721027785-f74eccf877e2?w=800&q=80' }}"
                    alt="{{ $about->story_title ?? 'Tim 153 Kreatif bekerja' }}"
                    class="w-full h-auto rounded-2xl object-contain shadow-lg border border-gray-100 transition-transform duration-500 group-hover:scale-[1.01]"
                    style="max-height: 550px;"
                />
            </div>
            
            {{-- Text Content --}}
            <div class="order-2 lg:order-2">
                <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6 leading-tight" style="font-family: 'Montserrat', sans-serif;">{{ $about->story_title ?? 'Cerita Kami' }}</h2>
                <div class="w-20 h-1.5 bg-[#ff6a00] mb-8 rounded-full"></div>
                <div class="space-y-6 text-gray-600 leading-relaxed text-lg" style="font-family: 'Inter', sans-serif;">
                    @if(isset($about->story_description) && !empty($about->story_description))
                        {!! nl2br(e($about->story_description)) !!}
                    @else
                        <p>
                            <strong class="text-gray-900 font-semibold">153 Kreatif</strong> adalah perusahaan jasa manajemen acara dan produksi kreatif yang berdedikasi untuk memberikan solusi pemasaran terpadu.
                        </p>
                        <p>
                            Kami mengombinasikan keahlian eksekusi lapangan dengan kemampuan produksi manufaktur dan desain teknis untuk menciptakan pengalaman yang berdampak bagi klien dan audiens.
                        </p>
                        <p>
                            Sebagai mitra strategis, kami membantu perusahaan menghadirkan aktivasi merek yang kuat, mulai dari pameran otomotif di pusat perbelanjaan hingga penyelenggaraan acara komunitas berskala besar.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 3. Vision & Mission Section --}}
<section class="py-24 lg:py-32 bg-gray-50 border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 scroll-fade">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4" style="font-family: 'Montserrat', sans-serif;">Visi & Misi</h2>
            <div class="w-16 h-1 bg-[#ff6a00] mx-auto rounded-full"></div>
        </div>

        <div class="grid lg:grid-cols-2 gap-10 scroll-fade">
            
            {{-- Vision Card (Konsisten Kiri) --}}
            <div class="bg-white p-10 sm:p-14 rounded-3xl shadow-lg border-t-4 border-[#ff6a00] relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div class="absolute top-0 right-0 p-8 opacity-5 transform group-hover:scale-110 group-hover:opacity-10 transition-all duration-700">
                    <svg class="w-32 h-32 text-[#ff6a00]" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>
                </div>
                <h3 class="text-3xl font-bold text-gray-900 mb-6 relative z-10" style="font-family: 'Montserrat', sans-serif;">Visi</h3>
                <p class="text-gray-600 text-lg leading-relaxed relative z-10" style="font-family: 'Inter', sans-serif;">
                    {{ $about->vision_text ?? 'Menjadi mitra strategis terdepan di industri manajemen acara dan produksi kreatif yang mengintegrasikan inovasi desain visual dengan kesempurnaan eksekusi lapangan.' }}
                </p>
            </div>

            {{-- Mission Card (Konsisten Kanan) --}}
            <div class="bg-white p-10 sm:p-14 rounded-3xl shadow-lg border-t-4 border-[#ff6a00] relative overflow-hidden hover:-translate-y-1 transition-transform duration-300">
                <h3 class="text-3xl font-bold text-gray-900 mb-8" style="font-family: 'Montserrat', sans-serif;">Misi</h3>
                <ul class="space-y-6 text-gray-600 text-lg" style="font-family: 'Inter', sans-serif;">
                    @forelse($missions as $mission)
                        <li class="flex items-start gap-4">
                            <div class="w-7 h-7 mt-0.5 flex-shrink-0 bg-[#fff3ec] rounded-full flex items-center justify-center text-[#ff6a00]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="leading-relaxed">{{ $mission->description }}</span>
                        </li>
                    @empty
                        <li class="flex items-start gap-4">
                            <div class="w-7 h-7 mt-0.5 flex-shrink-0 bg-[#fff3ec] rounded-full flex items-center justify-center text-[#ff6a00]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="leading-relaxed">Memberikan solusi pemasaran terpadu melalui pameran otomotif dan aktivasi brand di lokasi strategis.</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-7 h-7 mt-0.5 flex-shrink-0 bg-[#fff3ec] rounded-full flex items-center justify-center text-[#ff6a00]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="leading-relaxed">Menjamin kualitas produksi material seperti backdrop, neon box, dan konstruksi booth dengan standar tinggi.</span>
                        </li>
                    @endforelse
                </ul>
            </div>
            
        </div>
    </div>
</section>

{{-- 4. Our Process Section --}}
<section class="py-24 lg:py-32 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-fade">
        <div class="text-center mb-24">
            <h2 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6" style="font-family: 'Montserrat', sans-serif;">Proses Kerja Kami</h2>
            <div class="w-24 h-1.5 bg-[#ff6a00] mx-auto rounded-full"></div>
        </div>

        <div class="relative">
            @php
                $activeProcesses = $processes->count() > 0 ? $processes : collect([
                    (object)['title' => 'Consultation', 'description' => 'Berdiskusi bersama mendalami brief dan KPI dari kampanye Anda.'],
                    (object)['title' => 'Concept & Planning', 'description' => 'Menyusun moodboard visual, merancang agenda, dan pembagian tugas.'],
                    (object)['title' => 'Production', 'description' => 'Mengeksekusi desain, perizinan, panggung, serta instrumen marketing.'],
                    (object)['title' => 'Execution', 'description' => 'Hari-H. Kami memastikan seluruh skenario acara berjalan tepat waktu.'],
                ]);
            @endphp
            <div class="flex flex-col lg:flex-row justify-center lg:items-stretch gap-16 lg:gap-0 max-w-6xl mx-auto">
                @foreach($activeProcesses as $process)
                <div class="flex-1 flex flex-col items-center text-center relative max-w-[280px] mx-auto group">
                    
                    {{-- Circle and Connecting Line --}}
                    <div class="w-full relative flex items-center justify-center mb-8">
                        {{-- Horizontal line (hide on mobile and on the last element) --}}
                        @if(!$loop->last)
                        <div class="hidden lg:block absolute top-1/2 left-[50%] w-full h-1.5 bg-gray-100 -translate-y-1/2 -z-10">
                            <div class="w-full h-full bg-gradient-to-r from-[#fff3ec] via-[#ff6a00]/40 to-[#fff3ec]"></div>
                        </div>
                        @endif
                        
                        <div class="w-24 h-24 bg-white border-[6px] border-[#ff6a00] rounded-full flex items-center justify-center shadow-lg z-10 transition-transform group-hover:scale-110 duration-500">
                            <span class="text-3xl font-bold text-[#ff6a00]">{{ $loop->iteration }}</span>
                        </div>
                    </div>
                    
                    <h4 class="text-2xl font-bold text-gray-900 mb-4" style="font-family: 'Montserrat', sans-serif;">{{ $process->title }}</h4>
                    <p class="text-gray-600 px-4 text-lg leading-relaxed" style="font-family: 'Inter', sans-serif;">{{ $process->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- 5. Call To Action Section --}}
<section class="py-24 lg:py-32 bg-gradient-to-r from-[#ff6a00] to-[#ff8c3a] shadow-inner relative overflow-hidden">
    {{-- Decorative background element --}}
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white to-transparent"></div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center scroll-fade">
        <h2 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white mb-12 leading-tight drop-shadow-sm" style="font-family: 'Montserrat', sans-serif;">
            Let's Create Your Next Event With 153 Kreatif
        </h2>
        <a href="{{ route('contact') }}" class="inline-block px-10 py-4 bg-white text-[#ff6a00] font-bold rounded-full hover:bg-gray-50 transition-all duration-300 shadow-2xl hover:shadow-white/20 hover:-translate-y-2 transform text-xl" style="font-family: 'Montserrat', sans-serif;">
            Contact Us
        </a>
    </div>
</section>

@endsection
