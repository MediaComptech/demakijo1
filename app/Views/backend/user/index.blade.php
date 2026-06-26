@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')
@section('content')
<div class="card shadow">
    <div class="card-header border-0 pb-0">
        <h3 class="card-title">Data User</h3>
        <a href="{{ url('/admin/user/create') }}" class="btn btn-primary btn-sm float-end"><i class="fas fa-plus me-1"></i> Tambah User</a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Terdaftar Pada</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        @php $role = $item->role ?? 'admin'; @endphp
                        @if($role === 'super-admin')
                            <span class="badge bg-danger">Super Admin</span>
                        @elseif($role === 'operator')
                            <span class="badge bg-info text-dark">Operator</span>
                        @else
                            <span class="badge bg-primary">Admin</span>
                        @endif
                    </td>
                    <td>{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</td>
                    <td>
                        <a href="{{ route('admin.user.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        @if($item->id != 1)
                        <form action="{{ route('admin.user.destroy', $item->id) }}" method="POST" class="d-inline">
                            {!! csrf_field() !!} <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus user {{ $item->name }}?')"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
                @if($data->isEmpty())
                <tr><td colspan="6" class="text-center text-muted py-4">Belum ada data user.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection