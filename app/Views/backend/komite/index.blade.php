@extends('layouts.admin')
@section('title', 'Data Komite Sekolah')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Komite Sekolah</h5>
        <a href="{{ url('admin.komite.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Tambah</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show"><i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr><th width="5%">No</th><th width="80">Foto</th><th>Nama</th><th>Jabatan</th><th>Urutan</th><th width="110">Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr><td>{{ $loop->iteration }}</td><td>@if($item->foto ?? $item->cover ?? $item->gambar ?? null)<img src="{{ asset('storage/' . ($item->foto ?? $item->cover ?? $item->gambar)) }}" style="height:45px;width:45px;object-fit:cover;border-radius:6px;">@else<span class="text-muted">-</span>@endif</td><td>{{ $item->nama ?? '-' }}</td><td>{{ $item->jabatan ?? '-' }}</td><td>{{ $item->urutan ?? '-' }}</td><td>
    <a href="{{ route('admin.komite.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
    <form action="{{ url('admin.komite.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
        {!! csrf_field() !!} <input type="hidden" name="_method" value="DELETE">
        <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
    </form>
</td></tr>
                    @empty
                    <tr><td colspan="99" class="text-center text-muted py-4">Belum ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection