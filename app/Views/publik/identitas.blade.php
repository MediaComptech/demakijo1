@extends('publik.layout', ['title' => 'Identitas Sekolah', 'header_title' => 'Identitas Sekolah'])
@section('content')
<div class='card shadow-sm border-0 rounded-4'>
    <div class='card-body p-5'>
        <h4 class='fw-bold text-primary mb-4'>Profil Singkat SDN Demakijo 1</h4>
        <div class='row mb-4'>
            <div class='col-md-4 fw-bold text-muted'>Nama Sekolah</div>
            <div class='col-md-8'>SDN Demakijo 1</div>
        </div>
        <div class='row mb-4'>
            <div class='col-md-4 fw-bold text-muted'>NPSN</div>
            <div class='col-md-8'>12345678</div>
        </div>
        <div class='row mb-4'>
            <div class='col-md-4 fw-bold text-muted'>Alamat</div>
            <div class='col-md-8'>Jl. Godean, Nogotirto, Gamping, Sleman, Yogyakarta 55293</div>
        </div>
        <div class='row mb-4'>
            <div class='col-md-4 fw-bold text-muted'>Status</div>
            <div class='col-md-8'>Negeri</div>
        </div>
    </div>
</div>
@endsection