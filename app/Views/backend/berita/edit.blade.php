@extends('layouts.admin')
@section('title', 'Edit Berita')
@section('content')
<div class="card shadow-sm">
    <div class="card-header"><h5 class="mb-0">Edit Berita</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ route('admin.berita.update', $data->id) }}" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">
            
        <div class="mb-3">
            <label class="form-label fw-semibold">Judul Berita</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $data->judul) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Kategori</label>
            <select name="kategori_id" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategori as $opt)
                <option value="{{ $opt->id }}" {{ old('kategori_id', $data->kategori_id) == $opt->id ? 'selected' : '' }}>{{ $opt->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Konten / Isi</label>
            <textarea name="konten" class="form-control" rows="4" required>{{ old('konten', $data->konten) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Status Publikasi</label>
            <select name="is_published" class="form-select" >
                <option value="">-- Pilih Status Publikasi --</option>
                <option value="1" {{ old('is_published', $data->is_published) == '1' ? 'selected' : '' }}>Publikasikan</option><option value="0" {{ old('is_published', $data->is_published) == '0' ? 'selected' : '' }}>Simpan Draft</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Gambar Utama (Thumbnail)</label>
            @if(isset($data->gambar) && $data->gambar)
                <div class="mb-2"><img src="{{ asset('storage/' . $data->gambar) }}" style="max-height:120px; border-radius:8px;"></div>
            @endif
            <input type="file" name="gambar" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah Gambar Utama (Thumbnail).</small>
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update</button>
                <a href="{{ url('admin.berita.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection