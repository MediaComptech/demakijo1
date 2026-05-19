@extends('publik.layout', ['title' => 'Peserta Didik', 'header_title' => 'Direktori Peserta Didik Aktif'])
@section('content')
<div class='card shadow-sm border-0 rounded-4'>
    <div class='card-body p-4'>
        <div class='table-responsive'>
            <table class='table table-hover align-middle'>
                <thead class='table-light text-primary'>
                    <tr>
                        <th width='50'>No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $item)
                    <tr>
                        <td>{{ $loop->iteration + ($siswa->currentPage() - 1) * $siswa->perPage() }}</td>
                        <td><span class='badge bg-light text-dark border'>{{ $item->nis }}</span></td>
                        <td class='fw-bold'>{{ $item->nama }}</td>
                        <td><span class='badge bg-warning text-dark'>{{ $item->kelas }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan='4' class='text-center py-4 text-muted'>Belum ada data Peserta Didik.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class='d-flex justify-content-center mt-4'>
            {{ $siswa->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection