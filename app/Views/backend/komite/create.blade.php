@extends('layouts.admin')
@section('title', 'Tambah Anggota Komite')
@section('content')
<div class="card shadow-sm">
    <div class="card-header"><h5 class="mb-0">Tambah Anggota Komite</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ url('admin.komite.store') }}" method="POST">
            {!! csrf_field() !!}
            
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Anggota</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Jabatan</label>
            <select name="jabatan" class="form-select" required>
                <option value="">-- Pilih Jabatan --</option>
                <option value="Ketua Komite">Ketua Komite</option><option value="Wakil Ketua">Wakil Ketua</option><option value="Sekretaris">Sekretaris</option><option value="Bendahara">Bendahara</option><option value="Anggota">Anggota</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Urutan Tampil</label>
            <input type="number" name="urutan" class="form-control" value="{{ old('urutan') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Foto Profil</label>
            <input type="file" name="foto" class="form-control">
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ url('admin.komite.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection