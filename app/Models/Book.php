<?php

// app/Models/Book.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['name', 'book_category_id', 'author', 'description', 'thumbnail'];

    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'book_category_id');
    }
}
