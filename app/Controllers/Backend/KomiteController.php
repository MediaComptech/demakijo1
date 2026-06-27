<?php
namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Auth;
use App\Models\Komite;

class KomiteController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!Auth::check()) { redirect('/login'); }
    }

    public function index()
    {
        $data = Komite::orderBy('urutan')->get();
        return view('backend.komite.index', compact('data'));
    }

    public function create()
    {
        return view('backend.komite.create');
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        if ($request->hasFile('foto')) {
            $input['foto'] = $request->file('foto')->store('uploads', 'public');
        }
        Komite::create($input);
        redirect('/admin/komite')->with('success', 'Data komite berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = Komite::findOrFail($id);
        return view('backend.komite.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $model = Komite::findOrFail($id);
        $input = $request->except('_token', '_method');
        if ($request->hasFile('foto')) {
            if ($model->foto) native_storage_delete($model->foto);
            $input['foto'] = $request->file('foto')->store('uploads', 'public');
        }
        $model->update($input);
        redirect('/admin/komite')->with('success', 'Data komite berhasil diubah');
    }

    public function destroy($id)
    {
        $model = Komite::findOrFail($id);
        if ($model->foto) native_storage_delete($model->foto);
        $model->delete();
        redirect('/admin/komite')->with('success', 'Data komite berhasil dihapus');
    }
}
