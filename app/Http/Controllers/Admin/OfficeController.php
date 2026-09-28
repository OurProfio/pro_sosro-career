<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Http\Requests\Admin\StoreOfficeRequest;
use App\Http\Requests\Admin\UpdateOfficeRequest;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $offices = Office::all();

        return view('auth.admin.office.index', compact('offices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.admin.office.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfficeRequest $request)
    {
        Office::create($request->validated());

        return redirect()->route('office.index')->with('success', 'Berhasil menambahkan data kantor cabang baru.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Office $office)
    {
        return view('auth.admin.office.edit', compact('office'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfficeRequest $request, Office $office)
    {
        $office->update($request->validated());

        return redirect()->route('office.index')->with('success', 'Berhasil memperbarui data kantor cabang.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office)
    {
         $office->delete();

        return redirect()->route('office.index')->with('success', 'Berhasil menghapus data kantor cabang.');
    }
}
