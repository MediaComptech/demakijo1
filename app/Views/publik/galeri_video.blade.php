@extends('publik.layout', ['title' => 'Galeri Video Kegiatan', 'header_title' => 'Galeri Video Kegiatan', 'custom_css' => "
    /* ===== GALERI VIDEO PAGE ===== */
    .filter-chip { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:50px; border:1.5px solid #dee2e6; background:#fff; font-size:.875rem; font-weight:600; color:#555; cursor:pointer; transition:all .2s ease; text-decoration:none; }
    .filter-chip:hover { border-color:#0056b3; color:#0056b3; background:#f0f6ff; }
    .filter-chip.active { background:#0056b3; border-color:#0056b3; color:#fff; }

    /* Video Card */
    .video-card { border-radius:12px; overflow:hidden; background:#000; box-shadow:0 2px 10px rgba(0,0,0,.1); margin-bottom:20px; cursor:pointer; transition:transform .25s, box-shadow .25s; }
    .video-card:hover { transform:translateY(-4px); box-shadow:0 10px 28px rgba(0,0,0,.18); }
    .video-thumb { position:relative; width:100%; height:210px; overflow:hidden; }
    .video-thumb img { width:100%; height:210px; object-fit:cover; display:block; }
    .video-thumb iframe { width:100%; height:210px; border:none; }
    .badge-duration { position:absolute; top:10px; left:10px; background:rgba(0,0,0,.75); color:#fff; font-size:.72rem; font-weight:700; padding:3px 9px; border-radius:6px; }
    .badge-quality { position:absolute; top:10px; right:10px; background:rgba(0,0,0,.7); color:#fff; font-size:.7rem; font-weight:700; padding:2px 7px; border-radius:4px; letter-spacing:.5px; }
    .play-btn { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; }
    .play-circle { width:50px; height:50px; background:rgba(255,255,255,.9); border-radius:50%; display:flex; align-items:center; justify-content:center; color:#0056b3; font-size:1.2rem; transition:transform .2s; }
    .video-card:hover .play-circle { transform:scale(1.12); }
    .badge-cat { font-size:.72rem; font-weight:600; padding:3px 10px; border-radius:20px; }
    .badge-cat.blue { background:#e8f0fe; color:#0056b3; }
    .badge-cat.green { background:#e8f9f0; color:#198754; }
    .badge-cat.yellow { background:#fff8e1; color:#d4a017; }
    .badge-cat.purple { background:#f3e8fe; color:#6f42c1; }
    .video-info { padding:14px 16px; background:#fff; }
    .video-title { font-size:.92rem; font-weight:700; color:#1a1a1a; margin-bottom:6px; }
    .video-meta { font-size:.75rem; color:#888; display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
    .load-more-btn { display:flex; align-items:center; gap:8px; justify-content:center; padding:10px 28px; border-radius:30px; border:1.5px solid #dee2e6; background:#fff; color:#555; font-size:.88rem; font-weight:600; cursor:pointer; transition:all .2s; }
    .load-more-btn:hover { border-color:#0056b3; color:#0056b3; }

    /* Sidebar */
    .sidebar-card { background:#fff; border-radius:14px; border:1px solid #e8edf3; box-shadow:0 2px 10px rgba(0,0,0,.06); padding:18px; margin-bottom:18px; }
    .sidebar-card h6 { font-size:.92rem; font-weight:700; color:#1a1a1a; margin-bottom:14px; }
    .playlist-item { display:flex; align-items:center; gap:10px; padding:8px 0; border-bottom:1px solid #f0f2f5; }
    .playlist-item:last-child { border-bottom:none; }
    .playlist-thumb { width:52px; height:38px; border-radius:6px; object-fit:cover; flex-shrink:0; background:#e0e0e0; }
    .playlist-dot { width:22px; height:22px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .playlist-title { font-size:.8rem; font-weight:700; color:#1a1a1a; margin:0 0 2px; }
    .playlist-meta { font-size:.7rem; color:#888; }
    .stat-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:10px; }
    .stat-box { background:#f8f9fc; border-radius:10px; padding:12px; text-align:center; }
    .stat-box .val { font-size:1.2rem; font-weight:800; color:#1a1a1a; display:flex; align-items:center; justify-content:center; gap:6px; }
    .stat-box .lbl { font-size:.72rem; color:#888; margin-top:2px; }
    .btn-lihat-semua { display:block; text-align:center; padding:8px; border-radius:8px; border:1.5px solid #0056b3; color:#0056b3; font-size:.82rem; font-weight:600; text-decoration:none; margin-top:12px; transition:all .2s; }
    .btn-lihat-semua:hover { background:#0056b3; color:#fff; }
"])
@section('content')

@php
$videos = [
    ['id'=>'dQw4w9WgXcQ', 'judul'=>'Profil SDN Demakijo 1',        'durasi'=>'03:33', 'quality'=>'4K', 'tanggal'=>'12 Jan 2026', 'views'=>'1.250', 'kategori'=>'Kegiatan Sekolah',  'cat_class'=>'blue'  ],
    ['id'=>'OH-BrKToTFI', 'judul'=>'Kegiatan Ekstrakurikuler Pramuka','durasi'=>'04:48','quality'=>'4K','tanggal'=>'05 Feb 2026','views'=>'980',   'kategori'=>'Ekstrakurikuler',   'cat_class'=>'green' ],
    ['id'=>'pekN3XLKH7M', 'judul'=>'Upacara Bendera Senin',         'durasi'=>'02:15', 'quality'=>'',  'tanggal'=>'20 Feb 2026', 'views'=>'765',   'kategori'=>'Kegiatan Sekolah',  'cat_class'=>'blue'  ],
    ['id'=>'5qap5aO4i9A', 'judul'=>'Pentas Seni dan Budaya',        'durasi'=>'05:12', 'quality'=>'',  'tanggal'=>'25 Mar 2026', 'views'=>'1.120', 'kategori'=>'Acara Spesial',     'cat_class'=>'purple'],
];
$playlists = [
    ['judul'=>'Kegiatan Sekolah 2026', 'jml'=>'12 Video', 'color'=>'#0056b3'],
    ['judul'=>'Ekstrakurikuler Pramuka','jml'=>'8 Video',  'color'=>'#198754'],
    ['judul'=>'Prestasi Siswa',         'jml'=>'6 Video',  'color'=>'#ffc107'],
    ['judul'=>'Acara Spesial Sekolah',  'jml'=>'10 Video', 'color'=>'#6f42c1'],
];
@endphp

<div class="row g-4">
    <!-- MAIN VIDEO COLUMN -->
    <div class="col-lg-8">
        <!-- Filter Chips + Sort -->
        <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
            <a href="#" class="filter-chip active"><i class="fas fa-play-circle"></i> Semua Video</a>
            <a href="#" class="filter-chip"><i class="fas fa-school"></i> Kegiatan Sekolah</a>
            <a href="#" class="filter-chip"><i class="fas fa-running"></i> Ekstrakurikuler</a>
            <a href="#" class="filter-chip"><i class="fas fa-trophy"></i> Prestasi</a>
            <a href="#" class="filter-chip"><i class="fas fa-star"></i> Acara Spesial</a>
            <select class="ms-auto" style="border:1.5px solid #dee2e6;border-radius:8px;padding:5px 12px;font-size:.82rem;font-weight:600;color:#444;background:#fff;">
                <option>Terbaru</option>
                <option>Terlama</option>
                <option>Terpopuler</option>
            </select>
            <button style="width:34px;height:34px;border-radius:8px;border:1.5px solid #0056b3;background:#0056b3;display:inline-flex;align-items:center;justify-content:center;font-size:.85rem;color:#fff;"><i class="fas fa-th-large"></i></button>
        </div>

        <!-- Video Grid 2-kolom -->
        <div class="row g-3">
            @foreach($videos as $v)
            <div class="col-md-6">
                <div class="video-card">
                    <div class="video-thumb">
                        <img src="https://img.youtube.com/vi/{{ $v['id'] }}/hqdefault.jpg" alt="{{ $v['judul'] }}">
                        <span class="badge-duration">{{ $v['durasi'] }}</span>
                        @if($v['quality'])<span class="badge-quality">{{ $v['quality'] }}<br><span style="font-size:.55rem;">ULTRA HD</span></span>@endif
                        <div class="play-btn">
                            <a href="https://www.youtube.com/watch?v={{ $v['id'] }}" target="_blank">
                                <div class="play-circle"><i class="fas fa-play" style="margin-left:3px;"></i></div>
                            </a>
                        </div>
                    </div>
                    <div class="video-info">
                        <div class="video-title">{{ $v['judul'] }}</div>
                        <div class="video-meta">
                            <span><i class="fas fa-calendar-alt me-1"></i>{{ $v['tanggal'] }}</span>
                            <span><i class="fas fa-eye me-1"></i>{{ $v['views'] }} views</span>
                            <span class="ms-auto badge-cat {{ $v['cat_class'] }}">{{ $v['kategori'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Load More -->
        <div class="text-center mt-2">
            <button class="load-more-btn"><i class="fas fa-chevron-down"></i> Muat Lebih Banyak <i class="fas fa-chevron-down"></i></button>
        </div>
    </div>

    <!-- SIDEBAR KANAN -->
    <div class="col-lg-4">
        <!-- Playlist Populer -->
        <div class="sidebar-card">
            <h6>Playlist Populer</h6>
            @foreach($playlists as $pl)
            <div class="playlist-item">
                <div class="playlist-dot" style="background:{{ $pl['color'] }}1a;">
                    <i class="fas fa-play" style="color:{{ $pl['color'] }};font-size:.6rem;margin-left:2px;"></i>
                </div>
                <div style="flex:1;">
                    <div class="playlist-title">{{ $pl['judul'] }}</div>
                    <div class="playlist-meta">{{ $pl['jml'] }}</div>
                </div>
            </div>
            @endforeach
            <a href="#" class="btn-lihat-semua">Lihat Semua Playlist →</a>
        </div>

        <!-- Statistik Video -->
        <div class="sidebar-card">
            <h6>Statistik Video</h6>
            <div class="stat-grid-2">
                <div class="stat-box">
                    <div class="val"><i class="fas fa-play-circle" style="color:#0056b3;font-size:.9rem;"></i> 36</div>
                    <div class="lbl">Total Video</div>
                </div>
                <div class="stat-box">
                    <div class="val"><i class="fas fa-eye" style="color:#28a745;font-size:.9rem;"></i> 15.240</div>
                    <div class="lbl">Total Views</div>
                </div>
                <div class="stat-box">
                    <div class="val"><i class="fas fa-thumbs-up" style="color:#fd7e14;font-size:.9rem;"></i> 1.125</div>
                    <div class="lbl">Likes</div>
                </div>
                <div class="stat-box">
                    <div class="val"><i class="fas fa-calendar-alt" style="color:#6f42c1;font-size:.9rem;"></i> {{ date('Y') }}</div>
                    <div class="lbl">Tahun Ini</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection