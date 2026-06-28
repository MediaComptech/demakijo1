@extends('publik.layout', ['title' => 'Prestasi Sekolah', 'header_title' => 'Prestasi Membanggakan', 'custom_css' => "
    /* ===== PRESTASI PAGE ===== */
    .filter-chip { display:inline-flex; align-items:center; gap:6px; padding:8px 18px; border-radius:50px; border:1.5px solid #dee2e6; background:#fff; font-size:.875rem; font-weight:600; color:#555; cursor:pointer; transition:all .2s; text-decoration:none; }
    .filter-chip:hover { border-color:#0056b3; color:#0056b3; background:#f0f6ff; }
    .filter-chip.active { background:#0056b3; border-color:#0056b3; color:#fff; }

    /* Prestasi Card */
    .prestasi-card { background:#fff; border-radius:14px; border:1px solid #e8edf3; box-shadow:0 2px 12px rgba(0,0,0,.07); padding:22px; position:relative; overflow:hidden; transition:transform .25s, box-shadow .25s; display:flex; flex-direction:column; height:100%; }
    .prestasi-card:hover { transform:translateY(-4px); box-shadow:0 10px 28px rgba(0,0,0,.13); }

    /* Dekorasi sudut */
    .deco-star { position:absolute; top:12px; left:14px; width:10px; height:10px; background:#28a745; border-radius:50%; opacity:.6; }
    .deco-dot { position:absolute; bottom:16px; left:14px; width:7px; height:7px; background:#ffc107; border-radius:50%; opacity:.7; }

    /* Medali badge */
    .medal-badge { position:absolute; top:14px; right:14px; width:38px; height:48px; background:url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 40 50\"><ellipse cx=\"20\" cy=\"20\" rx=\"18\" ry=\"18\" fill=\"%23ffc107\"/><text x=\"50%%\" y=\"55%%\" text-anchor=\"middle\" dominant-baseline=\"middle\" font-size=\"16\" font-weight=\"bold\" fill=\"white\">1</text><polygon points=\"20,38 8,50 20,44 32,50\" fill=\"%23cc9900\"/></svg>') center/contain no-repeat; }

    .prestasi-icon-wrap { width:64px; height:64px; background:#e8f0fe; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-bottom:0; }
    .prestasi-icon-wrap i { color:#0056b3; font-size:1.6rem; }
    .prestasi-content { flex:1; }
    .prestasi-title { font-size:1rem; font-weight:700; color:#1a1a1a; margin:0 0 6px; line-height:1.3; }
    .tingkat-badge { display:inline-block; font-size:.72rem; font-weight:600; color:#0056b3; margin-bottom:8px; }
    .prestasi-desc { font-size:.82rem; color:#666; line-height:1.6; margin-bottom:12px; }
    .prestasi-date { font-size:.77rem; color:#888; display:flex; align-items:center; gap:5px; margin-bottom:14px; }
    .btn-detail-link { display:inline-flex; align-items:center; gap:6px; border:1.5px solid #dee2e6; border-radius:8px; padding:6px 16px; font-size:.8rem; font-weight:600; color:#333; text-decoration:none; transition:all .2s; }
    .btn-detail-link:hover { border-color:#0056b3; color:#0056b3; background:#f0f6ff; }

    /* Pagination */
    .custom-pagination { display:flex; justify-content:center; align-items:center; gap:6px; margin-top:32px; }
    .page-btn { width:36px; height:36px; border-radius:8px; border:1.5px solid #dee2e6; background:#fff; display:inline-flex; align-items:center; justify-content:center; font-size:.85rem; font-weight:600; color:#555; cursor:pointer; text-decoration:none; transition:all .2s; }
    .page-btn:hover { border-color:#0056b3; color:#0056b3; }
    .page-btn.active { background:#0056b3; border-color:#0056b3; color:#fff; }
    .page-btn.arrow { color:#888; }
"])
@section('content')

<!-- Filter Chips + Sort -->
<div class="d-flex flex-wrap align-items-center gap-2 mb-4">
    <a href="#" class="filter-chip active"><i class="fas fa-th-large"></i> Semua Prestasi</a>
    <a href="#" class="filter-chip"><i class="fas fa-graduation-cap"></i> Akademik</a>
    <a href="#" class="filter-chip"><i class="fas fa-running"></i> Olahraga</a>
    <a href="#" class="filter-chip"><i class="fas fa-music"></i> Seni & Budaya</a>
    <a href="#" class="filter-chip"><i class="fas fa-ellipsis-h"></i> Lainnya</a>
    <div class="ms-auto">
        <select style="border:1.5px solid #dee2e6;border-radius:8px;padding:5px 12px;font-size:.82rem;font-weight:600;color:#444;background:#fff;">
            <option>Terbaru</option>
            <option>Terlama</option>
        </select>
    </div>
</div>

<!-- Prestasi Grid 2-kolom -->
<div class="row g-3">
    @forelse($prestasi as $item)
    <div class="col-md-6" data-aos="fade-up">
        <div class="prestasi-card">
            <!-- Dekorasi -->
            <span class="deco-star"></span>
            <span class="deco-dot"></span>
            <!-- Badge medali -->
            <div class="medal-badge" title="Juara 1"></div>

            <div class="d-flex gap-3 align-items-start">
                <!-- Ikon piala -->
                <div class="prestasi-icon-wrap">
                    <i class="fas fa-trophy"></i>
                </div>

                <!-- Konten -->
                <div class="prestasi-content">
                    <h5 class="prestasi-title">{{ $item->judul }}</h5>
                    <div class="tingkat-badge">Tingkat: {{ $item->tingkat }}</div>
                    @if(!empty($item->deskripsi))
                    <p class="prestasi-desc">{{ Str::limit($item->deskripsi, 120) }}</p>
                    @endif
                    <div class="prestasi-date">
                        <i class="far fa-calendar-alt text-warning"></i>
                        {{ date('d M Y', strtotime($item->tanggal)) }}
                    </div>
                    <a href="#" class="btn-detail-link">Lihat Detail <i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <i class="fas fa-trophy fa-3x mb-3 d-block" style="color:#dee2e6;"></i>
        <p class="text-muted fs-5">Belum ada data prestasi.</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($prestasi->count() > 0)
<div class="custom-pagination">
    <a href="#" class="page-btn arrow"><i class="fas fa-chevron-left"></i></a>
    <a href="#" class="page-btn active">1</a>
    <a href="#" class="page-btn arrow"><i class="fas fa-chevron-right"></i></a>
</div>
@endif

@endsection