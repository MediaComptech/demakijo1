@extends('publik.layout', ['title' => $item->judul])
@section('content')
<div class="row g-5">
    {{-- Main Content --}}
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            @if($item->gambar)
                <img src="{{ asset('storage/'.$item->gambar) }}" class="card-img-top w-100" style="max-height:400px;object-fit:cover;" loading="lazy" alt="{{ $item->judul }}">
            @endif
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
                    <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold">
                        {{ $item->kategori->nama ?? 'Umum' }}
                    </span>
                    <small class="text-muted"><i class="far fa-calendar-alt text-warning me-1"></i>{{ $item->created_at->format('d M Y') }}</small>
                </div>
                <h1 class="h2 fw-bold text-dark mb-4">{{ $item->judul }}</h1>
                <div class="text-muted" style="line-height:1.9;font-size:1.05rem;">
                    {!! nl2br(e($item->konten)) !!}
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="/berita" class="btn btn-outline-primary rounded-pill"><i class="fas fa-arrow-left me-2"></i>Kembali ke Berita</a>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold text-primary mb-3"><i class="fas fa-newspaper me-2"></i>Berita Terkait</h5>
                @forelse($related as $r)
                <a href="/berita/{{ $r->slug }}" class="d-flex align-items-start text-decoration-none mb-3 pb-3 border-bottom">
                    @if($r->gambar)
                        <img src="{{ asset('storage/'.$r->gambar) }}" loading="lazy" style="width:70px;height:55px;object-fit:cover;border-radius:8px;flex-shrink:0;" class="me-3">
                    @else
                        <div class="me-3 bg-light d-flex align-items-center justify-content-center rounded" style="width:70px;height:55px;flex-shrink:0;">
                            <i class="fas fa-newspaper text-muted"></i>
                        </div>
                    @endif
                    <div>
                        <div class="text-dark fw-semibold small">{{ \Illuminate\Support\Str::limit($r->judul, 65) }}</div>
                        <small class="text-muted">{{ $r->created_at->format('d M Y') }}</small>
                    </div>
                </a>
                @empty
                <p class="text-muted small">Tidak ada berita terkait.</p>
                @endforelse
            </div>
        </div>

        {{-- Quick Links --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold text-primary mb-3"><i class="fas fa-link me-2"></i>Menu Cepat</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0"><a href="/berita" class="text-decoration-none text-dark"><i class="fas fa-chevron-right text-warning me-2 small"></i>Semua Berita</a></li>
                    <li class="list-group-item px-0"><a href="/prestasi" class="text-decoration-none text-dark"><i class="fas fa-chevron-right text-warning me-2 small"></i>Prestasi Sekolah</a></li>
                    <li class="list-group-item px-0"><a href="/agenda" class="text-decoration-none text-dark"><i class="fas fa-chevron-right text-warning me-2 small"></i>Agenda Kegiatan</a></li>
                    <li class="list-group-item px-0"><a href="/unduhan" class="text-decoration-none text-dark"><i class="fas fa-chevron-right text-warning me-2 small"></i>Dokumen Unduhan</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
