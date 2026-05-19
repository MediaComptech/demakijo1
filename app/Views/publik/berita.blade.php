@extends('publik.layout', ['title' => 'Berita Sekolah', 'header_title' => 'Berita & Artikel Sekolah'])
@section('content')
<div class='row g-4'>
    @forelse($berita as $item)
    <div class='col-md-4' data-aos='fade-up'>
        <div class='card h-100 shadow-sm border-0 rounded-4 overflow-hidden'>
            <img src='{{ $item->gambar ? asset("storage/".$item->gambar) : "https://images.unsplash.com/photo-1546410531-bea5aad1028f?auto=format&fit=crop&w=500&q=60" }}' class='card-img-top' alt='{{ $item->judul }}' style='height: 200px; object-fit: cover;' loading='lazy'>
            <div class='card-body p-4'>
                <div class='d-flex justify-content-between align-items-center mb-3'>
                    <span class='badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-bold'>{{ $item->kategori->nama ?? 'Umum' }}</span>
                    <small class='text-muted fw-bold'><i class='far fa-calendar-alt text-warning'></i> {{ $item->created_at->format('d M Y') }}</small>
                </div>
                <h5 class='card-title fw-bold text-primary mb-3'>{{ $item->judul }}</h5>
                <p class='card-text text-muted mb-4'>{{ \Illuminate\Support\Str::limit(strip_tags($item->konten), 120) }}</p>
                <a href='/berita/{{ $item->slug }}' class='btn btn-outline-primary btn-sm rounded-pill fw-bold px-3'>Baca Selengkapnya</a>
            </div>
        </div>
    </div>
    @empty
    <div class='col-12 text-center py-5'><p class='text-muted fs-5'>Belum ada berita yang dipublikasikan.</p></div>
    @endforelse
</div>
<div class='d-flex justify-content-center mt-5'>
    {{ $berita->links('pagination::bootstrap-5') }}
</div>
@endsection