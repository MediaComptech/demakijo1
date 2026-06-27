<?php
namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Auth;

class NotifikasiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!Auth::check()) { redirect('/login'); }
    }

    public function index()
    {
        return view('backend.notifikasi.index');
    }

    public function send(Request $request)
    {
        $request->validate(['title' => 'required', 'body' => 'required']);

        // Store notification in session to be broadcast via JS
        \App\Core\Session::setFlash('push_notif', [
            'title' => $request->title,
            'body'  => $request->body,
            'url'   => $request->url ?? '/',
        ]);

        // Save log to file for reference (native, no Cache facade)
        $log = [
            'sent_at' => now(),
            'title'   => $request->title,
            'body'    => $request->body,
            'url'     => $request->url ?? '/',
        ];
        $logFile = storage_path('notif_log.json');
        @file_put_contents($logFile, json_encode($log, JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND);

        return back()->with('success', 'Notifikasi berhasil dikirim!');
    }
}
