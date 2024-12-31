<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Tambahkan DB facade

class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan Query Builder
        $categories = DB::table('book_categories')->get();
        return view('book_categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('book_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:book_categories,name',
        ]);
    
        // Menggunakan Query Builder untuk insert
        DB::table('book_categories')->insert([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->route('book-categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Mengambil data berdasarkan ID dengan Query Builder
        $bookCategory = DB::table('book_categories')->where('id', $id)->first();
        return view('book_categories.edit', compact('bookCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:book_categories,name,' . $id,
        ]);

        // Menggunakan Query Builder untuk update
        DB::table('book_categories')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'updated_at' => now(),
            ]);

        return redirect()->route('book-categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Menggunakan Query Builder untuk delete
        DB::table('book_categories')->where('id', $id)->delete();

        return redirect()->route('book-categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}