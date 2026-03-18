@extends('admin.layouts.app')

@section('title', 'Manage Portfolio Categories')
@section('page-title', 'Portfolio Categories')

@section('content')

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Kategori Portfolio</h2>
                <p class="text-xs text-gray-500">Kelola kategori untuk filter portofolio di halaman user.</p>
            </div>
        </div>
        <button type="button" onclick="openCategoryModal()" class="text-sm bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg hover:bg-blue-100 font-medium transition-colors">
            + Tambah Kategori
        </button>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($categories as $category)
            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-all relative group flex flex-col justify-between h-full">
                <div class="absolute top-2 right-2 flex items-center gap-1 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity z-10">
                    <button type="button" onclick="openCategoryModal({{ $category->id }}, '{{ addslashes($category->name) }}')"
                        class="p-1 px-1.5 bg-white border border-gray-200 rounded shadow-sm text-gray-500 hover:text-blue-600 hover:border-blue-200 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button type="button" onclick="deleteCategory({{ $category->id }})"
                        class="p-1 px-1.5 bg-white border border-gray-200 rounded shadow-sm text-gray-500 hover:text-red-600 hover:border-red-200 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
                
                <div class="mt-2 mb-4 px-2">
                    <p class="text-base font-semibold text-gray-800" style="font-family:'Montserrat',sans-serif;">{{ $category->name }}</p>
                    <p class="text-xs text-gray-400 mt-1">Slug: {{ $category->slug }}</p>
                </div>
                
                <div class="px-2">
                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">
                        {{ $category->portfolios()->count() }} Portofolio
                    </span>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 text-center">
                <p class="text-sm text-gray-400">Belum ada Kategori. Klik "+ Tambah Kategori" untuk mulai.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- MODAL --}}
<div id="categoryModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 opacity-0 pointer-events-none transition-opacity">
    <div id="categoryModalInner" class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden transform scale-95 transition-transform">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-base font-semibold text-gray-900" id="categoryModalTitle">Tambah Kategori</h3>
            <button type="button" onclick="closeCategoryModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-6">
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Kategori <span class="text-red-500">*</span></label>
            <input type="text" id="category_name" class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 transition-colors" placeholder="e.g. Design">
        </div>
        <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-xl border-t border-gray-100">
            <button type="button" onclick="closeCategoryModal()" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800 font-medium transition-colors">Batal</button>
            <button type="button" onclick="submitCategoryForm()" class="px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">Simpan</button>
        </div>
    </div>
</div>

<form id="deleteCategoryForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@push('scripts')
<script>
    const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let currentCategoryId = null;

    function openCategoryModal(id = null, name = '') {
        currentCategoryId = id;
        document.getElementById('categoryModalTitle').textContent = id ? 'Edit Kategori' : 'Tambah Kategori';
        document.getElementById('category_name').value = name;
        
        const modal = document.getElementById('categoryModal');
        const inner = document.getElementById('categoryModalInner');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        inner.classList.remove('scale-95');
        document.body.style.overflow = 'hidden';
    }

    function closeCategoryModal() {
        const modal = document.getElementById('categoryModal');
        const inner = document.getElementById('categoryModalInner');
        modal.classList.add('opacity-0', 'pointer-events-none');
        inner.classList.add('scale-95');
        document.body.style.overflow = '';
    }

    async function submitCategoryForm() {
        const name = document.getElementById('category_name').value.trim();
        if(!name) { alert('Nama Kategori wajib diisi.'); return; }

        const fd = new FormData();
        fd.append('name', name);
        fd.append('_token', CSRF);

        let url, method = 'POST';
        if(currentCategoryId) {
            fd.append('_method', 'PUT');
            url = `{{ url('admin/portfolio/categories') }}/${currentCategoryId}`;
        } else {
            url = `{{ route('admin.portfolio.categories.store') }}`;
        }

        try {
            const resp = await fetch(url, {
                method: method,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: fd
            });
            if(resp.ok) {
                window.location.reload();
            } else {
                const errJson = await resp.json().catch(() => null);
                const msg = (errJson && (errJson.message || JSON.stringify(errJson.errors))) || 'Terjadi kesalahan.';
                alert('Error: ' + msg);
            }
        } catch(e) {
            alert('Kesalahan jaringan: ' + e.message);
        }
    }

    function deleteCategory(id) {
        if(!confirm('Yakin ingin menghapus kategori ini? Portofolio terkait juga mungkin terpengaruh jika tidak memiliki constraint yang tepat.')) return;
        const form = document.getElementById('deleteCategoryForm');
        form.action = `{{ url('admin/portfolio/categories') }}/${id}`;
        form.submit();
    }
</script>
@endpush
@endsection
