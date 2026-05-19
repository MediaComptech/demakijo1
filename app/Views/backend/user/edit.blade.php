@extends('layouts.admin')
@section('title', 'Edit User')
@section('content')
<div class="card shadow">
    <div class="card-body">
        <form action="{{ route('admin.user.update', $data->id) }}" method="POST">
            {!! csrf_field() !!} <input type="hidden" name="_method" value="PUT">
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ $data->name }}" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $data->email }}" required>
            </div>
            <div class="mb-3">
                <label>Password (Kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <button class="btn btn-primary">Update</button>
            <a href="{{ url('admin.user.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection