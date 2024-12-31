<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublisherController extends Controller
{
    public function index()
    {
        $books = DB::table('books')
            ->select('id', 'name as judulBuku', 'description as deskripsi')
            ->get();

        return view('publisher.index', compact('books'));
    }


    public function create()
    {
        return view('publisher.create');
    }


    public function store(Request $request)
    {
        DB::table('books')->insert([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('publisher.index');
    }

    public function update(Request $request,$id)
    {
        DB::table('books')
        ->where('id',$id)
        ->update([
            'name'=> $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('publisher.index');
    }

    public function edit($id)
    {
        $book = DB::table('books')->where('id', $id)->first();

        return view('publisher.edit',compact('book'));
    }

    public function delete($id)
    {
        DB::table('books')->where('id', $id)->delete();

        return redirect()->route('publisher.index');
    }
}

