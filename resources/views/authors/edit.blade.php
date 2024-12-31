@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Penulis</h1>

    <form action="{{ route('authors.update', $author->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="name" class="form-label">Nama Penulis</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $author->name) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
