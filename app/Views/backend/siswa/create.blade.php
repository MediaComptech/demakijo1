@extends('layouts.admin')
@section('title', 'Tambah Data Siswa')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center py-3" style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;"><h5 class="mb-0 text-white fw-bold"><i class="fas fa-plus me-2"></i>Tambah Data Siswa</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ url('admin.siswa.store') }}" method="POST">
            {!! csrf_field() !!}
            
        <div class="mb-3">
            <label class="form-label fw-semibold">NIS</label>
            <input type="text" name="nis" class="form-control" value="{{ old('nis') }}" >
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Kelas</label>
            <select name="kelas" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                <option value="1A">1A</option><option value="1B">1B</option><option value="2A">2A</option><option value="2B">2B</option><option value="3A">3A</option><option value="3B">3B</option><option value="4A">4A</option><option value="4B">4B</option><option value="5A">5A</option><option value="5B">5B</option><option value="6A">6A</option><option value="6B">6B</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Alamat</label>
            <textarea name="alamat" class="form-control" rows="4" >{{ old('alamat') }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Foto Siswa</label>
            <input type="file" name="foto" class="form-control">
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
                <a href="{{ url('admin.siswa.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection