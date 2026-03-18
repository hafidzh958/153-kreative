@extends('layouts.app')

@section('title', 'Portofolio - 153 Kreatif')

@push('styles')
<style>
    /* Filter Button Active State */
    .filter-btn.active {
        background-color: #ff6a00;
        color: white;
        border-color: #ff6a00;
        box-shadow: 0 4px 14px 0 rgba(255, 106, 0, 0.39);
    }

    /* ── Portfolio Wrapper (Flexbox 3-column) ── */
    .portfolio-wrapper {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 24px;
    }

    .portfolio-item {
        width: calc(33.333% - 16px);
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        background: #f3f4f6;
        box-shadow: 0 4px 20px rgba(0,0,0,0.07);
        cursor: zoom-in;
        transition: transform 0.3s ease, box-shadow 0.3s ease, opacity 0.4s ease;
    }

    .portfolio-item:hover {
        transform: scale(1.03);
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }

    .portfolio-item.hide {
        display: none;
    }

    .portfolio-item img {
        width: 100%;
        aspect-ratio: 4/3;
        object-fit: cover;
        display: block;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .portfolio-item:hover img {
        transform: scale(1.05);
    }

    /* ── Overlay ── */
    .portfolio-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(255, 106, 0, 0.95) 0%, rgba(255, 136, 58, 0.7) 50%, transparent 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 2rem;
    }

    .portfolio-item:hover .portfolio-overlay {
        opacity: 1;
    }

    .portfolio-text-content {
        transform: translateY(20px);
        transition: transform 0.4s ease;
    }

    .portfolio-item:hover .portfolio-text-content {
        transform: translateY(0);
    }

    /* ── Responsive ── */
    @media (max-width: 900px) {
        .portfolio-item {
            width: calc(50% - 12px);
        }
    }

    @media (max-width: 520px) {
        .portfolio-item {
            width: 100%;
        }
        .portfolio-wrapper {
            gap: 16px;
        }
    }

    /* ── Lightbox ── */
    #lightbox {
        backdrop-filter: blur(8px);
    }
    #lightbox.active {
        opacity: 1;
        pointer-events: auto;
    }
    #lightbox img {
        transform: scale(0.95);
        transition: transform 0.3s ease;
    }
    #lightbox.active img {
        transform: scale(1);
    }
</style>
@endpush

@section('content')

{{-- 1. Header Section --}}
<section class="pt-32 pb-24 md:pt-40 md:pb-32 bg-gradient-to-br from-[#fff3ec] to-[#ffe6d6] overflow-hidden relative shadow-inner">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-[#ff6a00] to-transparent"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
        <h1 class="animate-fade-in-up text-5xl md:text-6xl lg:text-7xl font-extrabold text-gray-900 tracking-tight mb-6 drop-shadow-sm" style="font-family: 'Montserrat', sans-serif;">
            {{ $settings->hero_title ?? 'Portofolio Kami' }}
        </h1>
        <p class="animate-fade-in-up delay-1 text-xl sm:text-2xl text-gray-700 font-medium max-w-2xl mx-auto leading-relaxed" style="font-family: 'Inter', sans-serif;">
            {!! nl2br(e($settings->hero_subtitle ?? 'Beberapa dokumentasi proyek event, pameran, dan aktivasi brand yang telah kami tangani dengan sepenuh hati.')) !!}
        </p>
    </div>
</section>

{{-- 2. Portfolio Grid & Filters --}}
<section class="pt-16 pb-24 lg:pt-24 lg:pb-32 bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Filter Buttons --}}
        <div class="flex flex-wrap justify-center gap-3 sm:gap-4 mb-16 scroll-fade" id="portfolio-filters">
            <button class="filter-btn active px-6 py-2.5 rounded-full border-2 border-gray-100 bg-gray-50 text-gray-600 font-semibold hover:border-[#ff6a00] hover:text-[#ff6a00] transition-all duration-300 focus:outline-none" data-filter="all" style="font-family: 'Montserrat', sans-serif;">
                All
            </button>
            @foreach($categories as $category)
                <button class="filter-btn px-6 py-2.5 rounded-full border-2 border-gray-100 bg-gray-50 text-gray-600 font-semibold hover:border-[#ff6a00] hover:text-[#ff6a00] transition-all duration-300 focus:outline-none" data-filter="{{ $category->slug }}" style="font-family: 'Montserrat', sans-serif;">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        {{-- Portfolio Flexbox Grid --}}
        @if($portfolios->isEmpty())
            <div class="text-center py-20 scroll-fade">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada portfolio</h3>
                <p class="text-gray-500">Karya-karya terbaik kami akan segera hadir di sini.</p>
            </div>
        @else
            <div class="portfolio-wrapper" id="portfolio-grid">
                @foreach($portfolios as $index => $portfolio)
                    <div class="portfolio-item scroll-fade"
                         data-category="{{ $portfolio->category->slug ?? 'uncategorized' }}"
                         data-show-in-all="{{ $portfolio->is_show_in_all ? '1' : '0' }}"
                         style="animation-delay: {{ $index * 0.05 }}s;"
                         onclick="openLightbox('{{ asset('storage/'.$portfolio->image) }}', '{{ addslashes($portfolio->title) }}', '{{ addslashes($portfolio->category->name ?? '') }}')">  

                        @if($portfolio->image)
                            <img src="{{ asset('storage/'.$portfolio->image) }}" alt="{{ $portfolio->title }}" loading="lazy">
                        @else
                            <div style="aspect-ratio:4/3;" class="flex items-center justify-center bg-gray-100 text-gray-400">No Image</div>
                        @endif

                        <div class="portfolio-overlay">
                            <div class="portfolio-text-content">
                                @if($portfolio->category)
                                    <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm shadow-sm text-white text-[11px] font-bold tracking-wider rounded-full mb-3 uppercase" style="font-family: 'Inter', sans-serif;">
                                        {{ $portfolio->category->name }}
                                    </span>
                                @endif
                                <h3 class="text-xl md:text-2xl font-bold text-white drop-shadow-lg leading-tight" style="font-family: 'Montserrat', sans-serif;">
                                    {{ $portfolio->title }}
                                </h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- 3. Call To Action Section --}}
