<?php
namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Auth;
use App\Models\Prestasi;

class PrestasiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!Auth::check()) { redirect('/login'); }
    }

    public function index()
    {
        $data = Prestasi::latest()->get();
        return view('backend.prestasi.index', compact('data'));
    }

    public function create()
    {
        return view('backend.prestasi.create');
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        $input['slug'] = unique_slug($request->judul ?? $request->nama ?? '', \App\Models\Prestasi::class);
        if ($request->hasFile('foto')) {
            $input['foto'] = $request->file('foto')->store('uploads', 'public');
        }
        Prestasi::create($input);
        redirect('/admin/prestasi')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Prestasi::findOrFail($id);
        return view('backend.prestasi.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $model = Prestasi::findOrFail($id);
        $input = $request->except('_token', '_method');
        $input['slug'] = unique_slug($request->judul ?? $request->nama ?? '', \App\Models\Prestasi::class, 'slug', $id);
        if ($request->hasFile('foto')) {
            if ($model->foto) native_storage_delete($model->foto);
            $input['foto'] = $request->file('foto')->store('uploads', 'public');
        }
        $model->update($input);
        redirect('/admin/prestasi')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $model = Prestasi::findOrFail($id);
        if ($model->foto) native_storage_delete($model->foto);
        $model->delete();
        redirect('/admin/prestasi')->with('success', 'Data berhasil dihapus');
    }
}
