@extends('publik.layout', ['title' => 'Sejarah', 'header_title' => 'Sejarah Sekolah'])
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
    
    /* Timeline styling */
    .timeline-container {
        position: relative;
        padding-left: 30px;
    }
    .timeline-container::before {
        content: '';
        position: absolute;
        left: 8px;
        top: 8px;
        bottom: 8px;
        width: 2px;
        background: #e2e8f0;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -26px;
        top: 5px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #0056b3;
        border: 2px solid #ffffff;
        box-shadow: 0 0 0 3px rgba(0, 86, 179, 0.15);
        z-index: 2;
    }
    .timeline-year {
        font-size: 0.95rem;
        font-weight: 700;
        color: #003366;
        margin-bottom: 2px;
    }
    .timeline-text {
        font-size: 0.85rem;
        color: #6c757d;
        line-height: 1.5;
    }
    .stat-card {
        border-radius: 1rem;
        border: 1px solid rgba(0, 0, 0, 0.04);
        transition: transform 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
    }
</style>

<div class="row g-4">
    <!-- Left Column: Sidebar -->
    <div class="col-lg-3 profile-sidebar" data-aos="fade-right">
        <div class="nav flex-column nav-pills gap-2">
            <a href="/identitas-sekolah" class="nav-link py-3 px-4 rounded-3 d-flex align-items-center gap-3">
                <i class="fas fa-id-card"></i> Identitas Sekolah
            </a>
            <a href="/sejarah" class="nav-link py-3 px-4 rounded-3 d-flex align-items-center gap-3 active">
                <i class="fas fa-history"></i> Sejarah
            </a>
            <a href="/akreditasi-sekolah" class="nav-link py-3 px-4 rounded-3 d-flex align-items-center gap-3">
                <i class="fas fa-award"></i> Akreditasi Sekolah
            </a>
            <a href="/sarana-prasarana" class="nav-link py-3 px-4 rounded-3 d-flex align-items-center gap-3">
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
            <div class="row g-4">
                
                <!-- Deskripsi Sejarah -->
                <div class="col-md-7">
                    <h4 class="fw-bold text-dark mb-4">Sejarah Singkat SDN Demakijo 1</h4>
                    <div class="text-secondary small d-flex flex-column gap-3" style="line-height: 1.8; font-size: 0.95rem;">
                        <p>
                            SDN Demakijo 1 berdiri pada tahun 1985 dan mulai beroperasi pada tahun 1986. Sekolah ini didirikan sebagai bentuk komitmen masyarakat dan pemerintah dalam menyediakan pendidikan dasar yang berkualitas bagi anak-anak di wilayah Demakijo dan sekitarnya.
                        </p>
                        <p>
                            Seiring berjalannya waktu, SDN Demakijo 1 terus berkembang dengan berbagai peningkatan fasilitas, kualitas tenaga pendidik, serta prestasi peserta didik baik di bidang akademik maupun non-akademik.
                        </p>
                        <p>
                            Hingga saat ini, SDN Demakijo 1 terus berkomitmen mewujudkan generasi yang berakhlak mulia, cerdas, mandiri, dan berprestasi.
                        </p>
                    </div>
                </div>

                <!-- Timeline Perkembangan -->
                <div class="col-md-5">
                    <h5 class="fw-bold text-dark mb-4">Timeline Perkembangan</h5>
                    <div class="timeline-container">
                        <div class="timeline-item">
                            <div class="timeline-year">1985</div>
                            <div class="timeline-text">Sekolah didirikan di atas tanah wakaf seluas 2.450 m².</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">1986</div>
                            <div class="timeline-text">Tahun ajaran pertama dimulai dengan 3 rombongan belajar.</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">1995</div>
                            <div class="timeline-text">Pembangunan ruang kelas baru dan ruang perpustakaan.</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2005</div>
                            <div class="timeline-text">Perluasan sarana dan prasarana serta laboratorium komputer.</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2015</div>
                            <div class="timeline-text">Akreditasi sekolah meningkat menjadi A.</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2020</div>
                            <div class="timeline-text">Implementasi Kurikulum 2013 dan pembelajaran berbasis IT.</div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-year">2024</div>
                            <div class="timeline-text">Pengembangan digitalisasi sekolah dan program inovasi.</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Bottom stat cards -->
        <div class="row g-3">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm stat-card bg-white p-3 d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary-subtle text-primary" style="width: 50px; height: 50px; flex-shrink: 0;">
                        <i class="fas fa-history fa-lg"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold text-dark">39+</div>
                        <div class="text-muted small fw-semibold">Tahun Berdiri</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm stat-card bg-white p-3 d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-success-subtle text-success" style="width: 50px; height: 50px; flex-shrink: 0;">
                        <i class="fas fa-user-tie fa-lg"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold text-dark">7</div>
                        <div class="text-muted small fw-semibold">Kepala Sekolah</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm stat-card bg-white p-3 d-flex flex-row align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-warning-subtle text-warning" style="width: 50px; height: 50px; flex-shrink: 0;">
                        <i class="fas fa-graduation-cap fa-lg"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold text-dark">Ribuan</div>
                        <div class="text-muted small fw-semibold">Alumni Berprestasi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection