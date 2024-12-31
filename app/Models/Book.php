<?php

// app/Models/Book.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['name', 'book_category_id', 'author_id', 'description', 'thumbnail'];

    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'book_category_id');
    }
    public function categories()
    {
        return $this->belongsToMany(BookCategory::class, 'book_category');
    }
}
