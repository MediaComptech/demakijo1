@extends('publik.layout', [
    'title' => 'Struktur Organisasi', 
    'header_title' => 'Struktur Organisasi',
    'custom_css' => "
        .tree ul { padding-top: 20px; position: relative; transition: all 0.5s; display: flex; justify-content: center; }
        .tree li { text-align: center; list-style-type: none; position: relative; padding: 20px 5px 0 5px; transition: all 0.5s; }
        .tree li::before, .tree li::after { content: ''; position: absolute; top: 0; right: 50%; border-top: 2px solid #ccc; width: 50%; height: 20px; }
        .tree li::after { right: auto; left: 50%; border-left: 2px solid #ccc; }
        .tree li:only-child::after, .tree li:only-child::before { display: none; }
        .tree li:only-child { padding-top: 0; }
        .tree li:first-child::before, .tree li:last-child::after { border: 0 none; }
        .tree li:last-child::before { border-right: 2px solid #ccc; border-radius: 0 5px 0 0; }
        .tree li:first-child::after { border-radius: 5px 0 0 0; }
        .tree ul ul::before { content: ''; position: absolute; top: 0; left: 50%; border-left: 2px solid #ccc; width: 0; height: 20px; transform: translateX(-50%); }
        .tree li a { border: 1px solid #ccc; padding: 10px 15px; text-decoration: none; color: #333; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; display: inline-block; border-radius: 10px; transition: all 0.5s; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .tree li a:hover, .tree li a:hover+ul li a { background: var(--secondary); color: var(--primary); border: 1px solid var(--secondary); }
        .tree li a.kepsek { background: var(--primary); color: white; border: none; padding: 15px 30px; font-weight: bold; font-size: 16px; box-shadow: 0 10px 20px rgba(0,86,179,0.3); }
        
        @media (max-width: 768px) {
            .tree ul { flex-direction: column; padding-top: 0; }
            .tree li { padding: 10px 0; }
            .tree li::before, .tree li::after, .tree ul ul::before { display: none; }
        }
    "
])
@section('content')
<div class='overflow-auto text-center w-100 py-5 bg-white rounded-4 shadow-sm border'>
    <div class='tree d-inline-block' data-aos='fade-up'>
        <ul>
            <li>
                <a href='#' class='kepsek'><i class='fas fa-user-tie mb-2 fs-3 d-block text-warning'></i>Kepala Sekolah<br><small class='fw-normal opacity-75'>Bpk. Sukanto, S.Pd.</small></a>
                <ul class='d-flex flex-wrap justify-content-center'>
                    <li class='px-3'>
                        <a href='#' class='fw-bold'><i class='fas fa-users-cog mb-2 fs-4 d-block text-primary'></i>Tenaga Support</a>
                        <ul class='d-flex flex-wrap justify-content-center gap-2'>
                            <li><a href='#'>Staf TU 1</a></li>
                            <li><a href='#'>Staf TU 2</a></li>
                            <li><a href='#'>Pustakawan</a></li>
                            <li><a href='#'>Penjaga Sekolah</a></li>
                        </ul>
                    </li>
                    <li class='px-3 mt-4 mt-md-0'>
                        <a href='#' class='fw-bold'><i class='fas fa-chalkboard-teacher mb-2 fs-4 d-block text-success'></i>Dewan Guru</a>
                        <ul class='d-flex flex-wrap justify-content-center gap-2' style='max-width: 600px;'>
                            <li><a href='#'>Guru Kelas 1A</a></li>
                            <li><a href='#'>Guru Kelas 1B</a></li>
                            <li><a href='#'>Guru Kelas 2A</a></li>
                            <li><a href='#'>Guru Kelas 2B</a></li>
                            <li><a href='#'>Guru Kelas 3</a></li>
                            <li><a href='#'>Guru Kelas 4</a></li>
                            <li><a href='#'>Guru Kelas 5</a></li>
                            <li><a href='#'>Guru Kelas 6</a></li>
                            <li><a href='#'>Guru Agama 1</a></li>
                            <li><a href='#'>Guru Agama 2</a></li>
                            <li><a href='#'>Guru Penjas 1</a></li>
                            <li><a href='#'>Guru Penjas 2</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
@endsection