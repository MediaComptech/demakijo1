@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

{{-- STAT CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card border-0 rounded-3 text-white h-100" style="background: linear-gradient(135deg,#1a73e8,#0d47a1);">
            <div class="card-body d-flex align-items-center justify-content-between py-3 px-4">
                <div>
                    <div class="fs-2 fw-bold">{{ $stats['siswa'] }}</div>
                    <div class="small">Total Siswa</div>
                </div>
                <i class="fas fa-user-graduate fa-2x opacity-75"></i>
            </div>
            <a href="{{ url('admin.siswa.index') }}" class="card-footer text-white-50 small text-decoration-none border-0 py-2 px-4 d-flex align-items-center justify-content-between" style="background:rgba(0,0,0,0.15);">
                <span>Lihat Data Siswa</span><i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 rounded-3 text-white h-100" style="background: linear-gradient(135deg,#2e7d32,#1b5e20);">
            <div class="card-body d-flex align-items-center justify-content-between py-3 px-4">
                <div>
                    <div class="fs-2 fw-bold">{{ $stats['guru'] }}</div>
                    <div class="small">Guru & Tendik</div>
                </div>
                <i class="fas fa-chalkboard-teacher fa-2x opacity-75"></i>
            </div>
            <a href="{{ url('admin.guru.index') }}" class="card-footer text-white-50 small text-decoration-none border-0 py-2 px-4 d-flex align-items-center justify-content-between" style="background:rgba(0,0,0,0.15);">
                <span>Lihat Data Guru</span><i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 rounded-3 text-white h-100" style="background: linear-gradient(135deg,#f57c00,#e65100);">
            <div class="card-body d-flex align-items-center justify-content-between py-3 px-4">
                <div>
                    <div class="fs-2 fw-bold">{{ $stats['berita'] }}</div>
                    <div class="small">Total Berita</div>
                </div>
                <i class="fas fa-newspaper fa-2x opacity-75"></i>
            </div>
            <a href="{{ url('admin.berita.index') }}" class="card-footer text-white-50 small text-decoration-none border-0 py-2 px-4 d-flex align-items-center justify-content-between" style="background:rgba(0,0,0,0.15);">
                <span>Lihat Berita</span><i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 rounded-3 text-white h-100" style="background: linear-gradient(135deg,#c62828,#b71c1c);">
            <div class="card-body d-flex align-items-center justify-content-between py-3 px-4">
                <div>
                    <div class="fs-2 fw-bold">{{ $stats['ppdb'] }}</div>
                    <div class="small">Pendaftar PPDB</div>
                </div>
                <i class="fas fa-user-plus fa-2x opacity-75"></i>
            </div>
            <a href="{{ url('admin.ppdb.index') }}" class="card-footer text-white-50 small text-decoration-none border-0 py-2 px-4 d-flex align-items-center justify-content-between" style="background:rgba(0,0,0,0.15);">
                <span>Lihat PPDB</span><i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

{{-- ROW 2: More stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card border-0 rounded-3 shadow-sm text-center py-3">
            <div class="text-warning fs-3 fw-bold">{{ $stats['prestasi'] }}</div>
            <div class="text-muted small">Prestasi</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 rounded-3 shadow-sm text-center py-3">
            <div class="text-primary fs-3 fw-bold">{{ $stats['pengumuman'] }}</div>
            <div class="text-muted small">Pengumuman</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 rounded-3 shadow-sm text-center py-3">
            <div class="text-success fs-3 fw-bold">{{ $stats['fasilitas'] }}</div>
            <div class="text-muted small">Fasilitas</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card border-0 rounded-3 shadow-sm text-center py-3 @if($stats['alumni_baru'] > 0) border-danger @endif">
            <div class="text-danger fs-3 fw-bold">{{ $stats['alumni_baru'] }}</div>
            <div class="text-muted small">Alumni Belum Verifikasi</div>
            @if($stats['alumni_baru'] > 0)
                <a href="{{ url('admin.alumni.index') }}" class="btn btn-danger btn-sm mt-2 mx-3">Verifikasi</a>
            @endif
        </div>
    </div>
</div>

{{-- ROW 3: Recent activity --}}
<div class="row g-4">
    {{-- Recent PPDB --}}
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="fas fa-user-plus text-danger me-2"></i>Pendaftar PPDB Terbaru</h6>
                <a href="{{ url('admin.ppdb.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light"><tr><th>Nama</th><th>Asal Sekolah</th><th>Status</th></tr></thead>
                    <tbody>
                    @forelse($recent_ppdb as $p)
                    <tr>
                        <td class="fw-bold">{{ $p->nama_lengkap }}</td>
                        <td class="text-muted small">{{ $p->asal_sekolah }}</td>
                        <td>@php $s=$p->status_verifikasi??'Baru';$c=$s=='Diterima'?'success':($s=='Ditolak'?'danger':'secondary'); @endphp
                            <span class="badge bg-{{$c}}">{{$s}}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">Belum ada pendaftar.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent Alumni Baru --}}
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="fas fa-bell text-warning me-2"></i>Alumni Perlu Verifikasi
                    @if($stats['alumni_baru'] > 0)
                        <span class="badge bg-danger ms-1">{{ $stats['alumni_baru'] }}</span>
                    @endif
                </h6>
                <a href="{{ url('admin.alumni.index') }}" class="btn btn-sm btn-outline-secondary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light"><tr><th>Nama</th><th>Lulus</th><th>Aksi</th></tr></thead>
                    <tbody>
                    @forelse($recent_alumni as $al)
                    <tr>
                        <td class="fw-bold">{{ $al->nama }}</td>
                        <td><span class="badge bg-warning text-dark">{{ $al->tahun_lulus }}</span></td>
                        <td><a href="{{ route('admin.alumni.edit', $al->id) }}" class="btn btn-xs btn-success btn-sm">Verifikasi</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted py-3">Semua alumni sudah terverifikasi.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent Berita --}}
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="fas fa-newspaper text-primary me-2"></i>Berita Terbaru</h6>
                <a href="{{ url('admin.berita.index') }}" class="btn btn-sm btn-outline-secondary">Kelola Berita</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light"><tr><th>Judul</th><th>Kategori</th><th>Status</th><th>Tanggal</th></tr></thead>
                    <tbody>
                    @forelse($recent_berita as $b)
                    <tr>
                        <td class="fw-bold">{{ $b->judul }}</td>
                        <td class="text-muted small">{{ $b->kategori->nama ?? '-' }}</td>
                        <td>@if($b->is_published)<span class="badge bg-success">Publikasi</span>@else<span class="badge bg-secondary">Draft</span>@endif</td>
                        <td class="text-muted small">{{ $b->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Belum ada berita.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection