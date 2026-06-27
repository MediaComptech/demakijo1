<?php
namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Auth;
use App\Models\Ekstrakurikuler;

class EkstrakurikulerController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!Auth::check()) { redirect('/login'); }
    }

    public function index()
    {
        $data = Ekstrakurikuler::latest()->get();
        return view('backend.ekstrakurikuler.index', compact('data'));
    }

    public function create()
    {
        return view('backend.ekstrakurikuler.create');
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        $input['slug'] = unique_slug($request->nama ?? $request->judul ?? '', \App\Models\Ekstrakurikuler::class);
        if ($request->hasFile('foto')) {
            $input['foto'] = $request->file('foto')->store('uploads', 'public');
        }
        Ekstrakurikuler::create($input);
        redirect('/admin/ekstrakurikuler')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Ekstrakurikuler::findOrFail($id);
        return view('backend.ekstrakurikuler.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $model = Ekstrakurikuler::findOrFail($id);
        $input = $request->except('_token', '_method');
        $input['slug'] = unique_slug($request->nama ?? $request->judul ?? '', \App\Models\Ekstrakurikuler::class, 'slug', $id);
        if ($request->hasFile('foto')) {
            if ($model->foto) native_storage_delete($model->foto);
            $input['foto'] = $request->file('foto')->store('uploads', 'public');
        }
        $model->update($input);
        redirect('/admin/ekstrakurikuler')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $model = Ekstrakurikuler::findOrFail($id);
        if ($model->foto) native_storage_delete($model->foto);
        $model->delete();
        redirect('/admin/ekstrakurikuler')->with('success', 'Data berhasil dihapus');
    }
}
