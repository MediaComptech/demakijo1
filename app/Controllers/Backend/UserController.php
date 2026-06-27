<?php
namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!Auth::check()) { redirect('/login'); }
    }

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
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Ambil password langsung dari $_POST agar karakter spesial tidak di-encode
        $rawPassword = $_POST['password'] ?? '';

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => password_hash($rawPassword, PASSWORD_BCRYPT),
            'role'     => $request->role ?? 'admin',
        ]);

        redirect('/admin/user')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('backend.user.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $user  = User::findOrFail($id);
        $input = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role ?? $user->role ?? 'admin',
        ];

        // Update password hanya jika diisi (ambil dari $_POST langsung agar karakter spesial tidak di-escape)
        $rawPassword = $_POST['password'] ?? '';
        if ($rawPassword !== '') {
            $input['password'] = password_hash($rawPassword, PASSWORD_BCRYPT);
        }

        $user->update($input);
        redirect('/admin/user')->with('success', 'User berhasil diubah');
    }

    public function destroy($id)
    {
        if ((int) $id === 1) {
            redirect('/admin/user')->with('error', 'Super Admin tidak bisa dihapus!');
            return;
        }
        User::findOrFail($id)->delete();
        redirect('/admin/user')->with('success', 'User berhasil dihapus');
    }
}
