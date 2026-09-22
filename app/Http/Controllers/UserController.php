<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 'user')
            ->latest()
            ->get();

        return view('auth.admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        User::create([
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'user',
        ]);

        return redirect()
            ->route('user.index')
            ->with('success', 'Berhasil menambahkan akun user.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        abort_if($user->role !== 'user', 404);

        return view('auth.admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        abort_if($user->role !== 'user', 404);

        $data = [
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);

        return redirect()
            ->route('user.index')
            ->with('success', 'Berhasil memperbarui akun user.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        abort_if($user->role !== 'user', 404);

        $user->delete();

        return redirect()
            ->route('user.index')
            ->with('success', 'Berhasil menghapus akun user.');
    }
}
