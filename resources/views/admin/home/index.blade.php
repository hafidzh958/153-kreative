@extends('admin.layouts.app')

@section('title', 'Manage Home')
@section('page-title', 'Home')

@section('content')
{{-- Success Message --}}

<form action="{{ route('admin.home.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
    @csrf
    @method('PUT')

    {{-- ─── HERO SECTION ─────────────────────────────────────── --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Hero Section</h2>
                <p class="text-xs text-gray-500">Bagian utama yang tampil pertama kali di halaman Home</p>
            </div>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Hero Title --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Hero Title <span class="text-red-500">*</span></label>
                <input
                    type="text" name="hero_title"
                    value="{{ old('hero_title', $home->hero_title ?? '') }}"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors @error('hero_title') border-red-400 @enderror"
                    required placeholder="e.g. 153 Kreatif"
                >
                @error('hero_title')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Hero Subtitle --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Hero Subtitle <span class="text-red-500">*</span></label>
                <input
                    type="text" name="hero_subtitle"
                    value="{{ old('hero_subtitle', $home->hero_subtitle ?? '') }}"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors @error('hero_subtitle') border-red-400 @enderror"
                    required placeholder="e.g. Integrated Event Solutions & Creative Production"
                >
                @error('hero_subtitle')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Hero Description --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Hero Description</label>
                <textarea
                    name="hero_description" rows="3"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors resize-none @error('hero_description') border-red-400 @enderror"
                    placeholder="Deskripsi singkat di hero section..."
                >{{ old('hero_description', $home->hero_description ?? '') }}</textarea>
                @error('hero_description')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Hero Button Text + Link --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Button Text <span class="text-red-500">*</span></label>
                <input
                    type="text" name="hero_button_text"
                    value="{{ old('hero_button_text', $home->hero_button_text ?? '') }}"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors @error('hero_button_text') border-red-400 @enderror"
                    required placeholder="e.g. View Portfolio"
                >
                @error('hero_button_text')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Button Link <span class="text-red-500">*</span></label>
                <input
                    type="text" name="hero_button_link"
                    value="{{ old('hero_button_link', $home->hero_button_link ?? '') }}"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors @error('hero_button_link') border-red-400 @enderror"
                    required placeholder="e.g. /portfolio"
                >
                @error('hero_button_link')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Hero Background Image --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Hero Background Image</label>
                <div class="flex flex-col sm:flex-row items-start gap-5">
                    {{-- Preview --}}
                    <div id="hero-preview-wrap" class="w-full sm:w-48 h-28 rounded-lg overflow-hidden border border-gray-200 bg-gray-50 flex items-center justify-center flex-shrink-0">
                        @if($home && $home->hero_background_image)
                            <img id="hero-preview" src="{{ asset('storage/'.$home->hero_background_image) }}" alt="Hero BG" class="w-full h-full object-cover">
                        @else
                            <div id="hero-preview-placeholder" class="flex flex-col items-center gap-1 text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-xs">No image</span>
                            </div>
                            <img id="hero-preview" src="" alt="Hero BG" class="w-full h-full object-cover hidden">
                        @endif
                    </div>
                    <div class="flex-1">
                        <label class="flex flex-col items-center justify-center w-full h-28 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-[#f97316] hover:bg-orange-50 transition-colors">
                            <svg class="w-6 h-6 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            <span class="text-sm text-gray-500">Klik untuk upload gambar</span>
                            <span class="text-xs text-gray-400 mt-0.5">PNG, JPG, WEBP maks. 4MB</span>
                            <input type="file" name="hero_background_image" accept="image/*" class="hidden" onchange="previewImage(this, 'hero-preview')">
                        </label>
                        @if($home && $home->hero_background_image)
                            <p class="mt-2 text-xs text-gray-500">File saat ini: <span class="font-medium">{{ basename($home->hero_background_image) }}</span></p>
                        @endif
                    </div>
                </div>
                @error('hero_background_image')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    {{-- ─── ABOUT SECTION ────────────────────────────────────── --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">About Preview Section</h2>
                <p class="text-xs text-gray-500">Bagian "Tentang Kami" yang tampil di bawah hero</p>
            </div>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- About Title --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">About Title <span class="text-red-500">*</span></label>
                <input
                    type="text" name="about_title"
                    value="{{ old('about_title', $home->about_title ?? '') }}"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors @error('about_title') border-red-400 @enderror"
                    required placeholder="e.g. Tentang Kami"
                >
                @error('about_title')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- About Description --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">About Description</label>
                <textarea
                    name="about_description" rows="4"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors resize-none @error('about_description') border-red-400 @enderror"
                    placeholder="Deskripsi tentang perusahaan Anda..."
                >{{ old('about_description', $home->about_description ?? '') }}</textarea>
                @error('about_description')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- About Image --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">About Image</label>
                <div class="flex flex-col sm:flex-row items-start gap-5">
                    <div class="w-full sm:w-48 h-36 rounded-lg overflow-hidden border border-gray-200 bg-gray-50 flex items-center justify-center flex-shrink-0">
                        @if($home && $home->about_image)
                            <img id="about-preview" src="{{ asset('storage/'.$home->about_image) }}" alt="About" class="w-full h-full object-cover">
                        @else
                            <div class="flex flex-col items-center gap-1 text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-xs">No image</span>
                            </div>
                            <img id="about-preview" src="" alt="About" class="w-full h-full object-cover hidden">
                        @endif
                    </div>
                    <div class="flex-1">
                        <label class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-[#f97316] hover:bg-orange-50 transition-colors">
                            <svg class="w-6 h-6 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            <span class="text-sm text-gray-500">Klik untuk upload gambar</span>
                            <span class="text-xs text-gray-400 mt-0.5">PNG, JPG, WEBP maks. 4MB</span>
                            <input type="file" name="about_image" accept="image/*" class="hidden" onchange="previewImage(this, 'about-preview')">
                        </label>
                        @if($home && $home->about_image)
                            <p class="mt-2 text-xs text-gray-500">File saat ini: <span class="font-medium">{{ basename($home->about_image) }}</span></p>
                        @endif
                    </div>
                </div>
                @error('about_image')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    {{-- ─── SERVICES SECTION (SORTABLE & MODAL) ───────────────────── --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-900">Layanan Kami (Services)</h2>
                    <p class="text-xs text-gray-500">Maksimal 6 layanan. Drag & Drop untuk mengurutkan.</p>
                </div>
            </div>
            @if($services->count() < 6)
                <button type="button" onclick="openServiceModal()" class="text-sm bg-blue-50 text-blue-600 px-3 py-1.5 rounded hover:bg-blue-100 font-medium transition-colors">+ Tambah Layanan</button>
            @endif
        </div>
        <div class="p-6">
            <div id="services-sortable" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($services as $service)
                <div class="service-card-wrapper bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow relative group cursor-move" data-id="{{ $service->id }}">
                    {{-- Tombol Aksi (Muncul saat hover) --}}
                    <div class="absolute top-2 right-2 flex items-center gap-1 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity z-10">
                        <button type="button" onclick="openServiceModal({{ $service->id }}, '{{ addslashes($service->title) }}', '{{ addslashes($service->description) }}')" class="p-1.5 bg-white border border-gray-200 rounded shadow-sm text-gray-600 hover:text-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <button type="button" onclick="deleteService({{ $service->id }})" class="p-1.5 bg-white border border-gray-200 rounded shadow-sm text-gray-600 hover:text-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                    
                    {{-- Preview Card (Mirip Frontend) --}}
                    <div class="p-5 pointer-events-none">
                        <div class="w-10 h-10 rounded-lg bg-gray-900 flex items-center justify-center mb-4">
                            @if($service->icon)
                                <span class="text-xl text-white flex items-center justify-center child-svg-white"><i class="bi {{ $service->icon }}"></i></span>
                            @else
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            @endif
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2 truncate" style="font-family: 'Montserrat', sans-serif;">{{ $service->title }}</h3>
                        <p class="text-xs text-gray-600 leading-relaxed line-clamp-2" style="font-family: 'Inter', sans-serif;">{{ $service->description }}</p>
                    </div>
                </div>
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-8 text-sm text-gray-500">Belum ada layanan. Klik "Tambah Layanan" untuk mulai.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ─── PORTFOLIO SECTION (SORTABLE & MODAL) ───────────────── --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-8" id="projects-section">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-900">Featured Projects</h2>
                    <p class="text-xs text-gray-500">Maksimal 6 project. Drag & Drop untuk mengurutkan.</p>
                </div>
            </div>
            @if($projects->count() < 6)
                <button type="button" onclick="openProjectModal()" class="text-sm bg-purple-50 text-purple-600 px-3 py-1.5 rounded hover:bg-purple-100 font-medium transition-colors">+ Tambah Project</button>
            @endif
        </div>
        <div class="p-6">
            <div id="projects-sortable" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($projects as $project)
                <div class="project-card-wrapper relative aspect-[4/3] rounded-lg border border-gray-200 overflow-hidden group cursor-move shadow-sm" data-id="{{ $project->id }}">
                    {{-- Aksi --}}
                    <div class="absolute top-2 right-2 flex items-center gap-1 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity z-10">
                        <button type="button" onclick="openProjectModal({{ $project->id }}, '{{ addslashes($project->title) }}', '{{ $project->image ? asset('storage/'.$project->image) : '' }}')" class="p-1.5 bg-white border border-gray-200 rounded shadow-sm text-gray-600 hover:text-purple-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </button>
                        <button type="button" onclick="deleteProject({{ $project->id }})" class="p-1.5 bg-white border border-gray-200 rounded shadow-sm text-gray-600 hover:text-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>

                    {{-- Preview Gambar --}}
                    @if($project->image)
                        <img src="{{ asset('storage/'.$project->image) }}" class="w-full h-full object-cover pointer-events-none">
                    @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center pointer-events-none"><svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                    @endif
                    <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-3 pt-8 pointer-events-none">
                        <p class="text-xs font-semibold text-white truncate">{{ $project->title }}</p>
                    </div>
                </div>
                @empty
                    <div class="col-span-2 md:col-span-3 lg:col-span-4 text-center py-8 text-sm text-gray-500">Belum ada project. Klik "Tambah Project" untuk mulai.</div>
                @endforelse
            </div>
        </div>
    </div>

 {{-- ─── ACTION BUTTONS ────────────────────────────────── --}}
<div class="flex items-center gap-4">
    <button
        type="submit"
        class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#f97316] text-white text-sm font-semibold rounded-lg hover:bg-orange-600 transition-colors shadow-sm hover:shadow-md"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Save Changes
    </button>

    <a href="{{ route('home') }}" target="_blank"
       class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
        </svg>
        Preview Halaman
    </a>
</div>
</form>

{{-- MODALS --}}
{{-- Service Modal Form --}}
<div id="serviceModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 opacity-0 pointer-events-none transition-opacity">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform" id="serviceModalInner">
        <form id="serviceForm" method="POST" action="">
            @csrf
            <div id="serviceMethod"></div> {{-- Tempat PUT method jika edit --}}
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900" id="serviceModalTitle">Tambah Layanan</h3>
                <button type="button" onclick="closeServiceModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="s_title" required class="w-full rounded border-gray-200 text-sm p-2.5 focus:ring-[#f97316] focus:border-[#f97316]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Description <span class="text-red-500">*</span></label>
                    <textarea name="description" id="s_desc" rows="3" required class="w-full rounded border-gray-200 text-sm p-2.5 focus:ring-[#f97316] focus:border-[#f97316]"></textarea>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-xl border-t border-gray-100">
                <button type="button" onclick="closeServiceModal()" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded hover:bg-blue-700">Simpan Layanan</button>
            </div>
        </form>
    </div>
</div>

{{-- Project Modal Form --}}
<div id="projectModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 opacity-0 pointer-events-none transition-opacity">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform" id="projectModalInner">
        <form id="projectForm" method="POST" action="" enctype="multipart/form-data">
            @csrf
            <div id="projectMethod"></div>
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900" id="projectModalTitle">Tambah Project</h3>
                <button type="button" onclick="closeProjectModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Project Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="p_title" required class="w-full rounded border-gray-200 text-sm p-2.5 focus:ring-[#f97316] focus:border-[#f97316]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Project Image <span class="text-red-500" id="p_img_req">*</span></label>
                    
                    <div class="w-full h-40 bg-gray-100 border border-gray-200 rounded-lg overflow-hidden mb-3 flex items-center justify-center">
                        <img id="p_preview" src="" class="w-full h-full object-cover hidden">
                        <span id="p_placeholder" class="text-gray-400 text-sm">Preview Gambar</span>
                    </div>

                    <input type="file" name="image_file" id="p_file" accept="image/*" class="w-full text-sm border border-gray-200 rounded p-2 focus:outline-none" onchange="previewImage(this, 'p_preview')">
                    <p class="text-xs text-gray-500 mt-1" id="p_img_help">Format: JPG, PNG, WEBP maks 4MB.</p>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-xl border-t border-gray-100">
                <button type="button" onclick="closeProjectModal()" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 font-medium">Batal</button>
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white text-sm font-semibold rounded hover:bg-purple-700">Simpan Project</button>
            </div>
        </form>
    </div>
</div>

{{-- Form Delete (Hidden) --}}
<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>



@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
// Image Preview
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (!preview) return;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            const placeholder = preview.previousElementSibling;
            if (placeholder && placeholder.id && placeholder.id.includes('placeholder')) {
                placeholder.classList.add('hidden');
            }
            const pPlaceholder = document.getElementById('p_placeholder');
            if (pPlaceholder && previewId === 'p_preview') pPlaceholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Service Modal Functions
function openServiceModal(id = null, title = '', description = '') {
    const modal = document.getElementById('serviceModal');
    const form = document.getElementById('serviceForm');
    const methodDiv = document.getElementById('serviceMethod');
    const modalTitle = document.getElementById('serviceModalTitle');

    if (id) {
        form.action = `{{ url('admin/home/services') }}/${id}`;
        methodDiv.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        modalTitle.textContent = 'Edit Layanan';
        
        document.getElementById('s_title').value = title;
        document.getElementById('s_desc').value = description;
    } else {
        form.action = `{{ route('admin.home.services.store') }}`;
        methodDiv.innerHTML = '';
        modalTitle.textContent = 'Tambah Layanan';
        
        document.getElementById('s_title').value = '';
        document.getElementById('s_desc').value = '';
    }

    modal.classList.remove('opacity-0', 'pointer-events-none');
    document.getElementById('serviceModalInner').classList.remove('scale-95');
}

function closeServiceModal() {
    const modal = document.getElementById('serviceModal');
    modal.classList.add('opacity-0', 'pointer-events-none');
    document.getElementById('serviceModalInner').classList.add('scale-95');
}

// Project Modal Functions
function openProjectModal(id = null, title = '', imageUrl = '') {
    const modal = document.getElementById('projectModal');
    const form = document.getElementById('projectForm');
    const methodDiv = document.getElementById('projectMethod');
    const modalTitle = document.getElementById('projectModalTitle');
    const imgReq = document.getElementById('p_img_req');
    const fileHelp = document.getElementById('p_img_help');
    
    document.getElementById('p_preview').classList.add('hidden');
    document.getElementById('p_placeholder').style.display = 'block';

    if (id) {
        form.action = `{{ url('admin/home/projects') }}/${id}`;
        methodDiv.innerHTML = '<input type="hidden" name="_method" value="PUT">';
        modalTitle.textContent = 'Edit Project';
        document.getElementById('p_title').value = title;
        
        document.getElementById('p_file').required = false;
        imgReq.classList.add('hidden');
        fileHelp.textContent = 'Biarkan kosong jika tidak ingin mengubah gambar.';

        if (imageUrl) {
            document.getElementById('p_preview').src = imageUrl;
            document.getElementById('p_preview').classList.remove('hidden');
            document.getElementById('p_placeholder').style.display = 'none';
        }
    } else {
        form.action = `{{ route('admin.home.projects.store') }}`;
        methodDiv.innerHTML = '';
        modalTitle.textContent = 'Tambah Project';
        document.getElementById('p_title').value = '';
        
        document.getElementById('p_file').required = true;
        imgReq.classList.remove('hidden');
        fileHelp.textContent = 'Format: JPG, PNG, WEBP maks 4MB.';
    }

    modal.classList.remove('opacity-0', 'pointer-events-none');
    document.getElementById('projectModalInner').classList.remove('scale-95');
}

function closeProjectModal() {
    const modal = document.getElementById('projectModal');
    modal.classList.add('opacity-0', 'pointer-events-none');
    document.getElementById('projectModalInner').classList.add('scale-95');
}

// Delete functions
function deleteService(id) {
    if (confirm('Yakin ingin menghapus layanan ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = `{{ url('admin/home/services') }}/${id}`;
        form.submit();
    }
}

function deleteProject(id) {
    if (confirm('Yakin ingin menghapus project ini?')) {
        const form = document.getElementById('deleteForm');
        form.action = `{{ url('admin/home/projects') }}/${id}`;
        form.submit();
    }
}

// Initialize SortableJS
document.addEventListener('DOMContentLoaded', function() {
    const servicesSortable = document.getElementById('services-sortable');
    if (servicesSortable) {
        new Sortable(servicesSortable, {
            animation: 150,
            ghostClass: 'opacity-50',
            handle: '.cursor-move',
            onEnd: function () {
                const order = Array.from(servicesSortable.querySelectorAll('.service-card-wrapper')).map(el => el.getAttribute('data-id'));
                fetch(`{{ route('admin.home.services.reorder') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ order: order })
                });
            }
        });
    }

    const projectsSortable = document.getElementById('projects-sortable');
    if (projectsSortable) {
        new Sortable(projectsSortable, {
            animation: 150,
            ghostClass: 'opacity-50',
            handle: '.cursor-move',
            onEnd: function () {
                const order = Array.from(projectsSortable.querySelectorAll('.project-card-wrapper')).map(el => el.getAttribute('data-id'));
                fetch('/admin/home/projects/reorder', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ order: order })
                });
            }
        });
    }
});
</script>
@endpush
@endsection