<section class="py-24 lg:py-32 bg-gradient-to-r from-[#ff6a00] to-[#ff8c3a] shadow-inner relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white to-transparent"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 text-center scroll-fade">
        <h2 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white mb-12 leading-tight drop-shadow-sm" style="font-family: 'Montserrat', sans-serif;">
            Let's Create Your Next Event With 153 Kreatif
        </h2>
        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 px-10 py-4 bg-white text-[#ff6a00] font-bold rounded-full hover:bg-gray-50 transition-all duration-300 shadow-2xl hover:shadow-white/20 hover:-translate-y-2 transform text-xl" style="font-family: 'Montserrat', sans-serif;">
            Hubungi Kami
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</section>

{{-- Lightbox Modal --}}
<div id="lightbox" class="fixed inset-0 z-50 bg-black/90 opacity-0 pointer-events-none transition-opacity duration-300 flex items-center justify-center p-4 sm:p-8" onclick="closeLightbox(event)">
    <div class="absolute top-4 right-4 sm:top-6 sm:right-6">
        <button type="button" class="text-white/70 hover:text-white bg-black/50 hover:bg-black/80 p-2 sm:p-3 rounded-full transition-colors focus:outline-none" onclick="closeLightbox(event, true)">
            <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    <div class="max-w-6xl w-full flex flex-col items-center justify-center">
        <img id="lightbox-img" src="" alt="Preview" class="max-h-[80vh] w-auto max-w-full rounded-lg shadow-2xl object-contain">
        <div class="mt-6 text-center">
            <span id="lightbox-cat" class="text-[#ff6a00] text-xs font-bold uppercase tracking-widest mb-2 block"></span>
            <h3 id="lightbox-title" class="text-white text-2xl sm:text-3xl font-bold" style="font-family: 'Montserrat', sans-serif;"></h3>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const portfolioItems = document.querySelectorAll('.portfolio-item');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active class from all buttons
                filterBtns.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                btn.classList.add('active');

                const filterValue = btn.getAttribute('data-filter');

                portfolioItems.forEach(item => {
                    // Start fade out animation
                    item.style.opacity = '0';
                    item.style.transform = 'scale(0.95)';
                    
                    setTimeout(() => {
                        let visible = false;
                        if (filterValue === 'all') {
                            // "All" tab: only show curated items
                            visible = item.getAttribute('data-show-in-all') === '1';
                        } else {
                            // Category tab: show all items of that category
                            visible = item.getAttribute('data-category') === filterValue;
                        }

                        if (visible) {
                            item.classList.remove('hide');
                            setTimeout(() => {
                                item.style.opacity = '1';
                                item.style.transform = 'scale(1)';
                            }, 50);
                        } else {
                            item.classList.add('hide');
                        }
                    }, 400); // 400ms matches transition duration
                });
            });
        });

        // Initialize display: "All" tab is default, so hide items not shown in All
        portfolioItems.forEach(item => {
            if (item.getAttribute('data-show-in-all') !== '1') {
                item.classList.add('hide');
                item.style.opacity = '0';
            } else {
                item.style.opacity = '1';
                item.style.transform = 'scale(1)';
            }
        });
    });

    // Lightbox Logic
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxTitle = document.getElementById('lightbox-title');
    const lightboxCat = document.getElementById('lightbox-cat');

    function openLightbox(imgSrc, title, cat) {
        lightboxImg.src = imgSrc;
        lightboxTitle.innerText = title;
        lightboxCat.innerText = cat;
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closeLightbox(e, force = false) {
        // If clicked exactly on the background overlay or close button
        if (force || e.target === lightbox) {
            lightbox.classList.remove('active');
            setTimeout(() => {
                lightboxImg.src = '';
            }, 300); // Wait for fade out
            document.body.style.overflow = ''; // Restore scrolling
        }
    }

    // Escape key to close
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && lightbox.classList.contains('active')) {
            closeLightbox(e, true);
        }
    });
</script>
@endpush
