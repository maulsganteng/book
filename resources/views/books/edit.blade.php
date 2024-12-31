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

    <div class="mb-3">
        <label for="categories" class="form-label">Categories:</label>
        <select name="categories[]" id="categories" class="form-select" multiple required>
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <small class="form-text text-muted">Hold Ctrl (Windows) or Command (Mac) to select multiple.</small>
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