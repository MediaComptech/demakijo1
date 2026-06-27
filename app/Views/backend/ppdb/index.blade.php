@extends('layouts.admin')
@section('title', 'PPDB Online')
@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center py-3"
         style="background:linear-gradient(135deg,#047857,#059669);border-radius:.5rem .5rem 0 0;">
        <h5 class="mb-0 text-white fw-bold"><i class="fas fa-user-plus me-2"></i>Data Pendaftar PPDB</h5>
        <div class="d-flex gap-2">
            <span class="badge bg-light text-dark">Total: {{ $data->count() }}</span>
            <span class="badge bg-warning text-dark">Pending: {{ $data->where('status','pending')->count() }}</span>
            <span class="badge bg-success">Diterima: {{ $data->where('status','accepted')->count() }}</span>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">No. Daftar</th>
                        <th>Nama Lengkap</th>
                        <th>L/P</th>
                        <th>Tgl Lahir</th>
                        <th>Asal TK</th>
                        <th>No. HP</th>
                        <th>Berkas</th>
                        <th>Status</th>
                        <th width="120" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($data as $item)
                <tr>
                    <td class="ps-3"><code class="text-primary fw-bold">{{ $item->no_pendaftaran }}</code></td>
                    <td>
                        <div class="fw-bold">{{ $item->nama_lengkap }}</div>
                        <small class="text-muted">{{ $item->agama }}</small>
                    </td>
                    <td>
                        @if($item->jenis_kelamin === 'L')
                            <span class="badge bg-primary">Laki-laki</span>
                        @else
                            <span class="badge bg-pink text-white" style="background:#e91e8c!important;">Perempuan</span>
                        @endif
                    </td>
                    <td class="small">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}</td>
                    <td class="small">{{ $item->asal_sekolah ?? '-' }}</td>
                    <td>
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $item->no_telp) }}" target="_blank" class="text-success text-decoration-none small">
                            <i class="fab fa-whatsapp"></i> {{ $item->no_telp }}
                        </a>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @if($item->berkas_kk)
                                <a href="{{ asset('storage/'.$item->berkas_kk) }}" target="_blank" class="btn btn-xs btn-outline-secondary btn-sm" title="Kartu Keluarga"><i class="fas fa-home"></i></a>
                            @endif
                            @if($item->berkas_akta)
                                <a href="{{ asset('storage/'.$item->berkas_akta) }}" target="_blank" class="btn btn-xs btn-outline-secondary btn-sm" title="Akta"><i class="fas fa-file-alt"></i></a>
                            @endif
                            @if($item->berkas_pasfoto)
                                <a href="{{ asset('storage/'.$item->berkas_pasfoto) }}" target="_blank" class="btn btn-xs btn-outline-secondary btn-sm" title="Foto"><i class="fas fa-camera"></i></a>
                            @endif
                        </div>
                    </td>
                    <td>
                        @php
                            $colors = ['pending'=>'secondary','verified'=>'info','accepted'=>'success','rejected'=>'danger'];
                            $labels = ['pending'=>'Pending','verified'=>'Diproses','accepted'=>'Diterima','rejected'=>'Ditolak'];
                        @endphp
                        <span class="badge bg-{{ $colors[$item->status] ?? 'secondary' }}">{{ $labels[$item->status] ?? '-' }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.ppdb.edit', $item->id) }}" class="btn btn-warning btn-sm" title="Edit / Ubah Status"><i class="fas fa-edit"></i></a>
                        <form action="{{ url('admin.ppdb.destroy', $item->id) }}" method="POST"
                              class="d-inline form-delete-confirm" data-label="pendaftar PPDB '{{ addslashes($item->nama_lengkap ?? '') }}'">
                            {!! csrf_field() !!} <input type="hidden" name="_method" value="DELETE">
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-5">
                        <i class="fas fa-inbox fa-2x d-block mb-2 opacity-50"></i>Belum ada pendaftar PPDB.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection