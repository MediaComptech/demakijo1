@extends('layouts.admin')
@section('title', 'Edit Data Siswa')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center py-3" style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;"><h5 class="mb-0 text-white fw-bold"><i class="fas fa-edit me-2"></i>Edit Data Siswa</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ route('admin.siswa.update', $data->id) }}" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">
            
        <div class="mb-3">
            <label class="form-label fw-semibold">NIS</label>
            <input type="text" name="nis" class="form-control" value="{{ old('nis', $data->nis) }}" >
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $data->nama) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Kelas</label>
            <select name="kelas" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                <option value="1A" {{ old('kelas', $data->kelas) == '1A' ? 'selected' : '' }}>1A</option><option value="1B" {{ old('kelas', $data->kelas) == '1B' ? 'selected' : '' }}>1B</option><option value="2A" {{ old('kelas', $data->kelas) == '2A' ? 'selected' : '' }}>2A</option><option value="2B" {{ old('kelas', $data->kelas) == '2B' ? 'selected' : '' }}>2B</option><option value="3A" {{ old('kelas', $data->kelas) == '3A' ? 'selected' : '' }}>3A</option><option value="3B" {{ old('kelas', $data->kelas) == '3B' ? 'selected' : '' }}>3B</option><option value="4A" {{ old('kelas', $data->kelas) == '4A' ? 'selected' : '' }}>4A</option><option value="4B" {{ old('kelas', $data->kelas) == '4B' ? 'selected' : '' }}>4B</option><option value="5A" {{ old('kelas', $data->kelas) == '5A' ? 'selected' : '' }}>5A</option><option value="5B" {{ old('kelas', $data->kelas) == '5B' ? 'selected' : '' }}>5B</option><option value="6A" {{ old('kelas', $data->kelas) == '6A' ? 'selected' : '' }}>6A</option><option value="6B" {{ old('kelas', $data->kelas) == '6B' ? 'selected' : '' }}>6B</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Alamat</label>
            <textarea name="alamat" class="form-control" rows="4" >{{ old('alamat', $data->alamat) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Foto Siswa</label>
            @if(isset($data->foto) && $data->foto)
                <div class="mb-2"><img src="{{ asset('storage/' . $data->foto) }}" style="max-height:120px; border-radius:8px;"></div>
            @endif
            <input type="file" name="foto" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah Foto Siswa.</small>
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update</button>
                <a href="{{ url('admin.siswa.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection