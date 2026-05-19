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
        
        return $this->view('backend.dashboard.index', [
            'user' => $user
        ]);
    }
}
