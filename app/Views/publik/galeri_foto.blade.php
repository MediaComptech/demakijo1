@extends('publik.layout', ['title' => 'Galeri Kegiatan', 'header_title' => 'Galeri Foto Kegiatan', 'custom_css' => "
    .album-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; }
    .album-card { border-radius: 16px; overflow: hidden; position: relative; background: #1a1a1a; box-shadow: 0 4px 15px rgba(0,0,0,0.12); transition: transform 0.3s ease, box-shadow 0.3s ease; cursor: pointer; }
    .album-card:hover { transform: translateY(-6px); box-shadow: 0 12px 30px rgba(0,0,0,0.2); }
    .album-thumb { width: 100%; height: 220px; object-fit: cover; display: block; transition: transform 0.5s ease; }
    .album-card:hover .album-thumb { transform: scale(1.06); }
    .album-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.2) 60%, transparent 100%); display: flex; flex-direction: column; justify-content: flex-end; padding: 18px; opacity: 0; transition: opacity 0.3s ease; }
    .album-card:hover .album-overlay, .album-card.always-show .album-overlay { opacity: 1; }
    .album-overlay h5 { color: #fff; font-weight: 700; font-size: 1rem; margin-bottom: 4px; line-height: 1.3; }
    .album-meta { color: rgba(255,255,255,0.85); font-size: 0.8rem; }
    .album-badge { position: absolute; top: 12px; left: 12px; background: rgba(0,0,0,0.55); backdrop-filter: blur(4px); color: #fff; font-size: 0.72rem; padding: 3px 10px; border-radius: 20px; }
    .album-placeholder { width: 100%; height: 220px; background: linear-gradient(135deg, #1e3a5f 0%, #2d6a9f 100%); display: flex; align-items: center; justify-content: center; flex-direction: column; color: rgba(255,255,255,0.4); }
    .empty-state { text-align: center; padding: 80px 20px; color: #aaa; }
    .empty-state i { font-size: 4rem; margin-bottom: 16px; opacity: 0.3; }
    @media (max-width: 576px) { .album-grid { grid-template-columns: 1fr 1fr; gap: 12px; } .album-thumb, .album-placeholder { height: 160px; } }
"])
@section('content')

<div class="album-grid">
    @forelse($album as $item)
    <?php
        // Ambil foto pertama sebagai thumbnail, atau null jika tidak ada
        $thumbnail = $item->galeri->first();
        $fotoCount = $item->galeri->count();
        $tgl = $item->created_at ? $item->created_at->format('d M Y') : '-';
    ?>
    <a href="#album-{{ $item->id }}" class="text-decoration-none album-card" data-bs-toggle="modal" data-bs-target="#album-{{ $item->id }}" data-aos="zoom-in">
        <!-- Badge jumlah foto -->
        <span class="album-badge"><i class="far fa-images me-1"></i>{{ $fotoCount }} Foto</span>

        <!-- Thumbnail album — ukuran seragam via CSS height: 220px + object-fit: cover -->
        @if($thumbnail && $thumbnail->file_path)
            <img
                src="{{ \Illuminate\Support\Facades\Storage::url($thumbnail->file_path) }}"
                class="album-thumb"
                alt="{{ $item->nama }}"
                loading="lazy"
            >
        @else
            <!-- Placeholder jika tidak ada foto -->
            <div class="album-placeholder">
                <i class="fas fa-images" style="font-size:2.5rem; margin-bottom:8px;"></i>
                <span style="font-size:0.8rem;">Belum ada foto</span>
            </div>
        @endif

        <!-- Overlay info -->
        <div class="album-overlay {{ $fotoCount > 0 ? 'always-show' : '' }}">
            <h5>{{ $item->nama }}</h5>
            <span class="album-meta">
                <i class="far fa-calendar-alt me-1 text-warning"></i>{{ $tgl }}
            </span>
        </div>
    </a>

    <!-- Modal lightbox per album -->
    <div class="modal fade" id="album-{{ $item->id }}" tabindex="-1" aria-label="{{ $item->nama }}" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 rounded-4 overflow-hidden">
                <div class="modal-header bg-primary text-white border-0 py-3">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-images me-2 text-warning"></i>{{ $item->nama }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-3" style="background:#f8f9fa;">
                    @if($item->deskripsi)
                    <p class="text-muted mb-3 small px-1">{{ $item->deskripsi }}</p>
                    @endif
                    @if($item->galeri->isNotEmpty())
                    <!-- Grid foto dalam modal — ukuran seragam -->
                    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 10px;">
                        @foreach($item->galeri as $foto)
                        <div style="border-radius:10px; overflow:hidden; height:160px; background:#ddd;">
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::url($foto->file_path) }}"
                                alt="{{ $foto->keterangan ?? $item->nama }}"
                                style="width:100%; height:160px; object-fit:cover; display:block; cursor:pointer;"
                                loading="lazy"
                                onclick="openFullImg(this.src, '{{ addslashes($foto->keterangan ?? $item->nama) }}')"
                            >
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-image fa-3x mb-3 opacity-25"></i>
                        <p>Album ini belum memiliki foto.</p>
                    </div>
                    @endif
                </div>
                <div class="modal-footer border-0 bg-white justify-content-between py-2 px-3">
                    <small class="text-muted">{{ $fotoCount }} foto • {{ $tgl }}</small>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @empty
    <div class="col-12 empty-state">
        <i class="fas fa-images d-block"></i>
        <h5 class="text-muted">Belum Ada Album Foto</h5>
        <p class="text-muted small">Album kegiatan sekolah akan segera ditambahkan.</p>
    </div>
    @endforelse
</div>

<!-- Full-screen image viewer -->
<div id="fullImgOverlay" onclick="closeFullImg()" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.95); z-index:9999; align-items:center; justify-content:center; flex-direction:column; cursor:zoom-out;">
    <img id="fullImgSrc" src="" alt="" style="max-width:92vw; max-height:85vh; object-fit:contain; border-radius:8px; box-shadow:0 0 40px rgba(255,255,255,0.1);">
    <p id="fullImgCaption" style="color:rgba(255,255,255,0.7); margin-top:12px; font-size:0.9rem; text-align:center;"></p>
    <button onclick="closeFullImg()" style="position:absolute; top:16px; right:20px; background:none; border:none; color:white; font-size:1.8rem; cursor:pointer;">&times;</button>
</div>

<script>
function openFullImg(src, caption) {
    document.getElementById('fullImgSrc').src = src;
    document.getElementById('fullImgCaption').textContent = caption;
    const ov = document.getElementById('fullImgOverlay');
    ov.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeFullImg() {
    document.getElementById('fullImgOverlay').style.display = 'none';
    document.getElementById('fullImgSrc').src = '';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e){ if(e.key === 'Escape') closeFullImg(); });
</script>

@endsection