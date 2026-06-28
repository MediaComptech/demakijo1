@extends('layouts.admin')
@section('title', 'Edit Galeri Foto')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center py-3" style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;">
        <h5 class="mb-0 text-white fw-bold"><i class="fas fa-edit me-2"></i>Edit Foto Galeri</h5>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        <form enctype="multipart/form-data" action="{{ route('admin.galeri.update', $data->id) }}" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="POST">
            <div class="mb-3">
                <label class="form-label fw-semibold">Album</label>
                <select name="album_id" class="form-select" required>
                    <option value="">-- Pilih Album --</option>
                    @foreach($album as $alb)
                    <option value="{{ $alb->id }}" {{ $data->album_id == $alb->id ? 'selected' : '' }}>{{ $alb->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Judul Foto</label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul', $data->judul) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">File Foto (Biarkan kosong jika tidak ingin mengubah)</label>
                <input type="file" name="file" class="form-control" accept="image/*">
                @if($data->file)
                    <div class="mt-2">
                        <span class="d-block small text-muted mb-1">Foto Saat Ini:</span>
                        <img src="{{ asset('storage/'.$data->file) }}" style="height:100px;width:150px;object-fit:cover;border-radius:8px;" class="shadow-sm border">
                    </div>
                @endif
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update</button>
                <a href="{{ url('admin.galeri.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection