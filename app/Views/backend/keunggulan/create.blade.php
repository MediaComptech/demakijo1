@extends('layouts.admin')
@section('title', 'Tambah Keunggulan')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Item Keunggulan</h6>
            </div>
            <div class="card-body">
                <form action="{{ url('admin.keunggulan.store') }}" method="POST">
                    {!! csrf_field() !!}

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Icon (Font Awesome Class) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i id="iconPreview" class="{{ old('icon', 'fas fa-star') }}"></i></span>
                            <input type="text" name="icon" class="form-control @error('icon') is-invalid @enderror"
                                   value="{{ old('icon', 'fas fa-star') }}" placeholder="fas fa-star"
                                   oninput="document.getElementById('iconPreview').className = this.value" required>
                            @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <small class="text-muted">Contoh: <code>fas fa-map-marker-alt</code>, <code>fas fa-star</code>, <code>fas fa-building</code>, <code>fas fa-user-tie</code></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                               value="{{ old('judul') }}" placeholder="Misal: Lokasi Strategis" required>
                        @error('judul')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4"
                                  placeholder="Tuliskan deskripsi singkat keunggulan ini...">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Urutan Tampil</label>
                            <input type="number" name="urutan" class="form-control" value="{{ old('urutan', 0) }}" min="0">
                        </div>
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check form-switch ms-2 mt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active"
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="is_active">Tampilkan di Website</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="fas fa-save me-2"></i>Simpan
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
