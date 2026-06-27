@extends('layouts.admin')
@section('title', 'Galeri Foto')
@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center py-3"
         style="background:linear-gradient(135deg,#0f172a,#7c3aed);border-radius:.5rem .5rem 0 0;">
        <h5 class="mb-0 text-white fw-bold"><i class="fas fa-images me-2"></i>Data Galeri Foto</h5>
        <a href="{{ url('/admin/galeri/create') }}" class="btn btn-warning btn-sm fw-semibold">
            <i class="fas fa-plus me-1"></i>Upload Foto
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Judul</th>
                        <th>Album</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($item->file)
                            <img src="{{ asset('storage/'.$item->file) }}"
                                 style="height:50px;width:70px;object-fit:cover;border-radius:6px;" class="shadow-sm">
                        @else
                            <div class="rounded d-flex align-items-center justify-content-center bg-light border"
                                 style="height:50px;width:70px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $item->judul }}</td>
                    <td>
                        <span class="badge bg-dark">{{ $item->album->nama ?? '-' }}</span>
                    </td>
                    <td class="text-center">
                        <form action="{{ url('/admin/galeri/' . $item->id . '/delete') }}" method="POST"
                              class="d-inline form-delete-confirm" data-label="foto '{{ addslashes($item->judul ?? '') }}'">
                            {!! csrf_field() !!} <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                        Belum ada foto di galeri.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection