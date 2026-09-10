<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Cabang;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::where('id', '!=', 1)->with('user', 'cabang')->get();

        return view('admin.admin.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cabangs = Cabang::all();

        return view('admin.admin.create', compact('cabangs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'admin',
            ]);

            Admin::create([
                'user_id' => $user->id,
                'cabang_id' => $request->cabang_id,
                'role' => $request->role,
            ]);
        });

        return redirect()->route('admin.index')->with('success', 'Berhasil menambahkan data admin baru.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $cabangs = Cabang::all();

        return view('admin.admin.edit', compact('admin', 'cabangs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        DB::transaction(function () use ($request, $admin) {
            $userData = [
                'nama' => $request->nama,
                'email' => $request->email,
            ];

            // Hanya update password jika diisi di form
            if ($request->filled('password')) {
                $userData['password'] = $request->password;
            }

            $admin->user->update($userData);

            $admin->update([
                'cabang_id' => $request->cabang_id,
                'role' => $request->role,
            ]);
        });

        return redirect()->route('admin.index')->with('success', 'Berhasil memperbarui data admin.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        DB::transaction(function () use ($admin) {
            $admin->user->delete();
            $admin->delete();
        });

        return redirect()->route('admin.index')->with('success', 'Berhasil menghapus data admin.');
    }
}
