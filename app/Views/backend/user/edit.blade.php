@extends('layouts.admin')
@section('title', 'Edit User')
@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center py-3"
         style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;">
        <h5 class="mb-0 text-white fw-bold"><i class="fas fa-user-edit me-2"></i>Edit User: {{ $data->name }}</h5>
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

        <form action="{{ url('/admin/user/' . $data->id . '/update') }}" method="POST">
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ $data->name }}" required placeholder="Nama lengkap">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ $data->email }}" required placeholder="email@contoh.com">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Password Baru</label>
                    <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                    <div class="form-text text-muted"><i class="fas fa-info-circle me-1"></i>Isi hanya jika ingin mengganti password.</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Role / Peran</label>
                    @php $currentRole = $data->role ?? 'admin'; @endphp
                    <select name="role" class="form-select" {{ $data->id == 1 ? 'disabled' : '' }}>
                        <option value="admin" {{ $currentRole == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="operator" {{ $currentRole == 'operator' ? 'selected' : '' }}>Operator</option>
                        <option value="super-admin" {{ $currentRole == 'super-admin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                    @if($data->id == 1)
                        <input type="hidden" name="role" value="{{ $currentRole }}">
                        <div class="form-text text-warning"><i class="fas fa-lock me-1"></i>Role Super Admin tidak dapat diubah.</div>
                    @endif
                </div>
            </div>
            <hr class="my-3">
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-1"></i>Simpan Perubahan
                </button>
                <a href="{{ url('/admin/user') }}" class="btn btn-secondary px-4">
                    <i class="fas fa-times me-1"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection