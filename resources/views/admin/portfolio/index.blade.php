@extends('admin.layouts.app')

@section('title', 'Portfolio Management')
@section('page-title', 'Portfolio')

@push('styles')
    <style>
        .portfolio-img-card {
            position: relative;
            overflow: hidden;
            border-radius: 16px;
            background: #f3f4f6;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .portfolio-img-card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.14);
        }

        .portfolio-img-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            pointer-events: none;
        }

        .portfolio-img-card.landscape {
            aspect-ratio: 4/3;
        }

        .portfolio-img-card.portrait {
            aspect-ratio: 3/4;
        }

        .portfolio-img-card.square {
            aspect-ratio: 1/1;
        }

        .portfolio-img-card .card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.75) 0%, transparent 60%);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1rem;
        }

        .portfolio-img-card:hover .card-overlay {
            opacity: 1;
        }

        .portfolio-img-card .card-actions {
            position: absolute;
            top: 8px;
            right: 8px;
            display: flex;
            gap: 4px;
            opacity: 0;
            transition: opacity 0.2s ease;
            z-index: 10;
        }

        .portfolio-img-card:hover .card-actions {
            opacity: 1;
        }

        /* featured removed – all cards are uniform size */
        .sortable-ghost {
            opacity: 0.3;
        }
    </style>
@endpush

@section('content')

    {{-- ─── GLOBAL HEADER ─── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-xl font-bold text-gray-900" style="font-family:'Montserrat',sans-serif;">Portfolio Management
            </h2>
            <p class="text-sm text-gray-500 mt-1">Kelola kategori dan item portofolio dalam satu halaman.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('portfolio') }}" target="_blank"
                class="inline-flex items-center gap-1.5 text-sm border border-gray-200 bg-white text-gray-600 px-3 py-2 rounded-lg hover:bg-gray-50 font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                Preview
            </a>
            <button type="button" onclick="openCategoryModal()"
                class="inline-flex items-center gap-1.5 text-sm border border-blue-200 bg-blue-50 text-blue-600 px-3 py-2 rounded-lg hover:bg-blue-100 font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kategori
            </button>
        </div>
    </div>

    {{-- ─── HERO SETTINGS ─── --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-6 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/60 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-2.5 h-2.5 rounded-full bg-blue-500"></div>
                <h3 class="font-bold text-gray-900 text-sm" style="font-family:'Montserrat',sans-serif;">Hero Settings</h3>
            </div>
        </div>
        <div class="p-5">
            <form action="{{ route('admin.portfolio.settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Hero Title <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="portfolio_hero_title"
                            value="{{ old('portfolio_hero_title', $settings->hero_title ?? 'Portofolio Kami') }}"
                            class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-colors"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Hero Subtitle</label>
                        <textarea name="portfolio_hero_subtitle" rows="3"
                            class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 transition-colors resize-none">{{ old('portfolio_hero_subtitle', $settings->hero_subtitle ?? 'Beberapa dokumentasi proyek event, pameran, dan aktivasi brand yang telah kami tangani dengan sepenuh hati.') }}</textarea>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex justify-center rounded-lg border border-transparent bg-blue-600 py-2 px-6 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ─── LOOP KATEGORI ─── --}}
    @forelse($categories as $category)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-6 overflow-hidden"
            id="cat-section-{{ $category->id }}">

            {{-- Category Header --}}
            <div class="flex flex-wrap items-center justify-between gap-3 px-5 py-4 border-b border-gray-100 bg-gray-50/60">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-[#f97316]"></div>
                    <h3 class="font-bold text-gray-900 text-sm" style="font-family:'Montserrat',sans-serif;">
                        {{ $category->name }}</h3>
                    <span class="text-xs text-gray-400 font-normal">{{ $category->portfolios->count() }} item</span>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="openPortfolioModal(null, '', {{ $category->id }})"
                        class="inline-flex items-center gap-1 text-xs bg-green-50 text-green-600 border border-green-200 px-3 py-1.5 rounded-lg hover:bg-green-100 font-semibold transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Gambar
                    </button>
                    <button type="button" onclick="openCategoryModal({{ $category->id }}, '{{ addslashes($category->name) }}')"
                        class="text-xs text-gray-500 border border-gray-200 bg-white px-2.5 py-1.5 rounded-lg hover:bg-gray-100 hover:text-gray-700 transition-colors font-medium">
                        Edit
                    </button>
                    <button type="button" onclick="deleteCategory({{ $category->id }})"
                        class="text-xs text-red-500 border border-red-100 bg-red-50 px-2.5 py-1.5 rounded-lg hover:bg-red-100 transition-colors font-medium">
                        Hapus
                    </button>
                </div>
            </div>

            {{-- Portfolio Grid (masonry adaptive) --}}
            <div class="p-5">
                @if($category->portfolios->isEmpty())
                    <div class="py-10 text-center rounded-xl border-2 border-dashed border-gray-100" id="empty-{{ $category->id }}">
                        <svg class="w-9 h-9 text-gray-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-xs text-gray-400">Belum ada portfolio dalam kategori ini.</p>
                    </div>
                @endif
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4" id="portfolio-grid-{{ $category->id }}"
                    style="--aspect: 4/3;">
                    @foreach($category->portfolios as $portfolio)
                        <div class="portfolio-img-card cursor-move" data-id="{{ $portfolio->id }}" id="pitem-{{ $portfolio->id }}"
                            style="aspect-ratio:4/3;">

                            {{-- Image --}}
                            @if($portfolio->image)
                                <img src="{{ asset('storage/' . $portfolio->image) }}" alt="{{ $portfolio->title }}"
                                    class="w-full h-full object-cover object-center">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif

                            {{-- Overlay on hover --}}
                            <div class="card-overlay">
                                <div class="flex gap-1 mb-1">
                                    @if(!$portfolio->is_show_in_all)
                                        <span
                                            class="inline-block bg-gray-700 text-gray-200 text-[9px] font-bold px-1.5 py-0.5 rounded self-start">HIDDEN
                                            FROM ALL</span>
                                    @endif
                                </div>
                                <p class="text-white text-xs font-semibold truncate" style="font-family:'Montserrat',sans-serif;">
                                    {{ $portfolio->title ?: 'Tanpa Judul' }}
                                </p>
                            </div>

                            {{-- Action buttons --}}
                            <div class="card-actions">
                                <button type="button"
                                    onclick='openPortfolioModal({{ $portfolio->id }}, {{ json_encode($portfolio->title) }}, {{ $portfolio->category_id }}, "{{ $portfolio->image ? asset("storage/" . $portfolio->image) : "" }}", {{ $portfolio->is_show_in_all ? "true" : "false" }})'
                                    class="p-1.5 bg-white/90 rounded-lg shadow text-gray-600 hover:text-blue-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button" onclick="deletePortfolio({{ $portfolio->id }})"
                                    class="p-1.5 bg-white/90 rounded-lg shadow text-gray-600 hover:text-red-600 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @empty
        <div class="py-24 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
            </div>
            <p class="text-gray-500 font-semibold mb-2">Belum ada kategori.</p>
            <p class="text-sm text-gray-400 mb-5">Mulai dengan menambahkan kategori portfolio pertama Anda.</p>
            <button type="button" onclick="openCategoryModal()"
                class="inline-flex items-center gap-1.5 text-sm bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 font-semibold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kategori Pertama
            </button>
        </div>
    @endforelse



    {{-- ════════════════════════════════════════════
    MODAL: Tambah / Edit Kategori
    ════════════════════════════════════════════ --}}
    <div id="categoryModal"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 opacity-0 pointer-events-none transition-opacity duration-200">
        <div id="categoryModalInner"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform scale-95 transition-transform duration-200">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-base font-bold text-gray-900" id="categoryModalTitle">Tambah Kategori</h3>
                <button type="button" onclick="closeCategoryModal()"
                    class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Kategori <span
                        class="text-red-500">*</span></label>
                <input type="text" id="cat_name" autocomplete="off"
                    class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400/40 focus:border-blue-400 transition-all"
                    placeholder="Contoh: Automotive Exhibition">
            </div>
            <div class="px-6 pb-5 flex justify-end gap-3">
                <button type="button" onclick="closeCategoryModal()"
                    class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 font-medium transition-colors">Batal</button>
                <button type="button" id="categorySubmitBtn" onclick="submitCategoryForm()"
                    class="px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition-colors shadow-sm">Simpan</button>
            </div>
        </div>
    </div>

    {{-- ════════════════════════════════════════════
    MODAL: Tambah / Edit Portfolio Item
    ════════════════════════════════════════════ --}}
    <div id="portfolioModal"
        class="fixed inset-0 z-50 flex items-start justify-center pt-12 p-4 bg-black/60 opacity-0 pointer-events-none transition-opacity duration-200">
        <div id="portfolioModalInner"
            class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform scale-95 transition-transform duration-200 max-h-[88vh] flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between flex-shrink-0">
                <h3 class="text-base font-bold text-gray-900" id="portfolioModalTitle">Tambah Gambar</h3>
                <button type="button" onclick="closePortfolioModal()"
                    class="text-gray-400 hover:text-gray-600 transition-colors p-1">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-5 overflow-y-auto flex-1">

                {{-- Title (optional) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul <span
                            class="text-gray-400 font-normal text-xs"></span></label>
                    <input type="text" id="p_title" autocomplete="off"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400/40 focus:border-orange-400 transition-all"
                        placeholder="e.g. Automotive Launch 2024">
                </div>

                {{-- Category (hidden pre-filled, but allow change) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori <span
                            class="text-red-500">*</span></label>
                    <select id="p_category"
                        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400/40 focus:border-orange-400 transition-all">
                        <option value="">Pilih Kategori...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Checkbox: show in All tab --}}
                <div class="flex items-center gap-2.5">
                    <label class="flex items-center gap-2.5 cursor-pointer select-none">
                        <input type="checkbox" id="p_show_in_all"
                            class="w-4 h-4 rounded text-green-500 border-gray-300 focus:ring-green-400/40 focus:ring-2"
                            checked>
                        <span class="text-sm text-gray-700">Tampilkan di Tab "All" <span
                                class="text-gray-400 text-xs">(halaman user)</span></span>
                    </label>
                </div>

                {{-- Image Upload --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar <span class="text-red-500"
                            id="p_img_required">*</span></label>
                    <div class="flex gap-4 items-start">
                        {{-- Preview --}}
                        <div
                            class="w-28 h-20 rounded-xl overflow-hidden border border-gray-200 bg-gray-50 flex items-center justify-center flex-shrink-0">
                            <img id="p_img_preview" src="" class="w-full h-full object-cover hidden" alt="">
                            <span id="p_img_placeholder" class="text-gray-300">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                        </div>
                        {{-- Drop zone --}}
                        <label
                            class="flex-1 flex flex-col items-center justify-center h-20 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-[#f97316] hover:bg-orange-50 transition-all text-center px-2">
                            <svg class="w-5 h-5 text-gray-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <span class="text-xs text-gray-500">Klik untuk upload</span>
                            <span class="text-[10px] text-gray-400">JPG, PNG, WEBP · maks 4MB</span>
                            <input type="file" id="p_img_file" accept="image/*" class="hidden"
                                onchange="previewPortfolioImage(this)">
                        </label>
                    </div>
                    <p id="p_img_current" class="mt-1.5 text-xs text-gray-400 hidden">Gambar terpasang. Upload baru untuk
                        mengganti.</p>
                </div>

            </div>
            <div
                class="px-6 py-4 bg-gray-50/80 flex justify-end gap-3 flex-shrink-0 border-t border-gray-100 rounded-b-2xl">
                <button type="button" onclick="closePortfolioModal()"
                    class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 font-medium transition-colors">Batal</button>
                <button type="button" id="portfolioSubmitBtn" onclick="submitPortfolioForm()"
                    class="px-5 py-2 bg-[#f97316] text-white text-sm font-bold rounded-xl hover:bg-orange-600 transition-colors shadow-sm">
                    Simpan
                </button>
            </div>
        </div>
    </div>

    {{-- Lightbox --}}
    <div id="lightbox"
        class="fixed inset-0 z-[60] bg-black/90 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 flex items-center justify-center p-4"
        onclick="closeLightbox(event)">
        <button type="button" onclick="closeLightbox(event, true)"
            class="absolute top-5 right-5 text-white/70 hover:text-white bg-black/40 hover:bg-black/70 p-2 rounded-full transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <img id="lightbox-img" src="" alt=""
            class="max-h-[90vh] max-w-full rounded-xl shadow-2xl object-contain transition-transform duration-200">
    </div>

    <form id="deletePortfolioForm" method="POST" class="hidden">@csrf @method('DELETE')</form>
    <form id="deleteCategoryForm" method="POST" class="hidden">@csrf @method('DELETE')</form>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
        <script>
            const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            /* ── HELPERS ──────────────────────────────── */
            function showModal(id, innerId) {
                const m = document.getElementById(id), i = document.getElementById(innerId);
                m.classList.remove('opacity-0', 'pointer-events-none');
                i.classList.remove('scale-95');
                document.body.style.overflow = 'hidden';
            }
            function hideModal(id, innerId) {
                const m = document.getElementById(id), i = document.getElementById(innerId);
                m.classList.add('opacity-0', 'pointer-events-none');
                i.classList.add('scale-95');
                document.body.style.overflow = '';
            }
            function setLoading(btnId, loading) {
                const btn = document.getElementById(btnId);
                if (!btn) return;
                btn.disabled = loading;
                btn.style.opacity = loading ? '0.6' : '1';
                btn.textContent = loading ? 'Menyimpan...' : 'Simpan';
            }

            /* ── CATEGORY MODAL ──────────────────────── */
            let currentCatId = null;

            function openCategoryModal(id = null, name = '') {
                currentCatId = id;
                document.getElementById('categoryModalTitle').textContent = id ? 'Edit Kategori' : 'Tambah Kategori';
                document.getElementById('cat_name').value = name;
                showModal('categoryModal', 'categoryModalInner');
                setTimeout(() => document.getElementById('cat_name').focus(), 150);
            }
            function closeCategoryModal() { hideModal('categoryModal', 'categoryModalInner'); }

            async function submitCategoryForm() {
                const name = document.getElementById('cat_name').value.trim();
                if (!name) { alert('Nama kategori wajib diisi.'); return; }

                setLoading('categorySubmitBtn', true);
                const fd = new FormData();
                fd.append('name', name);
                fd.append('_token', CSRF);
                let url = currentCatId
                    ? `{{ url('admin/portfolio/categories') }}/${currentCatId}`
                    : `{{ route('admin.portfolio.categories.store') }}`;
                if (currentCatId) fd.append('_method', 'PUT');

                try {
                    const r = await fetch(url, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: fd });
                    if (r.ok) { window.location.reload(); }
                    else {
                        const e = await r.json().catch(() => null);
                        alert('Error: ' + (e?.message || JSON.stringify(e?.errors) || 'Terjadi kesalahan.'));
                    }
                } catch (e) { alert('Kesalahan jaringan: ' + e.message); }
                finally { setLoading('categorySubmitBtn', false); }
            }

            function deleteCategory(id) {
                if (!confirm('Hapus kategori ini? Semua portofolio di dalamnya akan kehilangan kategori.')) return;
                const f = document.getElementById('deleteCategoryForm');
                f.action = `{{ url('admin/portfolio/categories') }}/${id}`;
                f.submit();
            }

            /* ── PORTFOLIO MODAL ─────────────────────── */
            let currentPortfolioId = null;

            function previewPortfolioImage(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const prev = document.getElementById('p_img_preview');
                        const ph = document.getElementById('p_img_placeholder');
                        prev.src = e.target.result;
                        prev.classList.remove('hidden');
                        ph.style.display = 'none';
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function openPortfolioModal(id = null, title = '', categoryId = '', imageUrl = '', isShowInAll = true) {
                currentPortfolioId = id;
                document.getElementById('portfolioModalTitle').textContent = id ? 'Edit Item Portfolio' : 'Tambah Gambar';
                document.getElementById('p_title').value = title;
                document.getElementById('p_category').value = categoryId;
                document.getElementById('p_show_in_all').checked = (isShowInAll === undefined || isShowInAll === null) ? true : !!isShowInAll;
                document.getElementById('p_img_file').value = '';

                const prev = document.getElementById('p_img_preview');
                const ph = document.getElementById('p_img_placeholder');
                const curr = document.getElementById('p_img_current');
                const req = document.getElementById('p_img_required');

                if (imageUrl) {
                    prev.src = imageUrl;
                    prev.classList.remove('hidden');
                    ph.style.display = 'none';
                    curr.classList.remove('hidden');
                    if (req) req.style.display = 'none'; // editing – image already exists
                } else {
                    prev.src = '';
                    prev.classList.add('hidden');
                    ph.style.display = '';
                    curr.classList.add('hidden');
                    if (req) req.style.display = '';
                }

                showModal('portfolioModal', 'portfolioModalInner');
            }
            function closePortfolioModal() { hideModal('portfolioModal', 'portfolioModalInner'); }

            async function submitPortfolioForm() {
                const categoryId = document.getElementById('p_category').value;
                const title = document.getElementById('p_title').value.trim();
                const isShowInAll = document.getElementById('p_show_in_all').checked ? 1 : 0;
                const imgFile = document.getElementById('p_img_file').files[0];

                if (!categoryId) { alert('Pilih kategori terlebih dahulu.'); return; }
                if (!currentPortfolioId && !imgFile) { alert('Gambar wajib diupload untuk item baru.'); return; }

                setLoading('portfolioSubmitBtn', true);
                const fd = new FormData();
                fd.append('title', title);
                fd.append('category_id', categoryId);
                fd.append('is_show_in_all', isShowInAll);
                if (imgFile) fd.append('image', imgFile);
                fd.append('_token', CSRF);

                let url = currentPortfolioId
                    ? `{{ url('admin/portfolio') }}/${currentPortfolioId}`
                    : `{{ route('admin.portfolio.store') }}`;
                if (currentPortfolioId) fd.append('_method', 'PUT');

                try {
                    const r = await fetch(url, { method: 'POST', headers: { 'X-Requested-With': 'XMLHttpRequest' }, body: fd });
                    if (r.ok) { window.location.reload(); }
                    else {
                        const e = await r.json().catch(() => null);
                        alert('Error: ' + (e?.message || JSON.stringify(e?.errors) || 'Terjadi kesalahan.'));
                    }
                } catch (e) { alert('Kesalahan jaringan: ' + e.message); }
                finally { setLoading('portfolioSubmitBtn', false); }
            }

            function deletePortfolio(id) {
                if (!confirm('Hapus gambar portfolio ini?')) return;
                const f = document.getElementById('deletePortfolioForm');
                f.action = `{{ url('admin/portfolio') }}/${id}`;
                f.submit();
            }

            /* ── LIGHTBOX ────────────────────────────── */
            document.querySelectorAll('.portfolio-img-card img').forEach(img => {
                img.addEventListener('click', function (e) {
                    e.stopPropagation(); // don't propagate to card drag
                    const lb = document.getElementById('lightbox');
                    const li = document.getElementById('lightbox-img');
                    li.src = this.src;
                    lb.classList.remove('opacity-0', 'pointer-events-none');
                    document.body.style.overflow = 'hidden';
                });
            });
            function closeLightbox(e, force = false) {
                const lb = document.getElementById('lightbox');
                if (force || e.target === lb) {
                    lb.classList.add('opacity-0', 'pointer-events-none');
                    document.body.style.overflow = '';
                    setTimeout(() => { document.getElementById('lightbox-img').src = ''; }, 300);
                }
            }
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') closeLightbox(e, true);
            });

            /* ── SORTABLE (per-category) ─────────────── */
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('[id^="portfolio-grid-"]').forEach(grid => {
                    if (!grid.children.length) return;
                    new Sortable(grid, {
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        onEnd: function () {
                            const items = Array.from(grid.children).map((el, index) => ({
                                id: el.dataset.id,
                                order: index
                            }));
                            fetch('{{ route("admin.portfolio.reorder") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': CSRF,
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({ items })
                            });
                        }
                    });
                });
            });
        </script>
    @endpush

@endsection