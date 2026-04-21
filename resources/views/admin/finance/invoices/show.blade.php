@extends('admin.layouts.finance')
@section('title', 'Invoice ' . $invoice->invoice_number)
@section('page-title', 'Detail Invoice')

@section('content')
    <div class="max-w-3xl">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.finance.invoices.index') }}" class="text-sm text-gray-500 hover:text-gray-700">←
                    Kembali</a>
                <span class="text-gray-300">/</span><span
                    class="text-sm font-medium text-gray-900">{{ $invoice->invoice_number }}</span>
            </div>
            <div class="flex gap-2" style="display:flex;gap:8px">
                <a href="{{ route('admin.finance.invoices.pdf', $invoice) }}" target="_blank" class="btn btn-outline"
                    style="padding:6px 12px">Cetak PDF</a>
                <a href="{{ route('admin.finance.invoices.edit', $invoice) }}" class="btn btn-outline"
                    style="padding:6px 12px">Edit</a>
                @if($invoice->status === 'draft')
                    <form action="{{ route('admin.finance.invoices.status', $invoice) }}" method="POST" style="display:inline">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="sent">
                        <button type="submit"
                            class="px-4 py-2 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600">Kirim Invoice</button>
                    </form>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700">{{ session('success') }}
            </div>
        @endif

        <div class="bg-white border border-gray-200 rounded-xl p-6">
            {{-- Invoice Header --}}
            <div class="flex items-start justify-between pb-6 border-b border-gray-100">
                <div>
                    <h1 class="text-2xl font-black text-gray-900">INVOICE</h1>
                    <p class="font-mono text-orange-600 font-semibold text-lg mt-1">{{ $invoice->invoice_number }}</p>
                </div>
                <div class="text-right">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm font-semibold
                    {{ match ($invoice->status) { 'paid' => 'bg-green-100 text-green-800', 'sent' => 'bg-blue-100 text-blue-800', 'draft' => 'bg-gray-100 text-gray-800', 'overdue' => 'bg-red-100 text-red-800', 'partial' => 'bg-orange-100 text-orange-800', default => 'bg-gray-100 text-gray-800'} }}">
                        {{ $invoice->status_label }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 py-5">
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-400 font-semibold mb-2">Klien</p>
                    <p class="font-bold text-gray-900">{{ $invoice->client_name }}</p>
                    @if($invoice->client_email)
                    <p class="text-sm text-gray-500">{{ $invoice->client_email }}</p>@endif
                    @if($invoice->client_phone)
                    <p class="text-sm text-gray-500">{{ $invoice->client_phone }}</p>@endif
                    @if($invoice->event_name)
                    <p class="text-sm mt-2 font-medium text-gray-700">📅 {{ $invoice->event_name }}</p>@endif
                </div>
                <div class="text-right">
                    <p class="text-xs uppercase tracking-wide text-gray-400 font-semibold mb-2">Info Invoice</p>
                    <div class="space-y-1 text-sm">
                        <div class="flex justify-end gap-6"><span class="text-gray-500">Tanggal</span><span
                                class="font-medium text-gray-900">{{ $invoice->date?->format('d F Y') }}</span></div>
                        <div class="flex justify-end gap-6"><span class="text-gray-500">Jatuh Tempo</span><span
                                class="font-medium {{ $invoice->status === 'overdue' ? 'text-red-600' : 'text-gray-900' }}">{{ $invoice->due_date?->format('d F Y') }}</span>
                        </div>
                        @if($invoice->bank_account)
                            <div class="flex justify-end gap-6"><span class="text-gray-500">Bank</span><span
                        class="font-medium text-gray-900 text-xs">{{ $invoice->bank_account }}</span></div>@endif
                    </div>
                </div>
            </div>

            {{-- Amount Summary --}}
            <div class="p-4 bg-gray-50 rounded-xl space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-600">Subtotal</span><span class="font-medium">Rp
                        {{ number_format($invoice->subtotal, 0, ',', '.') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-600">PPN ({{ $invoice->tax_rate }}%)</span><span
                        class="font-medium">Rp {{ number_format($invoice->tax_amount, 0, ',', '.') }}</span></div>
                <div class="flex justify-between text-base font-bold border-t border-gray-200 pt-2"><span>Total</span><span
                        class="text-orange-600">Rp {{ number_format($invoice->total, 0, ',', '.') }}</span></div>
                @if($invoice->paid_amount > 0)
                    <div class="flex justify-between border-t border-gray-200 pt-2"><span class="text-gray-600">Sudah
                            Dibayar</span><span class="font-semibold text-green-600">Rp
                            {{ number_format($invoice->paid_amount, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between font-bold text-red-600"><span>Sisa Tagihan</span><span>Rp
                            {{ number_format($invoice->total - $invoice->paid_amount, 0, ',', '.') }}</span></div>
                @endif
            </div>

            @if($invoice->notes)
                <div class="mt-4 p-4 bg-amber-50 border border-amber-100 rounded-xl text-sm text-amber-800">
                    <strong>Catatan:</strong> {{ $invoice->notes }}
                </div>
            @endif
        </div>
    </div>
@endsection