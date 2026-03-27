<nav class="absolute w-full top-0 z-50 bg-white transition-all duration-300" id="main-navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 sm:h-20">
            <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-3">
                <img src="{{ asset('assets/img/153.png') }}" 
                     alt="Logo 153 Kreatif" 
                     class="h-20 sm:h-24 w-auto object-contain">
            </a>

            {{-- Desktop nav --}}
            <ul class="hidden md:flex gap-8 items-center">
                <li><a href="{{ route('home') }}" class="relative text-sm font-semibold {{ request()->routeIs('home') ? 'text-[#ff6a00]' : 'text-gray-600 hover:text-[#ff6a00]' }} transition-colors" style="font-family: 'Inter', sans-serif;">Home</a></li>
                <li><a href="{{ route('about') }}" class="relative text-sm font-semibold {{ request()->routeIs('about') ? 'text-[#ff6a00]' : 'text-gray-600 hover:text-[#ff6a00]' }} transition-colors" style="font-family: 'Inter', sans-serif;">About</a></li>
                <li><a href="{{ route('services') }}" class="relative text-sm font-semibold {{ request()->routeIs('services') ? 'text-[#ff6a00]' : 'text-gray-600 hover:text-[#ff6a00]' }} transition-colors" style="font-family: 'Inter', sans-serif;">Services</a></li>
                <li><a href="{{ route('portfolio') }}" class="relative text-sm font-semibold {{ request()->routeIs('portfolio') ? 'text-[#ff6a00]' : 'text-gray-600 hover:text-[#ff6a00]' }} transition-colors" style="font-family: 'Inter', sans-serif;">Portofolio</a></li>
                <li><a href="{{ route('contact') }}" class="relative text-sm font-semibold {{ request()->routeIs('contact') ? 'text-[#ff6a00]' : 'text-gray-600 hover:text-[#ff6a00]' }} transition-colors" style="font-family: 'Inter', sans-serif;">Contact</a></li>
            </ul>

            {{-- Mobile menu button --}}
            <div class="flex items-center md:hidden">
                <button type="button" id="nav-toggle" class="p-2 -mr-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-[#ff6a00] transition-colors" aria-label="Toggle menu">
                    <svg id="nav-icon-menu" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="nav-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile dropdown --}}
        <div id="nav-menu" class="md:hidden hidden overflow-hidden transition-all duration-300 origin-top">
            <ul class="pt-2 pb-6 space-y-1">
                <li><a href="{{ route('home') }}" class="block py-2.5 px-4 text-base font-semibold {{ request()->routeIs('home') ? 'text-[#ff6a00] bg-orange-50' : 'text-gray-600 hover:text-[#ff6a00] hover:bg-orange-50/50' }} rounded-lg" style="font-family: 'Inter', sans-serif;">Home</a></li>
                <li><a href="{{ route('about') }}" class="block py-2.5 px-4 text-base font-semibold {{ request()->routeIs('about') ? 'text-[#ff6a00] bg-orange-50' : 'text-gray-600 hover:text-[#ff6a00] hover:bg-orange-50/50' }} rounded-lg" style="font-family: 'Inter', sans-serif;">About</a></li>
                <li><a href="{{ route('services') }}" class="block py-2.5 px-4 text-base font-semibold {{ request()->routeIs('services') ? 'text-[#ff6a00] bg-orange-50' : 'text-gray-600 hover:text-[#ff6a00] hover:bg-orange-50/50' }} rounded-lg" style="font-family: 'Inter', sans-serif;">Services</a></li>
                <li><a href="{{ route('portfolio') }}" class="block py-2.5 px-4 text-base font-semibold {{ request()->routeIs('portfolio') ? 'text-[#ff6a00] bg-orange-50' : 'text-gray-600 hover:text-[#ff6a00] hover:bg-orange-50/50' }} rounded-lg" style="font-family: 'Inter', sans-serif;">Portofolio</a></li>
                <li><a href="{{ route('contact') }}" class="block py-2.5 px-4 text-base font-semibold {{ request()->routeIs('contact') ? 'text-[#ff6a00] bg-orange-50' : 'text-gray-600 hover:text-[#ff6a00] hover:bg-orange-50/50' }} rounded-lg" style="font-family: 'Inter', sans-serif;">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var toggle = document.getElementById('nav-toggle');
    var menu = document.getElementById('nav-menu');
    var iconMenu = document.getElementById('nav-icon-menu');
    var iconClose = document.getElementById('nav-icon-close');
    if (!toggle || !menu) return;
    
    toggle.addEventListener('click', function() {
        var isHidden = menu.classList.contains('hidden');
        if (isHidden) {
            menu.classList.remove('hidden');
            iconMenu.classList.add('hidden');
            iconClose.classList.remove('hidden');
        } else {
            menu.classList.add('hidden');
            iconMenu.classList.remove('hidden');
            iconClose.classList.add('hidden');
        }
    });
});
</script>
