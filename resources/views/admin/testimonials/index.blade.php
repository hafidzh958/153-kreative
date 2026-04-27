@extends('admin.layouts.app')

@section('title', 'Kelola Testimonial')
@section('page-title', 'Testimonial')

@section('content')

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-semibold text-gray-900">Daftar Testimonial Klien</h2>
            <p class="text-xs text-gray-500">Review dan cerita pengalaman dari klien-klien 153 Kreatif.</p>
        </div>
        <button type="button" onclick="openModal()" class="text-sm bg-orange-50 text-[#f97316] px-3 py-1.5 rounded-lg hover:bg-orange-100 font-medium transition-colors">
            + Tambah Testimonial
        </button>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($testimonials as $testimonial)
            <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm relative group">
                <div class="absolute top-3 right-3 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button type="button" onclick='openModal({{ $testimonial->id }}, {{ json_encode($testimonial->client_name) }}, {{ json_encode($testimonial->client_position) }}, {{ json_encode($testimonial->quote) }}, {{ $testimonial->is_visible ? "true" : "false" }})' class="p-1 text-gray-500 hover:text-orange-500 bg-gray-100 rounded">✎</button>
                    <button type="button" onclick="deleteTesti({{ $testimonial->id }})" class="p-1 text-gray-500 hover:text-red-500 bg-gray-100 rounded">✗</button>
                </div>

                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 overflow-hidden">
                        <svg class="w-8 h-8 mt-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm text-gray-900">{{ $testimonial->client_name }}</h4>
                        <p class="text-xs text-gray-500">{{ $testimonial->client_position ?? 'Client' }}</p>
                    </div>
                </div>
                <div class="relative">
                    <svg class="absolute -top-2 -left-2 w-6 h-6 text-gray-100 transform -scale-y-100" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/></svg>
                    <p class="text-sm text-gray-600 italic relative z-10 leading-relaxed pl-4">{{ $testimonial->quote }}</p>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between items-center">
                    <span class="text-[10px] {{ $testimonial->is_visible ? 'text-green-600' : 'text-red-500' }} border {{ $testimonial->is_visible ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }} px-2 py-0.5 rounded-full">
                        {{ $testimonial->is_visible ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </div>
            </div>
            @empty
                <div class="col-span-full py-10 text-center">
                    <p class="text-sm text-gray-400">Belum ada testimonial.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- MODAL --}}
<div id="testiModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden">
        <form id="testiForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                <h3 class="font-semibold text-gray-900" id="modalTitle">Tambah Testimonial</h3>
                <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama Klien <span class="text-red-500">*</span></label>
                        <input type="text" name="client_name" id="client_name" class="w-full rounded-lg border px-3 py-2 text-sm focus:ring-[#f97316]" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Posisi / Instansi</label>
                        <input type="text" name="client_position" id="client_position" class="w-full rounded-lg border px-3 py-2 text-sm focus:ring-[#f97316]">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Kutipan Review (Quote) <span class="text-red-500">*</span></label>
                    <textarea name="quote" id="client_quote" rows="4" class="w-full rounded-lg border px-3 py-2 text-sm focus:ring-[#f97316]" required></textarea>
                </div>


                <div class="flex items-center gap-2 mt-4 inline-flex">
                    <input type="checkbox" name="is_visible" id="client_visible" checked class="rounded border-gray-300 text-[#f97316] focus:ring-[#f97316]">
                    <label for="client_visible" class="text-sm font-medium text-gray-700 select-none">Tampilkan di Halaman Utama</label>
                </div>
            </div>

            <div class="px-6 py-4 border-t flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-[#f97316] hover:bg-orange-600 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    function openModal(id = null, name = '', pos = '', quote = '', visible = true) {
        const form = document.getElementById('testiForm');
        document.getElementById('modalTitle').innerText = id ? 'Edit Testimonial' : 'Tambah Testimonial';
        document.getElementById('client_name').value = name;
        document.getElementById('client_position').value = pos;
        document.getElementById('client_quote').value = quote;
        document.getElementById('client_visible').checked = visible;
        
        if (id) {
            form.action = `/admin/testimonials/${id}`;
            document.getElementById('formMethod').value = 'PUT';
        } else {
            form.action = `{{ route('admin.testimonials.store') }}`;
            document.getElementById('formMethod').value = 'POST';
        }
        
        document.getElementById('testiModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('testiModal').classList.add('hidden');
    }

    function deleteTesti(id) {
        if (!confirm('Yakin ingin menghapus review testimonial ini?')) return;
        const form = document.getElementById('deleteForm');
        form.action = `/admin/testimonials/${id}`;
        form.submit();
    }
</script>

@endsection
