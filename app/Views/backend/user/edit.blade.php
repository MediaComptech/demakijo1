@extends('layouts.admin')
@section('title', 'Edit User')
@section('content')
<div class="card shadow">
    <div class="card-header border-0 pb-0">
        <h3 class="card-title">Edit User: {{ $data->name }}</h3>
        <a href="{{ url('/admin/user') }}" class="btn btn-secondary btn-sm float-end"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
        @endif
        <form action="{{ route('admin.user.update', $data->id) }}" method="POST">
            {!! csrf_field() !!} <input type="hidden" name="_method" value="PUT">
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ $data->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ $data->email }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Password Baru</label>
                <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                <div class="form-text text-muted">Isi hanya jika ingin mengganti password.</div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Role / Peran</label>
                @php $currentRole = $data->role ?? 'admin'; @endphp
                <select name="role" class="form-select" {{ $data->id == 1 ? 'disabled' : '' }}>
                    <option value="admin" {{ $currentRole == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="operator" {{ $currentRole == 'operator' ? 'selected' : '' }}>Operator</option>
                    <option value="super-admin" {{ $currentRole == 'super-admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                @if($data->id == 1)
                    <input type="hidden" name="role" value="{{ $currentRole }}">
                    <div class="form-text text-warning"><i class="fas fa-lock"></i> Role Super Admin tidak dapat diubah.</div>
                @endif
            </div>
            <hr>
            <button class="btn btn-primary"><i class="fas fa-save me-1"></i>Update</button>
            <a href="{{ url('/admin/user') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection