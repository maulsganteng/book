<?php

namespace App\Exports;

use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BooksExport implements FromCollection,WithHeadings
{
    public function collection()
    {
        return DB::table('books')
        ->join('book_category', 'books.id', '=', 'book_category.book_id')
        ->join('book_categories', 'book_category.category_id', '=', 'book_categories.id')
        ->select(
            'books.name',
            DB::raw('GROUP_CONCAT(book_categories.name) as categories'),
            'books.author',
            'books.description',
            )
        ->groupBy('books.id')
        ->get();
        
    }

    public function headings() :array
    {
        return [
            'book name',
            'categories',
            'penulis',
            'deskripsi',
        ];
    }

}


