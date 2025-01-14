<?php

namespace App\Http\Controllers;

use App\Imports\BooksImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Author;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB Facade
use Rap2hpoutre\FastExcel\FastExcel;

class BookController extends Controller
{
    public function index()
    {
        $books = DB::table('books')
            ->join('book_category', 'books.id', '=', 'book_category.book_id')
            ->join('book_categories', 'book_category.category_id', '=', 'book_categories.id')
            ->select('books.*', DB::raw('GROUP_CONCAT(book_categories.name) as categories'))
            ->groupBy('books.id')
            ->get();

        return view('books.index', compact('books'));
    }


    public function create()
    {
        // Mengambil semua kategori buku
        $categories = DB::table('book_categories')->get();
        $authors = Author::all();
        return view('books.create', compact('categories', 'authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:books,name',
            'categories' => 'required|array',
            'categories.*' => 'exists:book_categories,id',
            'author' => 'required',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $bookId = DB::table('books')->insertGetId([
            'name' => $request->name,
            'author' => $request->author,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Simpan kategori ke tabel pivot
        foreach ($request->categories as $categoryId) {
            DB::table('book_category')->insert([
                'book_id' => $bookId,
                'category_id' => $categoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan');
    }


    public function edit($id)
    {
        $book = DB::table('books')->where('id', $id)->first();
        $categories = DB::table('book_categories')->get();
        $selectedCategories = DB::table('book_category')->where('book_id', $id)->pluck('category_id')->toArray();

        return view('books.edit', compact('book', 'categories', 'selectedCategories'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'categories' => 'required|array',
            'categories.*' => 'exists:book_categories,id',
            'author' => 'required',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $thumbnailPath = DB::table('books')->where('id', $id)->value('thumbnail');
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        DB::table('books')->where('id', $id)->update([
            'name' => $request->name,
            'author' => $request->author,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
            'updated_at' => now(),
        ]);

        // Update kategori
        DB::table('book_category')->where('book_id', $id)->delete();
        foreach ($request->categories as $categoryId) {
            DB::table('book_category')->insert([
                'book_id' => $id,
                'category_id' => $categoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Menggunakan Query Builder untuk menghapus buku berdasarkan ID
        DB::table('books')->where('id', $id)->delete();
        
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus');
    }

    // public function exportUsers()
    // {
    //     $users = User::all(); // Data yang akan diekspor
    //     return (new FastExcel($users))->download('users.xlsx'); // Unduh file Excel
    // }
    // public function exportSelectedColumns()
    // {
    //     return (new FastExcel(User::all()))->export('users.csv', function ($user) {
    //         return [
    //             'Email' => $user->email,
    //             'First Name' => $user->firstname,
    //             'Last Name' => strtoupper($user->lastname),
    //         ];
    //     });
    // }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $import = new BooksImport;

        Excel::import($import, $request->file('file'));

        // Kirimkan alert jika ada buku yang sudah ada
        if (count($import->existingBooks) > 0) {
            return redirect()->back()->with([
                'success' => 'Data berhasil diimport, tetapi beberapa buku sudah ada.',
                'existingBooks' => $import->existingBooks,
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil diimport.');
    }
}