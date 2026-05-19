@extends('layouts.admin')
@section('title', 'Edit Guru/Tendik')
@section('content')
<div class="card shadow-sm">
    <div class="card-header"><h5 class="mb-0">Edit Guru/Tendik</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ route('admin.guru.update', $data->id) }}" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">
            
        <div class="mb-3">
            <label class="form-label fw-semibold">NIP</label>
            <input type="text" name="nip" class="form-control" value="{{ old('nip', $data->nip) }}" >
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $data->nama) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Jabatan / Mapel</label>
            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $data->jabatan) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Pendidikan Terakhir</label>
            <textarea name="pendidikan" class="form-control" rows="4" >{{ old('pendidikan', $data->pendidikan) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Biodata / Tentang</label>
            <textarea name="biodata" class="form-control" rows="4" >{{ old('biodata', $data->biodata) }}</textarea>
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
                <a href="{{ url('admin.guru.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection