@extends('layouts.admin')
@section('title', 'Tambah User')
@section('content')
<div class="card shadow">
    <div class="card-body">
        <form action="{{ url('admin.user.store') }}" method="POST">
            {!! csrf_field() !!}
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ url('admin.user.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection