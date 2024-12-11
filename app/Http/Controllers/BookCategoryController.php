<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookCategory;

class BookCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = BookCategory::all();
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
    
        BookCategory::create($request->all());
    
        return redirect()->route('book-categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookCategory $bookCategory)
{
    return view('book_categories.edit', compact('bookCategory'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookCategory $bookCategory)
{
    $request->validate([
        'name' => 'required|unique:book_categories,name,' . $bookCategory->id,
    ]);

    $bookCategory->update($request->all());

    return redirect()->route('book-categories.index')
        ->with('success', 'Kategori berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookCategory $bookCategory)
{
    $bookCategory->delete();

    return redirect()->route('book-categories.index')
        ->with('success', 'Kategori berhasil dihapus.');
}

}
