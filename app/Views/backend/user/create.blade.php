@extends('layouts.admin')
@section('title', 'Tambah User')
@section('content')
<div class="card shadow">
    <div class="card-header border-0 pb-0">
        <h3 class="card-title">Tambah User Baru</h3>
        <a href="{{ url('/admin/user') }}" class="btn btn-secondary btn-sm float-end"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif
        <form action="{{ url('/admin/user') }}" method="POST">
            {!! csrf_field() !!}
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Nama lengkap">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="email@contoh.com">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" required placeholder="Minimal 6 karakter">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Role / Peran</label>
                <select name="role" class="form-select">
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="operator" {{ old('role') == 'operator' ? 'selected' : '' }}>Operator</option>
                    <option value="super-admin" {{ old('role') == 'super-admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                <div class="form-text text-muted">Admin & Operator memiliki akses backend. Super Admin tidak dapat dihapus.</div>
            </div>
            <hr>
            <button class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan</button>
            <a href="{{ url('/admin/user') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection