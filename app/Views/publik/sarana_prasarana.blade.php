@extends('publik.layout', ['title' => 'Sarana Prasarana', 'header_title' => 'Fasilitas & Sarana Prasarana'])
@section('content')

<style>
    .profile-sidebar .nav-link {
        color: #495057;
        font-weight: 600;
        transition: all 0.2s ease;
        border: 1px solid rgba(0,0,0,0.05);
        background: #ffffff;
    }
    .profile-sidebar .nav-link:hover {
        background: rgba(0, 51, 102, 0.04);
        color: #003366;
    }
    .profile-sidebar .nav-link.active {
        background: #0056b3 !important;
        color: #ffffff !important;
        border-color: #0056b3 !important;
        box-shadow: 0 4px 10px rgba(0, 86, 179, 0.15);
    }
    
    /* Filter chip */
    .filter-chip {
        border-radius: 2rem;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 0.4rem 1.15rem;
        border: 1px solid rgba(0,0,0,0.06);
        background: #ffffff;
        color: #495057;
        transition: all 0.2s ease;
    }
    .filter-chip:hover {
        background: rgba(0, 51, 102, 0.04);
        color: #003366;
    }
    .filter-chip.active {
        background: #0056b3 !important;
        color: #ffffff !important;
        border-color: #0056b3 !important;
        box-shadow: 0 4px 10px rgba(0, 86, 179, 0.15);
    }
    
    .facility-card {
        border-radius: 1rem;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05) !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: #ffffff;
    }
    .facility-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.06);
    }
    
    .facility-img-container {
        height: 140px;
        overflow: hidden;
        position: relative;
    }
    .facility-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .facility-card:hover .facility-img-container img {
        transform: scale(1.08);
    }
    .facility-badge {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: rgba(255, 193, 7, 0.95);
        color: #003366;
        font-weight: 700;
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 6px;
    }
</style>

<div class="row g-4">
    <!-- Left Column: Sidebar -->
    <div class="col-lg-3 profile-sidebar" data-aos="fade-right">
        <div class="nav flex-column nav-pills gap-2">
            <a href="/identitas-sekolah" class="nav-link py-3 px-4 rounded-3 d-flex align-items-center gap-3">
                <i class="fas fa-id-card"></i> Identitas Sekolah
            </a>
            <a href="/sejarah" class="nav-link py-3 px-4 rounded-3 d-flex align-items-center gap-3">
                <i class="fas fa-history"></i> Sejarah
            </a>
            <a href="/akreditasi-sekolah" class="nav-link py-3 px-4 rounded-3 d-flex align-items-center gap-3">
                <i class="fas fa-award"></i> Akreditasi Sekolah
            </a>
            <a href="/sarana-prasarana" class="nav-link py-3 px-4 rounded-3 d-flex align-items-center gap-3 active">
                <i class="fas fa-building"></i> Sarana Prasarana
            </a>
            <a href="/komite-sekolah" class="nav-link py-3 px-4 rounded-3 d-flex align-items-center gap-3">
                <i class="fas fa-sitemap"></i> Struktur Komite
            </a>
        </div>
    </div>

    <!-- Right Column: Content -->
    <div class="col-lg-9" data-aos="fade-left">
        <div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
            
            <h4 class="fw-bold text-dark mb-4">Sarana Prasarana</h4>
            
            <!-- Category Filter Chips -->
            <div class="d-flex flex-wrap gap-2 mb-4">
                <button class="filter-chip active" onclick="filterFacility('Semua', this)">Semua</button>
                <button class="filter-chip" onclick="filterFacility('Ruang Kelas', this)">Ruang Kelas</button>
                <button class="filter-chip" onclick="filterFacility('Laboratorium', this)">Laboratorium</button>
                <button class="filter-chip" onclick="filterFacility('Perpustakaan', this)">Perpustakaan</button>
                <button class="filter-chip" onclick="filterFacility('Fasilitas Umum', this)">Fasilitas Umum</button>
                <button class="filter-chip" onclick="filterFacility('Lainnya', this)">Lainnya</button>
            </div>

            <!-- Facilities Grid -->
            @php
                // If database $fasilitas has data, we map it.
                // We fallback to standard 8 items from the Source of Truth image to make it pixel-perfect.
                $defaultFacilities = [
                    [
                        'nama' => 'Ruang Kelas',
                        'deskripsi' => 'Ruang kelas yang nyaman, bersih, dan representatif untuk kegiatan belajar mengajar.',
                        'jumlah' => '24 Ruang',
                        'kategori' => 'Ruang Kelas',
                        'foto' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=600&q=80'
                    ],
                    [
                        'nama' => 'Laboratorium Komputer',
                        'deskripsi' => 'Fasilitas komputer modern dengan koneksi internet untuk menunjang pembelajaran IT.',
                        'jumlah' => '1 Ruang',
                        'kategori' => 'Laboratorium',
                        'foto' => 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?auto=format&fit=crop&w=600&q=80'
                    ],
                    [
                        'nama' => 'Perpustakaan',
                        'deskripsi' => 'Koleksi buku lengkap, ruang baca tenang untuk meningkatkan minat baca siswa.',
                        'jumlah' => '1 Ruang',
                        'kategori' => 'Perpustakaan',
                        'foto' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=600&q=80'
                    ],
                    [
                        'nama' => 'Ruang Guru',
                        'deskripsi' => 'Ruang kerja guru dan staff tendik untuk berkolaborasi dan mempersiapkan bahan ajar.',
                        'jumlah' => '1 Ruang',
                        'kategori' => 'Fasilitas Umum',
                        'foto' => 'https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=600&q=80'
                    ],
                    [
                        'nama' => 'Ruang Kepala Sekolah',
                        'deskripsi' => 'Ruang kerja dan administrasi Kepala Sekolah SDN Demakijo 1.',
                        'jumlah' => '1 Ruang',
                        'kategori' => 'Fasilitas Umum',
                        'foto' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?auto=format&fit=crop&w=600&q=80'
                    ],
                    [
                        'nama' => 'UKS',
                        'deskripsi' => 'Unit Kesehatan Sekolah untuk penanganan kesehatan pertama bagi seluruh warga sekolah.',
                        'jumlah' => '1 Ruang',
                        'kategori' => 'Fasilitas Umum',
                        'foto' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=600&q=80'
                    ],
                    [
                        'nama' => 'Aula',
                        'deskripsi' => 'Gedung pertemuan serbaguna untuk menyelenggarakan event dan rapat besar.',
                        'jumlah' => '1 Ruang',
                        'kategori' => 'Fasilitas Umum',
                        'foto' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=600&q=80'
                    ],
                    [
                        'nama' => 'Lapangan Olahraga',
                        'deskripsi' => 'Lapangan luas untuk kegiatan upacara, olahraga bola voli, basket, dan bermain.',
                        'jumlah' => 'Lapangan',
                        'kategori' => 'Lainnya',
                        'foto' => 'https://images.unsplash.com/photo-1543466835-00a7907e9de1?auto=format&fit=crop&w=600&q=80'
                    ]
                ];

                $displayList = count($fasilitas) > 0 ? [] : $defaultFacilities;
                if (count($fasilitas) > 0) {
                    foreach($fasilitas as $item) {
                        // Dynamically map categories based on name
                        $name = $item->nama;
                        $cat = 'Lainnya';
                        if (str_contains(strtolower($name), 'kelas')) $cat = 'Ruang Kelas';
                        elseif (str_contains(strtolower($name), 'lab') || str_contains(strtolower($name), 'komputer')) $cat = 'Laboratorium';
                        elseif (str_contains(strtolower($name), 'perpus')) $cat = 'Perpustakaan';
                        elseif (str_contains(strtolower($name), 'guru') || str_contains(strtolower($name), 'kepala') || str_contains(strtolower($name), 'uks') || str_contains(strtolower($name), 'aula')) $cat = 'Fasilitas Umum';

                        $displayList[] = [
                            'nama' => $item->nama,
                            'deskripsi' => $item->deskripsi,
                            'jumlah' => str_contains(strtolower($name), 'lapangan') ? 'Lapangan' : '1 Ruang',
                            'kategori' => $cat,
                            'foto' => $item->foto ? asset('storage/'.$item->foto) : 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=600&q=80'
                        ];
                    }
                }
            @endphp

            <div class="row g-3" id="facilities-container">
                @foreach($displayList as $item)
                <div class="col-md-6 col-lg-4 facility-item" data-category="{{ $item['kategori'] }}">
                    <div class="card facility-card h-100 shadow-sm border">
                        <div class="facility-img-container">
                            <img src="{{ $item['foto'] }}" loading="lazy" alt="{{ $item['nama'] }}">
                            <span class="facility-badge shadow-sm"><i class="fas fa-check-circle me-1"></i>{{ $item['jumlah'] }}</span>
                        </div>
                        <div class="card-body p-3">
                            <h6 class="fw-bold text-dark mb-2">{{ $item['nama'] }}</h6>
                            <p class="text-secondary small mb-0 lh-base">{{ \Illuminate\Support\Str::limit($item['deskripsi'], 90) }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Bottom alert/callout box -->
            <div class="d-flex align-items-center gap-3 mt-4 p-3 rounded-4 bg-primary-subtle border border-primary-subtle text-primary">
                <div class="bg-white rounded-circle p-2 shadow-sm text-primary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                    <i class="fas fa-building fa-lg"></i>
                </div>
                <div>
                    <p class="small mb-0 fw-semibold">SDN Demakijo 1 terus berkomitmen untuk menyediakan sarana dan prasarana yang memadai guna mendukung proses pembelajaran yang efektif dan nyaman.</p>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function filterFacility(category, element) {
        if(window.event) window.event.preventDefault();
        
        // Active tab styling
        document.querySelectorAll('.filter-chip').forEach(btn => btn.classList.remove('active'));
        element.classList.add('active');
        
        // Show/hide grid cards
        const items = document.querySelectorAll('.facility-item');
        items.forEach(item => {
            const cardCat = item.getAttribute('data-category');
            if (category === 'Semua' || cardCat === category) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
@endsection