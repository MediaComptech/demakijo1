@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')
@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center py-3"
         style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;">
        <h5 class="mb-0 text-white fw-bold"><i class="fas fa-users-cog me-2"></i>Manajemen Pengguna</h5>
        <a href="{{ url('/admin/user/create') }}" class="btn btn-warning btn-sm fw-semibold">
            <i class="fas fa-plus me-1"></i>Tambah User
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Terdaftar Pada</th>
                        <th width="110" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $item->name }}</td>
                        <td><span class="text-muted small">{{ $item->email }}</span></td>
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
                        <td><span class="text-muted small">{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</span></td>
                        <td class="text-center">
                            <a href="{{ route('admin.user.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($item->id != 1)
                            <form action="{{ route('admin.user.destroy', $item->id) }}" method="POST"
                                  class="d-inline form-delete-confirm" data-label="user '{{ addslashes($item->name) }}'">
                                {!! csrf_field() !!} <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                            Belum ada data user.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection