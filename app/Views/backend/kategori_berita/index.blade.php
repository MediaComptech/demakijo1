@extends("layouts.admin")
@section("title", "Kategori Berita")
@section("content")
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center py-3"
         style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;">
        <h5 class="mb-0 text-white fw-bold"><i class="fas fa-tags me-2"></i>Kategori Berita</h5>
        <a href="{{ url('/admin/kategori-berita/create') }}" class="btn btn-warning btn-sm fw-semibold">
            <i class="fas fa-plus me-1"></i>Tambah Kategori
        </a>
    </div>
    <div class="card-body">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Jumlah Berita</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="fw-bold">{{ $item->nama }}</td>
                <td><code class="text-muted">{{ $item->slug }}</code></td>
                <td><span class="badge bg-primary">{{ $item->beritas_count ?? 0 }} berita</span></td>
                <td class="text-center">
                    <a href="{{ route('admin.kategori-berita.edit', $item->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ url('admin.kategori-berita.destroy', $item->id) }}" method="POST"
                          class="d-inline form-delete-confirm" data-label="kategori '{{ addslashes($item->nama) }}'">
                        {!! csrf_field() !!} <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-5">
                    <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                    Belum ada kategori.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection