<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
// Suggested code may be subject to a license. Learn more: ~LicenseLog:3115529447.
use Illuminate\Support\Facades\Validator;
// Suggested code may be subject to a license. Learn more: ~LicenseLog:290253998.
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(10); // paginasi 10 data per halaman

        return view('user.index', compact('users'));
    }


    public function create() {
        return view('user.create');
    }


    public function store(Request $request) {
        $validate = $request->validate([
            'name' => ['required','string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'name.required'=>'Nama wajib diisi!',
            'email.required'=>'Email wajib diisi!',
            'email.unique'=>'Email sudah terdaftar!',
            'password.required'=>'Password wajib diisi!',
            'password.min'=>'Password minimal 8 karakter!',
            'password.confirmed'=>'Password tidak cocok!'
        ]);
    
        User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
        ]);
    
        return redirect()->route('user.index')->with('success', 'Data berhasil disimpan!');
    }

    public function show(User $user) {
        return view('user.show', compact('user'));
    }

    public function edit(User $user) {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        $validate = $request->validate([
            'name' => ['required','string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'name.required'=>'Nama wajib diisi!',
            'email.required'=>'Email wajib diisi!',
            'email.unique'=>'Email sudah terdaftar!',
            'password.required'=>'Password wajib diisi!',
            'password.min'=>'Password minimal 8 karakter!',
            'password.confirmed'=>'Password tidak cocok!'
        ]);
    
        $user->update([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
        ]);
    
        return redirect()->route('user.index')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('user.index');
    }
}
