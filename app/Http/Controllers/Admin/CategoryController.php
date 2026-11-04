<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Kategori::all();

        return view('admin.category.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payload = $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:kategoris,nama'],
        ]);

        Kategori::create($payload);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $category)
    {
        $payload = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('kategoris', 'nama')->ignore($category)],
        ]);

        $category->update($payload);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $category)
    {
        if ($category->events()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->withErrors(['category' => 'Kategori masih digunakan oleh event dan tidak dapat dihapus.']);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
