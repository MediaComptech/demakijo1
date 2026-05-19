@extends('layouts.admin')
@section('title', 'Tambah Prestasi')
@section('content')
<div class="card shadow-sm">
    <div class="card-header"><h5 class="mb-0">Tambah Prestasi</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ url('admin.prestasi.store') }}" method="POST">
            {!! csrf_field() !!}
            
        <div class="mb-3">
            <label class="form-label fw-semibold">Judul Prestasi</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Tingkat</label>
            <select name="tingkat" class="form-select" required>
                <option value="">-- Pilih Tingkat --</option>
                <option value="Sekolah">Sekolah</option><option value="Kecamatan">Kecamatan</option><option value="Kapanewon">Kapanewon</option><option value="Kabupaten">Kabupaten</option><option value="Provinsi">Provinsi</option><option value="Nasional">Nasional</option><option value="Internasional">Internasional</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Tanggal Prestasi</label>
            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" >{{ old('deskripsi') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Foto Prestasi</label>
            <input type="file" name="foto" class="form-control">
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ url('admin.prestasi.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection