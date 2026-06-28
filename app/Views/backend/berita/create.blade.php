@extends('layouts.admin')
@section('title', 'Tambah Berita')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center py-3" style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;"><h5 class="mb-0 text-white fw-bold"><i class="fas fa-plus me-2"></i>Tambah Berita</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ url('admin.berita.store') }}" method="POST">
            {!! csrf_field() !!}
            
        <div class="mb-3">
            <label class="form-label fw-semibold">Judul Berita</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Kategori</label>
            <select name="kategori_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $opt)
                <option value="{{ $opt->id }}">{{ $opt->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Konten / Isi</label>
            <textarea name="konten" class="form-control" rows="4" required>{{ old('konten') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Status Publikasi</label>
            <select name="is_published" class="form-select" >
                <option value="">-- Pilih Status Publikasi --</option>
                <option value="1">Publikasikan</option><option value="0">Simpan Draft</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Gambar Utama (Thumbnail)</label>
            <input type="file" name="gambar" class="form-control">
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ url('admin.berita.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection