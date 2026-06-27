<?php
namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Auth;
use App\Models\Fasilitas;

class FasilitasController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!Auth::check()) { redirect('/login'); }
    }

    public function index()
    {
        $data = Fasilitas::latest()->get();
        return view('backend.fasilitas.index', compact('data'));
    }

    public function create()
    {
        return view('backend.fasilitas.create');
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        $input['slug'] = unique_slug($request->nama ?? $request->judul ?? '', \App\Models\Fasilitas::class);
        if ($request->hasFile('foto')) {
            $input['foto'] = $request->file('foto')->store('uploads', 'public');
        }
        Fasilitas::create($input);
        redirect('/admin/fasilitas')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Fasilitas::findOrFail($id);
        return view('backend.fasilitas.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $model = Fasilitas::findOrFail($id);
        $input = $request->except('_token', '_method');
        $input['slug'] = unique_slug($request->nama ?? $request->judul ?? '', \App\Models\Fasilitas::class, 'slug', $id);
        if ($request->hasFile('foto')) {
            if ($model->foto) native_storage_delete($model->foto);
            $input['foto'] = $request->file('foto')->store('uploads', 'public');
        }
        $model->update($input);
        redirect('/admin/fasilitas')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $model = Fasilitas::findOrFail($id);
        if ($model->foto) native_storage_delete($model->foto);
        $model->delete();
        redirect('/admin/fasilitas')->with('success', 'Data berhasil dihapus');
    }
}
