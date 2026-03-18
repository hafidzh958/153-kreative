@extends('admin.layouts.app')

@section('title', 'Manage Services')
@section('page-title', 'Services')

@section('content')



{{-- ─── SECTION 0: HERO SERVICES ─────────────────────────── --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Hero Services</h2>
                <p class="text-xs text-gray-500">Teks dan gambar utama di bagian atas halaman Services.</p>
            </div>
        </div>
    </div>

    <div class="p-6">
        <form action="{{ route('admin.services.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Hero Title <span class="text-red-500">*</span></label>
                        <input type="text" name="services_hero_title" value="{{ old('services_hero_title', $settings->hero_title ?? 'Layanan Kami') }}" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors" required>
                    </div>

                    {{-- Subtitle --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Hero Subtitle</label>
                        <textarea name="services_hero_subtitle" rows="3" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors resize-none">{{ old('services_hero_subtitle', $settings->hero_subtitle ?? 'Integrated Event Solutions & Creative Production') }}</textarea>
                    </div>

                    {{-- Intro Text --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Teks Pengantar (Intro)</label>
                        <textarea name="intro_text" rows="4" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors resize-none">{{ old('intro_text', $settings->intro_text ?? '153 Kreatif menyediakan solusi event terintegrasi yang mencakup manajemen acara, produksi kreatif, serta penyelenggaraan event komunitas untuk memperkuat kehadiran brand Anda.') }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">Teks di bawah Hero yang menjelaskan layanan secara singkat.</p>
                    </div>
                </div>

                {{-- External Image Section --}}
                <div class="bg-gray-50 border border-gray-100 rounded-xl p-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Background Image (Opsional)</label>
                    <p class="text-xs text-gray-500 mb-4">Jika dikosongkan, background akan berwarna orange.</p>
                    
                    <div class="relative w-full aspect-[21/9] rounded-lg overflow-hidden border border-gray-200 bg-white shadow-sm group">
                        @if(isset($settings) && $settings->hero_image)
                            <img id="hero_image_preview" src="{{ asset('storage/'.$settings->hero_image) }}" alt="Hero Background" class="w-full h-full object-cover">
                        @else
                            <img id="hero_image_preview" src="" alt="Hero Background" class="w-full h-full object-cover hidden">
                            <div id="hero_image_placeholder" class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 bg-orange-50">
                                <svg class="w-8 h-8 mb-2 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-xs">Tidak ada gambar</span>
                            </div>
                        @endif

                        {{-- Overlay & Change Button --}}
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <label class="cursor-pointer bg-white text-gray-900 px-4 py-2 rounded-lg text-sm font-medium shadow-md hover:bg-gray-50 transition-colors">
                                Ubah Gambar
                                <input type="file" name="services_hero_image" accept="image/*" class="hidden" onchange="previewHeroImage(this)">
                            </label>
                        </div>
                    </div>

                    {{-- Helper Text --}}
                    <div class="mt-3 flex items-center justify-between">
                        <span class="text-xs text-gray-500 hidden" id="hero_new_status">Gambar baru dipilih</span>
                        
                        <label class="inline-flex items-center gap-2 cursor-pointer ml-auto">
                            <input type="checkbox" name="remove_hero_image" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500" onchange="toggleRemoveHeroImage(this)">
                            <span class="text-xs text-red-600 hover:text-red-700 font-medium">Hapus Gambar Saat Disimpan</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-100">
                <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent bg-[#f97316] py-2 px-6 text-sm font-medium text-white shadow-sm hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-[#f97316] focus:ring-offset-2 transition-colors">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ─── SECTION A: MAIN SERVICES ─────────────────────────── --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Main Services</h2>
                <p class="text-xs text-gray-500">Layanan utama dengan gambar & deskripsi. Drag & Drop untuk mengurutkan.</p>
            </div>
        </div>
        <button type="button" onclick="openMainModal()" class="text-sm bg-orange-50 text-[#f97316] px-3 py-1.5 rounded-lg hover:bg-orange-100 font-medium transition-colors">
            + Tambah Main Service
        </button>
    </div>

    <div class="p-6">
        <div id="main-services-sortable" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($mainServices as $service)
            <div class="main-service-card bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-all relative group cursor-move" data-id="{{ $service->id }}">
                {{-- Actions --}}
                <div class="absolute top-2 right-2 flex items-center gap-1 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity z-10">
                    <button type="button"
                        onclick='openMainModal({{ $service->id }}, {{ json_encode($service->name) }}, {{ json_encode($service->description) }}, "{{ $service->image ? asset("storage/".$service->image) : "" }}", {{ $service->features->toJson() }})'
                        class="p-1.5 bg-white border border-gray-200 rounded-lg shadow-sm text-gray-600 hover:text-[#f97316] hover:border-orange-200 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button type="button" onclick="deleteService({{ $service->id }})"
                        class="p-1.5 bg-white border border-gray-200 rounded-lg shadow-sm text-gray-600 hover:text-red-600 hover:border-red-200 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>

                {{-- Drag Handle --}}
                <div class="absolute top-2 left-2 opacity-0 group-hover:opacity-100 transition-opacity text-gray-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 6a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM8 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM8 22a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM16 6a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM16 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4ZM16 22a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/></svg>
                </div>

                {{-- Image --}}
                @if($service->image)
                    <div class="aspect-[16/7] overflow-hidden rounded-t-xl">
                        <img src="{{ asset('storage/'.$service->image) }}" alt="{{ $service->title }}" class="w-full h-full object-cover pointer-events-none">
                    </div>
                @else
                    <div class="aspect-[16/7] bg-gray-100 rounded-t-xl flex items-center justify-center pointer-events-none">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endif

                {{-- Content --}}
                <div class="p-4 pointer-events-none">
                    <h3 class="text-sm font-bold text-gray-900 mb-1 truncate" style="font-family:'Montserrat',sans-serif;">{{ $service->name }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed line-clamp-2 mb-3">{{ $service->description }}</p>
                    @if($service->features->count())
                        <div class="flex flex-wrap gap-1">
                            @foreach($service->features->take(3) as $feat)
                                <span class="inline-block bg-orange-50 text-orange-600 text-xs px-2 py-0.5 rounded-full font-medium truncate max-w-[140px]">{{ $feat->text }}</span>
                            @endforeach
                            @if($service->features->count() > 3)
                                <span class="inline-block bg-gray-100 text-gray-500 text-xs px-2 py-0.5 rounded-full">+{{ $service->features->count() - 3 }}</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 py-16 text-center">
                    <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <p class="text-sm text-gray-400">Belum ada Main Service. Klik "+ Tambah Main Service" untuk mulai.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- ─── SECTION B: SUPPORTING SERVICES ──────────────────────── --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Supporting Services</h2>
                <p class="text-xs text-gray-500">Layanan pendukung (grid kecil di halaman user). Drag & Drop untuk mengurutkan.</p>
            </div>
        </div>
        <button type="button" onclick="openSupportModal()" class="text-sm bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg hover:bg-blue-100 font-medium transition-colors">
            + Tambah Supporting Service
        </button>
    </div>

    <div class="p-6">
        <div id="support-services-sortable" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($supportingServices as $service)
            <div class="support-service-card bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-all relative group cursor-move" data-id="{{ $service->id }}">
                {{-- Actions --}}
                <div class="absolute top-1.5 right-1.5 flex items-center gap-0.5 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity z-10">
                    <button type="button" onclick="openSupportModal({{ $service->id }}, {{ json_encode($service->name) }})"
                        class="p-1 bg-white border border-gray-200 rounded shadow-sm text-gray-500 hover:text-blue-600 hover:border-blue-200 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button type="button" onclick="deleteService({{ $service->id }})"
                        class="p-1 bg-white border border-gray-200 rounded shadow-sm text-gray-500 hover:text-red-600 hover:border-red-200 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
                <div class="w-full px-2 flex items-center justify-center text-center h-full pointer-events-none">
                    <p class="text-sm font-semibold text-gray-800" style="font-family:'Montserrat',sans-serif;">{{ $service->name }}</p>
                </div>
            </div>
            @empty
                <div class="col-span-2 md:col-span-3 lg:col-span-4 py-10 text-center">
                    <p class="text-sm text-gray-400">Belum ada Supporting Service. Klik "+ Tambah Supporting Service" untuk mulai.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Preview link --}}
<div class="flex items-center gap-4 mb-2">
    <a href="{{ route('services') }}" target="_blank"
       class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-800 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        Preview Halaman Services
    </a>
</div>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{-- MODAL: Main Service (Tambah / Edit) --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div id="mainModal" class="fixed inset-0 z-50 flex items-start justify-center p-4 pt-12 bg-black/50 opacity-0 pointer-events-none transition-opacity">
    <div id="mainModalInner" class="bg-white rounded-xl shadow-2xl w-full max-w-2xl overflow-hidden transform scale-95 transition-transform max-h-[85vh] flex flex-col">
        {{-- Header --}}
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between flex-shrink-0">
            <h3 class="text-base font-semibold text-gray-900" id="mainModalTitle">Tambah Main Service</h3>
            <button type="button" onclick="closeMainModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Body (scrollable) --}}
        <div class="p-6 space-y-5 overflow-y-auto flex-1">
            {{-- Title --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Title <span class="text-red-500">*</span></label>
                <input type="text" id="main_title" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors" placeholder="e.g. Automotive Exhibition">
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                <textarea id="main_desc" rows="3" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors resize-none" placeholder="Deskripsi layanan..."></textarea>
            </div>

            {{-- Image --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Gambar Layanan</label>
                <div class="flex flex-col sm:flex-row items-start gap-4">
                    <div class="w-full sm:w-36 h-24 rounded-lg overflow-hidden border border-gray-200 bg-gray-50 flex items-center justify-center flex-shrink-0">
                        <img id="main_img_preview" src="" class="w-full h-full object-cover hidden" alt="Preview">
                        <span id="main_img_placeholder" class="text-gray-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </span>
                    </div>
                    <label class="flex-1 flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-[#f97316] hover:bg-orange-50 transition-colors">
                        <svg class="w-5 h-5 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <span class="text-xs text-gray-500">Klik untuk upload gambar</span>
                        <span class="text-xs text-gray-400">PNG, JPG, WEBP maks. 4MB</span>
                        <input type="file" id="main_img_file" accept="image/*" class="hidden" onchange="previewMainImage(this)">
                    </label>
                </div>
                <p id="main_img_current" class="mt-1.5 text-xs text-gray-500 hidden"></p>
            </div>

            {{-- Features --}}
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-sm font-medium text-gray-700">Fitur / Bullet Points</label>
                    <button type="button" onclick="addFeatureRow()" class="text-xs text-[#f97316] hover:text-orange-600 font-medium flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Tambah Fitur
                    </button>
                </div>
                <div id="features-list" class="space-y-2"></div>
                <p class="text-xs text-gray-400 mt-2">Fitur akan langsung tersimpan ke database. Kosongkan semua jika tidak perlu.</p>
            </div>
        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 flex-shrink-0 border-t border-gray-100 rounded-b-xl">
            <button type="button" onclick="closeMainModal()" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 font-medium transition-colors">Batal</button>
            <button type="button" onclick="submitMainForm()" class="px-5 py-2 bg-[#f97316] text-white text-sm font-semibold rounded-lg hover:bg-orange-600 transition-colors">Simpan</button>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════ --}}
{{-- MODAL: Supporting Service (Tambah / Edit) --}}
{{-- ═══════════════════════════════════════════════════════════ --}}
<div id="supportModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 opacity-0 pointer-events-none transition-opacity">
    <div id="supportModalInner" class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform scale-95 transition-transform">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-semibold text-gray-900" id="supportModalTitle">Tambah Supporting Service</h3>
            <button type="button" onclick="closeSupportModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-6">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Title <span class="text-red-500">*</span></label>
            <input type="text" id="support_title" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-colors" placeholder="e.g. Event Planning">
        </div>
        <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-xl border-t border-gray-100">
            <button type="button" onclick="closeSupportModal()" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 font-medium transition-colors">Batal</button>
            <button type="button" onclick="submitSupportForm()" class="px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">Simpan</button>
        </div>
    </div>
</div>

{{-- Hidden Delete Form --}}
<form id="deleteServiceForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ── State ──────────────────────────────────────────────────────
let currentMainId   = null;
let currentSupportId = null;
// Features: array of {id: number|null, text: string, _delete: bool}
let currentFeatures = [];

// ── Image Preview ────────────────────────────────────────────
function previewHeroImage(input) {
    const preview = document.getElementById('hero_image_preview');
    const placeholder = document.getElementById('hero_image_placeholder');
    const statusText = document.getElementById('hero_new_status');
    const removeCheckbox = document.querySelector('input[name="remove_hero_image"]');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) placeholder.style.display = 'none';
            statusText.classList.remove('hidden');
            removeCheckbox.checked = false;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function toggleRemoveHeroImage(checkbox) {
    const preview = document.getElementById('hero_image_preview');
    const placeholder = document.getElementById('hero_image_placeholder');
    const fileInput = document.querySelector('input[name="services_hero_image"]');
    const statusText = document.getElementById('hero_new_status');

    if (checkbox.checked) {
        preview.src = '';
        preview.classList.add('hidden');
        if (placeholder) placeholder.style.display = 'flex';
        fileInput.value = '';
        statusText.classList.add('hidden');
    } else {
        // if it was unchecked, we reset to original if exists, otherwise keep placeholder
        // actually just keep placeholder
    }
}

function previewMainImage(input) {
    const preview     = document.getElementById('main_img_preview');
    const placeholder = document.getElementById('main_img_placeholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// ── Features UI ────────────────────────────────────────────────
function renderFeatures() {
    const container = document.getElementById('features-list');
    container.innerHTML = '';
    currentFeatures.forEach((feat, idx) => {
        if (feat._delete) return;
        const row = document.createElement('div');
        row.className = 'flex items-center gap-2';
        row.innerHTML = `
            <div class="w-2 h-2 rounded-full bg-[#f97316] flex-shrink-0"></div>
            <input type="text" value="${escapeHtml(feat.text)}"
                   oninput="updateFeatureText(${idx}, this.value)"
                   class="flex-1 rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors"
                   placeholder="Teks fitur...">
            <button type="button" onclick="removeFeature(${idx})" class="text-gray-400 hover:text-red-500 flex-shrink-0 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        `;
        container.appendChild(row);
    });
    if (!currentFeatures.filter(f => !f._delete).length) {
        container.innerHTML = '<p class="text-xs text-gray-400 italic">Belum ada fitur ditambahkan.</p>';
    }
}

function escapeHtml(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function addFeatureRow() {
    currentFeatures.push({ id: null, text: '', _delete: false });
    renderFeatures();
    // Focus last input
    const inputs = document.querySelectorAll('#features-list input[type="text"]');
    if (inputs.length) inputs[inputs.length - 1].focus();
}

function updateFeatureText(idx, val) {
    currentFeatures[idx].text = val;
}

function removeFeature(idx) {
    if (currentFeatures[idx].id) {
        currentFeatures[idx]._delete = true;
    } else {
        currentFeatures.splice(idx, 1);
    }
    renderFeatures();
}

// ── Main Modal ─────────────────────────────────────────────────
function openMainModal(id = null, title = '', desc = '', imageUrl = '', features = []) {
    currentMainId = id;
    currentFeatures = features.map(f => ({ id: f.id, text: f.text, _delete: false }));

    document.getElementById('mainModalTitle').textContent = id ? 'Edit Main Service' : 'Tambah Main Service';
    document.getElementById('main_title').value = title;
    document.getElementById('main_desc').value  = desc;
    document.getElementById('main_img_file').value = '';

    const preview     = document.getElementById('main_img_preview');
    const placeholder = document.getElementById('main_img_placeholder');
    const current     = document.getElementById('main_img_current');

    if (imageUrl) {
        preview.src = imageUrl;
        preview.classList.remove('hidden');
        placeholder.style.display = 'none';
        current.textContent = 'Gambar terpasang. Upload baru untuk mengganti.';
        current.classList.remove('hidden');
    } else {
        preview.src = '';
        preview.classList.add('hidden');
        placeholder.style.display = '';
        current.classList.add('hidden');
    }

    renderFeatures();
    showModal('mainModal', 'mainModalInner');
}

function closeMainModal() {
    hideModal('mainModal', 'mainModalInner');
}

async function submitMainForm() {
    const title = document.getElementById('main_title').value.trim();
    if (!title) { alert('Title wajib diisi.'); return; }

    const fd = new FormData();
    fd.append('name', title);
    fd.append('description', document.getElementById('main_desc').value.trim());
    fd.append('is_main', '1');
    const imgFile = document.getElementById('main_img_file').files[0];
    if (imgFile) fd.append('image', imgFile);
    fd.append('_token', CSRF);

    let url;
    if (currentMainId) {
        fd.append('_method', 'PUT');
        url = `{{ url('admin/services') }}/${currentMainId}`;
    } else {
        url = `{{ route('admin.services.store') }}`;
    }

    try {
        const resp = await fetch(url, {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: fd
        });

        if (resp.ok) {
            const json = await resp.json().catch(() => null);
            const serviceId = currentMainId || (json && json.id);

            if (serviceId && currentFeatures.some(f => !f._delete && f.text.trim())) {
                await syncFeatures(serviceId);
            } else if (currentMainId) {
                await syncFeatures(currentMainId);
            }
            window.location.reload();
        } else {
            const errJson = await resp.json().catch(() => null);
            const msg = (errJson && (errJson.message || JSON.stringify(errJson.errors))) || 'Terjadi kesalahan. Coba lagi.';
            alert('Error: ' + msg);
        }
    } catch(e) {
        alert('Terjadi kesalahan jaringan: ' + e.message);
    }
}

async function syncFeatures(serviceId) {
    // Delete marked features
    const toDelete = currentFeatures.filter(f => f.id && f._delete);
    for (const f of toDelete) {
        await fetch(`{{ url('admin/services/features') }}/${f.id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
        });
    }
    // Update existing
    const toUpdate = currentFeatures.filter(f => f.id && !f._delete && f.text.trim());
    for (const f of toUpdate) {
        const fd = new FormData();
        fd.append('_method', 'PUT');
        fd.append('text', f.text.trim());
        fd.append('_token', CSRF);
        await fetch(`{{ url('admin/services/features') }}/${f.id}`, { method: 'POST', body: fd });
    }
    // Create new
    const toCreate = currentFeatures.filter(f => !f.id && !f._delete && f.text.trim());
    for (const f of toCreate) {
        const fd = new FormData();
        fd.append('text', f.text.trim());
        fd.append('_token', CSRF);
        await fetch(`{{ url('admin/services') }}/${serviceId}/features`, { method: 'POST', body: fd });
    }
}

// After creating new service, we need to also add its features.
// We handle this by doing a reload after store and returning the new service ID from server.
// Simplified approach: store service, then on reload use edit modal to add features. 
// But for better UX when creating, we'll handle feature creation via the store response.

// ── Support Modal ──────────────────────────────────────────────
function openSupportModal(id = null, title = '') {
    currentSupportId = id;
    document.getElementById('supportModalTitle').textContent = id ? 'Edit Supporting Service' : 'Tambah Supporting Service';
    document.getElementById('support_title').value = title;
    showModal('supportModal', 'supportModalInner');
}

function closeSupportModal() {
    hideModal('supportModal', 'supportModalInner');
}

async function submitSupportForm() {
    const title = document.getElementById('support_title').value.trim();
    if (!title) { alert('Title wajib diisi.'); return; }

    const fd = new FormData();
    fd.append('name', title);
    fd.append('is_main', '0');
    fd.append('_token', CSRF);

    let url, method;
    if (currentSupportId) {
        fd.append('_method', 'PUT');
        url = `{{ url('admin/services') }}/${currentSupportId}`;
        method = 'POST';
    } else {
        url = `{{ route('admin.services.store') }}`;
        method = 'POST';
    }

    try {
        const resp = await fetch(url, {
            method,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: fd
        });
        if (resp.ok) {
            window.location.reload();
        } else {
            const errJson = await resp.json().catch(() => null);
            const msg = (errJson && (errJson.message || JSON.stringify(errJson.errors))) || 'Terjadi kesalahan. Coba lagi.';
            alert('Error: ' + msg);
        }
    } catch(e) {
        alert('Terjadi kesalahan jaringan: ' + e.message);
    }
}

// ── Delete ──────────────────────────────────────────────────────
function deleteService(id) {
    if (!confirm('Yakin ingin menghapus service ini? Semua fitur terkait juga akan dihapus.')) return;
    const form = document.getElementById('deleteServiceForm');
    form.action = `{{ url('admin/services') }}/${id}`;
    form.submit();
}

// ── Modal Helpers ───────────────────────────────────────────────
function showModal(modalId, innerId) {
    const modal = document.getElementById(modalId);
    const inner = document.getElementById(innerId);
    modal.classList.remove('opacity-0', 'pointer-events-none');
    inner.classList.remove('scale-95');
    document.body.style.overflow = 'hidden';
}

function hideModal(modalId, innerId) {
    const modal = document.getElementById(modalId);
    const inner = document.getElementById(innerId);
    modal.classList.add('opacity-0', 'pointer-events-none');
    inner.classList.add('scale-95');
    document.body.style.overflow = '';
}

// Close modal when clicking backdrop
document.getElementById('mainModal').addEventListener('click', function(e) {
    if (e.target === this) closeMainModal();
});
document.getElementById('supportModal').addEventListener('click', function(e) {
    if (e.target === this) closeSupportModal();
});

// ── SortableJS ─────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    const mainEl = document.getElementById('main-services-sortable');
    if (mainEl) {
        new Sortable(mainEl, {
            animation: 150,
            ghostClass: 'opacity-40',
            handle: '.main-service-card',
            onEnd: function () {
                const order = Array.from(mainEl.querySelectorAll('.main-service-card')).map(el => el.getAttribute('data-id'));
                fetch('{{ route("admin.services.reorder") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                    body: JSON.stringify({ order })
                });
            }
        });
    }

    const supportEl = document.getElementById('support-services-sortable');
    if (supportEl) {
        new Sortable(supportEl, {
            animation: 150,
            ghostClass: 'opacity-40',
            handle: '.support-service-card',
            onEnd: function () {
                const order = Array.from(supportEl.querySelectorAll('.support-service-card')).map(el => el.getAttribute('data-id'));
                fetch('{{ route("admin.services.reorder") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                    body: JSON.stringify({ order })
                });
            }
        });
    }
});
</script>
@endpush
@endsection
