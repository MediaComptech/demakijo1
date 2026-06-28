@extends('layouts.admin')
@section('title', 'Tambah Data Alumni')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center py-3" style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;"><h5 class="mb-0 text-white fw-bold"><i class="fas fa-plus me-2"></i>Tambah Data Alumni</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ url('admin.alumni.store') }}" method="POST">
            {!! csrf_field() !!}
            
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Alumni</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Tahun Lulus</label>
            <input type="number" name="tahun_lulus" class="form-control" value="{{ old('tahun_lulus') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Pekerjaan / Sekolah Lanjutan</label>
            <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}" >
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Testimoni / Pesan</label>
            <textarea name="testimoni" class="form-control" rows="4" >{{ old('testimoni') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Status Verifikasi</label>
            <select name="is_verified" class="form-select" >
                <option value="">-- Pilih Status Verifikasi --</option>
                <option value="1">Terverifikasi</option><option value="0">Belum Diverifikasi</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Foto Alumni</label>
            <input type="file" name="foto" class="form-control">
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ url('admin.alumni.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection