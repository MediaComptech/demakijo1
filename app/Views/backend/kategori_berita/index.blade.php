@extends("layouts.admin")
@section("title", "Kategori Berita")
@section("content")
<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Kategori Berita</h5>
        <a href="{{ url('admin.kategori-berita.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus me-1"></i>Tambah</a>
    </div>
    <div class="card-body">
        @if(session('success'))<div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>@endif
        <table class="table table-hover align-middle">
            <thead class="table-dark"><tr><th>No</th><th>Nama Kategori</th><th>Slug</th><th>Jumlah Berita</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="fw-bold">{{ $item->nama }}</td>
                <td><code>{{ $item->slug }}</code></td>
                <td><span class="badge bg-primary">{{ $item->beritas_count ?? 0 }} berita</span></td>
                <td>
                    <a href="{{ route('admin.kategori-berita.edit', $item->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                    <form action="{{ url('admin.kategori-berita.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                        {!! csrf_field() !!} <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada kategori.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection