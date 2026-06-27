@extends('layouts.admin')
@section('title', 'Tambah User')
@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center py-3"
         style="background:linear-gradient(135deg,#0f172a,#3b82f6);border-radius:.5rem .5rem 0 0;">
        <h5 class="mb-0 text-white fw-bold"><i class="fas fa-user-plus me-2"></i>Tambah User Baru</h5>
        <a href="{{ url('/admin/user') }}" class="btn btn-light btn-sm fw-semibold">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
    </div>
    <div class="card-body p-4">
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form action="{{ url('/admin/user') }}" method="POST">
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Nama lengkap">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="email@contoh.com">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Role / Peran</label>
                    <select name="role" class="form-select">
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                        <option value="super-admin" {{ old('role') == 'super-admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    <div class="form-text text-muted">Admin & Operator memiliki akses backend. Super Admin tidak dapat dihapus.</div>
                </div>
            </div>
            <hr class="my-3">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-1"></i>Simpan
                </button>
                <a href="{{ url('/admin/user') }}" class="btn btn-secondary px-4">
                    <i class="fas fa-times me-1"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection