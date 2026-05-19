@extends('publik.layout', ['title' => 'Agenda Sekolah', 'header_title' => 'Agenda Kegiatan Sekolah'])
@section('content')
<div class='row justify-content-center'>
    <div class='col-lg-10'>
        <div class='card shadow-sm border-0 rounded-4 p-4 p-md-5'>
            <h4 class='fw-bold text-primary mb-4 text-center'>Jadwal Kegiatan Akademik</h4>
            <div class='timeline'>
                @forelse($agenda as $item)
                <div class='d-flex mb-4 align-items-start'>
                    <div class='bg-warning text-dark text-center rounded-3 p-3 shadow-sm flex-shrink-0' style='width: 100px;'>
                        <h4 class='fw-bold mb-0'>{{ date('d', strtotime($item->tanggal_mulai)) }}</h4>
                        <small class='text-uppercase fw-bold'>{{ date('M Y', strtotime($item->tanggal_mulai)) }}</small>
                    </div>
                    <div class='ms-4 mt-2'>
                        <h5 class='fw-bold text-dark mb-1'>{{ $item->judul }}</h5>
                        <p class='text-muted small mb-2'>
                            <i class='far fa-clock me-1 text-primary'></i> {{ date('d M Y', strtotime($item->tanggal_mulai)) }} - {{ date('d M Y', strtotime($item->tanggal_selesai)) }}
                            <span class='mx-2'>|</span>
                            <i class='fas fa-map-marker-alt me-1 text-danger'></i> {{ $item->lokasi ?? 'Lingkungan Sekolah' }}
                        </p>
                        <p class='text-muted'>{{ $item->deskripsi }}</p>
                    </div>
                </div>
                @empty
                <div class='text-center py-5'><p class='text-muted'>Belum ada agenda terdaftar.</p></div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection