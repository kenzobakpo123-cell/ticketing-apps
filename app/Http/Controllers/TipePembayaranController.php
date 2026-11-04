<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipePembayaran;
use Illuminate\Http\Request;

class TipePembayaranController extends Controller
{
    // Menampilkan daftar tipe pembayaran
    public function index()
    {
        $tipePembayarans = TipePembayaran::latest()->paginate(10);
        return view('admin.tipe-pembayaran.index', compact('tipePembayarans'));
    }

    // Menampilkan form tambah tipe pembayaran
    public function create()
    {
        return view('admin.tipe-pembayaran.create');
    }

    // Menyimpan tipe pembayaran baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:tipe_pembayarans,nama',
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean'
        ], [
            'nama.required' => 'Nama tipe pembayaran harus diisi',
            'nama.unique' => 'Nama tipe pembayaran sudah ada'
        ]);

        $validated['is_active'] = $request->has('is_active');

        TipePembayaran::create($validated);

        return redirect()->route('admin.tipe-pembayaran.index')
            ->with('success', 'Tipe pembayaran berhasil ditambahkan');
    }

    // Menampilkan detail tipe pembayaran
    public function show(TipePembayaran $tipePembayaran)
    {
        return view('admin.tipe-pembayaran.show', compact('tipePembayaran'));
    }

    // Menampilkan form edit
    public function edit(TipePembayaran $tipePembayaran)
    {
        return view('admin.tipe-pembayaran.edit', compact('tipePembayaran'));
    }

    // Update tipe pembayaran
    public function update(Request $request, TipePembayaran $tipePembayaran)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:tipe_pembayarans,nama,' . $tipePembayaran->id,
            'deskripsi' => 'nullable|string',
            'is_active' => 'boolean'
        ], [
            'nama.required' => 'Nama tipe pembayaran harus diisi',
            'nama.unique' => 'Nama tipe pembayaran sudah ada'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $tipePembayaran->update($validated);

        return redirect()->route('admin.tipe-pembayaran.index')
            ->with('success', 'Tipe pembayaran berhasil diperbarui');
    }

    // Hapus tipe pembayaran
    public function destroy(TipePembayaran $tipePembayaran)
    {
        $tipePembayaran->delete();

        return redirect()->route('admin.tipe-pembayaran.index')
            ->with('success', 'Tipe pembayaran berhasil dihapus');
    }
}