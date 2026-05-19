@extends('layouts.admin')
@section('title', 'Pengaturan Website')
@section('content')
<form action="{{ url('admin.pengaturan.store') }}" method="POST" enctype="multipart/form-data">
{!! csrf_field() !!}
<div class="row g-4">

    {{-- Identitas --}}
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white"><h6 class="mb-0"><i class="fas fa-school me-2"></i>Identitas Sekolah</h6></div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Sekolah</label>
                        <input type="text" name="nama_sekolah" class="form-control" value="{{ $data->nama_sekolah }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $data->email }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Telepon</label>
                        <input type="text" name="telepon" class="form-control" value="{{ $data->telepon }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">WhatsApp (Format: 628xxx)</label>
                        <input type="text" name="whatsapp" class="form-control" value="{{ $data->whatsapp }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-control" rows="2">{{ $data->alamat }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Embed Google Maps (src URL dari iframe)</label>
                        <textarea name="google_maps" class="form-control" rows="2" placeholder="https://maps.google.com/maps?q=...&output=embed">{{ $data->google_maps }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Kepala Sekolah --}}
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white"><h6 class="mb-0"><i class="fas fa-user-tie me-2"></i>Kepala Sekolah</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nama Kepala Sekolah</label>
                        <input type="text" name="nama_kepsek" class="form-control" value="{{ $data->nama_kepsek ?? '' }}" placeholder="Sukanto, S.Pd.">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">NIP</label>
                        <input type="text" name="nip_kepsek" class="form-control" value="{{ $data->nip_kepsek ?? '' }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Sambutan Singkat Kepala Sekolah</label>
                        <textarea name="sambutan_kepsek_singkat" class="form-control" rows="3" placeholder="Teks untuk ditampilkan di bagian sambutan homepage...">{{ $data->sambutan_kepsek_singkat ?? '' }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Foto Kepala Sekolah</label>
                        @if($data->foto_kepsek)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$data->foto_kepsek) }}" style="max-height:80px; border-radius:8px;">
                            </div>
                        @endif
                        <input type="file" name="foto_kepsek" class="form-control" accept="image/*">
                        <small class="text-muted">Foto untuk halaman Sambutan Kepala Sekolah.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Sekolah --}}
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white"><h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistik Sekolah (Tampilan Angka di Homepage)</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jumlah Siswa Aktif</label>
                        <input type="number" name="jumlah_siswa" class="form-control" value="{{ $data->jumlah_siswa ?? '' }}" placeholder="350">
                        <small class="text-muted">Kosongkan = hitung otomatis dari DB</small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jumlah Guru & Tendik</label>
                        <input type="number" name="jumlah_guru" class="form-control" value="{{ $data->jumlah_guru ?? '' }}" placeholder="24">
                        <small class="text-muted">Kosongkan = hitung otomatis dari DB</small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Jumlah Alumni</label>
                        <input type="number" name="jumlah_alumni" class="form-control" value="{{ $data->jumlah_alumni ?? '' }}" placeholder="1500">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Akreditasi</label>
                        <select name="akreditasi" class="form-select">
                            @foreach(['A', 'B', 'C', 'Unggul', 'Baik Sekali', 'Baik'] as $ak)
                            <option value="{{ $ak }}" {{ ($data->akreditasi ?? 'A') == $ak ? 'selected' : '' }}>{{ $ak }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Image Slider --}}
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-warning"><h6 class="mb-0"><i class="fas fa-images me-2"></i>Image Slider Hero (Maks. 5 Foto)</h6></div>
            <div class="card-body">
                <p class="text-muted small mb-3"><i class="fas fa-info-circle text-info me-1"></i>Upload foto untuk slider homepage. Jika kosong, akan menggunakan gambar default. Ukuran ideal: 1920×700px.</p>
                <div class="row g-3">
                    @for($i = 1; $i <= 5; $i++)
                    <div class="col-md-4 col-lg-2d4">
                        <div class="card border h-100">
                            <div class="card-body p-3">
                                <label class="form-label fw-semibold">Foto Slider {{ $i }}</label>
                                @php $field = 'slider_'.$i; @endphp
                                @if($data->$field)
                                    <div class="mb-2 position-relative">
                                        <img src="{{ asset('storage/'.$data->$field) }}"
                                             class="img-fluid rounded" style="height:100px; width:100%; object-fit:cover;">
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox" name="delete_{{ $field }}" id="del_{{ $field }}">
                                            <label class="form-check-label text-danger small" for="del_{{ $field }}">Hapus foto ini</label>
                                        </div>
                                    </div>
                                @else
                                    <div class="mb-2 bg-light rounded d-flex align-items-center justify-content-center" style="height:100px;">
                                        <i class="fas fa-image text-muted fa-2x"></i>
                                    </div>
                                @endif
                                <input type="file" name="{{ $field }}" class="form-control form-control-sm" accept="image/*">
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    {{-- Visi Misi & Sejarah --}}
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white"><h6 class="mb-0"><i class="fas fa-eye me-2"></i>Visi, Misi & Sejarah</h6></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Visi Sekolah</label>
                        <textarea name="visi" class="form-control" rows="4">{{ $data->visi }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Misi Sekolah</label>
                        <textarea name="misi" class="form-control" rows="4">{{ $data->misi }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Sejarah Sekolah</label>
                        <textarea name="sejarah" class="form-control" rows="5">{{ $data->sejarah }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Sambutan Kepala Sekolah (Lengkap)</label>
                        <textarea name="sambutan_kepsek" class="form-control" rows="5">{{ $data->sambutan_kepsek }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Media Sosial --}}
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-info text-white"><h6 class="mb-0"><i class="fas fa-share-alt me-2"></i>Media Sosial & YouTube</h6></div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fab fa-facebook text-primary me-1"></i>Facebook URL</label>
                    <input type="url" name="facebook" class="form-control" value="{{ $data->facebook }}" placeholder="https://facebook.com/...">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fab fa-instagram text-danger me-1"></i>Instagram URL</label>
                    <input type="url" name="instagram" class="form-control" value="{{ $data->instagram }}" placeholder="https://instagram.com/...">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fab fa-youtube text-danger me-1"></i>YouTube URL</label>
                    <input type="url" name="youtube" class="form-control" value="{{ $data->youtube }}" placeholder="https://youtube.com/...">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="fab fa-youtube text-danger me-1"></i>YouTube Embed ID (untuk video profil)</label>
                    <input type="text" name="youtube_embed" class="form-control" value="{{ $data->youtube_embed ?? '' }}" placeholder="dQw4w9WgXcQ">
                    <small class="text-muted">Isi hanya ID video YouTube (bagian setelah watch?v=)</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Logo --}}
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-warning"><h6 class="mb-0"><i class="fas fa-image me-2"></i>Logo Sekolah</h6></div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label fw-semibold">Logo Sekolah</label>
                    @if($data->logo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/'.$data->logo) }}" style="max-height:80px; background:#f8f9fa; padding:8px; border-radius:8px; border:1px solid #dee2e6;">
                        </div>
                    @endif
                    <input type="file" name="logo" class="form-control" accept="image/*">
                    <small class="text-muted">Format PNG transparan direkomendasikan.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary btn-lg px-5">
            <i class="fas fa-save me-2"></i>Simpan Semua Pengaturan
        </button>
    </div>

</div>
</form>
@endsection