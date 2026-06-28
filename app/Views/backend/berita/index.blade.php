@extends('layouts.admin')
@section('title', 'Manajemen Berita')
@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center py-3"
         style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;">
        <h5 class="mb-0 text-white fw-bold"><i class="fas fa-newspaper me-2"></i>Data Berita & Artikel</h5>
        <a href="{{ url('/admin/berita/create') }}" class="btn btn-warning btn-sm fw-semibold">
            <i class="fas fa-plus me-1"></i>Tambah Berita
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th width="80">Thumbnail</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th width="110" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($item->gambar)
                            <img src="{{ asset('storage/'.$item->gambar) }}"
                                 style="height:45px;width:70px;object-fit:cover;border-radius:6px;" class="shadow-sm">
                        @else
                            <span class="badge bg-secondary"><i class="fas fa-image"></i></span>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $item->judul }}</td>
                    <td>
                        <span class="badge bg-light text-dark border">{{ $item->kategori->nama ?? '-' }}</span>
                    </td>
                    <td>
                        @if($item->is_published)
                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Publikasi</span>
                        @else
                            <span class="badge bg-secondary"><i class="fas fa-clock me-1"></i>Draft</span>
                        @endif
                    </td>
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.berita.edit', $item->id) }}"
                           class="btn btn-warning btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ url('admin.berita.destroy', $item->id) }}" method="POST"
                              class="d-inline form-delete-confirm" data-label="berita '{{ addslashes($item->judul) }}'">
                            {!! csrf_field() !!} <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger btn-sm" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                        Belum ada data berita.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection