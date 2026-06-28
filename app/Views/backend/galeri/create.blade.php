@extends('layouts.admin')
@section('title', 'Tambah Galeri Foto')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center py-3" style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;"><h5 class="mb-0 text-white fw-bold"><i class="fas fa-plus me-2"></i>Tambah Foto ke Galeri</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        <form enctype="multipart/form-data" action="{{ url('admin.galeri.store') }}" method="POST">
            {!! csrf_field() !!}
            <div class="mb-3">
                <label class="form-label fw-semibold">Album</label>
                <select name="album_id" class="form-select" required>
                    <option value="">-- Pilih Album --</option>
                    @foreach($album as $alb)
                    <option value="{{ $alb->id }}">{{ $alb->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Judul Foto</label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">File Foto</label>
                <input type="file" name="file" class="form-control" accept="image/*" required>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ url('admin.galeri.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection