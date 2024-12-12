<?php

// app/Http/Controllers/BookController.php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->get();  // Menampilkan buku beserta kategori
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $categories = BookCategory::all();  // Mengambil semua kategori buku
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:books,name',
            'book_category_id' => 'required|exists:book_categories,id',
            'author' => 'required',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Menyimpan file thumbnail jika ada
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Menyimpan data buku ke database
        Book::create([
            'name' => $request->name,
            'book_category_id' => $request->book_category_id,
            'author' => $request->author,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
        ]);

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = BookCategory::all();  // Mengambil semua kategori buku
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'book_category_id' => 'required|exists:book_categories,id',
            'author' => 'required',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $book = Book::findOrFail($id);

        // Simpan file thumbnail jika ada
        $thumbnailPath = $book->thumbnail; // Jika tidak ada perubahan thumbnail, gunakan yang lama
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Update data buku
        $book->update([
            'name' => $request->name,
            'book_category_id' => $request->book_category_id,
            'author' => $request->author,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
        ]);

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus');
    }
}
