<!-- resources/views/books/index.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Daftar Buku</h1>
    <br>
    <form action="/import-books" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" required>
        <button class="btn btn-primary"type="submit">Import Books</button>
        <a href="{{ route('books.export') }}" class="btn btn-success" style="padding: 10px; background-color: green; color: white; text-decoration: none; border-radius: 5px;">
            Export Books
        </a>
    </form>
    <br>
    <a href="{{ route('books.create') }}" class="btn btn-primary">Tambah Buku</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table" id="table">
        <thead>
            <tr>
                <th>Nama Buku</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Thumbnail</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>{{ $book->name }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td>{{ $book->author }}</td>
                    <td><img src="{{ asset('storage/' . $book->thumbnail) }}" width="50" alt="thumbnail"></td>
                    <td>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        $(document).ready(function() {
            $('#table').DataTable();  // Menambahkan fitur DataTables
        });
    </script>
@endsection
