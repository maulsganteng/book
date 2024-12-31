<?php
namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    // Menampilkan daftar authors
    public function index()
    {
        $authors = Author::all();
        return view('authors.index', compact('authors'));
    }

    // Menampilkan form untuk membuat author
    public function create()
    {
        return view('authors.create');
    }

    // Menyimpan author baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Author::create($request->all());

        return redirect()->route('authors.index');
    }

    // Menampilkan form untuk mengedit author
    public function edit($id)
    {
        $author = Author::findOrFail($id);
        return view('authors.edit', compact('author'));
    }

    // Memperbarui data author
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author = Author::findOrFail($id);
        $author->update($request->all());

        return redirect()->route('authors.index');
    }

    // Menghapus author
    public function destroy($id)
    {
        Author::findOrFail($id)->delete();
        return redirect()->route('authors.index');
    }
}
