@extends('layouts.admin')
@section('title', 'Tambah Ekstrakurikuler')
@section('content')
<div class="card shadow-sm">
    <div class="card-header"><h5 class="mb-0">Tambah Ekstrakurikuler</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ url('admin.ekstrakurikuler.store') }}" method="POST">
            {!! csrf_field() !!}
            
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Ekstrakurikuler</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" >{{ old('deskripsi') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Foto Kegiatan</label>
            <input type="file" name="foto" class="form-control">
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ url('admin.ekstrakurikuler.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection