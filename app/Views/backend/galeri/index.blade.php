@extends('layouts.admin')
@section('title', 'Galeri Foto')
@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Galeri Foto</h5>
        <a href="{{ url('admin.galeri.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Tambah Foto</a>
    </div>
    <div class="card-body">
        @if(session('success'))<div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark"><tr><th>No</th><th>Foto</th><th>Judul</th><th>Album</th><th>Aksi</th></tr></thead>
                <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>@if($item->file)<img src="{{ asset('storage/'.$item->file) }}" style="height:50px;width:70px;object-fit:cover;border-radius:6px;">@else<span class="text-muted">-</span>@endif</td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->album->nama ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.galeri.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                        <form action="{{ url('admin.galeri.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus foto ini?')">
                            {!! csrf_field() !!} <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada foto.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection