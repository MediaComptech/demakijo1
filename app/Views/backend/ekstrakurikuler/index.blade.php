@extends('layouts.admin')
@section('title', 'Data Ekstrakurikuler')
@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center py-3"
         style="background:linear-gradient(135deg,#14532d,#22c55e);border-radius:.5rem .5rem 0 0;">
        <h5 class="mb-0 text-white fw-bold"><i class="fas fa-futbol me-2"></i>Data Ekstrakurikuler</h5>
        <a href="{{ url('/admin/ekstrakurikuler/create') }}" class="btn btn-warning btn-sm fw-semibold">
            <i class="fas fa-plus me-1"></i>Tambah Ekstra
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th width="5%">No</th>
                        <th width="60">Foto</th>
                        <th>Nama Ekstrakurikuler</th>
                        <th>Deskripsi</th>
                        <th width="110" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($item->foto ?? $item->cover ?? $item->gambar ?? null)
                                <img src="{{ asset('storage/' . ($item->foto ?? $item->cover ?? $item->gambar)) }}"
                                     style="height:45px;width:45px;object-fit:cover;border-radius:6px;" class="shadow-sm">
                            @else
                                <div class="rounded bg-success d-flex align-items-center justify-content-center"
                                     style="height:45px;width:45px;">
                                    <i class="fas fa-futbol text-white small"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $item->nama ?? '-' }}</td>
                        <td><span class="text-muted small">{{ Str::limit($item->deskripsi ?? '-', 60) }}</span></td>
                        <td class="text-center">
                            <a href="{{ route('admin.ekstrakurikuler.edit', $item->id) }}"
                               class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ url('admin.ekstrakurikuler.destroy', $item->id) }}" method="POST"
                                  class="d-inline form-delete-confirm" data-label="ekstra '{{ addslashes($item->nama ?? '') }}'">
                                {!! csrf_field() !!} <input type="hidden" name="_method" value="DELETE">
                                <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="99" class="text-center text-muted py-5">
                            <i class="fas fa-inbox fa-2x mb-2 d-block opacity-50"></i>
                            Belum ada data ekstrakurikuler.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection