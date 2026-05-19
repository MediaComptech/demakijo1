<?php

namespace App\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Core\Request;
use App\Core\Auth;
use App\Models\Pengumuman;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = \App\Models\Pengumuman::latest()->get();
        return view('backend.pengumuman.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('backend.pengumuman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request) {
        $data = $request->except('_token');
        if($request->has('judul')) $data['slug'] = \Illuminate\Support\Str::slug($request->judul);
        if($request->has('nama')) $data['slug'] = \Illuminate\Support\Str::slug($request->nama);
        
        $files = ['foto', 'gambar', 'cover', 'file_lampiran', 'file'];
        foreach($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $data[$fileKey] = $request->file($fileKey)->store('uploads', 'public');
            }
        }

                $data['user_id'] = auth()->id();
        \App\Models\Pengumuman::create($data);
        return redirect('admin.pengumuman.index')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {
        $data = \App\Models\Pengumuman::findOrFail($id);
        return view('backend.pengumuman.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
        public function update(Request $request, $id) {
        $model = \App\Models\Pengumuman::findOrFail($id);
        $data = $request->except('_token', '_method');
        if($request->has('judul')) $data['slug'] = \Illuminate\Support\Str::slug($request->judul);
        if($request->has('nama')) $data['slug'] = \Illuminate\Support\Str::slug($request->nama);
        
        $files = ['foto', 'gambar', 'cover', 'file_lampiran', 'file'];
        foreach($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                if ($model->$fileKey && \Illuminate\Support\Facades\Storage::disk('public')->exists($model->$fileKey)) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($model->$fileKey);
                }
                $data[$fileKey] = $request->file($fileKey)->store('uploads', 'public');
            }
        }

        $model->update($data);
        return redirect('admin.pengumuman.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
        public function destroy($id) {
        $model = \App\Models\Pengumuman::findOrFail($id);
        $files = ['foto', 'gambar', 'cover', 'file_lampiran', 'file'];
        foreach($files as $fileKey) {
            if ($model->$fileKey && \Illuminate\Support\Facades\Storage::disk('public')->exists($model->$fileKey)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($model->$fileKey);
            }
        }
        $model->delete();
        return redirect('admin.pengumuman.index')->with('success', 'Data berhasil dihapus');
    }
}
