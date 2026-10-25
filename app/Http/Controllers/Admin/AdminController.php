<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::with('user', 'office')
            ->where('user_id', '!=', auth()->id())
            ->latest()
            ->get();

        $offices = Office::orderBy('name')->get();

        return view('auth.admin.admin.index', compact('admins', 'offices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $offices = Office::orderBy('name')->get();

        return view('auth.admin.admin.create', compact('offices'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::create([
                'email' => $request->email,
                'password' => $request->password,
                'role' => 'admin',
            ]);

            Admin::create([
                'name' => $request->name,
                'user_id' => $user->id,
                'office_id' => $request->office_id,
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
        $offices = Office::orderBy('name')->get();

        return view('auth.admin.admin.edit', compact('admin', 'offices'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        DB::transaction(function () use ($request, $admin) {
            $userData = [
                'email' => $request->email,
            ];

            // Hanya update password jika diisi di form
            if ($request->filled('password')) {
                $userData['password'] = $request->password;
            }

            $admin->user->update($userData);

            $adminData = [
                'name' => $request->name,
                'office_id' => $request->office_id,
                'role' => $request->role,
            ];

            if ($request->has('is_active')) {
                $adminData['is_active'] = $request->boolean('is_active');
            }

            $admin->update($adminData);
        });

        return redirect()->route('admin.index')->with('success', 'Berhasil memperbarui data admin.');
    }

    /**
     * Deactivate the specified admin.
     */
    public function destroy(Admin $admin)
    {
        if ($admin->user_id === auth()->id()) {
            return redirect()->route('admin.index')->with('error', 'Tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $admin->update(['is_active' => false]);

        return redirect()->route('admin.index')->with('success', 'Berhasil menonaktifkan data admin.');
    }

    /**
     * Toggle active/inactive status of the specified admin.
     */
    public function toggleStatus(Admin $admin)
    {
        if ($admin->user_id === auth()->id()) {
            return redirect()->route('admin.index')->with('error', 'Tidak dapat mengubah status akun Anda sendiri.');
        }

        $admin->update(['is_active' => ! $admin->is_active]);

        $statusText = $admin->is_active ? 'diaktifkan kembali' : 'dinonaktifkan';

        return redirect()->route('admin.index')->with('success', "Akun admin berhasil {$statusText}.");
    }
}
