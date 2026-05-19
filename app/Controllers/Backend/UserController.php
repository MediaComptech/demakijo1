<?php
namespace App\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Core\Request;
use App\Core\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $data = User::latest()->get();
        return view('backend.user.index', compact('data'));
    }

    public function create()
    {
        return view('backend.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('admin.user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('backend.user.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        $input = $request->except('password');
        if($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        }

        $user->update($input);
        return redirect('admin.user.index')->with('success', 'User berhasil diubah');
    }

    public function destroy($id)
    {
        if($id == 1) return redirect()->back()->with('error', 'Super Admin tidak bisa dihapus!');
        User::findOrFail($id)->delete();
        return redirect('admin.user.index')->with('success', 'User berhasil dihapus');
    }
}
