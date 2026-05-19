<?php

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Proteksi: Hanya user login yang bisa akses
        if (!Auth::check()) {
            redirect('/login');
        }
    }

    public function index()
    {
        $user = \App\Core\Auth::user();
        
        return $this->view('dashboard', [
            'user' => $user,
            // also we need to provide $stats, $recent_ppdb, $recent_alumni, $recent_berita
            'stats' => [
                'siswa' => \App\Models\Siswa::count(),
                'guru' => \App\Models\Guru::count(),
                'berita' => \App\Models\Berita::count(),
                'ppdb' => \App\Models\Ppdb::count(),
                'prestasi' => \App\Models\Prestasi::count(),
                'pengumuman' => \App\Models\Pengumuman::count(),
                'fasilitas' => \App\Models\Fasilitas::count(),
                'alumni_baru' => \App\Models\Alumni::where('is_verified', false)->count()
            ],
            'recent_ppdb' => \App\Models\Ppdb::latest()->take(5)->get(),
            'recent_alumni' => \App\Models\Alumni::where('is_verified', false)->latest()->take(5)->get(),
            'recent_berita' => \App\Models\Berita::with('kategori')->latest()->take(5)->get()
        ]);
    }
}
