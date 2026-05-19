@extends('layouts.admin')
@section('title', 'Edit Kategori Berita')
@section('content')
<div class="card shadow-sm">
    <div class="card-header"><h5 class="mb-0">Edit Kategori Berita</h5></div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        <form enctype="multipart/form-data" action="{{ route('admin.kategori-berita.update', $data->id) }}" method="POST">
            {!! csrf_field() !!}
            <input type="hidden" name="_method" value="PUT">
            
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Kategori</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $data->nama) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Deskripsi</label>
            <input type="text" name="deskripsi" class="form-control" value="{{ old('deskripsi', $data->deskripsi) }}" >
        </div>
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Update</button>
                <a href="{{ url('admin.kategori-berita.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection