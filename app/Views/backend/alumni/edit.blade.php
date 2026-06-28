@extends('layouts.admin')
@section('title', 'Edit Data Alumni')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center py-3" style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;"><h5 class="mb-0 text-white fw-bold"><i class="fas fa-edit me-2"></i>Edit Data Alumni</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ route('admin.alumni.update', $data->id) }}" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">
            
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Alumni</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $data->nama) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Tahun Lulus</label>
            <input type="number" name="tahun_lulus" class="form-control" value="{{ old('tahun_lulus', $data->tahun_lulus) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Pekerjaan / Sekolah Lanjutan</label>
            <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan', $data->pekerjaan) }}" >
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Testimoni / Pesan</label>
            <textarea name="testimoni" class="form-control" rows="4" >{{ old('testimoni', $data->testimoni) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Status Verifikasi</label>
            <select name="is_verified" class="form-select" >
                <option value="">-- Pilih Status Verifikasi --</option>
                <option value="1" {{ old('is_verified', $data->is_verified) == '1' ? 'selected' : '' }}>Terverifikasi</option><option value="0" {{ old('is_verified', $data->is_verified) == '0' ? 'selected' : '' }}>Belum Diverifikasi</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Foto Alumni</label>
            @if(isset($data->foto) && $data->foto)
                <div class="mb-2"><img src="{{ asset('storage/' . $data->foto) }}" style="max-height:120px; border-radius:8px;"></div>
            @endif
            <input type="file" name="foto" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah Foto Alumni.</small>
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update</button>
                <a href="{{ url('admin.alumni.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection