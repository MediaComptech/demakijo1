@extends('layouts.admin')
@section('title', 'Edit Prestasi')
@section('content')
<div class="card shadow-sm">
    <div class="card-header"><h5 class="mb-0">Edit Prestasi</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ route('admin.prestasi.update', $data->id) }}" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">
            
        <div class="mb-3">
            <label class="form-label fw-semibold">Judul Prestasi</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $data->judul) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Tingkat</label>
            <select name="tingkat" class="form-select" required>
                <option value="">-- Pilih Tingkat --</option>
                <option value="Sekolah" {{ old('tingkat', $data->tingkat) == 'Sekolah' ? 'selected' : '' }}>Sekolah</option><option value="Kecamatan" {{ old('tingkat', $data->tingkat) == 'Kecamatan' ? 'selected' : '' }}>Kecamatan</option><option value="Kapanewon" {{ old('tingkat', $data->tingkat) == 'Kapanewon' ? 'selected' : '' }}>Kapanewon</option><option value="Kabupaten" {{ old('tingkat', $data->tingkat) == 'Kabupaten' ? 'selected' : '' }}>Kabupaten</option><option value="Provinsi" {{ old('tingkat', $data->tingkat) == 'Provinsi' ? 'selected' : '' }}>Provinsi</option><option value="Nasional" {{ old('tingkat', $data->tingkat) == 'Nasional' ? 'selected' : '' }}>Nasional</option><option value="Internasional" {{ old('tingkat', $data->tingkat) == 'Internasional' ? 'selected' : '' }}>Internasional</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Tanggal Prestasi</label>
            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $data->tanggal) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4" >{{ old('deskripsi', $data->deskripsi) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Foto Prestasi</label>
            @if(isset($data->foto) && $data->foto)
                <div class="mb-2"><img src="{{ asset('storage/' . $data->foto) }}" style="max-height:120px; border-radius:8px;"></div>
            @endif
            <input type="file" name="foto" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah Foto Prestasi.</small>
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update</button>
                <a href="{{ url('admin.prestasi.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection