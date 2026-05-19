@extends('layouts.admin')
@section('title', 'Edit PPDB')
@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header"><h6 class="mb-0 fw-bold">Data Pendaftar</h6></div>
            <div class="card-body">
                <form action="{{ route('admin.ppdb.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                    {!! csrf_field() !!} <input type="hidden" name="_method" value="PUT">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. Pendaftaran</label>
                        <input type="text" class="form-control bg-light" value="{{ $data->no_pendaftaran }}" readonly>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ $data->nama_lengkap }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="L" {{ $data->jenis_kelamin=='L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ $data->jenis_kelamin=='P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control" value="{{ $data->tempat_lahir }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ $data->tanggal_lahir }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control" value="{{ $data->nama_ayah }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control" value="{{ $data->nama_ibu }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">No. HP / WA</label>
                            <input type="text" name="no_telp" class="form-control" value="{{ $data->no_telp }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Asal TK/RA</label>
                            <input type="text" name="asal_sekolah" class="form-control" value="{{ $data->asal_sekolah }}">
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Status Update Section --}}
                    <div class="p-3 rounded-3 border border-2 border-primary">
                        <h6 class="fw-bold text-primary mb-3"><i class="fas fa-clipboard-check me-2"></i>Keputusan Panitia</h6>
                        <div class="row g-3">
                            <div class="col-md-5">
                                <label class="form-label fw-semibold">Status Pendaftaran</label>
                                <select name="status" class="form-select">
                                    <option value="pending" {{ $data->status=='pending' ? 'selected':'' }}>⏳ Menunggu Verifikasi</option>
                                    <option value="verified" {{ $data->status=='verified' ? 'selected':'' }}>🔍 Sedang Diproses</option>
                                    <option value="accepted" {{ $data->status=='accepted' ? 'selected':'' }}>✅ DITERIMA</option>
                                    <option value="rejected" {{ $data->status=='rejected' ? 'selected':'' }}>❌ Tidak Diterima</option>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label fw-semibold">Catatan untuk Orang Tua</label>
                                <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan akan ditampilkan saat orang tua mengecek status...">{{ $data->catatan }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                        <a href="{{ url('admin.ppdb.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Right: Berkas --}}
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header"><h6 class="mb-0 fw-bold"><i class="fas fa-folder-open me-2"></i>Berkas Dokumen</h6></div>
            <div class="card-body">
                @foreach(['berkas_kk'=>'Kartu Keluarga','berkas_akta'=>'Akta Kelahiran','berkas_pasfoto'=>'Pas Foto'] as $field => $label)
                <div class="mb-4">
                    <label class="form-label fw-semibold small">{{ $label }}</label>
                    @if($data->$field)
                        @php $ext = pathinfo($data->$field, PATHINFO_EXTENSION); @endphp
                        @if(in_array(strtolower($ext), ['jpg','jpeg','png']))
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$data->$field) }}" class="img-thumbnail" style="max-height:150px;">
                            </div>
                        @else
                            <div class="mb-2">
                                <a href="{{ asset('storage/'.$data->$field) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-file-pdf me-1"></i>Lihat Dokumen
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-muted small mb-2"><i class="fas fa-times-circle me-1 text-danger"></i>Belum diupload</div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection