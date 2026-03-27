@extends('admin.layouts.app')

@section('title', 'Kelola Mitra & Client Logos')
@section('page-title', 'Mitra (Clients)')

@section('content')

<div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-semibold text-gray-900">Daftar Mitra / Client</h2>
            <p class="text-xs text-gray-500">Logo client yang akan ditampilkan di tampilan Marquee homepage.</p>
        </div>
        <button type="button" onclick="openModal()" class="text-sm bg-orange-50 text-[#f97316] px-3 py-1.5 rounded-lg hover:bg-orange-100 font-medium transition-colors">
            + Tambah Logo Mitra
        </button>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @forelse($clients as $client)
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 shadow-sm relative group flex flex-col items-center justify-center aspect-square">
                {{-- Actions --}}
                <div class="absolute top-2 right-2 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                    <button type="button" onclick='openModal({{ $client->id }}, {{ json_encode($client->name) }}, "{{ asset("storage/".$client->logo) }}", {{ $client->is_visible ? "true" : "false" }})' class="p-1.5 bg-white border border-gray-200 rounded-lg shadow-sm text-gray-600 hover:text-[#f97316]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </button>
                    <button type="button" onclick="deleteClient({{ $client->id }})" class="p-1.5 bg-white border border-gray-200 rounded-lg shadow-sm text-gray-600 hover:text-red-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>

                <div class="w-full flex-1 flex items-center justify-center p-2">
                    <img src="{{ asset('storage/'.$client->logo) }}" alt="{{ $client->name }}" class="max-w-full max-h-full object-contain filter grayscale hover:grayscale-0 transition-all duration-300 {{ !$client->is_visible ? 'opacity-40' : '' }}">
                </div>
                
                <div class="w-full mt-2 text-center border-t border-gray-200 pt-2">
                    <h3 class="text-xs font-bold text-gray-900 truncate">{{ $client->name }}</h3>
                    <span class="text-[10px] {{ $client->is_visible ? 'text-green-600' : 'text-red-500' }}">{{ $client->is_visible ? 'Ditampilkan' : 'Disembunyikan' }}</span>
                </div>
            </div>
            @empty
                <div class="col-span-2 md:col-span-4 lg:col-span-5 py-10 text-center">
                    <p class="text-sm text-gray-400">Belum ada mitra. Klik "+ Tambah Logo Mitra" untuk mulai menambahkan.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

{{-- MODAL --}}
<div id="clientModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 hidden">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden">
        <form id="clientForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                <h3 class="font-semibold text-gray-900" id="modalTitle">Tambah Logo Mitra</h3>
                <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>
            
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Mitra / Client</label>
                    <input type="text" name="name" id="client_name" class="w-full rounded-lg border px-3 py-2 text-sm focus:ring-[#f97316]" required>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Logo (PNG transparan sangat disarankan)</label>
                    <input type="file" name="logo" id="client_logo" accept="image/*" class="w-full text-sm border rounded-lg p-2">
                    <p class="text-xs text-gray-400 mt-1" id="logo_help"></p>
                </div>

                <div class="flex items-center gap-2 mt-4">
                    <input type="checkbox" name="is_visible" id="client_visible" checked class="rounded border-gray-300 text-[#f97316] focus:ring-[#f97316]">
                    <label for="client_visible" class="text-sm text-gray-700">Tampilkan di Homepage</label>
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
    function openModal(id = null, name = '', logo = '', visible = true) {
        const form = document.getElementById('clientForm');
        document.getElementById('modalTitle').innerText = id ? 'Edit Mitra' : 'Tambah Mitra';
        document.getElementById('client_name').value = name;
        document.getElementById('client_visible').checked = visible;
        
        if (id) {
            form.action = `/admin/clients/${id}`;
            document.getElementById('formMethod').value = 'PUT';
            document.getElementById('logo_help').innerText = 'Biarkan kosong jika tidak ingin mengubah logo.';
            document.getElementById('client_logo').required = false;
        } else {
            form.action = `{{ route('admin.clients.store') }}`;
            document.getElementById('formMethod').value = 'POST';
            document.getElementById('logo_help').innerText = 'Wajib upload gambar baru.';
            document.getElementById('client_logo').required = true;
        }
        
        document.getElementById('clientModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('clientModal').classList.add('hidden');
    }

    function deleteClient(id) {
        if (!confirm('Yakin ingin menghapus mitra ini?')) return;
        const form = document.getElementById('deleteForm');
        form.action = `/admin/clients/${id}`;
        form.submit();
    }
</script>

@endsection
