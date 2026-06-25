<?php

namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Models\KeunggulanSekolah;
use App\Core\Request;
use App\Core\Auth;

class KeunggulanController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!Auth::check()) { redirect('/login'); }
    }

    public function index()
    {
        $data = KeunggulanSekolah::orderBy('urutan')->get();
        return view('backend.keunggulan.index', compact('data'));
    }

    public function create()
    {
        return view('backend.keunggulan.create');
    }

    public function store(Request $request)
    {
        KeunggulanSekolah::create([
            'icon'      => $request->icon,
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'urutan'    => $request->urutan ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        redirect('/admin/keunggulan')
            ->with('success', 'Data keunggulan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $keunggulan = KeunggulanSekolah::findOrFail($id);
        return view('backend.keunggulan.edit', compact('keunggulan'));
    }

    public function update(Request $request, $id)
    {
        $keunggulan = KeunggulanSekolah::findOrFail($id);
        $keunggulan->update([
            'icon'      => $request->icon,
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'urutan'    => $request->urutan ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        redirect('/admin/keunggulan')
            ->with('success', 'Data keunggulan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        KeunggulanSekolah::findOrFail($id)->delete();
        redirect('/admin/keunggulan')
            ->with('success', 'Data keunggulan berhasil dihapus!');
    }
}
