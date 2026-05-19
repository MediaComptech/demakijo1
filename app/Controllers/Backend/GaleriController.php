<?php
namespace App\Controllers\Backend;
use App\Http\Controllers\Controller;
use App\Core\Request;
use App\Core\Auth;
use App\Models\Galeri;
use App\Models\Album;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index() {
        $data = Galeri::with("album")->latest()->get();
        return view("backend.galeri.index", compact("data"));
    }
    public function create() {
        $album = Album::all();
        return view("backend.galeri.create", compact("album"));
    }
    public function store(Request $request) {
        $input = $request->except("_token");
        $input["slug"] = Str::slug($request->judul);
        if ($request->hasFile("file")) {
            $input["file"] = $request->file("file")->store("uploads", "public");
        }
        Galeri::create($input);
        return redirect("admin.galeri.index")->with("success", "Foto berhasil ditambahkan");
    }
    public function edit($id) {
        $data = Galeri::findOrFail($id);
        $album = Album::all();
        return view("backend.galeri.edit", compact("data", "album"));
    }
    public function update(Request $request, $id) {
        $model = Galeri::findOrFail($id);
        $input = $request->except("_token", "_method");
        $input["slug"] = Str::slug($request->judul);
        if ($request->hasFile("file")) {
            if ($model->file) Storage::disk("public")->delete($model->file);
            $input["file"] = $request->file("file")->store("uploads", "public");
        }
        $model->update($input);
        return redirect("admin.galeri.index")->with("success", "Foto berhasil diubah");
    }
    public function destroy($id) {
        $model = Galeri::findOrFail($id);
        if ($model->file) Storage::disk("public")->delete($model->file);
        $model->delete();
        return redirect("admin.galeri.index")->with("success", "Foto berhasil dihapus");
    }
}
