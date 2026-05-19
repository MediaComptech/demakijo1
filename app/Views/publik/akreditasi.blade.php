@extends('publik.layout', ['title' => 'Akreditasi Sekolah', 'header_title' => 'Status Akreditasi'])
@section('content')
<div class='card shadow-sm border-0 rounded-4 text-center'>
    <div class='card-body p-5'>
        <div class='bg-success-subtle d-inline-block rounded-circle p-4 mb-4 text-success'>
            <i class='fas fa-medal fa-4x'></i>
        </div>
        <h2 class='fw-bold text-dark display-4 mb-3'>Akreditasi A</h2>
        <p class='lead text-muted mb-4'>SDN Demakijo 1 telah mendapatkan akreditasi predikat A (Sangat Baik) dari Badan Akreditasi Nasional Sekolah/Madrasah (BAN-S/M).</p>
        <p class='text-muted'>Pencapaian ini merupakan bukti komitmen kami dalam menyelenggarakan pendidikan berkualitas tinggi yang memenuhi 8 Standar Nasional Pendidikan (SNP).</p>
    </div>
</div>
@endsection