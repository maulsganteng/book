<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;

class BooksImport implements ToModel
{
    public function model(array $row)
    {
        return new Book([
            'name' => $row[0],
            'description' => $row[1],
            'author' => $row[2],
        ]);
    }
}