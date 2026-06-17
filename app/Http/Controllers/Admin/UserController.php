<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->search, fn($q) =>
            $q->where(fn($q2) => 
                $q2->where('name', 'like', '%' . $request->search . '%')
                   ->orWhere('email', 'like', '%' . $request->search . '%')
            )
        )->when($request->filled('role'), fn($q) =>
            $q->where('is_admin', $request->role)
        )->latest()->paginate(10)->withQueryString();

        return view('admin.pengguna', compact('users'));
    }
    public function create()
    {
        return view('admin.pengguna-create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'is_admin' => 'boolean',
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['is_admin'] = $request->boolean('is_admin');

        User::create($data);

        return redirect()->route('admin.pengguna')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.pengguna-edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'is_admin' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_admin'] = $request->boolean('is_admin');

        $user->update($data);

        return redirect()->route('admin.pengguna')->with('success', 'Pengguna berhasil diperbarui.');
    }
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        abort_if($user->id === auth()->id(), 403, 'Tidak bisa menghapus akun sendiri.');
        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
