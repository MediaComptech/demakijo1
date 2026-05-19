@extends('publik.layout', ['title' => 'Galeri Video', 'header_title' => 'Galeri Video Kegiatan'])
@section('content')
<div class='row g-4'>
    <div class='col-md-6' data-aos='zoom-in'>
        <div class='card shadow-sm border-0 rounded-4 overflow-hidden'>
            <div class='ratio ratio-16x9'>
                <iframe src='https://www.youtube.com/embed/dQw4w9WgXcQ?rel=0' title='YouTube video' allowfullscreen></iframe>
            </div>
            <div class='card-body p-4'>
                <h5 class='fw-bold text-dark mb-2'>Profil SDN Demakijo 1</h5>
                <p class='text-muted small'>Diunggah pada 12 Jan 2026</p>
            </div>
        </div>
    </div>
    <div class='col-md-6' data-aos='zoom-in' data-aos-delay='100'>
        <div class='card shadow-sm border-0 rounded-4 overflow-hidden'>
            <div class='ratio ratio-16x9'>
                <iframe src='https://www.youtube.com/embed/tgbNymZ7vqY?rel=0' title='YouTube video' allowfullscreen></iframe>
            </div>
            <div class='card-body p-4'>
                <h5 class='fw-bold text-dark mb-2'>Kegiatan Ekstrakurikuler Pramuka</h5>
                <p class='text-muted small'>Diunggah pada 05 Feb 2026</p>
            </div>
        </div>
    </div>
</div>
@endsection