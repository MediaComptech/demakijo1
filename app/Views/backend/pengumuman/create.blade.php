@extends('layouts.admin')
@section('title', 'Tambah Pengumuman')
@section('content')
<div class="card shadow-sm">
    <div class="card-header"><h5 class="mb-0">Tambah Pengumuman</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ url('admin.pengumuman.store') }}" method="POST">
            {!! csrf_field() !!}
            
        <div class="mb-3">
            <label class="form-label fw-semibold">Judul Pengumuman</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Isi Pengumuman</label>
            <textarea name="konten" class="form-control" rows="4" required>{{ old('konten') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">File Lampiran (PDF/DOCX)</label>
            <input type="file" name="file_lampiran" class="form-control">
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ url('admin.pengumuman.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection