@extends('layouts.admin')
@section('title', 'Tambah Guru/Tendik')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center py-3" style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;"><h5 class="mb-0 text-white fw-bold"><i class="fas fa-plus me-2"></i>Tambah Guru/Tendik</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ url('admin.guru.store') }}" method="POST">
            {!! csrf_field() !!}
            
        <div class="mb-3">
            <label class="form-label fw-semibold">NIP</label>
            <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" >
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Jabatan / Mapel</label>
            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Pendidikan Terakhir</label>
            <textarea name="pendidikan" class="form-control" rows="4" >{{ old('pendidikan') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Biodata / Tentang</label>
            <textarea name="biodata" class="form-control" rows="4" >{{ old('biodata') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Foto Profil</label>
            <input type="file" name="foto" class="form-control">
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ url('admin.guru.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection