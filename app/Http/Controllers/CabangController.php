<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Http\Requests\StoreCabangRequest;
use App\Http\Requests\UpdateCabangRequest;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cabangs = Cabang::all();

        return view('admin.cabang.index', compact('cabangs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cabang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCabangRequest $request)
    {
        Cabang::create($request->validated());

        return redirect()->route('cabang.index')->with('success', 'Berhasil menambahkan data cabang baru.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cabang $cabang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cabang $cabang)
    {
        return view('admin.cabang.edit', compact('cabang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCabangRequest $request, Cabang $cabang)
    {
        $cabang->update($request->validated());

        return redirect()->route('cabang.index')->with('success', 'Berhasil memperbarui data cabang.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cabang $cabang)
    {
        $cabang->delete();

        return redirect()->route('cabang.index')->with('success', 'Berhasil menghapus data cabang.');
    }
}
