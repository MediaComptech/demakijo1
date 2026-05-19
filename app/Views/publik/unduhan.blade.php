@extends('publik.layout', ['title' => 'Pusat Unduhan', 'header_title' => 'Dokumen & Unduhan Publik'])
@section('content')
<div class='card shadow-sm border-0 rounded-4'>
    <div class='card-body p-4'>
        <div class='table-responsive'>
            <table class='table table-hover align-middle'>
                <thead class='table-light'>
                    <tr>
                        <th width='50'>No</th>
                        <th>Judul Dokumen</th>
                        <th>Tanggal Publikasi</th>
                        <th width='150' class='text-center'>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($unduhan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class='fw-bold'>
                            <i class='fas fa-file-pdf text-danger me-2'></i> {{ $item->judul }}
                        </td>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                        <td class='text-center'>
                            <a href='#' class='btn btn-primary btn-sm rounded-pill px-3 fw-bold shadow-sm'><i class='fas fa-download me-1'></i> Unduh</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan='4' class='text-center py-5 text-muted'>Belum ada dokumen yang dibagikan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection