<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Berita;
use App\Models\KeunggulanSekolah;

class HomeController extends Controller
{
    public function index()
    {
        // Contoh pengambilan data dari model menggunakan Standalone Eloquent
        $beritaTerbaru = Berita::orderBy('created_at', 'desc')->take(3)->get();
        $keunggulan = KeunggulanSekolah::all();

        return $this->view('frontend.home', [
            'berita' => $beritaTerbaru,
            'keunggulan' => $keunggulan
        ]);
    }
}
