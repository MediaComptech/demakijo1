<?php
namespace App\Controllers\Backend;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($_POST['password'] ?? ''),
            'role'     => $request->role ?? 'admin',
        ]);

        \App\Core\Session::setFlash('success', 'User berhasil ditambahkan');
        header('Location: /admin/user');
        exit;
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
            $input['password'] = Hash::make($rawPassword);
        }

        $user->update($input);
        \App\Core\Session::setFlash('success', 'User berhasil diubah');
        header('Location: /admin/user');
        exit;
    }

    public function destroy($id)
    {
        if ((int) $id === 1) {
            \App\Core\Session::setFlash('error', 'Super Admin tidak bisa dihapus!');
            header('Location: /admin/user');
            exit;
        }
        User::findOrFail($id)->delete();
        \App\Core\Session::setFlash('success', 'User berhasil dihapus');
        header('Location: /admin/user');
        exit;
    }
}
