<?php
namespace App\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Core\Request;
use App\Core\Auth;
use App\Models\Guru;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class GuruController extends Controller
{
    public function index() {
        $data = \App\Models\Guru::latest()->get();
        return view("backend." . strtolower(preg_replace("/(?<!^)[A-Z]/", "_$0", "Guru")) . ".index", compact("data"));
    }
    public function create() {
        return view("backend." . strtolower(preg_replace("/(?<!^)[A-Z]/", "_$0", "Guru")) . ".create");
    }
    public function store(Request $request) {
        $input = $request->except("_token");
        $input["slug"] = Str::slug($request->nama ?? $request->nama ?? $request->judul ?? time());
        if ($request->hasFile("foto")) { $input["foto"] = $request->file("foto")->store("uploads", "public"); }
        \App\Models\Guru::create($input);
        Cache::forget("guru_all");
        return redirect("admin.guru.index")->with("success", "Data berhasil ditambahkan");
    }
    public function edit($id) {
        $data = \App\Models\Guru::findOrFail($id);
        return view("backend." . strtolower(preg_replace("/(?<!^)[A-Z]/", "_$0", "Guru")) . ".edit", compact("data"));
    }
    public function update(Request $request, $id) {
        $model = \App\Models\Guru::findOrFail($id);
        $input = $request->except("_token", "_method");
        $input["slug"] = Str::slug($request->nama ?? $request->nama ?? $request->judul ?? time());
        if ($request->hasFile("foto")) { if ($model->foto) Storage::disk("public")->delete($model->foto); $input["foto"] = $request->file("foto")->store("uploads", "public"); }
        $model->update($input);
        Cache::forget("guru_all");
        return redirect("admin.guru.index")->with("success", "Data berhasil diubah");
    }
    public function destroy($id) {
        $model = \App\Models\Guru::findOrFail($id);
        if ($model->foto) Storage::disk("public")->delete($model->foto);
        $model->delete();
        Cache::forget("guru_all");
        return redirect("admin.guru.index")->with("success", "Data berhasil dihapus");
    }
}
