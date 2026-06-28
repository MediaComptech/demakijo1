@extends('layouts.admin')
@section('title', 'Tambah Pendaftar PPDB')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center py-3" style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;"><h5 class="mb-0 text-white fw-bold"><i class="fas fa-plus me-2"></i>Tambah Pendaftar PPDB</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ url('admin.ppdb.store') }}" method="POST">
            {!! csrf_field() !!}
            
        <div class="mb-3">
            <label class="form-label fw-semibold">No. Pendaftaran</label>
            <input type="text" name="no_pendaftaran" class="form-control" value="{{ old('no_pendaftaran') }}" >
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap Calon Siswa</label>
            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">NISN</label>
            <input type="text" name="nisn" class="form-control" value="{{ old('nisn') }}" >
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Asal Sekolah (TK/RA)</label>
            <input type="text" name="asal_sekolah" class="form-control" value="{{ old('asal_sekolah') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Orang Tua</label>
            <input type="text" name="nama_orang_tua" class="form-control" value="{{ old('nama_orang_tua') }}" >
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">No. HP / WA</label>
            <input type="tel" name="no_hp" class="form-control" value="{{ old('no_hp') }}" >
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Alamat Lengkap</label>
            <textarea name="alamat" class="form-control" rows="4" >{{ old('alamat') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Status</label>
            <select name="status_verifikasi" class="form-select" >
                <option value="">-- Pilih Status --</option>
                <option value="Baru">Baru/Belum Diverifikasi</option><option value="Diterima">Diterima</option><option value="Ditolak">Ditolak</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Catatan Admin</label>
            <textarea name="catatan" class="form-control" rows="4" >{{ old('catatan') }}</textarea>
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ url('admin.ppdb.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection