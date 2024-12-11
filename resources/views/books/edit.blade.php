<!-- resources/views/books/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Edit Buku</h1>

    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama Buku</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $book->name) }}" required>
        </div>

        <div class="form-group">
            <label for="book_category_id">Kategori Buku</label>
            <select class="form-control" id="book_category_id" name="book_category_id" required>
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('book_category_id', $book->book_category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="author">Penulis</label>
            <input type="text" class="form-control" id="author" name="author" value="{{ old('author', $book->author) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $book->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="thumbnail">Thumbnail</label>
            <input type="file" class="form-control" id="thumbnail" name="thumbnail">
            @if ($book->thumbnail)
                <img src="{{ asset('storage/' . $book->thumbnail) }}" width="50" alt="thumbnail">
            @endif
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
@endsection
