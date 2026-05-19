@extends('layouts.admin')
@section('title', 'Manajemen Berita')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Berita</h5>
        <a href="{{ url('admin.berita.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Tambah</a>
    </div>
    <div class="card-body">
        @if(session('success'))<div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark"><tr>
                    <th>No</th><th>Thumbnail</th><th>Judul</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th>Aksi</th>
                </tr></thead>
                <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>@if($item->gambar)<img src="{{ asset('storage/'.$item->gambar) }}" style="height:45px;width:70px;object-fit:cover;border-radius:6px;">@else<span class="text-muted">-</span>@endif</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->kategori->nama ?? '-' }}</td>
                    <td>@if($item->is_published)<span class="badge bg-success">Publikasi</span>@else<span class="badge bg-secondary">Draft</span>@endif</td>
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.berita.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ url('admin.berita.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus berita ini?')">
                            {!! csrf_field() !!} <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Belum ada berita.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection