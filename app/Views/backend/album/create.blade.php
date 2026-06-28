@extends('layouts.admin')
@section('title', 'Tambah Album')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center py-3" style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;"><h5 class="mb-0 text-white fw-bold"><i class="fas fa-plus me-2"></i>Tambah Album</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ url('admin.album.store') }}" method="POST">
            {!! csrf_field() !!}
            
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Album</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Kategori Album</label>
            <select name="kategori" class="form-select" required>
                <option value="Kegiatan Sekolah" {{ old('kategori') == 'Kegiatan Sekolah' ? 'selected' : '' }}>Kegiatan Sekolah</option>
                <option value="Ekstrakurikuler" {{ old('kategori') == 'Ekstrakurikuler' ? 'selected' : '' }}>Ekstrakurikuler</option>
                <option value="Prestasi" {{ old('kategori') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                <option value="Kunjungan" {{ old('kategori') == 'Kunjungan' ? 'selected' : '' }}>Kunjungan</option>
                <option value="Lainnya" {{ old('kategori') == 'Lainnya' || !old('kategori') ? 'selected' : '' }}>Lainnya</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Deskripsi Album</label>
            <textarea name="deskripsi" class="form-control" rows="4" >{{ old('deskripsi') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Cover Album</label>
            <input type="file" name="cover" class="form-control">
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ url('admin.album.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection