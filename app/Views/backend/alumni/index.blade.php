@extends('layouts.admin')
@section('title', 'Data Alumni')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Alumni</h5>
        <a href="{{ url('admin.alumni.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Tambah</a>
    </div>
    <div class="card-body">
        @if(session('success'))<div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark"><tr><th>No</th><th>Foto</th><th>Nama</th><th>Lulus</th><th>Pekerjaan</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>@if($item->foto)<img src="{{ asset('storage/'.$item->foto) }}" style="height:45px;width:45px;object-fit:cover;border-radius:50%;">@else<span class="text-muted">-</span>@endif</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->tahun_lulus ?? '-' }}</td>
                    <td>{{ $item->pekerjaan ?? '-' }}</td>
                    <td>@if($item->is_verified)<span class="badge bg-success">Terverifikasi</span>@else<span class="badge bg-warning text-dark">Belum</span>@endif</td>
                    <td>
                        <a href="{{ route('admin.alumni.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ url('admin.alumni.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                            {!! csrf_field() !!} <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Belum ada data alumni.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection