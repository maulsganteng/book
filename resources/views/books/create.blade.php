<!-- resources/views/books/create.blade.php -->
@extends('layouts.app')

@section('content')
<!-- Alert Error -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Error!</strong> Please check the following issues:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Alert Sukses -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

    <h1>Tambah Buku</h1>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Nama Buku</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="book_category_id">Kategori Buku</label>
            <select class="form-control" id="book_category_id" name="book_category_id" required>
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('book_category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="author">Penulis</label>
            <input type="text" class="form-control" id="author" name="author" value="{{ old('author') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="thumbnail">Thumbnail</label>
            <input type="file" class="form-control" id="thumbnail" name="thumbnail" required>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
@endsection
