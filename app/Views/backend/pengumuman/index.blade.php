@extends('layouts.admin')
@section('title', 'Data Pengumuman')
@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center py-3"
         style="background:linear-gradient(135deg,#003366,#0056b3);border-radius:.5rem .5rem 0 0;">
        <h5 class="mb-0 text-white fw-bold"><i class="fas fa-bullhorn me-2"></i>Data Pengumuman</h5>
        <a href="{{ url('/admin/pengumuman/create') }}" class="btn btn-warning btn-sm fw-semibold">
            <i class="fas fa-plus me-1"></i>Tambah Pengumuman
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th>Judul</th>
                        <th>Isi (Singkat)</th>
                        <th>Lampiran</th>
                        <th width="110" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="fw-semibold">{{ $item->judul ?? '-' }}</td>
                        <td class="text-muted small">{{ Str::limit($item->konten ?? '-', 60) }}</td>
                        <td>
                            @if($item->file_lampiran ?? null)
                                <a href="{{ asset('storage/'.$item->file_lampiran) }}" target="_blank"
                                   class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-paperclip me-1"></i>Lihat
                                </a>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.pengumuman.edit', $item->id) }}"
                               class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ url('admin.pengumuman.destroy', $item->id) }}" method="POST"
                                  class="d-inline form-delete-confirm" data-label="pengumuman '{{ addslashes($item->judul ?? '') }}'">
                                {!! csrf_field() !!} <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="99" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                            Belum ada pengumuman.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection