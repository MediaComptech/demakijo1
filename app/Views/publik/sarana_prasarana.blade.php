@extends('publik.layout', ['title' => 'Sarana Prasarana', 'header_title' => 'Fasilitas & Sarana Prasarana', 'custom_css' => "
    .fasilitas-card { border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: all 0.3s ease; border: 1px solid #eee; }
    .fasilitas-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .fasilitas-img-wrapper { position: relative; height: 220px; overflow: hidden; }
    .fasilitas-img-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
    .fasilitas-card:hover .fasilitas-img-wrapper img { transform: scale(1.1); }
    .fasilitas-icon { position: absolute; bottom: -20px; right: 20px; width: 50px; height: 50px; background: var(--warning); color: var(--dark); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.2); border: 4px solid white; z-index: 2;}
"])
@section('content')
<div class='row g-4'>
    @php
        // Dummy image array for mapping
        $images = [
            'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1516321497487-e288fb19713f?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=600&q=80',
            'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=600&q=80'
        ];
    @endphp

    @foreach($fasilitas as $index => $item)
    <div class='col-md-6 col-lg-4' data-aos='fade-up'>
        <div class='card fasilitas-card bg-white h-100'>
            <div class='fasilitas-img-wrapper'>
                <img src='{{ $item->foto ? asset('storage/'.$item->foto) : $images[$index % count($images)] }}' loading='lazy' alt='{{ $item->nama }}'>
                <div class='fasilitas-icon'>
                    <i class='fas fa-check'></i>
                </div>
            </div>
            <div class='card-body p-4 pt-4'>
                <h5 class='fw-bold text-dark mb-3 mt-2'>{{ $item->nama }}</h5>
                <p class='text-muted small mb-0' style='line-height: 1.6;'>{{ $item->deskripsi }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection