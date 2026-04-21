@extends('admin.layouts.finance')
@section('title', 'Data Project Keuangan')
@section('page-title', 'Data Project')

@section('content')
<div class="row-between mb-24">
  <div>
    <div style="font-size:20px;font-weight:800;color:var(--text);letter-spacing:-.5px">Data Project Keuangan</div>
    <div class="muted small mt-8">Pantau status, harga modal, harga jual, dan laba project.</div>
  </div>
  <button onclick="openM('mCreate')" class="btn btn-primary">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Tambah Project Baru
  </button>
</div>

<div class="g4 mb-24">
  <div class="card">
    <div class="card-bd">
      <div class="muted small fw-600 mb-8 uppercase">Total Project</div>
      <div style="font-size:24px;font-weight:800;color:var(--text)">{{ $stats['total'] }}</div>
    </div>
  </div>
  <div class="card">
    <div class="card-bd">
      <div class="muted small fw-600 mb-8 uppercase" style="color:#2563eb">Belum Mulai</div>
      <div style="font-size:24px;font-weight:800;color:#2563eb">{{ $stats['belum_mulai'] }}</div>
    </div>
  </div>
  <div class="card">
    <div class="card-bd">
      <div class="muted small fw-600 mb-8 uppercase" style="color:#f59e0b">Berlangsung</div>
      <div style="font-size:24px;font-weight:800;color:#f59e0b">{{ $stats['berlangsung'] }}</div>
    </div>
  </div>
  <div class="card">
    <div class="card-bd">
      <div class="muted small fw-600 mb-8 uppercase" style="color:#10b981">Selesai</div>
      <div style="font-size:24px;font-weight:800;color:#10b981">{{ $stats['selesai'] }}</div>
    </div>
  </div>
</div>

<div class="card mb-24" style="background:#fffaf0; border-color:#fef08a;">
  <div class="card-bd flex gap-24" style="justify-content:space-around; flex-wrap:wrap;">
      <div style="text-align:center;">
          <div class="muted small fw-600 uppercase mb-4" style="color:#dc2626">Total Harga Modal</div>
          <div style="font-size:18px;font-weight:800;color:#dc2626">Rp {{ number_format($financialStats['cost'],0,',','.') }}</div>
      </div>
      <div style="text-align:center;">
          <div class="muted small fw-600 uppercase mb-4" style="color:#2563eb">Total Harga Jual</div>
          <div style="font-size:18px;font-weight:800;color:#2563eb">Rp {{ number_format($financialStats['revenue'],0,',','.') }}</div>
      </div>
      <div style="text-align:center;">
          <div class="muted small fw-600 uppercase mb-4" style="color:#16a34a">Estimasi Laba</div>
          <div style="font-size:18px;font-weight:800;color:#16a34a">Rp {{ number_format($financialStats['profit'],0,',','.') }}</div>
      </div>
  </div>
</div>

<form method="GET" style="display:flex;gap:8px;margin-bottom:16px;align-items:center;flex-wrap:wrap">
  <div class="search-bar" style="width:280px;">
    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama project...">
  </div>
  <select name="status" class="fi" style="width:auto">
    <option value="all">Semua Status</option>
    <option value="belum_mulai" {{ request('status') === 'belum_mulai' ? 'selected' : '' }}>Belum Mulai</option>
    <option value="berlangsung" {{ request('status') === 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
  </select>
  <button type="submit" class="btn btn-outline">Filter</button>
  @if(request('search') || request('status'))
  <a href="{{ route('admin.finance.projects.index') }}" class="btn btn-ghost">Reset</a>
  @endif
</form>

<div class="card">
  <div class="card-bd" style="padding:0">
    <table class="tbl">
      <thead>
        <tr>
          <th>Tgl Project</th>
          <th>Nama Project</th>
          <th class="tbl-right">Harga Modal</th>
          <th class="tbl-right">Harga Jual</th>
          <th class="tbl-right">Laba</th>
          <th class="tbl-center">Status</th>
          <th class="tbl-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($projects as $p)
      <tr>
        <td class="muted nowrap">{{ $p->project_date?->format('d M Y') }}</td>
        <td>
          <div class="semibold" style="color:var(--text)">{{ $p->project_name }}</div>
        </td>
        <td class="tbl-right" style="color:#ef4444">Rp {{ number_format($p->capital_price,0,',','.') }}</td>
        <td class="tbl-right" style="color:#2563eb">Rp {{ number_format($p->selling_price,0,',','.') }}</td>
        <td class="tbl-right semibold" style="color:{{ $p->profit >= 0 ? '#10b981' : '#ef4444' }}">
          Rp {{ number_format($p->profit,0,',','.') }}
        </td>
        <td class="tbl-center">
            @php
            $bg = match($p->status) {
                'belum_mulai' => '#eff6ff',
                'berlangsung' => '#fffbeb',
                'selesai' => '#ecfdf5',
                default => '#f1f5f9',
            };
            $color = match($p->status) {
                'belum_mulai' => '#2563eb',
                'berlangsung' => '#d97706',
                'selesai' => '#059669',
                default => '#64748b',
            };
            @endphp
            <span class="tag" style="background:{{ $bg }};color:{{ $color }}">{{ $p->status_label }}</span>
        </td>
        <td class="tbl-center">
          <div class="row" style="justify-content:center;gap:4px">
            <button onclick='openM("mEdit{{ $p->id }}")' class="btn btn-xs btn-outline">Edit</button>
            <form action="{{ route('admin.finance.projects.destroy',$p) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus project ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-xs btn-danger">Hapus</button>
            </form>
          </div>
        </td>
      </tr>

      {{-- Edit Modal --}}
      <div id="mEdit{{ $p->id }}" class="modal-wrap">
        <div class="modal">
          <div class="modal-hd">
            <div class="modal-title">Edit Project Keuangan</div>
            <button class="modal-x" type="button" onclick="closeM('mEdit{{ $p->id }}')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
          </div>
          <form action="{{ route('admin.finance.projects.update',$p) }}" method="POST">
            @csrf @method('PUT')
            <div class="modal-bd">
              <div class="g2">
                <div class="fi-grp gc2"><label class="fl">Nama Project</label><input type="text" name="project_name" class="fi" required value="{{ $p->project_name }}"></div>
                <div class="fi-grp"><label class="fl">Tanggal Terlaksana</label><input type="date" name="project_date" class="fi" required value="{{ $p->project_date->format('Y-m-d') }}"></div>
                <div class="fi-grp"><label class="fl">Status Progress</label>
                  <select name="status" class="fi" required>
                    <option value="belum_mulai" {{ $p->status === 'belum_mulai' ? 'selected' : '' }}>Belum Mulai</option>
                    <option value="berlangsung" {{ $p->status === 'berlangsung' ? 'selected' : '' }}>Berlangsung</option>
                    <option value="selesai" {{ $p->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                  </select>
                </div>
                <div class="fi-grp"><label class="fl">Harga Modal (Rp)</label><input type="number" name="capital_price" class="fi" required value="{{ floatval($p->capital_price) }}"></div>
                <div class="fi-grp"><label class="fl">Harga Jual (Rp)</label><input type="number" name="selling_price" class="fi" required value="{{ floatval($p->selling_price) }}"></div>
              </div>
            </div>
            <div class="modal-ft">
              <button type="button" class="btn btn-outline" onclick="closeM('mEdit{{ $p->id }}')">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
          </form>
        </div>
      </div>
      @empty
      <tr><td colspan="7">
        <div class="empty-state">
          <div class="empty-state-ico">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
          </div>
          <p>Belum ada data project.</p>
          <button onclick="openM('mCreate')" class="btn btn-primary btn-sm">Tambah Project Pertama</button>
        </div>
      </td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($projects->hasPages())<div style="padding:12px 16px;border-top:1px solid var(--border-l)">{{ $projects->links() }}</div>@endif
</div>

{{-- Create Modal --}}
<div id="mCreate" class="modal-wrap">
  <div class="modal">
    <div class="modal-hd">
      <div class="modal-title">Tambah Project Laba/Rugi</div>
      <button class="modal-x" type="button" onclick="closeM('mCreate')"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
    </div>
    <form action="{{ route('admin.finance.projects.store') }}" method="POST">
      @csrf
      <div class="modal-bd">
        <div class="g2">
          <div class="fi-grp gc2"><label class="fl">Nama Project</label><input type="text" name="project_name" class="fi" required placeholder="Cth: Wedding Pak Budi"></div>
          <div class="fi-grp"><label class="fl">Tanggal Project</label><input type="date" name="project_date" class="fi" required value="{{ date('Y-m-d') }}"></div>
          <div class="fi-grp"><label class="fl">Status Progress</label>
            <select name="status" class="fi" required>
              <option value="belum_mulai">Belum Mulai</option>
              <option value="berlangsung">Berlangsung</option>
              <option value="selesai">Selesai</option>
            </select>
          </div>
          <div class="fi-grp"><label class="fl">Harga Modal (Rp)</label><input type="number" name="capital_price" class="fi" required placeholder="0"></div>
          <div class="fi-grp"><label class="fl">Harga Jual (Rp)</label><input type="number" name="selling_price" class="fi" required placeholder="0"></div>
        </div>
      </div>
      <div class="modal-ft">
        <button type="button" class="btn btn-outline" onclick="closeM('mCreate')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Project</button>
      </div>
    </form>
  </div>
</div>
@endsection
