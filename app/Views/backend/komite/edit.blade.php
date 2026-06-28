@extends('layouts.admin')
@section('title', 'Edit Anggota Komite')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center py-3" style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;"><h5 class="mb-0 text-white fw-bold"><i class="fas fa-edit me-2"></i>Edit Anggota Komite</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ route('admin.komite.update', $data->id) }}" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">
            
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Anggota</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $data->nama) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Jabatan</label>
            <select name="jabatan" class="form-select" required>
                <option value="">-- Pilih Jabatan --</option>
                <option value="Ketua Komite" {{ old('jabatan', $data->jabatan) == 'Ketua Komite' ? 'selected' : '' }}>Ketua Komite</option><option value="Wakil Ketua" {{ old('jabatan', $data->jabatan) == 'Wakil Ketua' ? 'selected' : '' }}>Wakil Ketua</option><option value="Sekretaris" {{ old('jabatan', $data->jabatan) == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option><option value="Bendahara" {{ old('jabatan', $data->jabatan) == 'Bendahara' ? 'selected' : '' }}>Bendahara</option><option value="Anggota" {{ old('jabatan', $data->jabatan) == 'Anggota' ? 'selected' : '' }}>Anggota</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Urutan Tampil</label>
            <input type="number" name="urutan" class="form-control" value="{{ old('urutan', $data->urutan) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Foto Profil</label>
            @if(isset($data->foto) && $data->foto)
                <div class="mb-2"><img src="{{ asset('storage/' . $data->foto) }}" style="max-height:120px; border-radius:8px;"></div>
            @endif
            <input type="file" name="foto" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah Foto Profil.</small>
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update</button>
                <a href="{{ url('admin.komite.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection