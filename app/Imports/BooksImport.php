<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToCollection, WithHeadingRow
{
    public $existingBooks = []; // Untuk menyimpan buku yang sudah ada

    public function collection(Collection $rows)
    {
        DB::transaction(function () use ($rows) {
            foreach ($rows as $row) {
                // Validasi apakah buku sudah ada
                $bookName = $row['book_name'];
                $existingBook = DB::table('books')->where('name', $bookName)->exists();

                if ($existingBook) {
                    // Tambahkan ke daftar buku yang sudah ada
                    $this->existingBooks[] = $bookName;
                    continue; // Lewati proses jika buku sudah ada
                }

                // Tambahkan buku baru jika tidak ada
                $bookId = DB::table('books')->insertGetId([
                    'name' => $bookName,
                    'author' => $row['penulis'],
                    'description' => $row['deskripsi'],
                ]);

                // Proses kategori
                $categories = explode(',', $row['categories']);
                $categoryIds = [];

                foreach ($categories as $categoryName) {
                    // Insert kategori jika belum ada
                    $category = DB::table('book_categories')->where('name', trim($categoryName))->first();

                    if ($category) {
                        $categoryIds[] = $category->id;
                    } else {
                        $categoryIds[] = DB::table('book_categories')->insertGetId([
                            'name' => trim($categoryName),
                        ]);
                    }
                }

                // Sinkronkan data buku dan kategori di tabel pivot
                foreach ($categoryIds as $categoryId) {
                    DB::table('book_category')->updateOrInsert(
                        [
                            'book_id' => $bookId,
                            'category_id' => $categoryId,
                        ]
                    );
                }
            }
        });
    }
}
