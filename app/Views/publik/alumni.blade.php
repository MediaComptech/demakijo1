@extends('publik.layout', ['title' => 'Direktori Alumni', 'header_title' => 'Direktori Alumni & Pendaftaran'])
@section('content')
<div class='row g-4'>
    <div class='col-lg-8'>
        <div class='card shadow-sm border-0 rounded-4'>
            <div class='card-header bg-white p-4 border-0 d-flex align-items-center'>
                <h5 class='fw-bold text-primary mb-0'><i class='fas fa-user-graduate me-2'></i>Daftar Alumni</h5>
            </div>
            <div class='card-body px-4 pb-4 pt-0'>
                <div class='table-responsive'>
                    <table class='table table-hover align-middle'>
                        <thead class='table-light'>
                            <tr><th>No</th><th>Foto</th><th>Nama</th><th>Lulus</th><th>Pekerjaan</th></tr>
                        </thead>
                        <tbody>
                            @forelse($alumni as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src='{{ $item->foto ? asset("storage/".$item->foto) : "https://ui-avatars.com/api/?name=".urlencode($item->nama)."&background=004aad&color=fff&size=80" }}' loading='lazy' style='width:42px;height:42px;border-radius:50%;object-fit:cover;'></td>
                                <td class='fw-bold text-dark'>{{ $item->nama }}</td>
                                <td><span class='badge bg-warning text-dark'>{{ $item->tahun_lulus }}</span></td>
                                <td>{{ $item->pekerjaan ?? '-' }}<br><small class='text-muted'>{{ $item->instansi ?? '' }}</small></td>
                            </tr>
                            @if($item->testimoni)
                            <tr class='bg-light'>
                                <td colspan='5' class='py-2 px-4'>
                                    <i class='fas fa-quote-left text-primary me-2 opacity-50'></i>
                                    <em class='text-muted small'>{{ $item->testimoni }}</em>
                                    <i class='fas fa-quote-right text-primary ms-2 opacity-50'></i>
                                </td>
                            </tr>
                            @endif
                            @empty
                            <tr><td colspan='5' class='text-center py-4 text-muted'>Belum ada data alumni terverifikasi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class='col-lg-4'>
        <div class='card shadow-sm border-0 rounded-4 border-top border-5 border-primary'>
            <div class='card-body p-4'>
                <h5 class='fw-bold text-dark mb-4 text-center'>Form Pendaftaran Alumni</h5>
                @if(session('success'))
                    <div class='alert alert-success alert-dismissible fade show'>{{ session('success') }}<button type='button' class='btn-close' data-bs-dismiss='alert'></button></div>
                @endif
                <form action='/alumni/daftar' method='POST'>
                    {!! csrf_field() !!}
                    <div class='mb-3'>
                        <label class='form-label small fw-bold text-muted'>Nama Lengkap</label>
                        <input type='text' name='nama' class='form-control rounded-pill' required>
                    </div>
                    <div class='mb-3'>
                        <label class='form-label small fw-bold text-muted'>Tahun Lulus</label>
                        <input type='number' name='tahun_lulus' class='form-control rounded-pill' required placeholder='Contoh: 2010'>
                    </div>
                    <div class='mb-3'>
                        <label class='form-label small fw-bold text-muted'>Pekerjaan Saat Ini</label>
                        <input type='text' name='pekerjaan' class='form-control rounded-pill'>
                    </div>
                    <div class='mb-3'>
                        <label class='form-label small fw-bold text-muted'>Instansi / Perusahaan</label>
                        <input type='text' name='instansi' class='form-control rounded-pill'>
                    </div>
                    <div class='mb-4'>
                        <label class='form-label small fw-bold text-muted'>Kesan / Pesan (Testimoni)</label>
                        <textarea name='testimoni' class='form-control' rows='3' style='border-radius:15px;'></textarea>
                    </div>
                    <button type='submit' class='btn btn-primary w-100 rounded-pill fw-bold py-2'>
                        <i class='fas fa-paper-plane me-2'></i>Kirim Data Registrasi
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection