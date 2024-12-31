@extends('layouts.app')


@section('content')

<p class="h1">Halaman TEST</p>
<br>
<a href="{{ route('publisher.create') }}" class="btn btn-primary">add</a>
<br>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Judul Buku</th>
            <th>deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($books as $book)
        <tr>
            <td>{{$book->judulBuku}}</td>
            <td>{{$book->deskripsi}}</td>
            <td>
                <a href="{{route('publisher.edit', $book->id)}}" class="btn btn-success">edit</a>
                <a href="{{route('publisher.delete', $book->id)}}" class="btn btn-danger">delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection()