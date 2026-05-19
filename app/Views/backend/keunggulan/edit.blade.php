@extends('layouts.admin')
@section('title', 'Edit Keunggulan')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning">
                <h6 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Item Keunggulan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.keunggulan.update', $keunggulan) }}" method="POST">
                    {!! csrf_field() !!} <input type="hidden" name="_method" value="PUT">

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Icon (Font Awesome Class) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i id="iconPreview" class="{{ old('icon', $keunggulan->icon) }}"></i></span>
                            <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror"
                                   value="{{ old('icon', $keunggulan->icon) }}"
                                   oninput="document.getElementById('iconPreview').className = this.value" required>
                            @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <small class="text-muted">Contoh: <code>fas fa-map-marker-alt</code>, <code>fas fa-star</code>, <code>fas fa-building</code>, <code>fas fa-user-tie</code></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul', $keunggulan->judul) }}" required>
                        @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4">{{ old('deskripsi', $keunggulan->deskripsi) }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control"
                                   value="{{ old('urutan', $keunggulan->urutan) }}" min="0">
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check form-switch ms-2 mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                       {{ old('is_active', $keunggulan->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">Tampilkan di Website</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-warning px-4 fw-bold">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                        <a href="{{ url('admin.keunggulan.index') }}" class="btn btn-secondary px-4">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
