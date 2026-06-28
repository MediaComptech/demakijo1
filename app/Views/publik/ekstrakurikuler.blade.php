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
    @php
        $namaLower = strtolower($item->nama);
        if (str_contains($namaLower, 'pramuka')) {
            $icon = 'fa-campground';
            $bg = 'background: linear-gradient(135deg, #15803d, #22c55e);'; // green
        } elseif (str_contains($namaLower, 'tari')) {
            $icon = 'fa-music';
            $bg = 'background: linear-gradient(135deg, #a21caf, #d946ef);'; // purple
        } elseif (str_contains($namaLower, 'komputer') || str_contains($namaLower, 'ti') || str_contains($namaLower, 'coding')) {
            $icon = 'fa-laptop-code';
            $bg = 'background: linear-gradient(135deg, #1d4ed8, #3b82f6);'; // blue
        } elseif (str_contains($namaLower, 'taekwondo') || str_contains($namaLower, 'silat') || str_contains($namaLower, 'bela diri')) {
            $icon = 'fa-fist-raised';
            $bg = 'background: linear-gradient(135deg, #b91c1c, #ef4444);'; // red
        } elseif (str_contains($namaLower, 'kriya') || str_contains($namaLower, 'lukis') || str_contains($namaLower, 'seni')) {
            $icon = 'fa-paint-brush';
            $bg = 'background: linear-gradient(135deg, #b45309, #f59e0b);'; // amber
        } else {
            $icon = 'fa-star';
            $bg = 'background: linear-gradient(135deg, #ffcc00, #ff9900);'; // yellow
        }
    @endphp
    <div class='col-md-6 col-lg-4' data-aos='fade-up'>
        <div class='card border-0 rounded-4 overflow-hidden shadow-sm h-100' style='transition: transform 0.3s; border: 1px solid rgba(0,0,0,0.05) !important;' onmouseover='this.style.transform="translateY(-5px)"' onmouseout='this.style.transform="translateY(0)"'>
            <div style='height: 200px; overflow: hidden;'>
                <img src='{{ $item->foto ? asset("storage/".$item->foto) : $images[$index % count($images)] }}' class='w-100 h-100' style='object-fit: cover; transition: transform 0.5s;' loading='lazy' alt='{{ $item->nama }}'>
            </div>
            <div class='card-body p-4'>
                <div class='d-flex align-items-center mb-3'>
                    <div class='rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm text-white' style='width:42px;height:42px; {{$bg}}'>
                        <i class='fas {{$icon}}'></i>
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