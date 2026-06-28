@extends('layouts.admin')
@section('title', 'Kenapa Memilih Kami')
@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center py-3"
         style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;">
        <h6 class="mb-0 text-white fw-bold"><i class="fas fa-star me-2"></i>Data Keunggulan Sekolah</h6>
        <a href="{{ url('/admin/keunggulan/create') }}" class="btn btn-warning btn-sm fw-bold">
            <i class="fas fa-plus me-1"></i>Tambah Item
        </a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3" width="60">No</th>
                    <th width="80">Urutan</th>
                    <th width="80">Icon</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th width="80">Status</th>
                    <th width="130" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $i => $item)
                <tr>
                    <td class="ps-3">{{ $i + 1 }}</td>
                    <td><span class="badge bg-secondary">{{ $item->urutan }}</span></td>
                    <td class="text-center">
                        <i class="{{ $item->icon }} fs-4 text-primary"></i>
                    </td>
                    <td class="fw-semibold">{{ $item->judul }}</td>
                    <td><small class="text-muted">{{ \Illuminate\Support\Str::limit($item->deskripsi, 80) }}</small></td>
                    <td>
                        @if($item->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.keunggulan.edit', $item) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.keunggulan.destroy', $item) }}" method="POST" class="d-inline form-delete-confirm"
                              data-label="keunggulan '{{ addslashes($item->judul ?? '') }}'">
                            {!! csrf_field() !!} <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fas fa-star fa-3x mb-3 d-block opacity-25"></i>
                        Belum ada data. <a href="{{ url('admin.keunggulan.create') }}">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
