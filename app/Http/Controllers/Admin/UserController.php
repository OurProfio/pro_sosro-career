<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('id', '!=', auth()->user()->id)
            ->with(['admin', 'applicant'])
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
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            ...$request->validated(),
            'role' => 'user',
        ]);

        event(new Registered($user));

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
        return view('auth.admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        DB::transaction(function () use ($user, $data) {
            $user->update($data);

            if (! empty($data['email']) && $user->applicant) {
                $user->applicant->update(['email' => $data['email']]);
            }
        });

        return redirect()
            ->route('user.index')
            ->with('success', 'Berhasil memperbarui akun user.');
    }

    /**
     * Deactivate the specified user.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('user.index')
                ->with('error', 'Tidak dapat menonaktifkan akun Anda sendiri.');
        }

        $user->update(['is_active' => false]);

        if ($user->admin) {
            $user->admin->update(['is_active' => false]);
        }

        return redirect()
            ->route('user.index')
            ->with('success', 'Berhasil menonaktifkan akun user.');
    }

    /**
     * Toggle active/inactive status of the specified user.
     */
    public function toggleStatus(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()
                ->route('user.index')
                ->with('error', 'Tidak dapat mengubah status akun Anda sendiri.');
        }

        $user->update(['is_active' => ! $user->is_active]);

        if ($user->admin) {
            $user->admin->update(['is_active' => $user->is_active]);
        }

        $statusText = $user->is_active ? 'diaktifkan kembali' : 'dinonaktifkan';

        return redirect()
            ->route('user.index')
            ->with('success', "Akun user berhasil {$statusText}.");
    }
}
