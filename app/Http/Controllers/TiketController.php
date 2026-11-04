<?php

namespace App\Http\Controllers;

use App\Models\TipeTiket;
use Illuminate\Http\Request;

class TipeTiketController extends Controller
{
    // Menampilkan daftar tipe tiket
    public function index()
    {
        $tipeTikets = TipeTiket::latest()->paginate(10);
        return view('tipe-tiket.index', compact('tipeTikets'));
    }

    // Menampilkan form tambah tipe tiket
    public function create()
    {
        return view('tipe-tiket.create');
    }

    // Menyimpan tipe tiket baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:tipe_tikets,nama',
            'deskripsi' => 'nullable|string'
        ], [
            'nama.required' => 'Nama tipe tiket harus diisi',
            'nama.unique' => 'Nama tipe tiket sudah ada'
        ]);

        TipeTiket::create($validated);

        return redirect()->route('tipe-tiket.index')
            ->with('success', 'Tipe tiket berhasil ditambahkan');
    }

    // Menampilkan detail tipe tiket
    public function show(TipeTiket $tipeTiket)
    {
        return view('tipe-tiket.show', compact('tipeTiket'));
    }

    // Menampilkan form edit
    public function edit(TipeTiket $tipeTiket)
    {
        return view('tipe-tiket.edit', compact('tipeTiket'));
    }

    // Update tipe tiket
    public function update(Request $request, TipeTiket $tipeTiket)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:tipe_tikets,nama,' . $tipeTiket->id,
            'deskripsi' => 'nullable|string'
        ], [
            'nama.required' => 'Nama tipe tiket harus diisi',
            'nama.unique' => 'Nama tipe tiket sudah ada'
        ]);

        $tipeTiket->update($validated);

        return redirect()->route('tipe-tiket.index')
            ->with('success', 'Tipe tiket berhasil diperbarui');
    }

    // Hapus tipe tiket
    public function destroy(TipeTiket $tipeTiket)
    {
        $tipeTiket->delete();

        return redirect()->route('tipe-tiket.index')
            ->with('success', 'Tipe tiket berhasil dihapus');
    }
}