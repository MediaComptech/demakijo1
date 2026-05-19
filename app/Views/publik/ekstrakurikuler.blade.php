@extends('publik.layout', ['title' => 'Ekstrakurikuler', 'header_title' => 'Kegiatan Ekstrakurikuler'])
@section('content')
@php
$images = [
    'https://images.unsplash.com/photo-1571624436279-b272aff752b5?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1516321497487-e288fb19713f?auto=format&fit=crop&w=600&q=80',
    'https://images.unsplash.com/photo-1567416661576-659f9d4f0f10?auto=format&fit=crop&w=600&q=80',
];
@endphp
<div class='row g-4'>
    @forelse($ekstra as $index => $item)
    <div class='col-md-6 col-lg-4' data-aos='fade-up'>
        <div class='card border-0 rounded-4 overflow-hidden shadow-sm h-100' style='transition: transform 0.3s;' onmouseover='this.style.transform="translateY(-5px)"' onmouseout='this.style.transform="translateY(0)"'>
            <div style='height: 200px; overflow: hidden;'>
                <img src='{{ $item->foto ? asset("storage/".$item->foto) : $images[$index % count($images)] }}' class='w-100 h-100' style='object-fit: cover; transition: transform 0.5s;' loading='lazy' alt='{{ $item->nama }}'>
            </div>
            <div class='card-body p-4'>
                <div class='d-flex align-items-center mb-3'>
                    <div class='bg-warning rounded-circle d-flex align-items-center justify-content-center me-3' style='width:40px;height:40px;'>
                        <i class='fas fa-star text-white'></i>
                    </div>
                    <h5 class='fw-bold text-dark mb-0'>{{ $item->nama }}</h5>
                </div>
                <p class='text-muted small' style='line-height: 1.7;'>{{ $item->deskripsi ?? 'Kegiatan ekstrakurikuler unggulan SDN Demakijo 1.' }}</p>
            </div>
        </div>
    </div>
    @empty
    <div class='col-12 text-center py-5'><p class='text-muted fs-5'>Belum ada data ekstrakurikuler.</p></div>
    @endforelse
</div>
@endsection