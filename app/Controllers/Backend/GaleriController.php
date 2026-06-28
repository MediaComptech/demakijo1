<?php
namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Auth;
use App\Models\Galeri;
use App\Models\Album;

class GaleriController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!Auth::check()) { redirect('/login'); }
    }

    public function index()
    {
        $data = Galeri::with('album')->latest()->get();
        return view('backend.galeri.index', compact('data'));
    }

    public function create()
    {
        $album = Album::all();
        return view('backend.galeri.create', compact('album'));
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        if ($request->hasFile('file')) {
            $input['file'] = $request->file('file')->store('uploads', 'public');
        }
        Galeri::create($input);
        redirect('/admin/galeri')->with('success', 'Foto berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Galeri::findOrFail($id);
        $album = Album::all();
        return view('backend.galeri.edit', compact('data', 'album'));
    }

    public function update(Request $request, $id)
    {
        $model = Galeri::findOrFail($id);
        $input = $request->except('_token', '_method');
        if ($request->hasFile('file')) {
            if ($model->file) native_storage_delete($model->file);
            $input['file'] = $request->file('file')->store('uploads', 'public');
        }
        $model->update($input);
        redirect('/admin/galeri')->with('success', 'Foto berhasil diubah');
    }

    public function destroy($id)
    {
        $model = Galeri::findOrFail($id);
        if ($model->file) native_storage_delete($model->file);
        $model->delete();
        redirect('/admin/galeri')->with('success', 'Foto berhasil dihapus');
    }
}
