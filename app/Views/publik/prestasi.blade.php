@extends('publik.layout', ['title' => 'Prestasi Sekolah', 'header_title' => 'Prestasi Membanggakan'])
@section('content')
<div class='row g-4'>
    @forelse($prestasi as $item)
    <div class='col-md-6' data-aos='zoom-in'>
        <div class='card shadow-sm border-0 rounded-4 border-start border-5 border-warning h-100'>
            <div class='card-body d-flex align-items-center p-4'>
                <div class='bg-primary-subtle rounded-circle p-4 me-4 text-primary d-flex align-items-center justify-content-center' style='width: 80px; height: 80px;'>
                    <i class='fas fa-trophy fa-2x'></i>
                </div>
                <div>
                    <h5 class='fw-bold text-dark mb-2'>{{ $item->judul }}</h5>
                    <p class='mb-1 text-muted'><strong>Tingkat:</strong> {{ $item->tingkat }}</p>
                    <p class='text-muted small mb-0 fw-bold'><i class='far fa-calendar-alt text-warning me-1'></i> {{ date('d M Y', strtotime($item->tanggal)) }}</p>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class='col-12 text-center py-5'><p class='text-muted fs-5'>Belum ada data prestasi.</p></div>
    @endforelse
</div>
@endsection