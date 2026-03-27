<footer class="bg-[#0f0f0f] text-gray-400 pt-16 pb-24 md:py-20 mt-auto border-t border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 lg:gap-8 mb-16">
            
            {{-- Column 1: Brand & About --}}
            <div class="lg:col-span-1 space-y-6">
                <a href="{{ route('home') }}" class="inline-block">
                    <img src="{{ asset('assets/img/153.png') }}" alt="Logo 153 Kreatif" class="h-14 w-auto brightness-0 invert opacity-90 transition-opacity hover:opacity-100">
                </a>
                <p class="text-sm leading-relaxed text-gray-400" style="font-family: 'Inter', sans-serif;">
                    Mitra terpercaya Anda dalam mewujudkan event spektakuler, pameran inovatif, dan aktivasi brand yang tak terlupakan di seluruh Indonesia.
                </p>
                <div class="flex gap-4">
                    {{-- Social Icons --}}
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-800/80 flex items-center justify-center text-gray-400 hover:bg-[#ff6a00] hover:text-white transition-all duration-300 hover:-translate-y-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Column 2: Quick Links --}}
            <div class="lg:col-start-3">
                <h4 class="text-white font-bold mb-6 text-lg tracking-wide" style="font-family: 'Montserrat', sans-serif;">Perusahaan</h4>
                <ul class="space-y-4 text-sm font-medium" style="font-family: 'Inter', sans-serif;">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-[#ff6a00] hover:translate-x-1 inline-block transition-all duration-300">Home</a></li>
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-[#ff6a00] hover:translate-x-1 inline-block transition-all duration-300">Tentang Kami</a></li>
                    <li><a href="{{ route('services') }}" class="text-gray-400 hover:text-[#ff6a00] hover:translate-x-1 inline-block transition-all duration-300">Layanan</a></li>
                    <li><a href="{{ route('portfolio') }}" class="text-gray-400 hover:text-[#ff6a00] hover:translate-x-1 inline-block transition-all duration-300">Portofolio Pekerjaan</a></li>
                </ul>
            </div>

            {{-- Column 3: Contact --}}
            <div>
                <h4 class="text-white font-bold mb-6 text-lg tracking-wide" style="font-family: 'Montserrat', sans-serif;">Hubungi Kami</h4>
                <ul class="space-y-4 text-sm" style="font-family: 'Inter', sans-serif;">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-[#ff6a00] mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="text-gray-400 leading-relaxed">Cirebon, Indonesia</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#ff6a00]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <a href="{{ route('contact') }}" class="text-gray-400 hover:text-[#ff6a00] transition-colors">Tinggalkan Pesan</a>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#ff6a00]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span class="text-gray-400">+62 821-2501-1963</span>
                    </li>
                </ul>
            </div>

        </div>

        {{-- Bottom Footer --}}
        <div class="pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-sm text-gray-400 font-medium text-center md:text-left" style="font-family: 'Inter', sans-serif;">
                &copy; {{ date('Y') }} <span class="text-white">153 Kreatif</span>. All rights reserved.
            </p>
            <p class="text-sm text-gray-500 font-medium flex items-center gap-1.5" style="font-family: 'Inter', sans-serif;">
                Designed by 153 Team
            </p>
        </div>
    </div>
</footer>
