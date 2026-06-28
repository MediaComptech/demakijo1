@extends('publik.layout', ['title' => 'Struktur Komite', 'header_title' => 'Struktur Komite'])
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
    
    /* Org chart styling */
    .org-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 2rem;
        position: relative;
    }
    .org-node {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 20px;
        width: 220px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.04);
        position: relative;
        z-index: 2;
    }
    .org-node img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 8px;
        border: 2px solid #0056b3;
    }
    .org-node .node-name {
        font-weight: 700;
        font-size: 0.9rem;
        color: #1e293b;
        margin-bottom: 2px;
    }
    .org-node .node-role {
        font-weight: 600;
        font-size: 0.75rem;
        color: #ff9900;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Connective Tree Lines */
    .org-tree {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }
    .tree-branch-line {
        width: 2px;
        height: 30px;
        background: #cbd5e1;
    }
    .tree-row {
        display: flex;
        justify-content: center;
        position: relative;
        width: 100%;
        gap: 30px;
    }
    .tree-row::before {
        content: '';
        position: absolute;
        top: 0;
        left: 16.6%;
        right: 16.6%;
        height: 2px;
        background: #cbd5e1;
        z-index: 1;
    }
    
    @media (max-width: 768px) {
        .tree-row {
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }
        .tree-row::before {
            display: none;
        }
        .tree-branch-line {
            height: 15px;
        }
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
            <a href="/sarana-prasarana" class="nav-link py-3 px-4 rounded-3 d-flex align-items-center gap-3">
                <i class="fas fa-building"></i> Sarana Prasarana
            </a>
            <a href="/komite-sekolah" class="nav-link py-3 px-4 rounded-3 d-flex align-items-center gap-3 active">
                <i class="fas fa-sitemap"></i> Struktur Komite
            </a>
        </div>
    </div>

    <!-- Right Column: Content -->
    <div class="col-lg-9" data-aos="fade-left">
        <div class="card border-0 rounded-4 shadow-sm p-4 mb-4">
            
            <div class="text-center mb-4">
                <h4 class="fw-bold text-dark mb-1">Struktur Komite Sekolah</h4>
                <p class="text-secondary small fw-semibold">SDN Demakijo 1</p>
            </div>
            
            <!-- Tree Chart -->
            <div class="org-tree">
                <!-- Level 1: Ketua -->
                <div class="org-node">
                    <img src="https://ui-avatars.com/api/?name=Drs+Bambang+S&background=0056b3&color=fff&size=120" alt="Drs. Bambang S.">
                    <div class="node-name">Drs. Bambang S.</div>
                    <div class="node-role">Ketua Komite</div>
                </div>

                <!-- Connective Line -->
                <div class="tree-branch-line"></div>

                <!-- Level 2: Branches -->
                <div class="tree-row pt-3">
                    <!-- Wakil Ketua -->
                    <div class="d-flex flex-column align-items-center">
                        <div class="org-node">
                            <img src="https://ui-avatars.com/api/?name=Sri+Murni+S+Pd&background=0056b3&color=fff&size=120" alt="Sri Murni, S.Pd">
                            <div class="node-name">Sri Murni, S.Pd</div>
                            <div class="node-role">Wakil Ketua</div>
                        </div>
                    </div>

                    <!-- Sekretaris -->
                    <div class="d-flex flex-column align-items-center">
                        <div class="org-node">
                            <img src="https://ui-avatars.com/api/?name=Agus+Wibowo&background=0056b3&color=fff&size=120" alt="Agus Wibowo">
                            <div class="node-name">Agus Wibowo</div>
                            <div class="node-role">Sekretaris</div>
                        </div>
                    </div>

                    <!-- Bendahara -->
                    <div class="d-flex flex-column align-items-center">
                        <div class="org-node">
                            <img src="https://ui-avatars.com/api/?name=Dewi+Lestari&background=0056b3&color=fff&size=120" alt="Dewi Lestari">
                            <div class="node-name">Dewi Lestari</div>
                            <div class="node-role">Bendahara</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom alert/callout box -->
            <div class="d-flex align-items-center gap-3 mt-5 p-3 rounded-4 bg-success-subtle border border-success-subtle text-success">
                <div class="bg-white rounded-circle p-2 shadow-sm text-success d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; flex-shrink: 0;">
                    <i class="fas fa-handshake fa-lg"></i>
                </div>
                <div>
                    <p class="small mb-0 fw-semibold text-dark-emphasis">Komite Sekolah berperan sebagai mitra strategis dalam meningkatkan mutu pendidikan, transparansi, dan akuntabilitas di SDN Demakijo 1.</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection