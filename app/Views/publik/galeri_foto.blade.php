@extends('publik.layout', ['title' => 'Galeri Foto Kegiatan', 'header_title' => 'Galeri Foto Kegiatan', 'custom_css' => "
    /* ===== GALERI FOTO PAGE ===== */
    .filter-chip { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:50px; border:1.5px solid #dee2e6; background:#fff; font-size:0.875rem; font-weight:600; color:#555; cursor:pointer; transition:all .2s ease; text-decoration:none; }
    .filter-chip:hover { border-color:#0056b3; color:#0056b3; background:#f0f6ff; }
    .filter-chip.active { background:#0056b3; border-color:#0056b3; color:#fff; }
    .filter-chip i { font-size:0.85rem; }
    .gallery-toolbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:18px; }
    .gallery-toolbar h5 { font-size:1rem; font-weight:700; color:#0056b3; margin:0; display:flex; align-items:center; gap:8px; }
    .gallery-toolbar .sort-group { display:flex; align-items:center; gap:8px; }
    .sort-select { border:1.5px solid #dee2e6; border-radius:8px; padding:5px 12px; font-size:0.82rem; font-weight:600; color:#444; background:#fff; cursor:pointer; }
    .view-toggle-btn { width:34px; height:34px; border-radius:8px; border:1.5px solid #dee2e6; background:#fff; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; font-size:0.85rem; color:#666; transition:all .2s; }
    .view-toggle-btn.active { background:#0056b3; border-color:#0056b3; color:#fff; }

    /* Album Card */
    .album-grid { display:grid; grid-template-columns:repeat(4, 1fr); gap:16px; }
    .album-card { border-radius:12px; overflow:hidden; background:#1a1a1a; box-shadow:0 2px 10px rgba(0,0,0,0.10); transition:transform 0.28s, box-shadow 0.28s; cursor:pointer; text-decoration:none; display:block; }
    .album-card:hover { transform:translateY(-5px); box-shadow:0 10px 28px rgba(0,0,0,0.18); }
    .album-card .thumb-wrap { position:relative; height:160px; overflow:hidden; }
    .album-card .thumb-wrap img { width:100%; height:160px; object-fit:cover; display:block; transition:transform .4s; }
    .album-card:hover .thumb-wrap img { transform:scale(1.06); }
    .album-card .thumb-placeholder { width:100%; height:160px; background:linear-gradient(135deg,#1e3a5f,#2d6a9f); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,.3); }
    .badge-new { position:absolute; top:10px; left:10px; background:#ffc107; color:#333; font-size:0.7rem; font-weight:700; padding:3px 9px; border-radius:20px; z-index:2; }
    .badge-count-l { position:absolute; bottom:8px; left:8px; background:rgba(0,0,0,.6); color:#fff; font-size:0.7rem; padding:3px 8px; border-radius:12px; display:flex; align-items:center; gap:4px; }
    .badge-count-r { position:absolute; bottom:8px; right:8px; background:rgba(0,0,0,.6); color:#fff; font-size:0.7rem; padding:3px 8px; border-radius:12px; }
    .album-card .card-info { padding:10px 12px; background:#fff; }
    .album-card .card-info h6 { font-size:0.88rem; font-weight:700; color:#1a1a1a; margin:0 0 4px; }
    .album-card .card-info .meta { font-size:0.75rem; color:#888; display:flex; align-items:center; gap:5px; }

    /* Card Lihat Lainnya */
    .album-more-card { border-radius:12px; background:#e8f0fe; border:2px dashed #0056b3; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:8px; min-height:200px; cursor:pointer; transition:all .2s; text-decoration:none; }
    .album-more-card:hover { background:#d6e4ff; }
    .album-more-card .more-icon { width:48px; height:48px; background:#0056b3; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.1rem; }
    .album-more-card p { font-size:0.82rem; font-weight:600; color:#0056b3; text-align:center; margin:0; }

    /* Sidebar */
    .sidebar-card { background:#fff; border-radius:14px; border:1px solid #e8edf3; box-shadow:0 2px 10px rgba(0,0,0,.06); padding:18px; margin-bottom:18px; }
    .sidebar-card h6 { font-size:0.92rem; font-weight:700; color:#1a1a1a; margin-bottom:14px; }
    .stat-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    .stat-item { display:flex; align-items:center; gap:10px; }
    .stat-icon { width:38px; height:38px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1rem; flex-shrink:0; }
    .stat-icon.blue { background:#e8f0fe; color:#0056b3; }
    .stat-icon.green { background:#e8f9f0; color:#28a745; }
    .stat-icon.orange { background:#fff4e6; color:#fd7e14; }
    .stat-icon.purple { background:#f3e8fe; color:#6f42c1; }
    .stat-val { font-size:1.25rem; font-weight:800; color:#1a1a1a; line-height:1; }
    .stat-lbl { font-size:0.72rem; color:#888; }

    .popular-item { display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid #f0f2f5; }
    .popular-item:last-child { border-bottom:none; }
    .popular-thumb { width:52px; height:40px; object-fit:cover; border-radius:6px; flex-shrink:0; background:#e0e0e0; }
    .popular-title { font-size:0.82rem; font-weight:700; color:#1a1a1a; margin:0 0 2px; }
    .popular-meta { font-size:0.72rem; color:#888; }
    .btn-lihat-semua { display:block; text-align:center; padding:8px; border-radius:8px; border:1.5px solid #0056b3; color:#0056b3; font-size:0.82rem; font-weight:600; text-decoration:none; margin-top:12px; transition:all .2s; }
    .btn-lihat-semua:hover { background:#0056b3; color:#fff; }

    @media(max-width:768px){ .album-grid{ grid-template-columns:repeat(2,1fr); } }
    @media(max-width:480px){ .album-grid{ grid-template-columns:repeat(2,1fr); gap:10px; } }
"])
@section('content')

@php
    $totalFoto  = $album->sum(fn($a) => $a->galeri->count());
    $totalAlbum = $album->count();
    $popularAlbum = $album->sortByDesc(fn($a) => $a->galeri->count())->take(3);
@endphp

<div class="row g-4">
    <!-- MAIN COLUMN -->
    <div class="col-lg-8">
        <!-- Filter Chips -->
        <div class="d-flex flex-wrap gap-2 mb-4">
            <a href="#" class="filter-chip active"><i class="fas fa-th-large"></i> Semua Album</a>
            <a href="#" class="filter-chip"><i class="fas fa-school"></i> Kegiatan Sekolah</a>
            <a href="#" class="filter-chip"><i class="fas fa-running"></i> Ekstrakurikuler</a>
            <a href="#" class="filter-chip"><i class="fas fa-trophy"></i> Prestasi</a>
            <a href="#" class="filter-chip"><i class="fas fa-users"></i> Kunjungan</a>
            <a href="#" class="filter-chip"><i class="fas fa-ellipsis-h"></i> Lainnya</a>
        </div>

        <!-- Toolbar -->
        <div class="gallery-toolbar">
            <h5><i class="fas fa-images"></i> Album Foto</h5>
            <div class="sort-group">
                <select class="sort-select">
                    <option>Terbaru</option>
                    <option>Terlama</option>
                    <option>Terbanyak</option>
                </select>
                <button class="view-toggle-btn active" title="Grid"><i class="fas fa-th-large"></i></button>
                <button class="view-toggle-btn" title="List"><i class="fas fa-list"></i></button>
            </div>
        </div>

        <!-- Album Grid -->
        <div class="album-grid">
            @forelse($album as $idx => $item)
            @php
                $thumbnail = $item->galeri->first();
                $fotoCount = $item->galeri->count();
                $tgl = $item->created_at ? $item->created_at->format('d M Y') : '-';
                $isFirst = $idx === 0;
            @endphp

            @if($idx === 7)
            <!-- Card Lihat Album Lainnya -->
            <a href="#" class="album-more-card">
                <div class="more-icon"><i class="fas fa-plus"></i></div>
                <p>Lihat Album Lainnya</p>
                <p style="font-size:0.72rem; color:#0056b3; opacity:.7;">Jelajahi lebih banyak album kegiatan lainnya</p>
                <div style="width:38px;height:38px;background:#0056b3;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-arrow-right text-white" style="font-size:.85rem;"></i>
                </div>
            </a>
            @endif

            <a href="#" class="album-card" data-bs-toggle="modal" data-bs-target="#album-{{ $item->id }}">
                <div class="thumb-wrap">
                    @if($isFirst)
                    <span class="badge-new">Terbaru</span>
                    @endif

                    @if($thumbnail && $thumbnail->file)
                        <img src="{{ asset('storage/' . $thumbnail->file) }}" alt="{{ $item->nama }}" loading="lazy">
                    @else
                        <div class="thumb-placeholder"><i class="fas fa-images fa-2x"></i></div>
                    @endif

                    <span class="badge-count-l"><i class="fas fa-camera"></i> {{ $fotoCount }} Foto</span>
                    @if($fotoCount > 1)
                    <span class="badge-count-r">{{ $fotoCount }} Foto</span>
                    @endif
                </div>
                <div class="card-info">
                    <h6>{{ $item->nama }}</h6>
                    <div class="meta">
                        <i class="far fa-calendar-alt text-primary"></i>
                        {{ $tgl }}
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column:1/-1; text-align:center; padding:60px 20px; color:#aaa;">
                <i class="fas fa-images fa-3x mb-3 d-block opacity-25"></i>
                <h6 class="text-muted">Belum Ada Album Foto</h6>
                <p class="small text-muted">Album kegiatan sekolah akan segera ditambahkan.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- SIDEBAR KANAN -->
    <div class="col-lg-4">
        <!-- Statistik Galeri -->
        <div class="sidebar-card">
            <h6>Statistik Galeri</h6>
            <div class="stat-grid">
                <div class="stat-item">
                    <div class="stat-icon blue"><i class="fas fa-images"></i></div>
                    <div>
                        <div class="stat-val">{{ $totalAlbum }}</div>
                        <div class="stat-lbl">Album</div>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon green"><i class="fas fa-camera"></i></div>
                    <div>
                        <div class="stat-val">{{ $totalFoto }}</div>
                        <div class="stat-lbl">Foto</div>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon orange"><i class="fas fa-calendar-check"></i></div>
                    <div>
                        <div class="stat-val">{{ $album->count() > 0 ? $album->count() * 4 : 0 }}</div>
                        <div class="stat-lbl">Kegiatan</div>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon purple"><i class="fas fa-calendar-alt"></i></div>
                    <div>
                        <div class="stat-val">{{ date('Y') }}</div>
                        <div class="stat-lbl">Tahun Ini</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Album Populer -->
        <div class="sidebar-card">
            <h6>Album Populer</h6>
            @forelse($popularAlbum as $pop)
            @php
                $popThumb = $pop->galeri->first();
                $popCount = $pop->galeri->count();
                $popDate  = $pop->created_at ? $pop->created_at->format('d M Y') : '-';
            @endphp
            <div class="popular-item">
                @if($popThumb && $popThumb->file)
                    <img src="{{ asset('storage/' . $popThumb->file) }}" class="popular-thumb" alt="{{ $pop->nama }}" loading="lazy">
                @else
                    <div class="popular-thumb d-flex align-items-center justify-content-center" style="background:#e8f0fe;"><i class="fas fa-images text-primary" style="font-size:.8rem;"></i></div>
                @endif
                <div>
                    <div class="popular-title">{{ $pop->nama }}</div>
                    <div class="popular-meta"><i class="fas fa-camera me-1"></i>{{ $popCount }} Foto • {{ $popDate }}</div>
                </div>
            </div>
            @empty
            <p class="text-muted small">Belum ada album.</p>
            @endforelse
            <a href="#" class="btn-lihat-semua">Lihat Semua Album →</a>
        </div>
    </div>
</div>

<!-- Modals Lightbox Per Album -->
@foreach($album as $item)
@php $fotoCount = $item->galeri->count(); $tgl = $item->created_at ? $item->created_at->format('d M Y') : '-'; @endphp
<div class="modal fade" id="album-{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="modal-header py-3" style="background:linear-gradient(135deg,#003366,#0056b3);">
                <h5 class="modal-title fw-bold text-white"><i class="fas fa-images me-2 text-warning"></i>{{ $item->nama }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3" style="background:#f8f9fa;">
                @if($item->deskripsi)<p class="text-muted mb-3 small">{{ $item->deskripsi }}</p>@endif
                @if($item->galeri->isNotEmpty())
                <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(160px,1fr)); gap:10px;">
                    @foreach($item->galeri as $foto)
                    <div style="border-radius:10px; overflow:hidden; height:150px; background:#ddd;">
                        <img src="{{ asset('storage/'.$foto->file) }}" alt="{{ $foto->keterangan ?? $item->nama }}"
                             style="width:100%;height:150px;object-fit:cover;cursor:pointer;"
                             loading="lazy" onclick="openFullImg(this.src,'{{ addslashes($foto->keterangan ?? $item->nama) }}')">
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-5 text-muted"><i class="fas fa-image fa-3x mb-3 opacity-25 d-block"></i><p>Album ini belum memiliki foto.</p></div>
                @endif
            </div>
            <div class="modal-footer border-0 bg-white justify-content-between py-2 px-3">
                <small class="text-muted">{{ $fotoCount }} foto • {{ $tgl }}</small>
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Fullscreen viewer -->
<div id="fullImgOverlay" onclick="closeFullImg()" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.95);z-index:9999;align-items:center;justify-content:center;flex-direction:column;cursor:zoom-out;">
    <img id="fullImgSrc" src="" alt="" style="max-width:92vw;max-height:85vh;object-fit:contain;border-radius:8px;box-shadow:0 0 40px rgba(255,255,255,.1);">
    <p id="fullImgCaption" style="color:rgba(255,255,255,.7);margin-top:12px;font-size:.9rem;text-align:center;"></p>
    <button onclick="closeFullImg()" style="position:absolute;top:16px;right:20px;background:none;border:none;color:white;font-size:1.8rem;cursor:pointer;">&times;</button>
</div>
<script>
function openFullImg(src,caption){document.getElementById('fullImgSrc').src=src;document.getElementById('fullImgCaption').textContent=caption;const ov=document.getElementById('fullImgOverlay');ov.style.display='flex';document.body.style.overflow='hidden';}
function closeFullImg(){document.getElementById('fullImgOverlay').style.display='none';document.getElementById('fullImgSrc').src='';document.body.style.overflow='';}
document.addEventListener('keydown',function(e){if(e.key==='Escape')closeFullImg();});
</script>
@endsection