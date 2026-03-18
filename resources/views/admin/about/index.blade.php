@extends('admin.layouts.app')

@section('title', 'Manage About Page')
@section('page-title', 'About Page')

@section('content')
{{-- Success Message --}}

@if(session('error'))
    <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm font-medium">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8" id="aboutForm">
    @csrf
    @method('PUT')
    
    <input type="hidden" name="missions_data" id="missions_data_input">
    <input type="hidden" name="processes_data" id="processes_data_input">

    {{-- ─── SECTION 1: ABOUT HERO ─────────────────────────────────────── --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Section 1: About Hero</h2>
                <p class="text-xs text-gray-500">Judul utama di halaman About.</p>
            </div>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Hero Title <span class="text-red-500">*</span></label>
                <input
                    type="text" name="hero_title"
                    value="{{ old('hero_title', $about->hero_title ?? '') }}"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors @error('hero_title') border-red-400 @enderror"
                    required placeholder="e.g. Tentang 153 Kreatif"
                >
                @error('hero_title')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Hero Subtitle <span class="text-red-500">*</span></label>
                <input
                    type="text" name="hero_subtitle"
                    value="{{ old('hero_subtitle', $about->hero_subtitle ?? '') }}"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors @error('hero_subtitle') border-red-400 @enderror"
                    required placeholder="e.g. Integrated Event Solutions & Creative Production"
                >
                @error('hero_subtitle')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    {{-- ─── SECTION 2: CERITA KAMI ────────────────────────────────────── --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Section 2: Cerita Kami</h2>
                <p class="text-xs text-gray-500">Bagian penjelasan latar belakang perusahaan.</p>
            </div>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Story Title <span class="text-red-500">*</span></label>
                <input
                    type="text" name="story_title"
                    value="{{ old('story_title', $about->story_title ?? '') }}"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors @error('story_title') border-red-400 @enderror"
                    required placeholder="e.g. Cerita Kami"
                >
                @error('story_title')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Story Description <span class="text-red-500">*</span></label>
                <textarea
                    name="story_description" rows="6"
                    class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors resize-none @error('story_description') border-red-400 @enderror"
                    required placeholder="Ceritakan latar belakang perusahaan..."
                >{{ old('story_description', $about->story_description ?? '') }}</textarea>
                @error('story_description')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Story Image</label>
                <div class="flex flex-col sm:flex-row items-start gap-5">
                    <div class="w-full sm:w-48 h-36 rounded-lg overflow-hidden border border-gray-200 bg-gray-50 flex items-center justify-center flex-shrink-0">
                        @if($about && $about->story_image)
                            <img id="story-preview" src="{{ asset('storage/'.$about->story_image) }}" alt="Story" class="w-full h-full object-cover">
                        @else
                            <div class="flex flex-col items-center gap-1 text-gray-400" id="story-placeholder">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-xs">No image</span>
                            </div>
                            <img id="story-preview" src="" alt="Story" class="w-full h-full object-cover hidden">
                        @endif
                    </div>
                    <div class="flex-1">
                        <label class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-[#f97316] hover:bg-orange-50 transition-colors">
                            <svg class="w-6 h-6 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            <span class="text-sm text-gray-500">Klik untuk upload gambar</span>
                            <span class="text-xs text-gray-400 mt-0.5">PNG, JPG, WEBP maks. 4MB</span>
                            <input type="file" name="story_image" accept="image/*" class="hidden" onchange="previewImage(this, 'story-preview', 'story-placeholder')">
                        </label>
                        @if($about && $about->story_image)
                            <p class="mt-2 text-xs text-gray-500">File saat ini: <span class="font-medium">{{ basename($about->story_image) }}</span></p>
                        @endif
                    </div>
                </div>
                @error('story_image')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    {{-- ─── SECTION 3: VISI ─────────────────────────────────────────── --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-[#f97316]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Section 3: Visi</h2>
                <p class="text-xs text-gray-500">Teks Visi perusahaan.</p>
            </div>
        </div>
        <div class="p-6">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Vision Text <span class="text-red-500">*</span></label>
            <textarea
                name="vision_text" rows="4"
                class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#f97316]/30 focus:border-[#f97316] transition-colors resize-none @error('vision_text') border-red-400 @enderror"
                required placeholder="Masukkan teks visi perusahaan..."
            >{{ old('vision_text', $about->vision_text ?? '') }}</textarea>
            @error('vision_text')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
        </div>
    </div>

    {{-- SECTION 1, 2, 3 ACTION BUTTON MOVED TO BOTTOM --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-8" id="missions-section">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Section 4: Misi</h2>
                <p class="text-xs text-gray-500">Maksimal 5 Misi. Drag & Drop untuk mengurutkan.</p>
            </div>
        </div>
        @if($missions->count() < 5)
            <button type="button" onclick="openMissionModal()" class="text-sm bg-blue-50 text-blue-600 px-3 py-1.5 rounded hover:bg-blue-100 font-medium transition-colors">+ Tambah Misi</button>
        @endif
    </div>
    <div class="p-6">
        <div id="missions-sortable" class="space-y-3">
            {{-- Rendered by JS --}}
        </div>
    </div>
</div>

{{-- ─── SECTION 5: PROSES KERJA (SORTABLE & MODAL) ─────────────────────────── --}}
<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-8" id="processes-section">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Section 5: Proses Kerja</h2>
                <p class="text-xs text-gray-500">Maksimal 4 Proses. Drag & Drop untuk mengurutkan.</p>
            </div>
        </div>
        @if($processes->count() < 4)
            <button type="button" onclick="openProcessModal()" class="text-sm bg-purple-50 text-purple-600 px-3 py-1.5 rounded hover:bg-purple-100 font-medium transition-colors">+ Tambah Proses</button>
        @endif
    </div>
    <div class="p-6">
        <div id="processes-sortable" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Rendered by JS --}}
        </div>
    </div>
</div>

{{-- ─── MAIN FORM ACTION BUTTONS ─────────────────────────────────── --}}
<div class="flex items-center gap-4 mb-10 pt-4 border-t border-gray-200">
    <button
        type="submit"
        class="inline-flex items-center gap-2 px-8 py-3 bg-[#f97316] text-white text-base font-bold rounded-lg hover:bg-orange-600 transition-colors shadow-lg hover:shadow-xl hover:-translate-y-0.5"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Save Changes
    </button>
    <a href="{{ route('about') }}" target="_blank"
       class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
        Preview Halaman About
    </a>
</div>

</form>

{{-- MODALS --}}

<div id="missionModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 opacity-0 pointer-events-none transition-opacity">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform" id="missionModalInner">
        <div id="missionForm" class="block">
            <input type="hidden" id="m_id" value="">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900" id="missionModalTitle">Tambah Misi</h3>
                <button type="button" onclick="closeModal('missionModal', 'missionModalInner')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mission Title</label>
                    <input type="text" name="title" id="m_title" class="w-full rounded border-gray-200 text-sm p-2.5 focus:ring-[#f97316] focus:border-[#f97316]" placeholder="Boleh dilewati karena biasa text saja">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mission Description <span class="text-red-500">*</span></label>
                    <textarea name="description" id="m_desc" rows="3" required class="w-full rounded border-gray-200 text-sm p-2.5 focus:ring-[#f97316] focus:border-[#f97316]" placeholder="Teks misi..."></textarea>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-xl border-t border-gray-100">
                <button type="button" onclick="closeModal('missionModal', 'missionModalInner')" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 font-medium">Batal</button>
                <button type="button" onclick="saveMission()" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded hover:bg-blue-700">Simpan Misi</button>
            </div>
        </div>
    </div>
</div>

<div id="processModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 opacity-0 pointer-events-none transition-opacity">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform" id="processModalInner">
        <div id="processForm" class="block">
            <input type="hidden" id="pr_id" value="">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900" id="processModalTitle">Tambah Proses</h3>
                <button type="button" onclick="closeModal('processModal', 'processModalInner')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Process Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="pr_title" required class="w-full rounded border-gray-200 text-sm p-2.5 focus:ring-[#f97316] focus:border-[#f97316]" placeholder="e.g. Consultation">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Process Description <span class="text-red-500">*</span></label>
                    <textarea name="description" id="pr_desc" rows="3" required class="w-full rounded border-gray-200 text-sm p-2.5 focus:ring-[#f97316] focus:border-[#f97316]" placeholder="Teks penjelasan langkah proses..."></textarea>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-xl border-t border-gray-100">
                <button type="button" onclick="closeModal('processModal', 'processModalInner')" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 font-medium">Batal</button>
                <button type="button" onclick="saveProcess()" class="px-4 py-2 bg-purple-600 text-white text-sm font-semibold rounded hover:bg-purple-700">Simpan Proses</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
// Image Preview
function previewImage(input, previewId, placeholderId) {
    const preview = document.getElementById(previewId);
    if (!preview) return;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            const placeholder = document.getElementById(placeholderId);
            if (placeholder) {
                placeholder.classList.add('hidden');
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function openModal(modalId, innerId) {
    const modal = document.getElementById(modalId);
    modal.classList.remove('opacity-0', 'pointer-events-none');
    document.getElementById(innerId).classList.remove('scale-95');
}

function closeModal(modalId, innerId) {
    const modal = document.getElementById(modalId);
    modal.classList.add('opacity-0', 'pointer-events-none');
    document.getElementById(innerId).classList.add('scale-95');
}

// JS State
let missionsData = @json($missions);
let processesData = @json($processes);

// Submit Intercept
document.getElementById('aboutForm').addEventListener('submit', function(e) {
    // Inject array payloads to hidden inputs before submitting
    document.getElementById('missions_data_input').value = JSON.stringify(missionsData);
    document.getElementById('processes_data_input').value = JSON.stringify(processesData);
});

// Render functions
function renderMissions() {
    const list = document.getElementById('missions-sortable');
    list.innerHTML = '';
    
    if(missionsData.length === 0) {
        list.innerHTML = `<div class="text-center py-8 text-sm text-gray-500 border border-dashed border-gray-200 rounded-lg">Belum ada misi. Klik "Tambah Misi" untuk mulai.</div>`;
    } else {
        missionsData.forEach((m, index) => {
            const escapeQuote = (str) => str ? str.replace(/'/g, "\\'") : '';
            const html = `
            <div class="mission-card-wrapper bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow relative group cursor-move flex items-start gap-4" data-index="${index}">
                <div class="w-8 h-8 mt-1 flex-shrink-0 bg-orange-50 rounded-full flex items-center justify-center text-[#ff6a00]">
                    <span class="font-bold text-sm mission-iteration">${index + 1}</span>
                </div>
                <div class="flex-1 pointer-events-none">
                    <h3 class="text-base font-bold text-gray-900 mb-1" style="font-family: 'Montserrat', sans-serif;">${m.title || 'Misi'}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed" style="font-family: 'Inter', sans-serif;">${m.description}</p>
                </div>
                <div class="flex items-center gap-1 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                    <button type="button" onclick="openMissionModal('${m.id}', '${escapeQuote(m.title)}', '${escapeQuote(m.description)}')" class="p-1.5 bg-white border border-gray-200 rounded shadow-sm text-gray-600 hover:text-blue-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button type="button" onclick="deleteItem('${m.id}', 'missions')" class="p-1.5 bg-white border border-gray-200 rounded shadow-sm text-gray-600 hover:text-red-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </div>`;
            list.insertAdjacentHTML('beforeend', html);
        });
    }
}

function renderProcesses() {
    const list = document.getElementById('processes-sortable');
    list.innerHTML = '';
    
    if(processesData.length === 0) {
        list.innerHTML = `<div class="col-span-1 md:col-span-2 lg:col-span-4 text-center py-8 text-sm text-gray-500 border border-dashed border-gray-200 rounded-lg">Belum ada proses. Klik "Tambah Proses" untuk mulai.</div>`;
    } else {
        processesData.forEach((p, index) => {
            const escapeQuote = (str) => str ? str.replace(/'/g, "\\'") : '';
            const html = `
            <div class="process-card-wrapper bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow relative group cursor-move p-5 text-center flex flex-col items-center" data-index="${index}">
                <div class="absolute top-2 right-2 flex items-center gap-1 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity z-10 bg-white/80 p-1 rounded backdrop-blur-sm">
                    <button type="button" onclick="openProcessModal('${p.id}', '${escapeQuote(p.title)}', '${escapeQuote(p.description)}')" class="p-1.5 bg-white border border-gray-200 rounded shadow-sm text-gray-600 hover:text-purple-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button type="button" onclick="deleteItem('${p.id}', 'processes')" class="p-1.5 bg-white border border-gray-200 rounded shadow-sm text-gray-600 hover:text-red-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
                
                <div class="w-16 h-16 bg-white border-[4px] border-[#ff6a00] rounded-full flex items-center justify-center shadow-sm mb-4 pointer-events-none">
                    <span class="text-xl font-bold text-[#ff6a00] process-iteration">${index + 1}</span>
                </div>
                <h4 class="text-lg font-bold text-gray-900 mb-2 pointer-events-none" style="font-family: 'Montserrat', sans-serif;">${p.title}</h4>
                <p class="text-sm text-gray-600 leading-relaxed pointer-events-none" style="font-family: 'Inter', sans-serif;">${p.description}</p>
            </div>`;
            list.insertAdjacentHTML('beforeend', html);
        });
    }
}

// Modal Form Actions
function openMissionModal(id = null, title = '', description = '') {
    if(!id && missionsData.length >= 5) {
        alert('Maksimal 5 misi!');
        return;
    }
    document.getElementById('m_id').value = id || '';
    document.getElementById('m_title').value = title;
    document.getElementById('m_desc').value = description;
    document.getElementById('missionModalTitle').innerText = id ? 'Edit Misi' : 'Tambah Misi';
    openModal('missionModal', 'missionModalInner');
}

function saveMission() {
    const id = document.getElementById('m_id').value;
    const title = document.getElementById('m_title').value;
    const desc = document.getElementById('m_desc').value;

    if(!desc) { alert('Description is required!'); return; }

    if(id) {
        let m = missionsData.find(x => String(x.id) === String(id));
        if(m) {
            m.title = title;
            m.description = desc;
        }
    } else {
        missionsData.push({
            id: 'new_' + Date.now(),
            title: title,
            description: desc
        });
    }

    renderMissions();
    closeModal('missionModal', 'missionModalInner');
}

function openProcessModal(id = null, title = '', description = '') {
    if(!id && processesData.length >= 4) {
        alert('Maksimal 4 proses!');
        return;
    }
    document.getElementById('pr_id').value = id || '';
    document.getElementById('pr_title').value = title;
    document.getElementById('pr_desc').value = description;
    document.getElementById('processModalTitle').innerText = id ? 'Edit Proses' : 'Tambah Proses';
    openModal('processModal', 'processModalInner');
}

function saveProcess() {
    const id = document.getElementById('pr_id').value;
    const title = document.getElementById('pr_title').value;
    const desc = document.getElementById('pr_desc').value;

    if(!title || !desc) { alert('Title & Description required!'); return; }

    if(id) {
        let p = processesData.find(x => String(x.id) === String(id));
        if(p) {
            p.title = title;
            p.description = desc;
        }
    } else {
        processesData.push({
            id: 'new_' + Date.now(),
            title: title,
            description: desc
        });
    }

    renderProcesses();
    closeModal('processModal', 'processModalInner');
}

function deleteItem(id, type) {
    if(confirm('Hapus item ini dari daftar? (Perubahan akan permanen setelah klik Save Changes)')) {
        if(type === 'missions') {
            missionsData = missionsData.filter(x => String(x.id) !== String(id));
            renderMissions();
        } else if(type === 'processes') {
            processesData = processesData.filter(x => String(x.id) !== String(id));
            renderProcesses();
        }
    }
}

// Initial Render and Sortable
document.addEventListener('DOMContentLoaded', function() {
    renderMissions();
    renderProcesses();

    // Missions Sortable
    new Sortable(document.getElementById('missions-sortable'), {
        animation: 150, ghostClass: 'opacity-50', handle: '.cursor-move',
        onEnd: function (evt) {
            const item = missionsData.splice(evt.oldIndex, 1)[0];
            missionsData.splice(evt.newIndex, 0, item);
            renderMissions();
        }
    });

    // Processes Sortable
    new Sortable(document.getElementById('processes-sortable'), {
        animation: 150, ghostClass: 'opacity-50', handle: '.cursor-move',
        onEnd: function (evt) {
            const item = processesData.splice(evt.oldIndex, 1)[0];
            processesData.splice(evt.newIndex, 0, item);
            renderProcesses();
        }
    });
});
</script>
@endpush
@endsection
