<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('user-management.index', compact('users'));
    }

    public function create()
    {
        return view('user-management.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,manpurchase,direktur',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect('/direktur/user-management')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user-management.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,manpurchase,direktur',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect('/direktur/user-management')->with('success', 'User berhasil diperbarui');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect('/direktur/user-management')->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user->delete();

        return redirect('/direktur/user-management')->with('success', 'User berhasil dihapus');
    }
}
